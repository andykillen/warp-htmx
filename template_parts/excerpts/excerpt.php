<article id="<?php echo get_post_type() ?>-<?php the_ID(); ?>" <?php warp_add_class("excerpt", ['append' => implode(' ', get_post_class( ))]) ?>>
    <header>
        <h2 <?php warp_add_class("html.h2") ?> ><?php warp_link(get_permalink(), get_the_title(), 'post/?id=' . get_the_ID(), ["hx-target" => "#main"]) ?></h2>
        <?php if ( has_post_thumbnail() ) : ?>
            <?php warp_link(get_permalink(), get_the_post_thumbnail(), 'post/?id=' . get_the_ID(), ["hx-target" => "#main"]) ?>
        <?php endif; ?>
        <?php the_excerpt(); ?>
    </header>
</article>