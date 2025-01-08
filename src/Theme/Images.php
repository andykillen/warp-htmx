<?php

namespace WarpHtmx\Theme;

class Images{

    public function init(){
        add_action( 'after_setup_theme', [$this, 'after_theme_setup' ] );

        add_filter( 'wp_get_attachment_image_attributes', [$this, 'thumbnail_image_sizes_attr'], 10 , 3 );
        add_filter( 'wp_calculate_image_sizes', [$this,'content_image_sizes_attr'], 10 , 3 );

        add_filter( 'image_size_names_choose', [$this,'size_display'] );

    }
    /**
     * Add custom image sizes attribute to enhance responsive image functionality
     * for content images
     *
     * @param string $sizes A source size value for use in a 'sizes' attribute.
     * @param array  $size  Image size. Accepts an array of width and height
     *                      values in pixels (in that order).
     * @return string A source size value for use in a content image 'sizes' attribute.
     */
    public function thumbnail_image_sizes_attr( $attr, $attachment, $size ) {

    if($size == 'preview-large'){

        $attr['sizes'] = '(max-width: 767px) 66vw, (max-width: 1000px) 54vw, (max-width: 2033px) 40vw, 813px';
        $attr['srcset'] = $this->generate_srcset($size, $attachment->ID);

    } else if ( $size == 'preview-mobile' ) {
        // $attr['sizes'] = '(max-width: 442px) 40vw, (max-width: 660px) 46vw,(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1920px) 440px, 660px';
        $attr['sizes'] = '(max-width: 442px) 15vw, (max-width: 600px) 30vw,  (max-width: 1920px) 440px, 440px';
        $attr['srcset'] = $this->generate_srcset($size, $attachment->ID);
    } else if ($size == 'page'){
        $attr['srcset'] = $this->generate_srcset($size, $attachment->ID);
    } else if ($size == 'thumbnail'){
        $attr['srcset'] = $this->generate_srcset($size, $attachment->ID);
        $attr['sizes'] = '(max-width: 150px) 100vw, 150px';
    }else {
        $attr['sizes'] = '(max-width: 2033px) 40vw, 813px';
    }

        $attr['loading'] = 'lazy';

        return $attr;
    }

    public function size_display($sizes) {
        
        foreach(['preview-large','page', 'preview-mobile'] as $name) {
            $sizes[$name] = $name;
        }
        
        return $sizes;
    }


    public function content_image_sizes_attr( $attr, $attachment, $size ) {

        switch($size){
            case 'post-thumbnail':
                $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
            break;
        }

        return $attr;
    }



    protected function generate_srcset ($imagestyle, $attachement_id){
        $output =  [];
        switch($imagestyle){
            case 'preview-large':
                foreach( ['preview-large','preview-mobile','preview-standard'] as $size){
                    $output[] = $this->srcset($size, $attachement_id);
                }
            break;
            case 'preview-mobile':
                // ['preview-mobile','preview-standard','medium','thumbnail']
                foreach( ['preview-standard','medium','thumbnail']  as $size){
                    $output[] = $this->srcset($size, $attachement_id);
                }
            break;
            case 'page':
                foreach( ['page','page-standard','page-mobile'] as $size){
                    $output[] = $this->srcset($size, $attachement_id);
                }
            case 'thumbnail':
                foreach( ['thumbnail'] as $size){
                    $output[] = $this->srcset($size, $attachement_id);
                }
            break;
        }
        return implode (", ", $output );
    }

    protected function srcset($size, $attachement_id){
        $src = wp_get_attachment_image_src( $attachement_id, $size);
        return "{$src[0]} {$src[1]}w";
    }

    /**
     * Setup image sizes.
     */
    public function after_theme_setup(){
        /**
         * width / 4 * 2.7 = height
         * */
        add_image_size( 'preview-large', 813, 456, true );
        add_image_size( 'preview-standard', 440, 247, ['center', 'top'] );
        add_image_size( 'preview-mobile', 660, 445, true ); // not sure we use this one now.
        add_image_size( 'page', 768, 9999, false );
        add_image_size( 'page-mobile', 660, 9999, false );
        add_image_size( 'page-standard', 440, 9999, false );
        add_image_size( 'facebook', 1200, 630, true );
    }

}