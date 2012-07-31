/*******************************************************************************
** File: wp-currency-converter.js
** Description: Helper functions for the WP Currency Converter plugin
** @since 1.0
*******************************************************************************/

jQuery(document).ready(function() {
	jQuery('#wpcc_converting').hide();
	
	jQuery('#wpcc_convert').click(function() {
		var wpcc_currency_amount = jQuery('#wpcc_currency_amount').val();
		var wpcc_currency_from = jQuery('#wpcc_currency_from').val();
		var wpcc_currency_to = jQuery('#wpcc_currency_to').val();
		
		jQuery('#wpcc_converting').show();
		
		jQuery.post(
			wpccAjaxLink,
			{
				action: 'wpccAjaxConvert',
				wpcc_currency_amount: wpcc_currency_amount,
				wpcc_currency_from: wpcc_currency_from,
				wpcc_currency_to: wpcc_currency_to
			},
			function(results) {
				jQuery('#wpcc_results').html(results);
				jQuery('#wpcc_results').slideDown(400);
				jQuery('#wpcc_converting').delay(400).hide();
			}
		);
	});
	
});
