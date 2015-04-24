=== WP Currency Converter ===
Contributors: jkohlbach
Donate link: http://www.codemyownroad.com
Tags: currency conversion, currency converter, currency convert, conversion, currency, widget, currency widget, currency conversion widget, currency converter widget, foreign exchange, forex, forex widget
Requires at least: 3.0
Tested up to: 4.2
Stable tag: trunk

An ajax currency conversion widget to let your visitors convert currency amounts on the fly (powered by Google Finance).

== Description ==

This plugin adds a fancy ajax currency converter widget to provide your visitors with a convenient on the spot currency conversions powered by Google Finance.

You can add as many currencies as you like. It uses Google Finance to get up to date foreign exchange information.

Because it's all ajax powered, it doesn't require your visitors to refresh the page, providing a seemless user experience.

This is the perfect addition to your shopping cart page if you're looking for a reliable currency conversion widget that works.

This plugin also support localization, so if you have any translations please submit them via the support forum.

== Installation ==

To install WP Currency Converter:

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

To use this plugin, configure your currency lists in the Settings -> WP Currency Converter menu.

Now drag the widget to your desired sidebar and enjoy.

You can also use the Shortcode option, for example:
[wpcc title="Currency Converter" pretool_paragraph="Try this handy currency converter tool:" from_default=USD to_default=AUD]

Minimal styling is included so you can make it look as fancy as you like and match your shopping cart experience.

== Frequently Asked Questions ==

= I don't have any currencies in the drop downs =

Check your currency lists have data in them in the WP Currency Converter settings page found at Settings -> WP Currency Converter.

Make sure you use the three letter currency acronym as per the <a href="http://en.wikipedia.org/wiki/ISO_4217">ISO 4217 standard</a>

This plugin uses Google Finance for it's calculations so ensure the currency is one they support.

= Can I add more currencies? =

You can add any currency by it's currency acronym as long as it's in the <a href="http://en.wikipedia.org/wiki/ISO_4217">ISO 4217 standard</a> list.

= I always see the error: "Error: Currency conversion temporarily not available. Please try again." =

It's likely that you're not using a currency code that Google Finance recognises. To check you can try Googling for the currency conversion, eg. 25 AUD to USD (replace with your currency codes).

== Screenshots ==

N/A

== Upgrade Notice ==

N/A

== Changelog ==

* 1.4 Adding internationalization capabilities
 - Fix all echo output statements to be localizable
 - Add text domain wpcc
 - Added /lang folder to house .mo .po files

* 1.3 Changing to Google Finance
 - Switching API services from iGoogle to Google Finance (iGoogle was deactivated on 1st Nov 2013)
 - Added more sophisticated curl processing
 - Added backup to use file_get_content in cases where curl isn't available

* 1.2 Adding shortcode
 - Added shortcode "wpcc"
 - Added default currency list on activation on plugin activation for new installs

* 1.1 Fixing conversion widget
 - Ajax bug when user logged out

* 1.0 Initial version
 - Initial commit of WP Currency Converter
