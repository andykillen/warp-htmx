<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div <?php warp_add_class('checkout.div', ['append' => "woocommerce-form-coupon-toggle"]) ?>>
	<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' ); ?>
</div>

<form <?php warp_add_class('checkout.form', ['append' => "checkout_coupon, woocommerce-form-coupon" ]) ?> method="post" style="display:none">

	<p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'woocommerce' ); ?></p>

	<p <?php warp_add_class('html.p', ['append' => "form-row form-row-first" ]) ?>>
		<label <?php warp_add_class('html.label', ['append' => "screen-reader-text" ]) ?> for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
		<input <?php warp_add_class('html.input', ['append' => "input-text" ]) ?> type="text" name="coupon_code" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
	</p>

	<p <?php warp_add_class('html.p', ['append' => "form-row, form-row-last" ]) ?>>
		<button <?php warp_add_class('html.button', ['append' => "button" ]) ?> type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
	</p>

	<div <?php warp_add_class('checkout.div', ['append' => "clear" ]) ?>></div>
</form>
