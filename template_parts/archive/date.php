<?php

$archive_title    = get_the_archive_title();
$archive_subtitle = get_the_archive_description();

if ( $archive_title || $archive_subtitle ) {
		?>

		<header class="">

			<div class="">

				<?php if ( $archive_title ) { ?>
					<h1 class=""><?php echo wp_kses_post( $archive_title ); ?></h1>
				<?php } ?>

				<?php if ( $archive_subtitle ) { ?>
					<div class=""><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
				<?php } ?>

			</div>

		</header>

		<?php
	}
    ?><div><?php
	if ( have_posts() ) {

		while ( have_posts() ) {

			the_post();

			get_template_part('template_parts/excerpts/list'); 

		}
	}
	?></div>