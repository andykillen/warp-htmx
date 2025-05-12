<?php
/**
 * Photoswipe markup
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/photoswipe.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div <?php warp_add_class('single-product.div', ['append' => "pswp" ]) ?> tabindex="-1" role="dialog" aria-hidden="true">
	<div <?php warp_add_class('single-product.div', ['append' => "pswp__bg" ]) ?>></div>
	<div <?php warp_add_class('single-product.div', ['append' => "pswp__scroll-wrap" ]) ?>>
		<div <?php warp_add_class('single-product.div', ['append' => "pswp__container" ]) ?>>
			<div <?php warp_add_class('single-product.div', ['append' => "pswp__item" ]) ?>></div>
			<div <?php warp_add_class('single-product.div', ['append' => "pswp__item" ]) ?>></div>
			<div <?php warp_add_class('single-product.div', ['append' => "pswp__item" ]) ?>></div>
		</div>
		<div <?php warp_add_class('single-product.div', ['append' => "pswp__ui, pswp__ui--hidden" ]) ?>>
			<div <?php warp_add_class('single-product.div', ['append' => "pswp__top-bar" ]) ?>>
				<div <?php warp_add_class('single-product.div', ['append' => "pswp__counter" ]) ?>></div>
				<button <?php warp_add_class('single-product.button', ['append' => "pswp__button, pswp__button--close" ]) ?> aria-label="<?php esc_attr_e( 'Close (Esc)', 'woocommerce' ); ?>"></button>
				<button <?php warp_add_class('single-product.button', ['append' => "pswp__button, pswp__button--share" ]) ?> aria-label="<?php esc_attr_e( 'Share', 'woocommerce' ); ?>"></button>
				<button <?php warp_add_class('single-product.button', ['append' => "pswp__button, pswp__button--fs" ]) ?> aria-label="<?php esc_attr_e( 'Toggle fullscreen', 'woocommerce' ); ?>"></button>
				<button <?php warp_add_class('single-product.button', ['append' => "pswp__button, pswp__button--zoom" ]) ?> aria-label="<?php esc_attr_e( 'Zoom in/out', 'woocommerce' ); ?>"></button>
				<div <?php warp_add_class('single-product.div', ['append' => "pswp__preloader" ]) ?>>
					<div <?php warp_add_class('single-product.div', ['append' => "pswp__preloader__icn" ]) ?>>
						<div <?php warp_add_class('single-product.div', ['append' => "pswp__preloader__cut" ]) ?>>
							<div <?php warp_add_class('single-product.div', ['append' => "pswp__preloader__donut" ]) ?>></div>
						</div>
					</div>
				</div>
			</div>
			<div <?php warp_add_class('single-product.div', ['append' => "pswp__share-modal, pswp__share-modal--hidden, pswp__single-tap" ]) ?>>
				<div <?php warp_add_class('single-product.div', ['append' => "pswp__share-tooltip" ]) ?>></div>
			</div>
			<button <?php warp_add_class('single-product.button', ['append' => "pswp__button, pswp__button--arrow--left" ]) ?> aria-label="<?php esc_attr_e( 'Previous (arrow left)', 'woocommerce' ); ?>"></button>
			<button <?php warp_add_class('single-product.button', ['append' => "pswp__button, pswp__button--arrow--right" ]) ?> aria-label="<?php esc_attr_e( 'Next (arrow right)', 'woocommerce' ); ?>"></button>
			<div <?php warp_add_class('single-product.div', ['append' => "pswp__caption" ]) ?>>
				<div <?php warp_add_class('single-product.div', ['append' => "pswp__caption__center" ]) ?>></div>
			</div>
		</div>
	</div>
</div>
