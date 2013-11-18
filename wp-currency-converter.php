<?php
/*******************************************************************************
** Plugin Name: WP Currency Converter
**
** Description: An ajax currency conversion widget to let your visitors convert currency amounts on the fly (powered by Google Finance).
**
** Author: Josh Kohlbach
** Author URI: http://www.codemyownroad.com
** Plugin URI: http://www.codemyownroad.com/products/wp-currency-converter
** Version: 1.4
** Text Domain: wpcc
*******************************************************************************/

require_once('wpccWidget.php'); // include the widget
require_once('wpccShortcode.php'); // include the shortcode

/*******************************************************************************
** wpccMenu()
**
** Setup the plugin options menu
**
** @since 1.0
*******************************************************************************/
function wpccMenu() {
	if (is_admin()) {
		register_setting('wp-currency-converter', 'wpccOptions');
		add_options_page('WP Currency Converter Settings', 'WP Currency Converter', 'administrator', __FILE__, 'wpccOptions', '');
	}
}

/*******************************************************************************
** wpccOptions()
**
** Plugin options page
**
** @since 1.0
*******************************************************************************/
function wpccOptions() {
	require_once('wpccSymbols.php');
	
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have suffifient permissions to access this page.') );
	}
	
	echo '<div class="wrap">' . screen_icon() . '<h2>WP Currency Converter</h2>';
	
	$wpccOptions = get_option('wpccOptions');
	
	if (!isset($wpccOptions['from_currencies']) || empty($wpccOptions['from_currencies'])) {
		$wpccOptions['from_currencies'] = implode("\n", array_keys($currency));
	}
	
	if (!isset($wpccOptions['to_currencies']) || empty($wpccOptions['to_currencies'])) {
		$wpccOptions['to_currencies'] = implode("\n", array_keys($currency));
	}
	
	echo '<div id="wpcc_default_currencies" style="display: none;">' . implode("\n", array_keys($currency)) . '</div>';
	
	echo '<form method="post" action="options.php">';
	
	wp_nonce_field('update-options');
	settings_fields( 'wp-currency-converter' );
	
	echo '<table class="form-table" style="width: 430px">';
	
	echo '<tr valign="top">
	<th scope="col" style="white-space: nowrap;">From Currency List:</th>
	<th scope="col" style="white-space: nowrap;">To Currency List:</th>
	</tr>
	
	<tr valign="top">
	
	<td>
		<textarea id="wpcc_from_currencies" name="wpccOptions[from_currencies]" rows="20" cols="10">' . $wpccOptions['from_currencies'] . '</textarea>
		<p><span class="description">' . __('One currency code per line', 'wpcc') . '<br /><a href="#" id="wpcc_restore_default_from_currencies">' . __('Click to restore defaults', 'wpcc') . '</a><br /><a href="#" id="wpcc_copy_to_currencies">' . __('Copy "To" currencies', 'wpcc') . '</a></span></p>
	</td>
	
	<td>
		<textarea id="wpcc_to_currencies" name="wpccOptions[to_currencies]" rows="20" cols="10">' . $wpccOptions['to_currencies'] . '</textarea>
		<p><span class="description">' . __('One currency code per line', 'wpcc') . '<br /><a href="#" id="wpcc_restore_default_to_currencies">' . __('Click to restore defaults', 'wpcc') . '</a><br /><a href="#" id="wpcc_copy_from_currencies">' . __('Copy "From" currencies', 'wpcc') . '</a></span></p>
	</td>
	
	</tr>
	
	<tr valign="top">
	<td colspan="2">
		<input type="submit" class="button-primary" value="Save Settings" />
	</td>
	</tr>';
	
	echo '</form></div>';
}

