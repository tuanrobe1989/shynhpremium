<?php
namespace WpAssetCleanUp;

// [wpacu_pro]
use WpAssetCleanUpPro\MainPro;
// [/wpacu_pro]

/**
 * Class OwnAssets
 *
 * These are plugin's own assets (CSS, JS etc.) and they are used only when you're logged in and do not show in the list for unload
 *
 * @package WpAssetCleanUp
 */
class OwnAssets
{
    /**
     * @var bool
     */
    public $loadPluginAssets = false; // default

    // [wpacu_pro]
	/**
	 * @var bool
	 */
	public $isTaxonomyEditPage = false;
    // [/wpacu_pro]

	/**
	 *
	 */
	public function init()
    {
        add_action('admin_enqueue_scripts', array($this, 'stylesAndScriptsForAdmin'));
        add_action('wp_enqueue_scripts',    array($this, 'stylesAndScriptsForPublic'));

	    // Code only for the Dashboard
	    add_action('admin_head',   array($this, 'inlineAdminHeadCode'));
	    add_action('admin_footer', array($this, 'inlineAdminFooterCode'));

	    // Code for both the Dashboard and the Front-end view
	    add_action('admin_head',   array($this, 'inlineCode'));
	    add_action('wp_head',      array($this, 'inlineCode'));

	    // Rename ?ver= to ?wpacuversion to prevent other plugins from stripping "ver"
	    // This is valid in the front-end and the Dashboard
	    add_filter('script_loader_src', array($this, 'ownAssetLoaderSrc'), 10, 2);
	    add_filter('style_loader_src',  array($this, 'ownAssetLoaderSrc'), 10, 2);
	    add_filter('script_loader_tag', array($this, 'ownAssetLoaderTag'), 10, 2);

	    add_filter('wpacu_object_data', static function($wpacu_object_data) {
		    $wpacu_object_data['source_load_error_msg'] = __('The source might not be reachable', 'wp-asset-clean-up');
		    $wpacu_object_data['plugin_id'] = WPACU_PLUGIN_ID;
		    $wpacu_object_data['plugin_title'] = WPACU_PLUGIN_TITLE;
		    $wpacu_object_data['ajax_url']  = admin_url('admin-ajax.php');
		    $wpacu_object_data['is_frontend_view'] = false;

		    if ( isset($_GET['wpacu_manage_dash']) ) {
			    $wpacu_object_data['force_manage_dash'] = true;
            }

		    // Current Page URL (for preloading) in the front-end view
		    if (! is_admin()) {
			    $wpacu_object_data['page_url'] = Misc::getCurrentPageUrl();
			    $wpacu_object_data['is_frontend_view'] = true;
		    }

		    if (isset($wpacu_object_data['page_url']) && is_admin() && Misc::isHttpsSecure()) {
			    $wpacu_object_data['page_url'] = str_replace('http://', 'https://', $wpacu_object_data['page_url']);
		    }

		    // Security nonces for AJAX calls
		    $wpacu_object_data['wpacu_update_specific_settings_nonce'] = wp_create_nonce('wpacu_update_specific_settings_nonce');
		    $wpacu_object_data['wpacu_update_asset_row_state_nonce'] = wp_create_nonce('wpacu_update_asset_row_state_nonce');
            $wpacu_object_data['wpacu_print_loaded_hardcoded_assets_nonce'] = wp_create_nonce('wpacu_print_loaded_hardcoded_assets_nonce');
		    $wpacu_object_data['wpacu_ajax_check_remote_file_size_nonce'] = wp_create_nonce('wpacu_ajax_check_remote_file_size_nonce');
            $wpacu_object_data['wpacu_ajax_check_external_urls_nonce'] = wp_create_nonce('wpacu_ajax_check_external_urls_nonce');
		    $wpacu_object_data['wpacu_ajax_get_loaded_assets_nonce'] = wp_create_nonce('wpacu_ajax_get_loaded_assets_nonce');
		    $wpacu_object_data['wpacu_ajax_load_page_restricted_area_nonce'] = wp_create_nonce('wpacu_ajax_load_page_restricted_area_nonce');
		    $wpacu_object_data['wpacu_ajax_clear_cache_nonce'] = wp_create_nonce('wpacu_ajax_clear_cache_nonce');
		    $wpacu_object_data['wpacu_ajax_preload_url_nonce'] = wp_create_nonce('wpacu_ajax_preload_url_nonce'); // After the CSS/JS manager's form is submitted (e.g. on an edit post/page)

		    // [wpacu_pro]
		    $wpacu_object_data['script_is_parent_alert'] = 'This JavaScript is having the following "children" that depend on it (at least that\'s how it was marked): {wpacu_script_child_handles}.'."\n\n".
                                 'If this file is loaded AFTER its "children" (e.g. by either applying "async" or "defer"), then you might end up with broken functionality as it is likely the order of the loaded files would be changed.'."\n\n".
                                 'Please test carefully if you decided to continue OR make sure its "children" handles are also having the same attribute applied.';

		    $wpacu_object_data['parent_asset_media_query_load_alert'] = 'This [asset_type] has other "children" files connected to it that might not load in the same way if you apply any media query rule.' ."\n\n".
                    'Please test the page in both mobile and desktop view if you decide to add a rule, making sure everything is loading fine.' ."\n\n".
                    'Click "OK" to continue and set the rule or "Cancel" if you have any doubts about taking this action.';
		    // [/wpacu_pro]

            $wpacu_object_data['jquery_unload_alert'] = 'jQuery library is a WordPress library that it is used in WordPress plugins/themes most of the time.'."\n\n".
                                        'There are currently other JavaScript "children" files connected to it, that will stop working, if this library is unloaded'."\n\n".
                                        'If you are positive this page does not require jQuery (very rare cases), then you can continue by pressing "OK"'."\n\n".
                                        'Otherwise, it is strongly recommended to keep this library loaded by pressing "Cancel" to avoid breaking the functionality of the website.';
            // js-cookie
		    $wpacu_object_data['woo_js_cookie_unload_alert'] = 'Please be careful when unloading "js-cookie" as there are other JS files that depend on it which will also be unloaded, including "wc-cart-fragments" which is required for the functionality of the WooCommerce mini cart.'."\n\n".
                                                        'Click "OK" to continue or "Cancel" if you have any doubts about unloading this file';

		    // wc-cart-fragments
		    $wpacu_object_data['woo_wc_cart_fragments_unload_alert'] = 'Please be careful when unloading "wc-cart-fragments" as it\'s required for the functionality of the WooCommerce mini cart. Unless you are sure you do not need it on this page, it is advisable to leave it loaded.'."\n\n".
		                                                       'Click "OK" to continue or "Cancel" if you have any doubts about unloading this file.';

            // backbone, underscore, etc.
            $wpacu_object_data['sensitive_library_unload_alert'] = 'Please make sure to properly test this page after this particular JavaScript file is unloaded as it is usually loaded for a reason.'."\n\n".
                                                   'If you are not sure whether it is used or not, then consider using the "Cancel" button to avoid taking ay chances in breaking the website\'s functionality.'."\n\n".
                                                   'It is advised to check the browser\'s console via right-click and "Inspect" to check for any reported errors.';

		    $wpacu_object_data['dashicons_unload_alert_ninja_forms'] = 'It looks like you are using "Ninja Forms" plugin which is sometimes loading Dashicons for the forms\' styling.'."\n\n".
                                                   'If you are sure your forms do not use Dashicons, please use the following option \'Ignore dependency rule and keep the "children" loaded\' to avoid the unloading of the "nf-display" handle.'. "\n\n".
                                                   'Click "OK" to continue or "Cancel" if you have any doubts about unloading the Dashicons. It is better to have Dashicons loaded, then take a chance and break the forms\' layout.';

		    // After homepage/post/page is saved and the page is reloaded, clear the cache
            // Cache clearing default values
		    $wpacu_object_data['clear_cache_on_page_load'] = $wpacu_object_data['clear_other_caches'] = false; // default

            /*
             * [Start] Trigger plugin cache and other plugins'/system caches
             */
                // After editing post/page within the Dashboard
                $unloadAssetsSubmit = (isset($_POST['wpacu_unload_assets_area_loaded']) && $_POST['wpacu_unload_assets_area_loaded']);

                // After updating the CSS/JS manager within the front-end view (when "Manage in the front-end" is enabled)
                $frontendViewPageAssetsJustUpdated = (! is_admin() && get_transient('wpacu_page_just_updated'));

                // After updating the "Settings" within the Dashboard
                $pluginSettingsWithinDashboardJustUpdated = (is_admin() && get_transient('wpacu_settings_updated'));

                if ($unloadAssetsSubmit || $frontendViewPageAssetsJustUpdated || $pluginSettingsWithinDashboardJustUpdated) {
                    // Instruct the script to trigger clearing the cache via AJAX
                    $wpacu_object_data['clear_cache_on_page_load'] = true;
                }
		    /*
			 * [End] Trigger plugin cache and other plugins'/system caches
			 */

		    /*
			 * [Start] Trigger ONLY other plugins'/system caches
			 */
                // When click the "Clear CSS/JS Files Cache" link within the Dashboard (e.g. toolbar or quick action areas)
                // Cache was already cleared; Do not clear it again (save resources); Clear other caches
                if (get_transient('wpacu_clear_assets_cache_via_link')) {
	                delete_transient('wpacu_clear_assets_cache_via_link');
                    $wpacu_object_data['clear_other_caches'] = true;
                }
		    /*
			 * [End] Trigger ONLY other plugins'/system caches
			 */

            $wpacu_object_data['server_returned_404_not_found'] = sprintf(
                    __('When accessing this page the server responded with a status of %s404 (Not Found)%s. If this page is meant to return this status, you can ignore this message, otherwise you might have a problem with this page if it is meant to return a standard 200 OK status.', 'wp-asset-clean-up'),
                    '<strong>',
                    '</strong>'
            );

            /*
             * Whether to clear Autoptimize Cache or not (if the plugin is enabled)
             */
            $wpacu_object_data['clear_autoptimize_cache'] = assetCleanUpClearAutoptimizeCache() ? 'true' : 'false';

		    return $wpacu_object_data;
        });
    }

