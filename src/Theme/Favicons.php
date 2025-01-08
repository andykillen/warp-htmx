<?php
namespace WarpHtmx\Theme;

class Favicons {

    static public function init(){
        add_action('wp_head', [__CLASS__,'add_to_head']);
    }

    static public function add_to_head(){

        $tile_color = '#ffffff';

        if(class_exists('\RnwChild\SystemColors')){
            $tile_color = \RnwChild\SystemColors::tile();
        }
?>
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri() ?>/images/icons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri() ?>/images/icons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri() ?>/images/icons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/wp-content/themes/<?php echo basename( get_stylesheet_directory() ) ?>/images/icons/manifest.json">
<link rel="mask-icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/icons/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/icons/favicon.ico">
<meta name="msapplication-config" content="<?php echo get_stylesheet_directory_uri() ?>/images/icons/browserconfig.xml">
<meta name="theme-color" content="<?php echo $tile_color; ?>">
<?php
    }
}