<?php 


function warp_cart_totals_table_row($name, $heading, $data, $value) {
	?>
	<tr <?php warp_add_class("cart.summary.tr", ['append' => esc_attr( $name )] ) ?>>
		<th <?php warp_add_class("cart.summary.th" ) ?>><?php echo esc_html($heading); ?></th>
		<td <?php warp_add_class("cart.summary.td" ) ?> data-title="<?php echo esc_attr($data); ?>"><?php echo wp_kses_post( $value ); ?></td>
	</tr>
	<?php
}


add_filter( 'woocommerce_enqueue_styles', 'warp_woocommerce_dequeue_styles' );
function warp_woocommerce_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}
