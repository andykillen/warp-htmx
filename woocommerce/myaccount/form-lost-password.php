<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
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

do_action( 'woocommerce_before_lost_password_form' );
?>

<form <?php warp_add_class('my-account.form', ['append' => "woocommerce-ResetPassword, lost_reset_password" ]) ?> method="post">

	<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

	<p <?php warp_add_class('my-account.p', ['append' => "woocommerce-form-row, woocommerce-form-row--first, form-row, form-row-first" ]) ?>>
		<label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?>&nbsp;<span <?php warp_add_class('my-account.span', ['append' => "required" ]) ?> aria-hidden="true">*</span><span <?php warp_add_class('my-account.span', ['append' => "screen-reader-text" ]) ?>><?php esc_html_e( 'Required', 'woocommerce' ); ?></span></label>
		<input <?php warp_add_class('my-account.input', ['append' => "woocommerce-Input, woocommerce-Input--text, input-text" ]) ?> type="text" name="user_login" id="user_login" autocomplete="username" required aria-required="true" />
	</p>

	<div <?php warp_add_class('my-account.div', ['append' => "clear" ]) ?>></div>

	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

	<p <?php warp_add_class('my-account.p', ['append' => "woocommerce-form-row form-row" ]) ?>>
		<input type="hidden" name="wc_reset_password" value="true" />
		<button <?php warp_add_class('my-account.button', ['append' => 'woocommerce-Button button'. esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) ]) ?> type="submit" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
	</p>

	<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

</form>
<?php
do_action( 'woocommerce_after_lost_password_form' );