	/**
	 *
	 */
	public function inlineCode()
	{
		if (is_admin_bar_showing()) {
			?>
            <style <?php echo Misc::getStyleTypeAttribute(); ?> data-wpacu-own-inline-style="true">
                #wp-admin-bar-assetcleanup-asset-unload-rules-css-default,
                #wp-admin-bar-assetcleanup-asset-unload-rules-js-default,
                #wp-admin-bar-assetcleanup-plugin-unload-rules-notice-default {
                    overflow-y: auto;
                    max-height: calc(100vh - 250px);
                }

                #wp-admin-bar-assetcleanup-parent span.dashicons {
                    width: 15px;
                    height: 15px;
                    font-family: 'Dashicons', Arial, "Times New Roman", "Bitstream Charter", Times, serif !important;
                }

                #wp-admin-bar-assetcleanup-parent > a:first-child strong {
                    font-weight: bolder;
                    color: #76f203;
                }

                #wp-admin-bar-assetcleanup-parent > a:first-child:hover {
                    color: #00b9eb;
                }

                #wp-admin-bar-assetcleanup-parent > a:first-child:hover strong {
                    color: #00b9eb;
                }

                #wp-admin-bar-assetcleanup-test-mode-info {
                    margin-top: 5px !important;
                    margin-bottom: -8px !important;
                    padding-top: 3px !important;
                    border-top: 1px solid #ffffff52;
                }

                /* Add some spacing below the last text */
                #wp-admin-bar-assetcleanup-test-mode-info-2 {
                    padding-bottom: 3px !important;
                }
            </style>
			<?php
			if (wp_style_is(WPACU_PLUGIN_ID . '-style', 'enqueued')) {
				echo Misc::preloadAsyncCssFallbackOutput();
			}
		}
	}

	/**
	 *
	 */
	public function inlineAdminHeadCode()
	{
		?>
        <style <?php echo Misc::getStyleTypeAttribute(); ?> data-wpacu-own-inline-style="true">
            <?php
            // For the main languages, leave the style it was always set as it worked well
            $applyDefaultStyleForCurrentLang = (strpos(get_locale(), 'en_') !== false)
                || (strpos(get_locale(), 'es_') !== false)
                || (strpos(get_locale(), 'fr_') !== false)
                || (strpos(get_locale(), 'de_') !== false);

            if ( (! $applyDefaultStyleForCurrentLang) || Misc::isPluginActive('WPShapere/wpshapere.php') ) {
                // This would also work well if the language is Arabic (the text shown right to left)
            ?>
                /* Compatibility with "Wordpress Admin Theme - WPShapere" plugin - make sure Asset CleanUp's icon is not misaligned */
                .menu-top.toplevel_page_wpassetcleanup_getting_started .wp-menu-image > img { width: 26px; height: auto; }
            <?php
            } else {
            ?>
                .menu-top.toplevel_page_wpassetcleanup_getting_started .wp-menu-image > img { width: 26px; height: auto; position: absolute; left: 8px; top: -4px; }
            <?php
            }

            if (Main::instance()->settings['hide_from_side_bar']) {
                // Just hide the menu without removing any of its pages from the menu (for sidebar cleanup purposes)
                ?>
                #toplevel_page_wpassetcleanup_getting_started { display: none !important; }
                <?php
            } elseif (isset($_GET['page']) && strpos($_GET['page'], WPACU_PLUGIN_ID.'_') === 0) {
                // The menu is shown: make the sidebar area a bit larger so the whole "Asset CleanUp Pro" menu text is seen properly when viewing its pages
                ?>
                #adminmenuback, #adminmenuwrap, #adminmenu, #adminmenu .wp-submenu { width: 172px; }
                #wpcontent, #wpfooter { margin-left: 172px; }
                <?php
            }
            ?>
        </style>
        <?php
    }

	/**
	 *
	 */
	public function inlineAdminFooterCode()
	{
		if (defined('WPACU_USE_MODAL_BOX') && WPACU_USE_MODAL_BOX === true) { ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    /*
					 * START WPACU MODAL
					 */
                    var wpacuCurrentModal, $wpacuModals = $('.wpacu-modal');

                    if ($wpacuModals.length < 1) {
                        return;
                    }

                    $wpacuModals.each(function (wpacuIndex) {
                       var wpacuModalId = $(this).attr('id');
                       var wpacuModal = document.getElementById(wpacuModalId);

                        // Get the link/button that opens the modal

                        if ($('#'+ wpacuModalId +'-target').length > 0) {
                            var wpacuTargetById = document.getElementById(wpacuModalId + '-target');
                            // When the user clicks the element with "id", open the modal
                            wpacuTargetById.onclick = function () {
                                wpacuModal.style.display = 'block';
                                wpacuCurrentModal = wpacuModal;
                            };
                        }

                        if ($('.'+ wpacuModalId +'-target').length > 0) {
                            // When the user clicks the element with "class", open the modal
                            $('.'+ wpacuModalId +'-target').each(function (wpacuIndex2) {
                                // Get the link/button that opens the modal
                                var wpacuTargetByClass = document.getElementsByClassName(wpacuModalId + '-target')[wpacuIndex2];

                                wpacuTargetByClass.onclick = function () {
                                    wpacuModal.style.display = 'block';
                                    wpacuCurrentModal = wpacuModal;
                                };
                            });
                        }

                        // Get the <span> element that closes the modal
                        var wpacuSpan = document.getElementsByClassName('wpacu-close')[wpacuIndex];

                        // When the user clicks on <span> (x), close the modal
                        wpacuSpan.onclick = function () {
                            wpacuModal.style.display = 'none';
                        };
                    });

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function (event) {
                        if (event.target === wpacuCurrentModal) {
                            wpacuCurrentModal.style.display = 'none';
                        }
                    };
                    /*
					 * END WPACU MODAL
					 */
                });
            </script>
		<?php }

		if (isset($_GET['page']) && $_GET['page'] === WPACU_PLUGIN_ID.'_settings') {
			// Only relevant in the "Settings" area
			?>
            <script type="text/javascript">
                // Tab Area | Keep selected tab after page reload
                if (location.href.indexOf('#') !== -1) {
                    var hashFromUrl = location.href.substr(location.href.indexOf('#'));
                    //wpacuTabOpenSettingsArea(event, hashFromUrl.substring(1));
                    //console.log(hashFromUrl);
                    jQuery('a[href="'+ hashFromUrl +'"]').trigger('click');
                    //console.log(hashFromUrl.substring(1));
                }
            </script>
			<?php
		}

		}

    /**
     *
     */
    public function stylesAndScriptsForAdmin()
    {
		global $post, $pagenow;

		if (! Menu::userCanManageAssets()) {
			return;
		}

	    // Is the user inside the Dashboard (edit post/page mode)?
	    // Could be post, page, custom post type (e.g. product, download)
	    $getPostId = (isset($_GET['post'], $_GET['action']) && $_GET['action'] === 'edit' && $pagenow === 'post.php') ? (int)Misc::getVar('get', 'post') : '';

	    if ($getPostId && ! Main::instance()->settings['show_assets_meta_box']) {
		    // No point in loading the plugin JS if the management meta box is not shown
		    return;
	    }

	    // Were the meta boxes hidden for particular post types?
        // There's no point in showing any plugin's CSS/JS there
	    if (isset($post->post_type) && in_array($post->post_type, MetaBoxes::hideMetaBoxesForPostTypes())) {
		    return;
	    }

	    // This refers only to the Dashboard pages generated by the plugin
		$page = Misc::getVar('get', 'page');

		// Only load the plugin's assets when they are needed
		// This an example of assets that are correctly loaded in WordPress
		if (isset($post->ID)) {
			$this->loadPluginAssets = true;
		}

		if ($getPostId > 0) {
			$this->loadPluginAssets = true;
		}

		if (strpos($page, WPACU_PLUGIN_ID) === 0) {
			$this->loadPluginAssets = true;
		}

        // [wpacu_pro]
	    if ($this->isTaxonomyEditPage()) {
		    $this->loadPluginAssets = true;
        }
        // [/wpacu_pro]

		if (! $this->loadPluginAssets) {
			return;
		}

		$this->enqueueAdminStyles();
		$this->enqueueAdminScripts();
	}

	/**
	 *
	 */
	public function stylesAndScriptsForPublic()
    {
		// Do not print it when an AJAX call is made from the Dashboard
		if (WPACU_GET_LOADED_ASSETS_ACTION === true) {
			return;
		}

		// Only for the administrator with the right permission
		if (! Menu::userCanManageAssets()) {
			return;
		}

		// If "Manage in the Front-end" option is not enabled in the plugin's "Settings", there's no point in loading the assets below
		if (! Main::instance()->frontendShow()) {
			return;
		}

	    // Do not load any CSS & JS belonging to Asset CleanUp if in "Elementor" preview
	    if (Main::instance()->isFrontendEditView && isset($_GET['elementor-preview']) && $_GET['elementor-preview']) {
	        return;
	    }

	    if ( isset($_GET['wpacu_clean_load']) ) {
	        return;
        }

        $this->enqueuePublicStyles();
        $this->enqueuePublicScripts();
    }

	/**
	 *
	 */
	private function enqueueAdminStyles()
    {
        $styleRelPath = '/assets/style.min.css';
        wp_enqueue_style( WPACU_PLUGIN_ID . '-style', plugins_url($styleRelPath, WPACU_PLUGIN_FILE), array(), self::assetVer($styleRelPath));
    }

	/**
	 *
	 */
	private function enqueueAdminScripts()
    {
		global $post, $pagenow;

	    $postId = 0; // default
		$page = Misc::getVar('get', 'page');
	    $pageRequestFor = Misc::getVar('get', 'wpacu_for') ?: 'homepage';

	    // The admin is in a page such as /wp-admin/post.php?post=[POST_ID_HERE]&action=edit
	    $isPostIdFromEditPostPage = (isset($_GET['post'], $_GET['action']) && $_GET['action'] === 'edit' && $pagenow === 'post.php') ? (int)$_GET['post'] : '';
        $isDashAssetsManagerPage  = ($page === WPACU_PLUGIN_ID . '_assets_manager');

        if ($isDashAssetsManagerPage) {
	        if ( $pageRequestFor === 'homepage' ) {
		        $postId = 0; // default

		        // Homepage tab / Check if the home page is one of the singular pages
		        $pageOnFront = (int) get_option( 'page_on_front' );

		        if ( $pageOnFront && $pageOnFront > 0 ) {
			        $postId = $pageOnFront;
		        }
	        } elseif ( in_array( $pageRequestFor, array( 'posts', 'pages', 'custom-post-types', 'media-attachment' ) ) && isset( $_GET['wpacu_post_id'] ) && $_GET['wpacu_post_id'] ) {
		        $postId = (int)Misc::getVar( 'get', 'wpacu_post_id' ) ?: 0;
	        }
        } else {
		    $postId = isset($post->ID) ? $post->ID : 0;

		    if ($isPostIdFromEditPostPage > 0 && $isPostIdFromEditPostPage !== $postId) {
			    $postId = $isPostIdFromEditPostPage;
		    }
	    }

	    $scriptRelPath = '/assets/script.min.js';

        wp_register_script(
	        WPACU_PLUGIN_ID . '-script',
            plugins_url($scriptRelPath, WPACU_PLUGIN_FILE),
            array('jquery'),
            self::assetVer($scriptRelPath)
        );

        // Edit Taxonomy (Dashboard)
        if ($pagenow === 'term.php' && ($taxonomy = Misc::getVar('get', 'taxonomy')) && ($tagId = Misc::getVar('get', 'tag_ID'))) {
            // [wpacu_pro]
            $pageUrl = Misc::getPageUrl(0, $taxonomy, (int)$tagId);
            // [wpacu_pro]
        } elseif ($postId > 0)  {
	        // It can also be the front page URL
	        $pageUrl = Misc::getPageUrl($postId);
        } else {
	        $pageUrl = Misc::getPageUrl(0);
        }

	    $svgReloadIcon = <<<HTML
<svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-cloud" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M14.9 9c1.8.2 3.1 1.7 3.1 3.5 0 1.9-1.6 3.5-3.5 3.5h-10C2.6 16 1 14.4 1 12.5 1 10.7 2.3 9.3 4.1 9 4 8.9 4 8.7 4 8.5 4 7.1 5.1 6 6.5 6c.3 0 .7.1.9.2C8.1 4.9 9.4 4 11 4c2.2 0 4 1.8 4 4 0 .4-.1.7-.1 1z"></path></svg>
HTML;

	    // If the post status is 'private' only direct method can be used to fetch the assets
	    // as the remote post one will return a 404 error since the page is accessed as a guest visitor
        $postStatus = $postId > 0 ? get_post_status($postId) : false;
        $wpacuDomGetType = ($postStatus === 'private') ? 'direct' : Main::$domGetType;

		$wpacuObjectData = array(
			'plugin_name'       => WPACU_PLUGIN_ID,
			'plugin_id'         => WPACU_PLUGIN_ID,

			'reload_icon'       => $svgReloadIcon,
			'reload_msg'        => sprintf(__('Reloading %s area', 'wp-asset-clean-up'), '<strong style="margin: 0 4px;">' . WPACU_PLUGIN_TITLE . '</strong>'),
			'dom_get_type'      => $wpacuDomGetType,
			'list_show_status'  => Main::instance()->settings['assets_list_show_status'],

            'start_del_e'       => Main::START_DEL_ENQUEUED,
			'end_del_e'         => Main::END_DEL_ENQUEUED,

            'start_del_h'       => Main::START_DEL_HARDCODED,
            'end_del_h'         => Main::END_DEL_HARDCODED,

			'ajax_url'          => admin_url('admin-ajax.php'),
			'post_id'           => $postId, // if any
			'page_url'          => $pageUrl // post, page, custom post type, homepage etc.
		);

	    // Assets List Show Status only applies for edit post/page/custom post type/category/custom taxonomy
	    // Dashboard pages such as "Homepage" from plugin's "CSS/JavaScript Load Manager" will fetch the list on load
	    $wpacuObjectData['override_assets_list_load'] = false;

	    if ($page === WPACU_PLUGIN_ID.'_assets_manager' && in_array($pageRequestFor, array('homepage', 'pages', 'posts', 'custom-post-types', 'media-attachment'))) {
		    $wpacuObjectData['override_assets_list_load'] = true;
	    }

	    // [wpacu_pro]
        $submitTicketLink = 'https://www.gabelivan.com/contact/?utm_source=wpacu_plugin_user&utm_medium=wpacu_ajax_direct_call_error';
        // [/wpacu_pro]

        $wpacuObjectData['ajax_direct_fetch_error'] = <<<HTML
<div class="ajax-direct-call-error-area">
    <p class="note"><strong>Note:</strong> The checked URL returned an error when fetching the assets via AJAX call. This could be because of a firewall that is blocking the AJAX call, a redirect loop or an error in the script that is retrieving the output which could be due to an incompatibility between the plugin and the WordPress setup you are using.</p>
    <p>Here is the response from the call:</p>

    <table>
        <tr>
            <td width="135"><strong>Status Code Error:</strong></td>
            <td><span class="error-code">{wpacu_status_code_error}</span> * for more information about client and server errors, <a target="_blank" href="https://en.wikipedia.org/wiki/List_of_HTTP_status_codes">check this link</a></td>
        </tr>
        <tr>
            <td valign="top"><span class="dashicons dashicons-lightbulb" style="color: orange;"></span> <strong>Suggestion:</strong></td>
            <td>Select "WP Remote Post" as a method of retrieving the assets from the "Settings" page. If that doesn't fix the issue, just use "Manage in Front-end" option which should always work and <a target="_blank" href="{$submitTicketLink}">submit a ticket</a> about your problem.</td>
        </tr>
        <tr>
            <td valign="top"><strong>Output:</strong></td>
            <td valign="top">{wpacu_output}</td>
        </tr>
    </table>
</div>
HTML;

        // Sometimes, 200 OK (success) is returned, but due to an issue with the page, the assets list is not retrieved
	    $wpacuObjectData['ajax_direct_fetch_error_with_success_response'] = <<<HTML
<div style="overflow-y: scroll; max-height: 290px;" class="ajax-direct-call-error-area">
    <p class="note"><strong>Note:</strong> The assets could not be fetched via the AJAX call. Here is the response:</p>
    <table>
        <tr>
            <td valign="top"><strong>Suggestion:</strong></td>
            <td>Select "WP Remote Post" as a method of retrieving the assets from the "Settings" page. If that doesn't fix the issue, just use "Manage in Front-end" option which should always work and <a target="_blank" href="{$submitTicketLink}">submit a ticket</a> about your problem.</td>
        </tr>
        <tr>
            <td valign="top"><strong>Output:</strong></td>
            <td valign="top">{wpacu_output}</td>
        </tr>
    </table>
</div>
HTML;

	    $wpacuObjectData['jquery_migration_disable_confirm_msg'] =
		    __('Make sure to properly test your website if you unload the jQuery migration library.', 'wp-asset-clean-up')."\n\n".
		    __('In some cases, due to old jQuery code triggered from plugins or the theme, unloading this migration library could cause those scripts not to function anymore and break some of the front-end functionality.', 'wp-asset-clean-up')."\n\n".
		    __('If you are not sure about whether activating this option is right or not, it is better to leave it as it is (to be loaded by default) and consult with a developer.', 'wp-asset-clean-up')."\n\n".
		    __('Confirm this action to enable the unloading or cancel to leave it loaded by default.', 'wp-asset-clean-up');

	    $wpacuObjectData['comment_reply_disable_confirm_msg'] =
		    __('This is worth disabling if you are NOT using the default WordPress comment system (e.g. you are using the website for business purposes, to showcase your products and you are not using it as a blog where people leave comments to your posts).', 'wp-asset-clean-up')."\n\n".
		    __('If you are not sure about whether activating this option is right or not, it is better to leave it as it is (to be loaded by default).', 'wp-asset-clean-up')."\n\n".
		    __('Confirm this action to enable the unloading or cancel to leave it loaded by default.', 'wp-asset-clean-up');

	    // "Tools" - "Reset"
	    $wpacuObjectData['reset_settings_confirm_msg'] =
		    __('Are you sure you want to reset the settings to their default values?', 'wp-asset-clean-up')."\n\n".
		    __('This is an irreversible action.', 'wp-asset-clean-up')."\n\n".
		    __('Please confirm to continue or "Cancel" to abort it', 'wp-asset-clean-up');

	    // [wpacu_pro]
	    $wpacuObjectData['reset_critical_css_confirm_msg'] =
		    __('Are you sure you want to remove all the critical CSS information?', 'wp-asset-clean-up')."\n\n".
		    __('This is an irreversible action.', 'wp-asset-clean-up')."\n\n".
		    __('Please confirm to continue or "Cancel" to abort it', 'wp-asset-clean-up');
	    // [/wpacu_pro]

	    $wpacuObjectData['reset_everything_except_settings_confirm_msg'] =
		    __('Are you sure you want to reset everything (unloads, load exceptions etc.) except settings?', 'wp-asset-clean-up')."\n\n".
		    __('This is an irreversible action.', 'wp-asset-clean-up')."\n\n".
		    __('Please confirm to continue or "Cancel" to abort it.', 'wp-asset-clean-up');

	    $wpacuObjectData['reset_everything_confirm_msg'] =
		    __('Are you sure you want to reset everything (settings, unloads, load exceptions etc.) to the same point it was when you first activated the plugin?', 'wp-asset-clean-up')."\n\n".
            __('This is an irreversible action.', 'wp-asset-clean-up')."\n\n".
            __('Please confirm to continue or "Cancel" to abort it.', 'wp-asset-clean-up');

	    // "Tools" - "Import & Export"
	    $wpacuObjectData['import_confirm_msg'] =
            __('This process is NOT reversible.', 'wp-asset-clean-up')."\n\n".
            __('Please make sure you have a backup (e.g. an exported JSON file) before proceeding.', 'wp-asset-clean-up')."\n\n".
            __('Please confirm to continue or "Cancel" to abort it.', 'wp-asset-clean-up');

	    // [wpacu_pro]
	    $wpacuObjectData['mark_license_valid_confirm'] =
		    __('Please note that you should continue only if you already tried "Activate License" button and it did not work to validate the license and you followed the alternative steps that were just mentioned on points 1 and 2.', 'wp-asset-clean-up')."\n\n".
		    __('Confirm this action or cancel it!', 'wp-asset-clean-up');

        $wpacuObjectData['inline_auto_js_files_confirm_msg'] = 'If you automatically want to inline all JavaScript (.js) files smaller than the chosen size in KB, please make sure to test your website after you enable this option.'."\n\n".
	                           'This can lead to broken functionality as, some JavaScript code could be meant to load later during the page load, so extra attention needs to be paid.'."\n\n".
	                           'The feature should be used mostly by advanced users (e.g. developers) who know what they are doing. Do not worry, your website can be fast, even if you do not enable this feature.'."\n\n".
	                           'To continue, please confirm by pressing "OK", or cancel to avoid enabling this option if you are not sure if it is the right thing to do.';
        // [/wpacu_pro]

		wp_localize_script(
			WPACU_PLUGIN_ID . '-script',
			'wpacu_object',
			apply_filters('wpacu_object_data', $wpacuObjectData)
		);

		wp_enqueue_script(WPACU_PLUGIN_ID . '-script');

		if ($page === WPACU_PLUGIN_ID . '_settings') {
		    // [Start] Chosen Style
			wp_enqueue_style(
                WPACU_PLUGIN_ID . '-chosen-style',
                plugins_url('/assets/chosen/chosen.min.css', WPACU_PLUGIN_FILE),
                array(),
				'1.8.7'
            );

			$chosenStyleInline = <<<CSS
#wpacu_hide_meta_boxes_for_post_types_chosen { margin-top: 5px; min-width: 320px; }
CSS;
			wp_add_inline_style(WPACU_PLUGIN_ID . '-chosen-style', $chosenStyleInline);
            // [End] Chosen Style

			// [Start] Chosen Script
			wp_enqueue_script(
				WPACU_PLUGIN_ID . '-chosen-script',
				plugins_url('/assets/chosen/chosen.jquery.min.js', WPACU_PLUGIN_FILE),
				array('jquery'),
				'1.8.7'
			);

			$chosenScriptInline = <<<JS
jQuery(document).ready(function($) { $('.wpacu-chosen-select').chosen(); });
JS;
			wp_add_inline_script(WPACU_PLUGIN_ID . '-chosen-script', $chosenScriptInline);
			// [End] Chosen Script
        }

	    global $pagenow;

		$isEditPostArea = ($pagenow === 'post.php' && Misc::getVar('get', 'post') && Misc::getVar('get', 'action') === 'edit');

		if (in_array($page, array(WPACU_PLUGIN_ID . '_assets_manager', WPACU_PLUGIN_ID . '_plugins_manager')) || $isEditPostArea) {
			// [Start] SweetAlert
			wp_enqueue_style(
				WPACU_PLUGIN_ID . '-sweetalert2-style',
				plugins_url('/assets/sweetalert2/dist/sweetalert2.css', WPACU_PLUGIN_FILE),
				array(),
				1
			);

			add_action('admin_head', static function() {
			?>
				<style <?php echo Misc::getStyleTypeAttribute(); ?> data-wpacu-own-inline-style="true">
				.wpacu-swal2-overlay {
					z-index: 10000000;
				}

                .wpacu-swal2-container {
                    z-index: 100000000;
                }

                .wpacu-swal2-html-container {
                    line-height: 30px;
                }

                .wpacu-swal2-title {
                    margin: 0 0 20px;
                    font-size: 1.2em;
                }

				.wpacu-swal2-text {
					line-height: 24px;
				}

				.wpacu-swal2-footer {
					text-align: center;
					padding: 13px 16px 20px;
				}

				.wpacu-swal2-button.wpacu-swal2-button--confirm {
					background-color: #008f9c;
				}

				.wpacu-swal2-button.wpacu-swal2-button--confirm:hover {
					background-color: #006e78;
				}
				</style>
			<?php
			});

			// Changed "Swal" to "wpacuSwal" to avoid conflicts with other plugins using SweetAlert
			wp_enqueue_script(
				WPACU_PLUGIN_ID . '-sweetalert2-js',
				plugins_url('/assets/sweetalert2/dist/sweetalert2.js', WPACU_PLUGIN_FILE),
				array('jquery'),
				1.1
			);

			// [wpacu_pro]
            $wpacuSiteUrl = site_url();

			$wpacuSubPage = (isset($_GET['wpacu_sub_page']) && $_GET['wpacu_sub_page']) ? $_GET['wpacu_sub_page'] : 'manage_plugins_front';

			$sweetAlertTwoScriptInline = <<<JS
jQuery(document).ready(function($) {
    $(document).on('change focusout blur', '.wpacu-handle-media-queries-load-field-input', function() {
        //console.log('Media Query Load Input Change');
        if ($(this).val().toLowerCase().indexOf('@media') > -1) {
            $(this).val($(this).val().toLowerCase().replace('@media', ''));
            wpacuSwal.fire({
                icon: "info",
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> I understand',
                html: "You have added @media in the input box which has been removed. It is not needed here as it not included within a CSS STYLE/LINK tag. For instance, if the CSS media query you had in mind is <strong>@media (min-width: 768px)</strong>, then you can just input <strong>(min-width: 768px)</strong>."
            });
         }
    });
    
    $(document).on('change focusout blur', '.wpacu_regex_rule_textarea', function() {
        var wpacuSiteUrl = '{$wpacuSiteUrl}';
        
        //console.log('RegEx Rule Textarea Input Change');
        if ($(this).val().toLowerCase().indexOf(wpacuSiteUrl) > -1) {
            $(this).val($(this).val().toLowerCase().replace(wpacuSiteUrl, ''));
            wpacuSwal.fire({
                width: 600,
                icon: "info",
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> I understand',
                html: "You have added the website URL in the input box which has been removed. It is not needed here as only the request URI is required. For instance, if you want the following URL to match - {$wpacuSiteUrl}<strong>/contact</strong> - then you can just use <strong>#/contact#</strong> as a rule. Also, being relative, it would look cleaner and still work as it should whenever you move from staging to live or vice-versa."
            });
        }
        
        var wpacuSubPage = '{$wpacuSubPage}';
        
        if (wpacuSubPage === 'manage_plugins_front' && $(this).val().toLowerCase().indexOf('wp-admin') > -1) {         
            wpacuSwal.fire({
                width: 650,
                icon: "warning",
                title: 'Heads up! You might be in the wrong tab',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> I understand',
                html: "You have added a RegEx rule that contains <strong>wp-admin</strong> to the input box and you are in the area where rules for the frontend view should be added (current tab: 'IN FRONTEND VIEW (your visitors)').<br /><br />If your intention is to apply the rule for an admin page, then you have to access the 'IN THE DASHBOARD /wp-admin/' tab."
            });
        }        
    });
    
    var wpacuPluginPath, wpacuUnloadLoggedInTarget, wpacuLoadLoggedInTarget;
    
    $(document).on('change focusout blur', '.wpacu_plugin_unload_logged_in, .wpacu_plugin_load_exception_logged_in', function() {
        wpacuPluginPath = $(this).attr('data-wpacu-plugin-path');
        wpacuUnloadLoggedInTarget = 'input[data-wpacu-plugin-path="'+ wpacuPluginPath +'"].wpacu_plugin_unload_logged_in';
        wpacuLoadLoggedInTarget = 'input[data-wpacu-plugin-path="'+ wpacuPluginPath +'"].wpacu_plugin_load_exception_logged_in';
 
        if ($(wpacuUnloadLoggedInTarget).prop('checked') && $(wpacuLoadLoggedInTarget).prop('checked')) {
               $(wpacuUnloadLoggedInTarget).prop('checked', false);
               $(wpacuLoadLoggedInTarget).prop('checked', false);
               
               wpacuSwal.fire({
                    width: 600,
                    icon: "info",
                    confirmButtonText: '<i class="fa fa-thumbs-up"></i> I understand',
                    html: "You have marked both 'Unload it if the user is logged in' and 'Always load it if the user is logged in' which cancel each other. The load exception rules, that are below the unload rules, always have priority. The checkboxes have been ticked off. Please review the unload and load exceptions rules again to avoid any confusion."
                });
               
           return false;
         }
    });    
});
JS;
			wp_add_inline_script(WPACU_PLUGIN_ID . '-sweetalert2-js', $sweetAlertTwoScriptInline);
			// [/wpacu_pro]
			// [End] SweetAlert
        }

		if (in_array($page, array(WPACU_PLUGIN_ID . '_plugins_manager', WPACU_PLUGIN_ID . '_overview', WPACU_PLUGIN_ID . '_bulk_unloads'))) {
			// [Start] Tooltipster Style
			wp_enqueue_style(
				WPACU_PLUGIN_ID . '-tooltipster-style',
				plugins_url('/assets/tooltipster/tooltipster.bundle.min.css', WPACU_PLUGIN_FILE),
				array(),
				1
			);
			// [End] Tooltipster Style

			// [Start] Tooltipster Script
			wp_enqueue_script(
				WPACU_PLUGIN_ID . '-tooltipster-script',
				plugins_url('/assets/tooltipster/tooltipster.bundle.min.js', WPACU_PLUGIN_FILE),
				array('jquery'),
				1
			);

			$tooltipsterScriptInline = <<<JS
jQuery(document).ready(function($) { $('.wpacu-tooltip').tooltipster({ contentCloning: true, delay: 0 }); });
JS;
			wp_add_inline_script(WPACU_PLUGIN_ID . '-tooltipster-script', $tooltipsterScriptInline);
			// [End] Tooltipster Script
        }

		// [wpacu_pro]
		if (isset($_GET['page'], $_GET['wpacu_sub_page']) && $_GET['page'] === WPACU_PLUGIN_ID . '_assets_manager' && $_GET['wpacu_sub_page'] === 'manage_critical_css') {
			wp_enqueue_script( 'wp-theme-plugin-editor' );
			wp_enqueue_style( 'wp-codemirror' );

			$cm_settings = array();
			$cm_settings['codeEditor'] = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
			$customPagesInlineJS = ''; // only fills if the "Custom Pages" tab is used

			if (isset($_GET['wpacu_for']) && $_GET['wpacu_for'] === 'custom-pages') {
				$cm_settings_custom_pages = array();
				$cm_settings_custom_pages['codeEditor'] = wp_enqueue_code_editor( array( 'type' => 'text/x-php' ) );
				wp_localize_script( 'jquery', 'wpacu_cm_settings_custom_pages', $cm_settings_custom_pages );

				$customPagesInlineJS = <<<JS
// Custom Pages
wp.codeEditor.initialize($('#wpacu-php-editor-textarea'), wpacu_cm_settings_custom_pages);
JS;
			}

			wp_localize_script( 'jquery', 'wpacu_cm_settings', $cm_settings );

			$wpacuCodeMirrorInlineScript = <<<JS
jQuery(document).ready(function($) {
  // Editable CSS
  var wpacuEditor = wp.codeEditor.initialize($('#wpacu-css-editor-textarea'), wpacu_cm_settings);
  
  {$customPagesInlineJS}
  
  $(document).on('change', '#wpacu_critical_css_status', function() {
      var \$wpacuTargetElement     = $('#wpacu-critical-css-options-area'),
          \$wpacuTargetTabMenuItem = $('#wpacu-critical-css-manager-tab-menu').find('.nav-tab-active > .wpacu-circle-status'),
          wpacuAnyCustomPageType   = $(this).attr('data-wpacu-custom-page-type');
      
      if ($(this).prop('checked')) {
          \$wpacuTargetElement.removeClass('wpacu-faded');
          
          if (wpacuAnyCustomPageType !== '') {
              $('.wpacu-circle-status[data-wpacu-custom-page-type="'+ wpacuAnyCustomPageType +'"]')
                .removeClass('wpacu-off').addClass('wpacu-on');
          }
          
          \$wpacuTargetTabMenuItem.removeClass('wpacu-off').addClass('wpacu-on');
      } else {
          \$wpacuTargetElement.addClass('wpacu-faded');
          
          if (wpacuAnyCustomPageType !== '') {
              $('.wpacu-circle-status[data-wpacu-custom-page-type="'+ wpacuAnyCustomPageType +'"]')
                .removeClass('wpacu-on').addClass('wpacu-off');
          }
          
          /* In case there are any other custom post types with critical CSS enabled, then keep the green circle for the "Custom Posty Types" main tab */
          if ($('#wpacu_custom_pages_nav_links').find('.wpacu-circle-status.wpacu-on').length === 0) {
              \$wpacuTargetTabMenuItem.removeClass('wpacu-on').addClass('wpacu-off');
          }
      }
  });
  
  $(document).on('submit', '#wpacu-critical-css-form', function() {
      if (wpacuEditor.codemirror.getValue() === '' && $('#wpacu_critical_css_status').prop('checked')) {
          alert('You have chosen to activate the critical CSS. You need to provide the CSS content before submitting this form.');
          return false;
      }
      
      $('#wpacu-updating-critical-css').addClass('wpacu-show').removeClass('wpacu-hide');
      $('#wpacu-update-critical-css-button-area').find('.button').prop('disabled', true).attr('value', 'UPDATING...');
  });
})
JS;
			$wpacuCodeMirrorInlineStyle = <<<CSS
.CodeMirror {
  border: 1px solid #ddd;
}

#wpacu-critical-css-options-area.wpacu-faded {
    opacity: 0.4;
}

#wpacu-css-editor-textarea {
    width: 100%;
    min-height: 600px;
}

