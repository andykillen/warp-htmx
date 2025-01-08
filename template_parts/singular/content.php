<main id="main">
	<article id="<?php echo get_post_type() ?>-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php	
	if ( is_active_sidebar( 'above-content-header' ) ) { 
		dynamic_sidebar( 'above-content-header' );
	} 
	?>
		<header <?php warp_add_class('singular.content.header') ?> >
		<?php
			do_action('post_header_top');
			if ( '' !== get_the_post_thumbnail() ) : ?>
				<div <?php warp_add_class('singular.content.header.thumbnail') ?>>
					<?php the_post_thumbnail('page'); ?>
				</div>
			<?php endif; ?>
			<h1 <?php warp_add_class('html.h1') ?>><?php echo get_the_title() ?></h1>
			<?php if ( 'page' != get_post_type() ) : ?>
				<div <?php warp_add_class('singular.content.header.meta') ?> >
					<div <?php warp_add_class('singular.content.header.meta.cats') ?>>
						<?php get_template_part('template_parts/terms/post_categories', get_post_type()); ?>
					</div>
					<div <?php warp_add_class('singular.content.header.meta.author') ?>>
						<?php get_template_part('template_parts/author', get_post_type()); ?>
					</div>
				</div>
			<?php endif; ?>
		</header>

		<div <?php warp_add_class('singular.content.entry', ["append" => "html-" . get_post_type() ]) ?>>
			<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					_x( 'Continue reading<span class="visually-hidden"> "%s"</span>','screen reader text', WARP_HTMX_TEXT_DOMAIN ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				get_the_title()
			) );
			?>
		</div>
		
		<footer <?php warp_add_class('singular.content.footer') ?>>
			<?php if(apply_filters(warp_prefix('show_post_tags'), true)) { ?>
				<div <?php warp_add_class('singular.content.footer.tags') ?>>
					<?php get_template_part('template_parts/terms/post_tags', get_post_type()); ?>
				</div>
			<?php } ?>

		</footer>
		
	</article>

	<?php
	
	if ( ( comments_open() || get_comments_number() ) && apply_filters(warp_prefix('show_comments'), true)) :
		?><section <?php warp_add_class('singular.content.comments', ['append' => 'comments-section']) ?>><?php
			comments_template();
		?></section><?php
	endif;
	?>
</main>