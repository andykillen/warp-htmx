<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

$holder_class = 'cart_totals ' . ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : '';
?>
<div <?php  warp_add_class("cart.summary.totals", ['append' => $holder_class] ) ?>>

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2 <?php warp_add_class('html.h2') ?>><?php esc_html_e( 'Summary', WARP_HTMX_TEXT_DOMAIN ); ?></h2>

	<table cellspacing="0" <?php warp_add_class("cart.summary.table") ?>>
		<tbody>
			<?php warp_cart_totals_table_row('cart-subtotal ', 'Subtotal', 'Subtotal', WC()->cart->get_cart_subtotal() ); ?>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<?php 
				ob_start();
					wc_cart_totals_coupon_html( $coupon ); 
					$content = ob_get_clean();
				warp_cart_totals_table_row("cart-discount coupon-" .   esc_attr( sanitize_title( $code ) ), wc_cart_totals_coupon_label( $coupon, false ), wc_cart_totals_coupon_label( $coupon, false ), $content ); ?>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
			<?php
					ob_start();
						woocommerce_shipping_calculator(  ); 
						$content = ob_get_clean();
					warp_cart_totals_table_row('shipping', 'Shipping', 'Shipping', $content ); ?>
		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<?php
					ob_start();
						wc_cart_totals_fee_html( $fee ); 
						$content = ob_get_clean();
					warp_cart_totals_table_row('fee', $fee->name, $fee->name, $content ); ?>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				/* translators: %s location. */
				$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					
					warp_cart_totals_table_row(
						'tax-rate tax-rate-' . esc_attr( sanitize_title( $code ) ),
						esc_html( $tax->label ) . $estimated_text,
						esc_attr( $tax->label ),
						$tax->formatted_amount );
				}
			} else {

				ob_start();
				wc_cart_totals_taxes_total_html( ); 
						$content = ob_get_clean();

				warp_cart_totals_table_row(
					'tax-total', 
					esc_html( WC()->countries->tax_or_vat() ) . $estimated_text, 
					esc_attr( WC()->countries->tax_or_vat() ), 
					$content );
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' );
			ob_start();
				wc_cart_totals_order_total_html(  ); 
				$content = ob_get_clean();
			warp_cart_totals_table_row('order-total', esc_html( 'Total', 'woocommerce' ), esc_attr( 'Total', 'woocommerce' ), $content ); ?>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
		</tbody>
	</table>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
