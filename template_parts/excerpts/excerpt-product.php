<article id="<?php echo get_post_type() ?>-<?php the_ID(); ?>" <?php warp_add_class("excerpt.term", ['append' => get_post_class( )]) ?>>
<?php wc_get_template_part('content', 'product'); ?>
</article>



