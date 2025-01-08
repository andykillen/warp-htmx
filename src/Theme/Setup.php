<?php

namespace WarpHtmx\Theme;

class Setup {

    /**
    * Call this init method from the functions.php
    */
    static function init(){
		// add action for things like text domain and thumbnails. Needs to be loaded before child theme.
		add_action( 'after_setup_theme', [__CLASS__, 'after_theme_setup' ] );
		// load widgets area
	    add_action( 'widgets_init', [__CLASS__, 'register_widget_area' ] );
		// after turning on the theme do this
		add_action( 'after_switch_theme', [__CLASS__, 'after_switch_theme' ] );
    }


    /**
    * Add the text domain to the theme (look for po files)
    *
    * The system first looks for the existance of the wp-content/languages/WARP_HTMX_THEME_DIR_NAME
    * directory and then loads the files from there if it exists
    *
    *
    * @return void
    */
    static public function after_theme_setup(){
        if(file_exists(WP_CONTENT_DIR."/languages/".WARP_HTMX_THEME_DIR_NAME)){
            load_theme_textdomain( WARP_HTMX_TEXT_DOMAIN, WP_CONTENT_DIR."/languages/".WARP_HTMX_THEME_DIR_NAME );
        } else {
            load_theme_textdomain( WARP_HTMX_TEXT_DOMAIN, get_template_directory() . '/languages' );
        }

        add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Custom background color.
		add_theme_support(
			'custom-background',
			array(
				'default-color' => 'ffffff',
			)
		);


		add_post_type_support( 'page', 'excerpt' );

		$woo_settings = [
			'thumbnail_image_width' => 360,
			'single_image_width'    => 760,
			'product_grid'    => [
				'default_rows'    => 3,
				'min_rows'        => 2,
				'max_rows'        => 8,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 5,
			],
		];
		add_theme_support( 'woocommerce', apply_filters('theme_woo_settings', $woo_settings) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'main-menu' => esc_html_x( 'Main menu','admin screen setting', WARP_HTMX_TEXT_DOMAIN ),
			'footer-menu' => esc_html_x( 'Footer menu','admin screen setting', WARP_HTMX_TEXT_DOMAIN ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		] );


	}
	
	// Have no plan for widgets yet. open to anything
	static public function register_widget_area(){
		
		$areas = [
			[
				'name' => 'primary',
				'description' => 'is sidebar',
				'id' => 'sidebar-',
				'tag' => 'div',
				'class' => 'sidebar',
			],

		];
	
		if(count($areas) > 0) {
			foreach ( $areas as $widgetinfo){
				foreach(range(1,apply_filters('theme_menu_widget_count', 7)) as $i) {
					register_sidebar( [
						'name' => $widgetinfo['name'] . $i,
						'id' => $widgetinfo['id'] . $i,
						'description' => $widgetinfo['description'],
						'before_widget' => '<'.$widgetinfo['tag'].' id="%1$s" class="widget '.$widgetinfo['class'].' widget-area-'.$widgetinfo['id']. $i .' %2$s">',
						'after_widget'  => '</'.$widgetinfo['tag'].'>',
						'before_title'  => '<span class="widget-title">',
						'after_title'   => '</span>',
					 ] );
				}
			}
		}
		
	}

	
	/**
	 * Runs after theme has been changed to a Citizens Voice theme
	 *
	 * @return void
	 */
	static public function after_switch_theme(){
		// Set the thumbnail to be 150x85
		update_option( 'thumbnail_size_w', 80 );
		update_option( 'thumbnail_size_h', 80 );
		// Set the medium image to be 300 x 169
		update_option( 'medium_size_w', 360 );
		update_option( 'medium_size_h', 360 );
	}

}