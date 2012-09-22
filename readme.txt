=== WP Currency Converter ===
Contributors: jkohlbach
Donate link: http://www.codemyownroad.com
Tags: currency conversion, currency converter, currency convert, conversion, currency, widget, currency widget, currency conversion widget, currency converter widget, foreign exchange, forex, forex widget
Requires at least: 3.0
Tested up to: 3.2
Stable tag: trunk

A widget to provide an ajax currency conversion widget calculator powered by Google.

== Description ==

This plugin adds a currency converter widget to provide your visitors with a convenient on the spot currency conversions powered by Google.

You can add as many currencies as you like. It uses Google's API to get up to date foreign exchange information.

It doesn't require refreshing the page, everything is done via Ajax to provide a seemless user experience.

This is the perfect addition to your shopping cart page.

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

This plugin uses Google for it's calculations so ensure the currency is one they support.

== Screenshots ==

N/A

== Upgrade Notice ==

N/A

== Changelog ==

* 1.2 Adding shortcode
 - Added shortcode "wpcc"
 - Added default currency list on activation on plugin activation for new installs

* 1.1 Fixing conversion widget
 - Ajax bug when user logged out

* 1.0 Initial version
 - Initial commit of WP Currency Converter