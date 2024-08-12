<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;


?>
<span id="woocommerce_loop_add_to_cart_link_describedby_<?php echo esc_attr( $product->get_id() ); ?>" class="screen-reader-text">
	<?php echo esc_html( $args['aria-describedby_text'] ); ?>
</span>
<a></a>
<div class="product-item duplicated">
	<div class="block-quantity-button">
		<button class="quantity-arrow-minus"> - </button>
		<div class="quantity">
			<input type="number" class="qty" name="quantity" value="1" min="1" />
		</div>
		<button class="quantity-arrow-plus"> + </button>
		<a class="add-to-cart button add_to_cart_button ajax_add_to_cart" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"><span class="add-to-cart-text">Купить</span></a>
	</div>
</div>

