<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_reset_password_form' );
?>

<form <?php warp_add_class('my-account.form', ['append' => "woocommerce-ResetPassword, lost_reset_password" ]) ?> method="post">

	<p><?php echo apply_filters( 'woocommerce_reset_password_message', esc_html__( 'Enter a new password below.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

	<p <?php warp_add_class('my-account.p', ['append' => "woocommerce-form-row, woocommerce-form-row--first, form-row, form-row-first" ]) ?>>
		<label for="password_1"><?php esc_html_e( 'New password', 'woocommerce' ); ?>&nbsp;<span <?php warp_add_class('my-account.span', ['append' => "required" ]) ?> aria-hidden="true">*</span><span <?php warp_add_class('my-account.span', ['append' => "screen-reader-text" ]) ?>><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
		<input <?php warp_add_class('my-account.input', ['append' => "woocommerce-Input, woocommerce-Input--text, input-text" ]) ?> type="password" name="password_1" id="password_1" autocomplete="new-password" required aria-required="true" />
	</p>
	<p <?php warp_add_class('my-account.p', ['append' => "woocommerce-form-row, woocommerce-form-row--last, form-row, form-row-last" ]) ?>>
		<label for="password_2"><?php esc_html_e( 'Re-enter new password', 'woocommerce' ); ?>&nbsp;<span <?php warp_add_class('my-account.span', ['append' => "required" ]) ?> aria-hidden="true">*</span><span <?php warp_add_class('my-account.span', ['append' => "screen-reader-text" ]) ?>><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
		<input <?php warp_add_class('my-account.input', ['append' => "woocommerce-Input, woocommerce-Input--text, input-text" ]) ?> type="password" name="password_2" id="password_2" autocomplete="new-password" required aria-required="true" />
	</p>

	<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
	<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

	<div class="clear"></div>

	<?php do_action( 'woocommerce_resetpassword_form' ); ?>

	<p <?php warp_add_class('my-account.p', ['append' => "woocommerce-form-row, form-row" ]) ?>>
		<input type="hidden" name="wc_reset_password" value="true" />
		<button <?php warp_add_class('my-account.button', ['append' => 'woocommerce-Button button'. esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) ]) ?> type="submit" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>"><?php esc_html_e( 'Save', 'woocommerce' ); ?></button>
	</p>

	<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>

</form>
<?php
do_action( 'woocommerce_after_reset_password_form' );

