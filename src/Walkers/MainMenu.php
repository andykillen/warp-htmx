<?php

namespace WarpHtmx\Walkers;

use WarpHtmx\Theme\Links;

class MainMenu extends \Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

        // Passed classes.
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

        // Build HTML.
        $output .= $indent . '<li class="' . $class_names . '">';

        $url = $item->url;

        $warp_attributes = [ 
            'hx-push-url' =>  esc_url( Links::make_relative($url) ), 
            'echo' => false,
            'method' => 'get',
            'hx-target' => '#global',
            'href' => esc_url($url) 
        ];

        if($item->attr_title) {
            $warp_attributes['title'] = $item->attr_title;
        }
        if($item->target) {
            $warp_attributes['target'] = $item->target;
        }
        if($item->xfn) {
            $warp_attributes['rel'] = $item->xfn;
        }

        // TODO: fix request. need to add the object and the directory structure. to the htmx gateway.
        
        if($item->type == 'taxonomy') {
            $warp_request= 'taxonomy?id=' . $item->object_id . '&type='. $item->object .'&object=' . $item->object ;
        } else {
            $warp_request= 'post?id=' . $item->ID;
        }
        
       // TODO add other stuff to attributes and then deal with OBJECT TYPES. this is only POSTS right now.
        $warp_attributes['data-action'] = "main_menu";
        $warp_attributes['data-label'] = Links::make_relative( $url );
        $warp_attributes['data-category'] = "menus" ;
        // TODO : decide if we want to change the to not exist.  We are not using it at all in CSS right now.
        $warp_attributes['class']= ( $depth > 0 ? apply_filters('main_menu_submenu_classes', 'text-slate-600 ml-3', $depth) :  apply_filters('main_menu_classes', 'text-slate-800') );
        // Build link first.
        $content = $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after ;
        // create a WARP HTMX link
        $link = warp_link($url, $content, $warp_request, $warp_attributes );
        // Add the link to the output.
        $item_output = sprintf( '%1$s%2$s%3$s',
            $args->before,
            $link,
            $args->after
        );
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }
}