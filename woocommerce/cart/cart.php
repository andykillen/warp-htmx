<?php
/**
 * Cart Page
 *
 * the TABLE has been converted to a section with a list of items.
 * feel free to change it back if wanted.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

$woo_button_style = "button ". esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ?  ' ' . wc_wp_theme_get_element_class_name( 'button' ) : ' ');
?>
  <div <?php warp_add_class('cart.before.table') ?>>
  
  <?php do_action( 'woocommerce_before_cart_table' ) ?> 
    
	<form <?php warp_add_class('cart.form.container', ['append' => "woocommerce-cart-form" ]) ?> hx-post="<?php echo esc_url( wc_get_cart_url() ) ?>" action="<?php echo esc_url( wc_get_cart_url() ) ?>" method="post">
      <section aria-labelledby="cart-heading" <?php warp_add_class('cart.section.left') ?>>
        <h2 id="cart-heading" <?php warp_add_class('cart.section.cart-heading') ?>><?php _e('Items in your shopping cart', WARP_HTMX_TEXT_DOMAIN) ?></h2>
		<?php do_action( 'woocommerce_before_cart_contents' ) ?>	
        <ul role="list" <?php warp_add_class('cart.section.ul') ?>>
		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				$product_attributes = $_product->get_attributes();

				/**
				 * Filter the product name.
				 *
				 * @since 2.1.0
				 * @param string $product_name Name of the product in the cart.
				 * @param array $cart_item The product in the cart.
				 * @param string $cart_item_key Key for the product in the cart.
				 */
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		?>
          <li <?php warp_add_class('cart.section.li') ?>>
            <div <?php warp_add_class('cart.section.thumbnail.container') ?>>
				<?php
					$thumbnail = apply_filters( 
						'woocommerce_cart_item_thumbnail', 
						$_product->get_image(
							apply_filters('theme_cart_image_thumbnail_size','woocommerce_thumbnail'), 
							[
								'class' => warp_get_class('cart.section.thumbnail.img', ['append' => 'product-thumbnail']),
							]
						),
						$cart_item, 
						$cart_item_key );

					if ( ! $product_permalink ) {
						echo $thumbnail; // PHPCS: XSS ok.
					} else {
						printf( '<a href="%s" %s>%s</a>', esc_url( $product_permalink ), warp_get_class('cart.section.thumbnail.a'), $thumbnail ); // PHPCS: XSS ok.
					}
				?>
            </div>

            <div <?php warp_add_class('cart.section.overview.outer') ?> >
              <div <?php warp_add_class('cart.section.overview') ?> >
                <div <?php warp_add_class('cart.section.overview.inner') ?> >
					<div <?php warp_add_class('cart.section.overview.product') ?> >
                    <h3 <?php warp_add_class('cart.section.overview.product.name', ['append' => 'product-name']) ?> data-title="<?php esc_attr_e( 'Product', 'woocommerce' ) ?>">
						<?php 
							if ( ! $product_permalink ) {
								echo wp_kses_post( $product_name . '&nbsp;' );
							} else {
								/**
								 * This filter is documented above.
								 *
								 * @since 2.1.0
								 */
								echo wp_kses_post( 
									apply_filters( 'woocommerce_cart_item_name',
										sprintf( '<a href="%s" class="%s">%s</a>', esc_url( $product_permalink ), warp_get_class('cart.section.overview.a'), $_product->get_name() ),
										$cart_item,
										$cart_item_key, 
										) );
							}
						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ) ?>
                    </h3>
					<?php
					echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

					// Backorder notification.
					if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
						$paragraph = '<p '. warp_add_class('cart.section.overview.backorder.notification', ['echo' => false]) .' >' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', $paragraph, $product_id ) );
					} 

					?>
                  </div>
                  <div <?php warp_add_class('cart.section.overview.product.attributes') ?> >
					<?php if(isset($product_attributes['pa_color']) && !empty($product_attributes['pa_color']['options'])) { ?>
						<p <?php warp_add_class('cart.section.overview.product.attributes.text') ?> ><?php echo get_term($product_attributes['pa_color']['options'][0])->name; ?></p>
				    <?php } else if(isset($product_attributes['color']) && !empty($product_attributes['color'])) { ?>
						<p <?php warp_add_class('cart.section.overview.product.attributes.text') ?>><?php echo $product_attributes['color'] ?></p>
					<?php } ?>
                    <?php if(isset($product_attributes['size']) && !empty($product_attributes['size'])) { ?>
                    	<p <?php warp_add_class('cart.section.overview.product.attributes.size') ?> ><?php echo $product_attributes['size'] ?></p>
					<?php } ?>
                  </div>
					<p <?php warp_add_class('cart.section.overview.product.attributes.price', ['append' => 'product-price']) ?> data-title="<?php esc_attr_e( 'Price', 'woocommerce' ) ?>"><?php
						echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
					?> <?php echo ($cart_item['quantity'] > 1) ? __("each", WARP_HTMX_TEXT_DOMAIN): ""; ?>
					</p>
					<?php if($cart_item['quantity'] > 1) { ?>
						<p <?php warp_add_class('cart.section.overview.product.attributes.subtotal', ['append' => 'product-subtotal']) ?> data-title="<?php esc_attr_e( 'Subtotal Price', 'woocommerce' ) ?>"><?php
							$subtotal_price = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							echo "Subtotal: " . $subtotal_price; // PHPCS: XSS ok.
						?></p>
					<?php } ?>
                </div>

                <div data-test="true" <?php warp_add_class('cart.section.overview.product.attributes.quantity', ['append' => 'product-quantity']) ?> data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ) ?>">
                  <label  <?php warp_add_class('cart.section.overview.product.attributes.quantityLabel') ?> for="cart[<?php echo $cart_item_key ?>][qty] ?>">Quantity, <?php echo $product_name ?></label>
						<?php
						if ( $_product->is_sold_individually() ) {
							$min_quantity = 1;
							$max_quantity = 1;
						} else {
							$min_quantity = 0;
							$max_quantity = $_product->get_max_purchase_quantity();
						}

						$product_quantity = woocommerce_quantity_input(
							array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $max_quantity,
								'min_value'    => $min_quantity,
								'product_name' => $product_name,
							),
							$_product,
							false
						);

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
                  <div <?php warp_add_class('cart.section.overview.product.remove') ?> >
				  <?php
				  	$sr_text = '<span '.warp_add_class('accessibility.screenreader', ['echo' => false]).'>Remove</span>';
					$svg = '<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>';
						// TODO: add htmx actions to the link to process the delete in the background.
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" %s aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								warp_get_class('cart.section.overview.product.attributes.quantity.remove', "-m-2 inline-flex p-2 text-gray-400 hover:text-gray-500",['echo' => false]),
								/* translators: %s is the product name */
								esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() ),
								$sr_text . $svg
							),
							$cart_item_key
						);
					?>
                  </div>
                </div>
              </div>
            </div>
          </li>
		<?php } } ?>
        </ul>
		<button type="submit" <?php warp_add_class('buttons.primary', ['append' => $woo_button_style ]) ?> name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ) ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ) ?></button>
		<?php do_action( 'woocommerce_cart_contents' ) ?>

		
      </section>


      <!-- Order summary -->
      <section aria-labelledby="summary-heading" <?php warp_add_class('cart.summary.heading') ?>>
		<div <?php warp_add_class('cart.summary.heading.holder') ?>>
			<div <?php warp_add_class('cart.summary.heading.coupons') ?>>

				<?php if ( wc_coupons_enabled() ) { ?>
					<div <?php warp_add_class('cart.summary.heading.form') ?> >
						<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ) ?></label> 
						<input type="text" 
								name="coupon_code"
								<?php warp_add_class('html.input.text', ['append' => "input-text"]) ?>
								id="coupon_code" 
								value="" 
								placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ) ?>" /> 
						<button type="submit" 
								<?php warp_add_class('buttons.secondary', ['append' => $woo_button_style]) ?>
								name="apply_coupon"
								value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ) ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ) ?></button>
						<?php do_action( 'woocommerce_cart_coupon' ) ?>
					</div>
				<?php } ?>

				<button type="submit" <?php warp_add_class('buttons.primary', ['append' => $woo_button_style]) ?> ><?php esc_html_e( 'Update cart', 'woocommerce' ) ?></button>

				<?php do_action( 'woocommerce_cart_actions' ) ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ) ?>

			</div>
			<div <?php warp_add_class('cart.summary.collaterals') ?>>
				<?php do_action( 'woocommerce_cart_collaterals' ) ?>
			</div>
		</div>
		</div>
      </section>

	  <div>
	  	<?php do_action( 'woocommerce_after_cart_contents' ) ?>
	  </div>
	  
	  <?php do_action( 'woocommerce_after_cart_table' ) ?>
    </form>
  </div>
<?php do_action( 'woocommerce_after_cart' );