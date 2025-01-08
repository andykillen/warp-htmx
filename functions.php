<?php
/**
 * Constants
 *
 */

 define('WARP_HTMX_THEME_DIR_NAME', 'warp-htmx');
 define('WARP_HTMX_THEME_VERSION', '1.0.1');
 define('WARP_HTMX_TEXT_DOMAIN', 'warp-htmx');
 if(!defined('WARP_HTMX_THEME_DEBUG')) {
    define('WARP_HTMX_THEME_DEBUG', true);
 }
 
 /**
  * Autoloader (created on composer using PSR-4)
  */
 require dirname(__FILE__) . '/vendor/autoload.php' ;
 // standard functions for WarpHtmx Theme
 require dirname(__FILE__) . '/inc/functions.php';
 // specific functions used for WooCommerce. *** where is disables woo commerce styles ***
 require dirname(__FILE__) . '/inc/woocommerce.php';
 // plugable functions for the theme, mostly in place to allow for child themes to override, or continue to work when plugins are disabled.
 require dirname(__FILE__) . '/inc/pluggables.php';
 /**
  * Load the theme setup to set things like text domain, thumbnails, customizer
  */
// setup theme, things like after_theme setup, widgets, etc.
WarpHtmx\Theme\Setup::init();
// load scripts and styles as needed
WarpHtmx\Theme\ScriptsStyles::init();
// Where the add_action() items are setup
WarpHtmx\Theme\Actions::init();
// Where the add_filter() items are setup
WarpHtmx\Theme\Filters::init();
// Setup the Tailwind stuff, inject the inline css into the head
new WarpHtmx\Theme\Tailwind\Settings();