/*******************************************************************************
** File: wp-currency-converter.js
** Description: Helper functions for the WP Currency Converter plugin
** @since 1.0
*******************************************************************************/

jQuery(document).ready(function() {
		
	jQuery('#wpcc_restore_default_from_currencies').click(function() {
		var defaultCurrencies = jQuery('#wpcc_default_currencies').html();
		jQuery('#wpcc_from_currencies').val(defaultCurrencies);
	});
	
	jQuery('#wpcc_restore_default_to_currencies').click(function() {
		var defaultCurrencies = jQuery('#wpcc_default_currencies').html();
		jQuery('#wpcc_to_currencies').val(defaultCurrencies);
	});
	
	jQuery('#wpcc_copy_to_currencies').click(function() {
		var toCurrencies = jQuery('#wpcc_to_currencies').val();
		jQuery('#wpcc_from_currencies').val(toCurrencies);
	});
	
	jQuery('#wpcc_copy_from_currencies').click(function() {
		var fromCurrencies = jQuery('#wpcc_from_currencies').val();
		jQuery('#wpcc_to_currencies').val(fromCurrencies);
	});
	
});
