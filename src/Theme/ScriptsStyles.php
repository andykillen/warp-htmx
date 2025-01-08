<?php

namespace WarpHtmx\Theme;

use WarpHtmx\ScriptLocalizations;
use WarpHtmx\Theme\Theming\ColorMode;
use WarpHtmx\ThemeIcons;

class ScriptsStyles {

    static public function init(){
        add_action( 'wp_enqueue_scripts', [__CLASS__,'frontend_scripts'] );
        add_action( 'wp_enqueue_scripts', [__CLASS__,'frontend_styles'],1 );
        
       
        add_action( 'wp_enqueue_scripts', [__CLASS__,'remove_frontend_styles'],100 );
       
        add_filter( 'asl_load_css_js', [__CLASS__, 'remove_search_scripts']);
        add_filter( 'asl_load_js', [__CLASS__, 'remove_search_scripts']);
        

        add_action( 'wp_footer', [__CLASS__,'frontend_remove_script'],1 );

        add_action( 'admin_enqueue_scripts', [__CLASS__,'admin_scripts'] );
        add_action( 'admin_enqueue_scripts', [__CLASS__,'admin_styles'] );

        add_action( 'login_enqueue_scripts', [__CLASS__,'login_scripts'], 1 );
        add_action( 'login_enqueue_scripts', [__CLASS__,'login_styles'], 10 );
    }

    /**
     * Load all scripts
     */

     static public function remove_search_scripts($should_exit) {
        if( !is_page()){
            return true;
        }
        return $should_exit;
     }
     
     /**
      * queue scripts for frontend only
      *
      * @return void
      */
    static public function frontend_scripts(){
        //Default always loaded scripts
        $scripts = [
            'theme' =>[],
        ];

        foreach($scripts as $script => $dependency){            
            if (wp_script_is( $script, 'registered' )) {
                wp_enqueue_script( $script);
            } else {
                wp_enqueue_script( 
                        $script,
                        get_template_directory_uri()."/disti/js/{$script}.min.js",
                        $dependency,
                        self::cache_bust("/disti/js/{$script}.min.js"),
                        true
                    );
            }
        }

        wp_localize_script( 'theme', 'theme', ScriptLocalizations::as_array() );

        if(is_singular()){
            wp_enqueue_script( 'comment-reply' );
        }

    }

    /**
     * remove scripts as needed from the front end.
     *
     * Relies on all scripts being loaded via the footer.
     *
     * @return void
     */
    static public function frontend_remove_script(){
        $array_of_scripts = [
            'wp-embed',
            'jquery-migrate',
            'jquery-core',
            'wp-polyfill',
            'wp-polyfill-formdata',
            'wp-polyfill-fetch',
            'wp-polyfill-node-contains',
            'wp-polyfill-node-prototype-remove'];

        $array_of_scripts = apply_filters('warp_remove_frontend_scripts', $array_of_scripts);            
        foreach($array_of_scripts as $script){
            wp_dequeue_script($script);
        }
            
        //     // wp_dequeue_script( 'cf7-material-design' );
        //     // wp_dequeue_style( 'cf7md_roboto' );
        //     // wp_dequeue_style( 'cf7-material-design' );
         
    }
     /**
      * queue scripts for login page only
      *
      * @return void
      */
    static public function login_scripts(){

    }

     /**
      * queue scripts for admin pages only
      *
      * @return void
      */
    static public function admin_scripts($hook){
        $scripts_array = [
            'video-admin' => [],
        ];

        foreach($scripts_array as $script => $dependency ){
            wp_enqueue_script( "{$script}",
                get_template_directory_uri()."/disti/js/admin/{$script}.js",
                $dependency,
                self::cache_bust("/disti/js/admin/{$script}.js"),
                true
            );
        }



        if ( ! in_array( $hook, ['post.php', 'post-new.php'] ) ) {
            return;
        }

        wp_enqueue_script( 'page-template', get_template_directory_uri() . '/js/admin/page-template-fields.js', ['jquery'] );

    }

    /**
     * remove unneeded styles
     *
     * @return void
     */
    static public function remove_frontend_styles(){
        // remove WP blocks from none singular pages
        if(!is_singular()){
            wp_dequeue_style( 'wp-block-library' );
        }
    }

    /**
     * Load all styles
     */
    static public function frontend_styles(){
        $styles = [];
        $base_style = 'tailwind';
        

        $styles[$base_style] = [
                        'dependency' => [],
                        'media' => 'all'
                    ];

        $styles['print'] = [
                        'dependency' => [$base_style],
                        'media' => 'all'
                    ];
        if(count($styles) > 0) {
            foreach($styles as $style => $settings){
                if(file_exists(get_template_directory() . "/disti/css/{$style}.css")) {
                    wp_enqueue_style( "{$style}",
                           get_template_directory_uri()."/disti/css/{$style}.css",
                           $settings['dependency'],
                           self::cache_bust("/disti/css/{$style}.css"),
                           $settings['media']
                        );
                }
            }
        }

        if(isset($styles['tailwind'])){
            $val = new ColorMode();
            wp_add_inline_style( 'tailwind',  $val->getColors() );
        }

    }

    static public function login_styles(){

    }

    static public function admin_styles(){

        $admin_styles = [
            'video-admin'=>[
                'dependency' => [],
                'media' => 'all'
             ],
        ];

        foreach($admin_styles as $style => $settings){
            wp_enqueue_style( "{$style}",
                           get_template_directory_uri()."/disti/css/admin/{$style}.css",
                           $settings['dependency'],
                           self::cache_bust("/disti/css/admin/{$style}.css"),
                           $settings['media']
                        );
        }

    }


    static public function cache_bust($path){
        if(file_exists(get_template_directory() . $path )){
            return filemtime(get_template_directory() . $path );
        }
        return null;
    }

}