/*******************************************************************************
** wpccAjaxConvert()
**
** Convert the given amounts
**
** @since 1.0
*******************************************************************************/
function wpccAjaxConvert() {
	require_once('wpccSymbols.php'); // currency symbols for conversions
	
	$amount = $_POST['wpcc_currency_amount'];
	$currency_from = $_POST['wpcc_currency_from'];
	$currency_to = $_POST['wpcc_currency_to'];
	
	if(!strstr($amount, '.')){
		$amount = $amount . '.00';
	}
	
	// Change to using Google Finance as iGoogle was deactivated on 1st Nov 2013
	$url = 'https://www.google.com/finance/converter?a=' . urlencode($amount) . '&from=' . urlencode($currency_from) . '&to=' . urlencode($currency_to);
	
	if (function_exists('curl_init')) { // cURL is installed on the server so use this preferably
		$ch = curl_init();
		
		$ua = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13';
		
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/html"));
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	
		$responseString = curl_exec($ch);
		
		curl_close($ch);
	} else { // try using file_get_contents, though this causes some issues on some servers
		$responseString = file_get_contents($url, true);
	}
	
	preg_match('/([\d\.]+) ' . $currency_to . '/', $responseString, $matches);
	
	if (!empty($matches) && isset($matches[1])){
		$output = sprintf("%.2f", $matches[1]);
		echo '<p>' . __('Amount', 'wpcc') . ' (' . $currency_to . '): ' . $currency[$currency_to] . $output . '</p>';
	} else {
		echo '<p class="wpcc_error">' . __('Error: Currency conversion temporarily not available. Please try again.', 'wpcc') . '</p>';
	}
	
	exit();
}

/*******************************************************************************
** wpccOnActivation()
**
** Activate the plugin and load default options
**
** @since 1.0
*******************************************************************************/
function wpccOnActivation() {
	require_once('wpccSymbols.php'); // currency symbols for conversions
	$wpccOptions = get_option('wpccOptions');
	
	if (!isset($wpccOptions['from_currencies']) || empty($wpccOptions['from_currencies']))
		$wpccOptions['from_currencies'] = implode("\n", array_keys($currency));
	
	if (!isset($wpccOptions['to_currencies']) || empty($wpccOptions['to_currencies']))
		$wpccOptions['to_currencies'] = implode("\n", array_keys($currency));
		
	update_option('wpccOptions', $wpccOptions);
		
}

/*******************************************************************************
** wpccInit()
**
** Initialize plugin
**
** @since 1.0
*******************************************************************************/
function wpccInit() {
	add_action('admin_menu', 'wpccMenu');
	
	if (!is_admin()) {
		wp_enqueue_script('wp-currency-converter', plugins_url('wp-currency-converter/js/wp-currency-converter.js'), array('jquery'));
		wp_enqueue_style('wp-currency-converter', plugins_url('wp-currency-converter/css/wp-currency-converter.css'));
	}
}

/*******************************************************************************
** wpccAdminInit()
**
** Initialize admin side
**
** @since 1.0
*******************************************************************************/
function wpccAdminInit() {
	wp_enqueue_script('wp-currency-converter-admin', plugins_url('wp-currency-converter/js/wp-currency-converter-admin.js'), array('jquery'));
}

/*******************************************************************************
** wpccHead()
**
** Initialize header
**
** @since 1.0
*******************************************************************************/
function wpccHead() {
	if (!is_admin()) {
		echo '<script type="text/javascript">var wpccAjaxLink = "' . admin_url('admin-ajax.php') . '";</script>';
	}
}

/*******************************************************************************
** wpccPluginLoaded()
**
** Plugin loaded, do things like load the text domain
**
** @since 1.4
*******************************************************************************/
function wpccPluginLoaded() {
	$plugin_dir = basename(dirname(__FILE__));
	load_plugin_textdomain('wpcc', false, $plugin_dir);
}

add_action('plugins_loaded', 'wpccPluginLoaded');
register_activation_hook(__FILE__, 'wpccOnActivation');
add_action('init', 'wpccInit');
add_action('admin_init', 'wpccAdminInit');
add_action('wp_head', 'wpccHead');
add_action('wp_ajax_wpccAjaxConvert', 'wpccAjaxConvert');
add_action('wp_ajax_nopriv_wpccAjaxConvert', 'wpccAjaxConvert');
