<?php
/*
Custom Taxonomies Filters & Columns.

Plugin name: Custom Taxonomies Filters & Columns
Description: Provides Custom Taxonomies Filters & sortable Columns in Custom Post Types Edit screen
Plugin URI: http://www.concepteur-developpeur-web.fr/plugin-wordpress-filtres-colonnes-taxonomies-personnalisees/
Author: J. Sébastien Teitgen
Author URI: http://www.concepteur-developpeur-web.fr
Version: 1.0.3
Text Domain: jstctfc
Domain Path: /languages
License: GPLv2 or later

Custom Taxonomies Filters & Columns is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Custom Taxonomies Filters & Columns is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You can get a copy of the GNU General Public License at http://www.gnu.org/licenses/gpl-2.0.html.
*/
defined( 'ABSPATH' ) OR exit;
if( !class_exists( 'JST_CTFC' ) )
{
	register_activation_hook( __FILE__, array( 'JST_CTFC', 'activate' ) );
	class JST_CTFC
	{
		private $plg_data;
		private $plg_name;
		private $menu_name	= 'CTFC';
		private $textdomain;
		protected static $opt_name 	= 'jst_ctfc_options';
		private $opts = array();
		private $post_types;
		private $cpt_taxonomies = array();

		/**
		 * On Activation
		 */
		public static function activate()
		{
			if( ! current_user_can( 'activate_plugins' ) )
			{
				return;
			}
			$plugin = isset( $_REQUEST[ 'plugin' ] ) ? $_REQUEST[ 'plugin' ] : '';
			check_admin_referer( "activate-plugin_{$plugin}" );
			register_uninstall_hook( __FILE__, array( 'JST_CTFC', 'uninstall' ) );
		}

		/**
		 * On Uninstall
		 */
		public static function uninstall()
		{
			if( ! current_user_can( 'activate_plugins' ) )
			{
				return;
			}
			self::delete_options();
		}

		/**
		 * Delete all option on uninstall
		 */
		protected static function delete_options()
		{
			delete_option( self::$opt_name );
		}

		/**
		 * Constructor
		 */
		public function __construct()
		{
			$this->opts 		= get_option( self::$opt_name, array() );
			
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'init', array( $this, 'init' ) );

			add_action( 'admin_init', array( $this, 'admin_page_settings' ) );
			add_action( 'admin_menu', array( $this, 'create_admin_page' ) );
			/**
			 * UI actions & filters
			 */
			add_action( 'restrict_manage_posts', array( $this, 'restrict_manage_posts' ) );
			add_action( 'parse_query', array( $this, 'parse_query_to_manage_restrict' ) );
			add_filter( 'posts_clauses', array( $this, 'posts_clauses' ), 10, 2 );
		}
		
		/**
		 * Retrieve all Non Builtin Post Types
		 *
		 * @return array $post_types
		 */
		private function get_all_non_builtin_custom_post_types()
		{
			return array_values( get_post_types( array( '_builtin' => false ) ) );
		}

		/**
		 * Checks if the Post Type is enabled in the plugin admin page
		 * checkes if the "filter" || "column" option is checked
		 *
		 * @param string $post_type the current Post Type
		 * @param string $tax_id the Taxonomy string identifoer (used for registering the taxonomy)
		 * @param string $option_type ("filter" || "column")
		 * @return bool
		 */
		private function isset_taxonomy_ui_option( $post_type=false, $tax_id=false, $option_type=false )
		{
			if( !$post_type  )
			{
				return false;
			}
			$tax_options = get_option( 'jst_ctfc_options', array() );
			if( !$tax_id )
			{
				return isset( $tax_options[ $post_type ] );
			}
			if( !$option_type || !in_array( $option_type, array( 'filter', 'column' ) ) )
			{
				return false;
			}
			return isset( $tax_options[ $post_type ][ $tax_id ][ $option_type ] );
		}

		/**
		 * Adds a Users (authors) Select & CPT Categoreis (categories OR taxonomy terms) to the edit screen
		 *
		 * @param string $post_type Current post type for the current screen
		 * @return void
		 */
		public function restrict_manage_posts( $post_type )
		{
			wp_dropdown_users(array(
				'show_option_all'	=> 'Tous les utilisateurs',
				'name'				=> 'author',
				'who'				=> 'authors',
				'include_selected'	=> true
			));
			
			$tax_options = $this->opts;

			if( ! isset( $tax_options[ $post_type ] ) )
			{
				return;
			}

			$taxos = get_object_taxonomies( $post_type );
			if( count( $taxos ) )
			{
				foreach( $taxos as $tax_id )
				{
					if( isset( $tax_options[ $post_type ][ $tax_id ]['filter'] ) )
					{
						$tax = get_taxonomy( $tax_id );
						
						$selected = isset( $_GET[ $tax_id ] ) ? $_GET[ $tax_id ] : 0;
						wp_dropdown_categories(array(
							'show_option_all'	=> sprintf( __( 'All %s', $this->textdomain ), $tax->label ),
							'taxonomy'			=> $tax_id,
							'name'				=> $tax_id,
							'orderby'			=> 'name',
							'order'				=> 'ASC',
							'hierarchical'		=> true,
							'show_count'		=> true,
							'selected'			=> $selected,
							'hide_if_empty'		=> true,
						));
					}
				}
			}
		}

		/**
		 * Parses WP_Query When on edit.php screen && CPT is filtered
		 *
		 * @param Object WP_Query Current Querry instance
		 * @return Object WP_Query
		 */
		public function parse_query_to_manage_restrict( $wp_query )
		{
			$qv =& $wp_query->query_vars;
			global $pagenow;
			
			$tax_options = $this->opts;
			
			if( 'edit.php' != $pagenow || !isset( $_GET[ 'post_type' ] ) || ! isset( $tax_options[ $qv[ 'post_type' ] ] ) )
			{
				return $wp_query;
			}
			$requested_post_type = $_GET[ 'post_type' ];
			
			$post_type_taxonomies = get_object_taxonomies( $requested_post_type );
			if( count( $post_type_taxonomies )  )
			{
				foreach( $post_type_taxonomies as $tax_id )
				{
					if( isset( $qv[ $tax_id ] ) && is_numeric( $qv[ $tax_id ] ) && 0 != $qv[ $tax_id ] )
					{
						$term = get_term_by( 'id', $qv[ $tax_id ], $tax_id );
						$qv[ $tax_id ]	= $term ? $term->slug : '';
					}
				}
			}
			return $wp_query;
		}

		/**
		 * Adds Category Column to CPT Admin screen (if enabled)
		 *
		 * @param array $cols Posts table columns headers (<th>)
		 * @return array $cols
		 */
		public function manage_cpt_posts_columns( $cols )
		{
			$post_type = get_current_screen()->post_type;
			
			$taxonomies = get_object_taxonomies( $post_type );
			if( count( $taxonomies ) )
			{
				foreach( $taxonomies as $tax_id )
				{
					$tax = get_taxonomy( $tax_id );
					if( $this->isset_taxonomy_ui_option( $post_type, $tax_id, 'column' ) && ! isset( $cols[ 'taxonomy-' . $tax_id ] ) )
					{
						$cols[ 'taxonomy-' . $tax_id ] = $tax->label;
					}
				}
			}
			return $cols;
		}

		/**
		 * Fills Category Column for each post (row)
		 *
		 * @param string $col Current column id while looping on screen posts
		 * @param interger $post_id Current screen post->ID
		 */
		public function manage_cpt_posts_custom_column( $col, $post_id )
		{
			// current post type
			$post_type = get_current_screen()->post_type;
			// current post type taxonomies
			$taxonomies = get_object_taxonomies( $post_type );	
			if( count( $taxonomies ) )
			{
				foreach( $taxonomies as $tax_id )
				{
					if( $this->isset_taxonomy_ui_option( $post_type, $tax_id, 'column' ) )
					{
						switch( $col )
						{
							case 'taxonomy-'.$tax_id :
								// If any taxonomy terms attached to the post
								if( FALSE !== ( $the_terms = get_the_terms( $post_id, $tax_id ) ) )
								{
									// Get the first (main) attached term
									$term = $the_terms[ 0 ];
									// Admin URL to same screen... but filted by the term
									$term_link = admin_url( 'edit.php?post_type='.$post_type.'&'.$tax_id.'='.$term->slug );
									printf( '<a href="%1$s">%2$s</a>', $term_link, $term->name );
								}
								break;
							default:
								break;
						}
					}
				}
			}
		}

		/**
		 * Make Taxonomy column sortable
		 *
		 * @param array $sortable 
		 */
		public function manage_edit_cpt_posts_sortable_custom_column( $sortable )
		{
			// current post type
			$post_type = get_current_screen()->post_type;
			// current post type taxonomies
			$taxonomies = get_object_taxonomies( $post_type );

			if( count( $taxonomies ) )
			{
				foreach( $taxonomies as $tax_id )
				{
					$taxo = get_taxonomy( $tax_id );
					if( $this->isset_taxonomy_ui_option( $post_type, $tax_id, 'column' ) && !isset( $sortable[ 'taxonomy-' . $taxo->name ] ) )
					{
						$sortable[ 'taxonomy-'.$taxo->name ] = $taxo->name;
					}
				}
			}
			return $sortable;
		}

		/**
		 * Rebuild WP_Query SQL Clauses for Custom Taxonomies columns sort
		 *
		 * @param array $clauses Array os SQL clauses
		 * @param object $wp_query WP_Query instance
		 * @return array $clauses
		 */
		public function posts_clauses( $clauses, $wp_query )
		{
			// We want posts_clauses to handle only sorting actions
			if( isset( $_GET[ 'filter_action' ] ) )
			{
				return $clauses;
			}

			global $pagenow;
			
			/*
			 * Rebuilds the SQL clauses only if we're on the "edit.php^" screen
			 * We also need $_GET variables
			 */
			if( 'edit.php' != $pagenow || !isset( $wp_query->query_vars[ 'post_type' ] ) || 
				! isset( $_GET[ 'order' ] ) || ! isset( $_GET[ 'orderby' ] ) )
			{
				return $clauses;
			}

			$order =  ( isset( $_GET[ 'order' ] ) && 'desc' == $_GET[ 'order' ] ) ? 'DESC' : 'ASC';

			// This could be anything : title, date, author, tax_id, etc.
			$orderby_taxonomy = esc_sql( $_GET[ 'orderby' ] );

			$all_cpts = $this->get_all_non_builtin_custom_post_types();
			$tax_options = $this->opts;
			$requested_post_type = $wp_query->query_vars[ 'post_type' ];
			
			// Check if post type in options && ORDERBY is set to taxonomy 
			if( !isset( $tax_options[ $requested_post_type ] ) || 
				!isset( $tax_options[ $requested_post_type ][ $orderby_taxonomy ] ) )
			{
				return $clauses;
			}
			
			global $wpdb;
			$table_term_relationships 	= $wpdb->prefix.'term_relationships';
			$table_term_taxonomy 		= $wpdb->prefix.'term_taxonomy';
			$table_terms 				= $wpdb->prefix.'terms';
			$table_posts				= $wpdb->prefix.'posts';

			$clauses[ 'distinct' ]		= 'DISTINCT';
			$clauses[ 'join' ]			= " LEFT JOIN ".$table_term_relationships. " tr ON (".$table_posts.".ID = tr.object_id)";
			$clauses[ 'join' ]			.= " LEFT JOIN ".$table_term_taxonomy." termtax USING ( term_taxonomy_id )";
			$clauses[ 'join' ]			.= " LEFT JOIN ".$table_terms." terms USING (term_id)";
			$clauses[ 'where' ] 		.= " AND termtax.taxonomy = '".$orderby_taxonomy."'";
			$clauses[ 'orderby' ] 		= "terms.name ".$order;

			//echo '<pre style="width:70%;margin:0 auto;background:#777;color:fff;padding:1.5em;line-height:1.6;white-space:pre-line;">'.var_export( $clauses, true ) .'</pre>';
			return $clauses;
		}

		/**
		 * For each Custom Post Type
		 * calls the necessary hooks to make Custom Taxonomy Column Sortable
		 *
		 * @return void
		 */
		public function loop_through_cpts()
		{
			
			$all_post_types = $this->get_all_non_builtin_custom_post_types();
			
			$tax_options = $this->opts;
			if( count( $tax_options ) )
			{
				foreach( $tax_options as $post_type_id=>$taxonomies )
				{
					if( is_array( $taxonomies ) && isset( current( $taxonomies )['column'] ) )
					{
						add_filter( 'manage_'.$post_type_id.'_posts_columns', array( $this, 'manage_cpt_posts_columns' ) );
						add_filter( 'manage_'.$post_type_id. '_posts_custom_column', array( $this, 'manage_cpt_posts_custom_column' ), 10, 2 );
						add_filter( 'manage_edit-'.$post_type_id.'_sortable_columns', array( $this,  'manage_edit_cpt_posts_sortable_custom_column' ) );
					}
				}
			}
		}

		/**
		 * PLugin DATA
		 */
		function admin_init()
		{
			$this->plg_data 	= get_plugin_data( __FILE__ );
			$this->plg_name 	= $this->plg_data[ 'Name' ];
			$this->textdomain 	= $this->plg_data[ 'TextDomain' ];
		}


		/** 
		 *	textdomain & other inits
		 */
		public function init()
		{
			$this->load_textdomain();
			$this->get_cpt_taxonomies();
			$this->loop_through_cpts();
		}

		/**
		 * Text Domain
		 * @see load_plugin_textdomain()
		 */
		private function load_textdomain()
		{
			load_plugin_textdomain( 'jstctfc', false, dirname( plugin_basename( __FILE__ ) ).'/languages' );
		}

		/**
		 * Registers the plugin page
		 * Hooks on 'load'-{menu-page} to enqueue scripts 
		 */
		public function create_admin_page()
		{
			$menu_page_hook = add_menu_page(
				sprintf( __( '%s Settings', $this->textdomain ), $this->plg_name ),
				$this->menu_name,
				'manage_options',
				basename( __FILE__ ),
				array( $this, 'admin_page' ),
				'dashicons-filter', 
				100
			);
			add_action( 'load-'.$menu_page_hook, array( $this, 'menu_page_script' ) );
		}

		/**
		 * Scrpits enqueing for admin menu page
		 */
		public function menu_page_script()
		{
			wp_enqueue_script(
				'ctfc-admin-js',
				plugin_dir_url( __FILE__ ).'js/ctfc-admn.js',
				array( 'jquery' ),
				filemtime( plugin_dir_path( __FILE__ ) ).'js/ctfc-admn.js',
				false
			);
			wp_enqueue_style(
				'ctfc-admin-style',
				plugin_dir_url( __FILE__ ).'css/ctfc-admn.css',
				array(),
				filemtime( plugin_dir_path( __FILE__ ) ).'/css/ctfc-admn.css',
				'all'
			);
		}

		/**
		 * Admin Page OPtions Form Settings
		 */
		public function admin_page_settings()
		{
			register_setting( self::$opt_name, self::$opt_name, array( $this, 'sanitize_jst_ctfc_options' ) );

			$cpt_taxonomies = $this->get_cpt_taxonomies();
			if( count( $cpt_taxonomies ) )
			{
				foreach( $cpt_taxonomies as $post_type=>$taxonomies )
				{
					if( is_array( $taxonomies ) && count( $taxonomies ) )
					{
						$post_type_object = get_post_type_object( $post_type );
						add_settings_section(
							'jst_ctfc_post_type-'.$post_type,
							sprintf( __( '%s Managment', $this->textdomain ), ucfirst( $post_type_object->label ) ),
							array( $this, 'post_type_section_description' ),
							basename( __FILE__, '.php' )
						);

						add_settings_field(
							'jst_ctfc-'.$post_type,
							sprintf( '<label for="jst_ctfc-'.$post_type.'">'.__( '%s Taxonomies Tools', $this->textdomain ).'</label>', ucfirst( $post_type_object->label ) ),
							array( $this, 'cpt_taxonomy_field' ),
							basename( __FILE__, '.php' ),
							'jst_ctfc_post_type-'.$post_type,
							array( 'id' => $post_type, 'field_for' => 'cpt' )
						);

						foreach( $taxonomies as $taxonomy )
						{
							$taxonomy_object = get_taxonomy( $taxonomy );
							add_settings_field(
								'jst_ctfc-'.$post_type.'-'.$taxonomy,
								sprintf( '<label class="jst_ctfc-tax-label" for="jst_ctfc-'.$post_type.'-'.$taxonomy.'">'.__( 'Use for %s', $this->textdomain ).'</label>', $taxonomy_object->label ),
								array( $this, 'cpt_taxonomy_field' ),
								basename( __FILE__, '.php' ),
								'jst_ctfc_post_type-'.$post_type,
								array( 'id' => $taxonomy, 'post_type' => $post_type, 'field_for' => 'tax' )
							);
						}
					}
				}
			}
		}

		/**
		 * Custom Taxonomies Fields
		 * @param array $args depending on the CPT ou Taxonomy field (last argument of ass_settings_field())
		 * @return void
		 */
		public function cpt_taxonomy_field( $args )
		{
			$field_id 	= $args[ 'id' ];
			$id_attr 	= esc_attr( $field_id );
			$field_for	= $args[ 'field_for' ];

			$opts 		= $this->opts;
			
			switch( $field_for )
			{
				case 'cpt':
					$checked 	= isset( $opts[ $field_id ] )  ? 'checked' : '';
					echo '<input type="checkbox" class="jst_ctft-cpt-check" id="'.$id_attr.'" name="'.self::$opt_name.'['.$id_attr.']" value="1" '.$checked.' />';
					break;
				case 'tax':
					$post_type = $args[ 'post_type' ];
					$post_type_attr = esc_attr( $post_type );
					foreach( array( 'filter' => __( 'Add filter', $this->textdomain ), 'column' => __( 'Add column', $this->textdomain ) ) as $option=>$option_label )
					{
						$checked = isset( $opts[ $post_type ][ $field_id ][ $option ] ) && $opts[ $post_type ][ $field_id ][ $option ] == 1 ? 'checked' : '';
						echo '<label><input type="checkbox" id="'.$post_type_attr.'-'.$id_attr.'-'.$option.'" name="'.self::$opt_name.'['.$post_type_attr.']['.$id_attr.']['.esc_attr( $option ).']" value="1" '.$checked.' />&nbsp;'.esc_html( $option_label ).'</label><br />';
					}
					break;
				default:
					break;
			}
		}

		/**
		 * Custom Post Types Sections descriptions
		 * @param array $args add_settings_section arguments
		 * @return void
		 */
		public function post_type_section_description( $args )
		{
			$post_type_infos = explode( '-', $args['id'] );
			$post_type_label = get_post_type_object( $post_type_infos[1] )->label;
			printf( '<p style="font-style:italic;">'.__( 'Add taxonomies filters and/or sortable columns to %s Custom Post Type', $this->textdomain ).'</p>', ucfirst( $post_type_label ) );
		}

		/**
		 *
		 */
		public function sanitize_jst_ctfc_options( $input )
		{
			return $input;
		}

		/**
		 * Admin Menu Page
		 */
		public function admin_page()
		{
		?>
			<div class="wrap">
				<h1><?php printf( __( '%s Settings', $this->textdomain ), $this->plg_name );?></h1>
				<form action="options.php" method="POST">
					<?php settings_fields('jst_ctfc_options' ); ?>
					<?php do_settings_sections( basename( __FILE__, '.php' ) ); ?>
					<input type="submit" class="button button-primary"/>
				</form>
			</div>
		<?php
		}

		/**
		 * Retrieves all nont biltin plugins
		 * @return array $piost_types
		 */
		private function get_post_types()
		{
			$post_types = array_keys( get_post_types(array( '_builtin' => false ) ) );
			$this->post_types  = $post_types;
			return $post_types;
		}

		/**
		 * Retrietves  & sets all registered_taxonomies for each Custom Post Type
		 * @return array  $cpt_taxonomies array( $post_type0 => array( $taxonomy0, $taxonomyn ) )
		 */
		private function get_cpt_taxonomies()
		{
			$post_types = $this->get_post_types();
			if( count( $post_types ) )
			{
				foreach( $post_types as $post_type )
				{
					$this->cpt_taxonomies[ $post_type ] = get_object_taxonomies( $post_type );
				}
			}
			return $this->cpt_taxonomies;
		}
	}
	new JST_CTFC;
}