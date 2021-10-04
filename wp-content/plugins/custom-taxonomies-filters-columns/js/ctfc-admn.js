(function( $ ){
	// CPT clicked checkbox ID & state
	var current_check_id, current_check;
	// Foreach checkbox ID & Taxonomy checkbox ID regular Expression
	var checkId, idRegExp;
	$( document ).ready(function(){
		//
		alignTaxonomiesLabels();
		// Disable all Taxonomy checkbox which belongs to unchecked CPT
		disableAllUncked();
		$( '.jst_ctft-cpt-check' ).click(function(){
			current_check_id = $( this ).attr( 'id' );
			current_check = $(this).prop( 'checked' );
			// Loops through all checkboxes
			$( 'input:checkbox' ).each(function(){
				// checkbox ID
				checkId = $( this ).attr( 'id' );
				idRegExp = new RegExp( '^' + current_check_id + '-[a-z0-9_-]+$', 'i' );
				if( idRegExp.test( checkId ) ){
					$( this ).prop({
						'checked': current_check,
						'disabled': ! current_check
					});
				}
			})
		});
	});
	function alignTaxonomiesLabels(){
		$( '.jst_ctfc-tax-label' ).each(function(){
			$( this ).parent( 'th' ).css( 'color', '#444' );
		});
	}
	function disableAllUncked(){
		// Foreach CPT checkbox current ID
		var crntId;
		// Loops through all Custom Post Type Checkboxes
		$( '.jst_ctft-cpt-check' ).each(function(){	
			// to reytreive unchecked ones
			if( ! $( this ).prop( 'checked' ) ){
				crntId = $( this ).attr( 'id' );
				// and find taxonomies ones
				$( 'input[id^="' + crntId + '-"]' ).each(function( i, el ){
					// to uncheck & disable them
					$( el ).prop({
						'checked': false,
						'disabled': true
					});
				});
			}
		});
	}
})( jQuery );