<?php

namespace WarpHtmx\Theme;

class Links{

    static protected $relative = true;

    static public function get_relative_path($id = false) {
        if(!$id){
            $id = get_the_ID();
        }
        if(self::$relative) {
            return wp_make_link_relative( get_permalink( $id ) );
        } 
        return get_permalink( $id );
    }

    static public function make_relative( $url ){
        if(self::$relative) {
            return wp_make_link_relative( $url );
        } 
        return $url ;
    }

    static public function relative_path ($id = false){
        echo self::get_relative_path( $id );
    }
}