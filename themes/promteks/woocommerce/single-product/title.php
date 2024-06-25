<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
    return;
}

$product_attributes = $product->get_attributes();

if ( empty( $product_attributes ) ) {
    return;
}
?>
<table class="woocommerce-product-attributes shop_attributes">
	<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
		<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
			<th class="woocommerce-product-attributes-item__label"><?php echo wp_kses_post( $product_attribute['name'] ); ?></th>
			<td class="woocommerce-product-attributes-item__value"><?php echo wp_kses_post( $product_attribute['value'] ); ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<?php 

echo do_shortcode('[yith_wcwl_add_to_wishlist]');

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
the_title( '<h4 class="product_title entry-title">', '</h4>' );

// Получение данных о запасах
$stock_status = get_post_meta( $product->get_id(), '_stock_status', true );
$stock_status_options = wc_get_product_stock_status_options();
?>
<div class="stock-status">
    <p><?php 
	if ( $stock_status === 'outofstock' ) {
		echo '<span class="out-of-stock">Нет на складе</span>';
	} else {
		echo '<span class="in-stock">Есть на складе</span>';
	}
	?></p>
</div>
<?php