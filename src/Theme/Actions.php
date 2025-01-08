<?php

namespace WarpHtmx\Theme;

class Actions
{
    static public function init() {

        add_action('woocommerce_before_cart_table', [__CLASS__, 'before_cart_table'], 10);
        add_action('warp_theme_before_main_content', [__CLASS__, 'before_main_content'], 10);
        add_action('woocommerce_before_main_content', [__CLASS__, 'before_main_content'], 10);
        add_action('warp_theme_after_main_content', [__CLASS__, 'after_main_content'], 10);
        add_action('woocommerce_after_main_content', [__CLASS__, 'after_main_content'], 10);
    }

    /**
     * Add a title to the cart page.
     * 
     * It just makes it look better and easier to understand where you are.
     * 
     * @return string
     */
    static public function before_cart_table() {
        return '<h1 '.warp_add_class('html.h1', ['echo' => false]).'>'. __('Shopping Cart', WARP_HTMX_TEXT_DOMAIN)  .'</h1>';
    }

    /** 
     * Setup the Masthead and Main Navigation.
     * 
     * Masthead = logo and top line navigation
     * Main Navigation = main menu
     * 
     * @return void
     */
    static public function before_main_content() {
        do_action("before_masthead");
            get_template_part('template_parts/layout/masthead', apply_filters('selected_masthead', get_post_type())); 
        do_action("after_masthead"); 
            ?><div id="global" class="<?php echo apply_filters('global_class', '') ?>"><?php
        do_action('before_main_navigation');
            get_template_part('template_parts/navigation/main', apply_filters('warp_theme_main_menu_type','')); 
        do_action('after_main_navigation');
            ?><main id="main" class="<?php echo apply_filters('main_class', 'content-grid') ?>"><?php
    }

    /**
     * Close the main content and #global divs.
     * 
     * @return void
     */
    static public function after_main_content() {
        echo '</main></div>';
    }
}

