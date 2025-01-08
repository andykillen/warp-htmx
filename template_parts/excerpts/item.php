<li>
    <a href="<?php echo esc_url( get_permalink($item->ID) ); ?>" hx-get="<?php echo esc_url( get_permalink($item->ID) ); ?>" hx-swap="outerHTML" hx-target="#main-content" class="text-slate-800 hover:text-slate-900"><?php echo apply_filters( 'the_title', $item->post_title, $item->ID ); ?></a>
</li>