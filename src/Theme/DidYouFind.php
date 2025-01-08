<?php

namespace WarpHtmx\Theme;

use WarpHtmx\Theme\Links;

class DidYouFind {

    static function init(){
        if( get_theme_mod('show_useful', "yes") == 'no') {
            return;
        }
        add_action( 'post_footer_bottom', [__CLASS__, 'show'], 1,100);
    }

    static function show($content){
        global $post;

        if(!is_object($post)) {
            return $content;
        }

        $show = get_post_meta( $post->ID, 'show_did_you_find', true);

        if($show == false){
            $show = get_theme_mod('show_useful', "yes");
        }

        if( is_singular(apply_filters('did_you_find_show_metabox', ['post'])) && $show == 'yes'){
            $content .= self::html($post->ID);
        }
        echo $content;
    }

    static function html($id){
        ob_start();
        $question = get_post_meta( $id, 'did_you_find', true);

        if($question == false){
            $question = get_theme_mod('lm_useful_text', _x(  'did you find this useful?', 'admin screen setting', WARP_HTMX_TEXT_DOMAIN));
        }

        ?>
        <script>
        dataLayer.push({
            events : {
                label : "<?php echo Links::make_relative( get_permalink() ); ?>",
                action : "button_loaded",
                category : "<?php echo $question ?>"
            },
            event : "interaction"
        });
        </script>

        <div class='did-you-find' id='did-you-find'>
            <span><?php echo $question ?></span>
            <button class='button-yes' data-label='<?php echo Links::make_relative( get_permalink() ); ?>' data-action='yes' data-category='did_you_find'><?php _e('yes', WARP_HTMX_TEXT_DOMAIN); ?></button>
            <button class='button-no'  data-label='<?php echo Links::make_relative( get_permalink() ); ?>' data-action='no' data-category='did_you_find'><?php _e('no', WARP_HTMX_TEXT_DOMAIN); ?></button>
        </div><?php
        $didyou = ob_get_contents();

        $html = preg_replace( '/\>\s+\</m', '><',$didyou);
        
        ob_end_clean();
        return $html;
    }
}