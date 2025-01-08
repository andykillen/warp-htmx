<?php

namespace WarpHtmx\Theme\Tailwind;

use WarpHtmx\Traits\Singleton;

class FileReader {

    protected $design = null;

    use Singleton;

    /**
     * Constructor
     * 
     * Reads the design.json file and sets the design property.
     * 
     * setup = true/false setup as an optional constant. 
     * preferences
     * 1. When setup will only use the design.json file in the child theme (template directory).
     * 2. When override is enabled will load the parent theme design.json file and then the child theme design.json file. Setting the child theme design.json file as the overide design.
     * @return void
     */
    public function __construct() {
        $this->design = json_decode(file_get_contents(get_template_directory() . '/design.json'), true);

        // TODO: work out how to also use both parent and child theme design.json files in the creation of TAILWIND CSS. 
        // it needs to be in the tailwind.config.js file as a place to look, but that needs to be setup to be only if exists
        // otherwise there will be an error.... I'm thinking dynamic generation of the files location array in the tailwind.config.js
        //
        // if( !defined('WARP_THEME_OVERRIDE_DESIGN') ) {
        //     define('WARP_THEME_OVERRIDE_DESIGN', get_option( warp_prefix('override_design'), false ) );
        // }

        // if( $this->design == null
        //     && WARP_THEME_OVERRIDE_DESIGN
        //     && file_exists(get_template_directory() . '/design.json')
        //     && file_exists(get_stylesheet_directory() . '/design.json') ) {
        //         $file1 = json_decode(file_get_contents(get_stylesheet_directory() . '/design.json'), true);
        //         $file2 = json_decode(file_get_contents(get_template_directory() . '/design.json'), true);
        //         $this->design = array_replace_recursive($file1, $file2);
        //         unset($file1, $file2); 
        // } else if( $this->design == null && file_exists(get_template_directory() . '/design.json') ) {
        //     $this->design = json_decode(file_get_contents(get_template_directory() . '/design.json'), true);
        // }
    }

    public function getDesign() {
        return $this->design;
    }

    public function getDesignValue($filter_name = '') {
        if( $filter_name == '' ) return '';
        if( strpos($filter_name, ' ')) $filter_name = str_replace(' ', '', $filter_name);
        $keys = explode('.', $filter_name);
        $value = $this->design;
        $keycount = count($keys);
        $counter = 0;
        foreach ($keys as $key) {
            $counter++;
            if (is_array($value) && array_key_exists($key, $value)) {
                // setup the value to be the next key.
                $value = $value[$key];

                // if there is a child called 'continer' and this key is the lowest child in the dot notation
                // return the 'container'.
                if (is_array($value) && array_key_exists('container', $value) && $counter == $keycount) {
                    return $value['container'];
                } 
            } else {
                return null;
            }
        }
        return ($value == null) ? '' : $value;
    }

}   