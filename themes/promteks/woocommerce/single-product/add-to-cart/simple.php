<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	<div class="product-item">
			<div class="block-quantity-button">
				<button class="quantity-arrow-minus"> - </button>
				<div class="quantity">
					<input type="number" class="qty" name="quantity" value="1" min="1" />
				</div>
				<button class="quantity-arrow-plus"> + </button>
				<a class="add-to-cart button add_to_cart_button ajax_add_to_cart" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"><span class="add-to-cart-text">Купить</span></a>
			</div>
		</div>

	<?php custom_delivery_options_fields();?>
	<?php /*do_action( 'woocommerce_after_add_to_cart_form' );*/ ?>

<?php endif; ?>