#wpacu-update-critical-css-button-area {
    display: inline-block;
    margin: 20px 0 0 0;
}

#wpacu-update-critical-css-button-area input {
    padding: 5px 18px;
    height: 45px;
    font-size: 15px;
}

#wpacu-updating-critical-css.wpacu-hide {
    display: none;
}

#wpacu-updating-critical-css.wpacu-show {
    display: inline-block;
    margin: 13px 0 0 8px;
}
CSS;
			wp_add_inline_script('wp-theme-plugin-editor', $wpacuCodeMirrorInlineScript);
			wp_add_inline_style('wp-codemirror', $wpacuCodeMirrorInlineStyle);
		}
		// [/wpacu_pro]
	}

    /**
     *
     */
    private function enqueuePublicStyles()
    {
        $styleRelPath = '/assets/style.min.css';
        wp_enqueue_style(WPACU_PLUGIN_ID . '-style', plugins_url($styleRelPath, WPACU_PLUGIN_FILE), array(), self::assetVer($styleRelPath));
    }

    /**
     *
     */
    public function enqueuePublicScripts()
    {
        $scriptRelPath = '/assets/script.min.js';

	    wp_register_script(WPACU_PLUGIN_ID . '-script', plugins_url($scriptRelPath, WPACU_PLUGIN_FILE), array('jquery'), self::assetVer($scriptRelPath), true);

	    // [wpacu_pro]
	    wp_localize_script(
		    WPACU_PLUGIN_ID . '-script',
		    'wpacu_object',
		    apply_filters('wpacu_object_data', array(
                'ajax_url'    => admin_url('admin-ajax.php'),
                'plugin_id'   => WPACU_PLUGIN_ID,
                'plugin_name' => WPACU_PLUGIN_ID,
                'start_del_h' => Main::START_DEL_HARDCODED,
                'end_del_h'   => Main::END_DEL_HARDCODED
            ))
	    );
	    // [/wpacu_pro]

	    wp_enqueue_script(WPACU_PLUGIN_ID . '-script');
    }

	/**
	 * @param $relativePath
	 *
	 * @return false|string
	 */
	public static function assetVer($relativePath)
    {
		return @filemtime(dirname(WPACU_PLUGIN_FILE) . $relativePath) ?: date('dmYHi');
	}

	/**
	 * Prevent "?ver=" or "&ver=" from being stripped when loading plugin's own assets
	 * It will force them to refresh whenever there's a change in either of the files
	 *
	 * @param $src
	 * @param $handle
	 *
	 * @return mixed
	 */
	public function ownAssetLoaderSrc($src, $handle)
	{
	    if (in_array($handle, array(WPACU_PLUGIN_ID . '-style', WPACU_PLUGIN_ID . '-script'))) {
			$src = str_replace(
				array('?ver=',          '&ver='),
				array('?wpacuversion=', '&wpacuversion='),
				$src);
		}

		return $src;
	}

	/**
	 * @param $tag
	 * @param $handle
	 *
	 * @return mixed
	 */
	public function ownAssetLoaderTag($tag, $handle)
    {
		// Useful in case jQuery library is deferred too (rare situations)
		if ($handle === WPACU_PLUGIN_ID . '-script') {
			$tag = str_replace(' src=', ' data-wpacu-plugin-script src=', $tag);
		}

		return $tag;
	}

	// [wpacu_pro]
	/**
	 * @return bool
	 */
	public function isTaxonomyEditPage()
    {
        if ( ! $this->isTaxonomyEditPage ) {
            // [wpacu_pro]
            $mainPro = new MainPro();
	        $this->isTaxonomyEditPage = $mainPro->isTaxonomyEditPage();
	        // [/wpacu_pro]
        }

        return $this->isTaxonomyEditPage;
    }
    // [/wpacu_pro]
}
