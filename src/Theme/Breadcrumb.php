<?php
namespace WarpHtmx\Theme;

use WarpHtmx\Theme\Links;

class Breadcrumb {
    static public function make($id = false, $icons = true ){
        if ( is_single() ) {
           return self::createBreadcrumb( $id, $icons);
        }
    }

    static protected function createBreadcrumb( $id = false , $icons = true){
        if($id = false){
            $id = get_the_ID();
        }

        $terms = get_the_category($id);
        $count = count($terms);
        $counter = 1;
        $icon = "";
        $html = "";
        foreach($terms as $term){
            // prefix with parent cat if possible
            if($count == 1 && $term->parent != 0){
                $parentcat = get_term_by('id', $term->parent, 'category');
                $html .= self::crumb($parentcat);
            }
            //add other cats
            $html .= self::crumb($term);
            // append icon
            if($counter == $count && $icons == true){
                // $icon = "<a class='crumb-icon' href='". esc_url( Links::make_relative( get_category_link( $term->term_id ) ) )."' >".lm_parent_get_icon($term->slug)."</a>";
            }
            $counter++;
        }


        return self::layout($html, $icon);
    }

    static protected function crumb($term){
        $html = "<a
                    href='". esc_url( Links::make_relative( get_category_link( $term->term_id ) ) )."'
                    class='breadcrumb crumb-{$term->slug}'
                    data-action='click'
                    data-label='". esc_url( Links::make_relative(  get_category_link( $term->term_id ) ) )."'
                    data-category='breadcrumb'>{$term->name}</a>";
        return $html;
    }

    static protected function layout($html, $icon){
        return "<nav class='crumbset'>{$html} {$icon}</nav>";
    }
}