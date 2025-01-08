
<article id="<?php echo get_post_type() ?>-<?php the_ID(); ?>" <?php warp_add_class("excerpt.term", ['append' => get_post_class( )]) ?>>
<?php  get_template_part('template_parts/commerce/excerpts/excerpt-product'); ?>
</article>


