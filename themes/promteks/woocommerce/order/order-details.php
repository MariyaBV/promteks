<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.0.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

 // phpcs:disable WooCommerce.Commenting.CommentHooks.MissingHookComment

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items        = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$downloads          = $order->get_downloadable_items();

// We make sure the order belongs to the user. This will also be true if the user is a guest, and the order belongs to a guest (userID === 0).
$show_customer_details = $order->get_user_id() === get_current_user_id();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="woocommerce-order-details">
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details txt">
		<thead>
			<tr>
				<th class="product-thumbnail"></th>
				<th class="product-name">Товар</th>
				<th class="product-quantity">Количество</th>
				<th class="product-total">Сумма</th>
			</tr>
		</thead>

		<tbody style="display:none;">
			<?php
			do_action( 'woocommerce_order_details_before_order_table_items', $order );

			foreach ( $order_items as $item_id => $item ) {
				$product = $item->get_product();

				wc_get_template(
					'order/order-details-item.php',
					array(
						'order'              => $order,
						'item_id'            => $item_id,
						'item'               => $item,
						'show_purchase_note' => $show_purchase_note,
						'purchase_note'      => $product ? $product->get_purchase_note() : '',
						'product'            => $product,
					)
				);
			}

			do_action( 'woocommerce_order_details_after_order_table_items', $order );
			?>
		</tbody>

		<tbody>
			<?php
			do_action('woocommerce_order_details_before_order_table_items', $order);

			foreach ($order_items as $item_id => $item) {
				$product = $item->get_product();
				if ($product) {
					?>
					<tr class=" <?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'order_item', $item, $order)); ?>">
						<td class="product-thumbnail">
							<?php
							$thumbnail = apply_filters('woocommerce_order_item_thumbnail', $product->get_image(), $item, $order);
							echo wp_kses_post($thumbnail);
							?>
						</td>
						<td class="product-name">
							<?php echo wp_kses_post(apply_filters('woocommerce_order_item_name', $product->get_name(), $item, $order)) . '&nbsp;'; ?>
							<?php echo wc_display_item_meta($item); ?>
						</td>
						<td class="product-quantity">
							<?php echo apply_filters('woocommerce_order_item_quantity_html', sprintf('<span>%s</span>', $item->get_quantity()), $item); ?>
							<span class="attribute-unit">
								<?php custom_attribute_unit($product->get_id()); ?>
							</span>
						</td>
						<td class="product-total">
							<?php echo wc_price($order->get_line_subtotal($item, true)); ?>
						</td>
					</tr>
					<?php
				}
			}

			do_action('woocommerce_order_details_after_order_table_items', $order);
			?>
		</tbody>


		<?php /*<tfoot>
			<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) {
				?>
					<tr>
						<th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
						<td><?php echo wp_kses_post( $total['value'] ); ?></td>
					</tr>
					<?php
			}
			?>
			<?php if ( $order->get_customer_note() ) : ?>
				<tr>
					<th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td><?php echo wp_kses( nl2br( wptexturize( $order->get_customer_note() ) ), array() ); ?></td>
				</tr>
			<?php endif; ?>
		</tfoot>*/?>

		<tfoot>
			<?php
			// Получаем массив с итогами заказа
			$order_totals = $order->get_order_item_totals();
			
			// Проверяем, есть ли итоговая сумма в массиве итогов
			if (isset($order_totals['order_total'])) {
				// Выводим только итоговую строку
				$total = $order_totals['order_total'];
				?>
				<tr>
					<td scope="row"></td>
					<td scope="row"></td>
					<td scope="row"><?php echo esc_html($total['label']); ?></td>
					<td><?php echo wp_kses_post($total['value']); ?></td>
				</tr>
				<?php
			}?>
		</tfoot>

	</table>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
	<div class="pdf-buttons">
		<button id="save-pdf" class="button show-more-btn"><span class="icon-increase-3"></span>Сохранить</button>
		<button id="print-pdf" class="button show-more-btn"><span class="icon-print-1"></span>Распечатать</button>
	</div>
</section>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
