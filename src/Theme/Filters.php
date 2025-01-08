<?php

namespace WarpHtmx\Theme;

use WarpHtmx\Theme\Tailwind\FileReader;
class Filters {
    static public $design = [];


    /**
    * Call this init method from the functions.php
    */
    static function init(){
        add_filter( 'the_excerpt', [__CLASS__, 'the_excerpt' ], 10, 1);
		add_filter( 'body_class', [__CLASS__, 'body_class' ] );
        add_filter( 'post_class', [__CLASS__, 'post_class' ] );
        add_filter( 'theme_body_class', [__CLASS__, 'theme_body_class'], 10 );
        add_filter( 'theme_post_class', [__CLASS__, 'theme_post_class'], 10 );
        add_filter( 'woocommerce_quantity_input_classes', [__CLASS__, 'woocommerce_quantity_input_classes'], 10, 2);
        // all pagination links for archives, curretly only used for the UL element adaption.
        add_filter( 'paginate_links_output', [__CLASS__, 'paginate_links_output'], 10, 2);
    }

    /**
     * This method is used to add a class attribute to an element. returns the class="..." attribute for a given filter name.
     *
     * if the filter name is not found in the design.json file, it will return the default value.
     *
     * If debug is set to true, it will add a warp-htmx-filter attribute to the element. 
     *
     * warp-htmx-filter="buttons.primary"
     *
     * @param string $filter_name The filter name to use.
     * @param array $options An array of options to use.
     * 
     * @return string the class attribute for the element.
     */
    static public function addClass($filter_name, $options = []) {
        $options = wp_parse_args($options, 
            [
                'echo'      => true,
                'append'    => '',
                'prepend'   => '',
                'default'   => '',
            ]
        );
        $output = '';
        $default_value = self::getDesignKey($filter_name);

        if( WARP_HTMX_THEME_DEBUG ) {
            $output = 'warp-htmx-filter="' . $filter_name . '"';
        }
        $options = apply_filters("warp_add_class_{$filter_name}", $options);
        $classes = ($default_value != '') ? $default_value : $options['default'];
        $output .= ' class="' . rtrim(ltrim(sprintf('%s %s %s', $options['prepend'], $classes, $options['append']))).'"';
        return $output;
    }

    /**
     * This method only returns the CSS class values, not the class attribute.
     * 
     * i.e. "class1 class2 class3"
     * 
     * @param string $filter_name The filter name to use.
     * @param array $options An array of options to use.
     * 
     * @return string the CSS class for the element.
     */
    static public function getClass($filter_name, $options = []) {
        $default_value = self::getDesignKey($filter_name);
        $options = apply_filters("warp_add_class_{$filter_name}", $options);
        $classes = ($default_value != '') ? $default_value : $options['default'];
        return  esc_attr(
                    rtrim(
                        ltrim(
                            sprintf('%s %s %s', $options['prepend'], $classes, $options['append'])
                        )
                    )
                );
    }

    /**
     * This method is used to get the design key from the design.json file.
     * 
     * It uses dot.notation to This can be a single key or multiple keys separated by a comma.
     * 
     * @param string $filter_name The filter name to use.
     * 
     * @return string the design key value.
     */
    static public function getDesignKey($filter_name = '') {
        if( $filter_name == '' ) return;
        if( strpos($filter_name, ',') !== false ) {
            $filter_names = explode(',', $filter_name);
            $output = '';
            foreach($filter_names as $filter_name) {
                $output .= FileReader::getInstance()->getDesignValue($filter_name) . ' ';
            }
            return $output;
        }
        return FileReader::getInstance()->getDesignValue($filter_name);
    }

    /**
     * Filter the classes for the quantity input field in WooCommerce.
     * 
     * @param array $classes The classes to add to the input field.
     * @param WC_Product $product The product object.
     * 
     * @return array The classes to add to the input field.
     */
    static public function woocommerce_quantity_input_classes($classes, $product) {
            $classes[] = warp_get_class('woocommerce.quantity_input');
            return $classes;
    }

    /**
     * Filter the body class to add custom classes based on the page type.
     * 
     * This is not needed for Tailwind, just good practice for debugging.
     */
    static public function body_class( $classes ) {
        if ( is_404() ) {
            $classes[] = 'error404';
        } elseif ( is_archive() ) {
            $classes[] = 'archive';
            if ( is_category() || is_tag() || is_tax() ) {
                $classes[] = 'taxonomy-' . get_queried_object()->taxonomy;
            }
            if ( is_author() ) {
                $classes[] = 'author';
            }
            if ( is_date() ) {
                $classes[] = 'date';
            }
            if ( is_post_type_archive() ) {
                $classes[] = 'post_type-' . get_post_type();
            }
        } elseif ( is_singular() ) {
            $classes[] = 'singular';
            $classes[] = 'singular-' . get_post_type();
        }

        $classes[] = apply_filters('theme_body_class',warp_get_class('html.body') );
        return $classes;
    }

    static public function post_class( $classes ) {
        if ( is_singular() ) {
            $classes[] = 'id-' . get_the_ID();
            $classes[] = 'entry-' . get_post_type();
        }
        $classes[] = apply_filters('theme_post_class',warp_get_class('defaults.' .  get_post_type()) );
        return $classes;
    }

    // todo: hook into this filter to add custom classes to the body tag when I setup the admin panel
    static public function theme_body_class($classes_string){
        return $classes_string;
    }

    // todo: hook into this filter to add custom classes to the article tag when I setup the admin panel
    static public function theme_post_class($classes_string){
        return $classes_string;
    }

    /**
     * Filter the excerpt to add a paragraph tag with Tailwind
     * styling. 
     * 
     * @param string $excerpt
     * 
     * @return string
     */
    static public function the_excerpt($excerpt) {
        return warp_adapt_html(strip_tags($excerpt, warp_allowed_excerpt_tags()));
    }


    /**
     * Generic filter to add a flex class to the pagination links holder.
     */
    static public function paginate_links_output($html, $args) {
        $newClass = warp_get_class('pagination.ul');
        return preg_replace_callback(
            '/<ul\s+[^>]*class=["\']([^"\']*)["\']([^>]*)>/i',
            function ($matches) use ($newClass) {
                // Reconstruct the <ul> tag with the new class
                return '<ul class="' . esc_attr($newClass) . '"' . $matches[2] . '>';
            },
            $html
        );
    }
}
