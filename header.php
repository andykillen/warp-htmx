<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8" hx-preserve="true">
    <meta name="viewport" content="width=device-width, initial-scale=1"  hx-preserve="true">
    <?php 
        do_action('dns_prefetch');
        wp_head();
    ?>
</head>
<body <?php body_class(); ?> hx-ext="head-support">
    <?php do_action('after_body'); ?>
    <a class="hidden" aria-role href="#main"><?php echo esc_html_x( 'Skip to content', 'screen reader text', WARP_HTMX_TEXT_DOMAIN ); ?></a>
    <div id="page" <?php warp_add_class('page') ?>>