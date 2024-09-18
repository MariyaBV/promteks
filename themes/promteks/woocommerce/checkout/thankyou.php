<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
$selected_shipping_method = WC()->session->get('selected_shipping_method');
$shipping_label = WC()->session->get('selected_shipping_label');
$shipping_cost = WC()->session->get('selected_shipping_cost');

if ($selected_shipping_method === 'local_pickup:8') {
	$shipping_label = 'Самовывоз';
	$shipping_cost = '0₽';
} elseif ($selected_shipping_method === 'flat_rate:7') {
	$shipping_label = 'Доставка по области';
	$shipping_cost = '1км / 55₽';
} elseif ($selected_shipping_method === 'flat_rate:3') {
	$shipping_label = 'Доставка по Брянску';
	$shipping_cost = 'от 500₽';
}
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

			<h2 class="title-order">Заказ</h2>

			<p class="txt subtitle-checkout order">Данные заказа</p>

			<div class="block-address txt">
				<!-- О заказе -->
				<div class="block-details">
					<p class="subtitle-details">О заказе</p>
					<p class="text-details">№ <?php echo $order->get_order_number(); ?>, создан <?php echo wc_format_datetime( $order->get_date_created(),'Y-m-d H:i:s' ); ?></p>
				</div>
				<!-- ФИО заказчика -->
				<div class="block-details">
					<p class="subtitle-details"><?php esc_html_e( 'Заказчик:', 'woocommerce' ); ?></p>
					<p class="text-details"><?php echo esc_html( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ); ?></p>
				</div>

				<!-- Телефон -->
				<div class="block-details">
					<p class="subtitle-details"><?php esc_html_e( 'Телефон:', 'woocommerce' ); ?></p>
					<p class="text-details"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
				</div>

				<!-- E-mail -->
				<div class="block-details">
					<p class="subtitle-details"><?php esc_html_e( 'E-mail:', 'woocommerce' ); ?></p>
					<p class="text-details"><?php echo esc_html( $order->get_billing_email() ); ?></p>
				</div>

				<!-- Адрес -->
				<?php if ($selected_shipping_method !== 'local_pickup:8'): ?>
					<div class="block-details">
						<p class="subtitle-details"><?php esc_html_e( 'Адрес:', 'woocommerce' ); ?></p>
						<p class="text-details">
						<?php

							// Получаем labels из формы
							$fields = WC()->checkout()->get_checkout_fields('billing');

							$labels = array(
								'city'        => '', //isset($fields['billing_city']['label']) ? $fields['billing_city']['label'] : ' ',
								'address_1'   => 'ул.', //isset($fields['billing_address_1']['label']) ? $fields['billing_address_1']['label'] : 'ул.',
								'address_2'   => 'дом', //isset($fields['billing_address_2']['label']) ? $fields['billing_address_2']['label'] : 'дом',
								'address_3'   => 'корпус',//isset($fields['billing_address_3']['label']) ? $fields['billing_address_3']['label'] : 'корпус',
								'address_4'   => 'квартира',//isset($fields['billing_address_4']['label']) ? $fields['billing_address_4']['label'] : 'квартира',
								'apartment'   => 'подъезд',//isset($fields['billing_apartment']['label']) ? $fields['billing_apartment']['label'] : 'подъезд',
								'code'        => 'код от подъезда',//isset($fields['billing_code']['label']) ? $fields['billing_code']['label'] : 'код от подъезда',
							);

							$billing_address = array(
								'city'        => $order->get_billing_city(),
								'address_1'   => $order->get_billing_address_1(),
								'address_2'   => $order->get_billing_address_2(),
								'address_3'   => $order->get_meta('_billing_address_3'),
								'address_4'   => $order->get_meta('_billing_address_4'),
								'apartment'   => $order->get_meta('_billing_apartment'),
								'code'        => $order->get_meta('_billing_code'),
							);

							// Форматирование адреса
							$formatted_address = array();
							foreach ($billing_address as $key => $value) {
								if (!empty($value)) {
									$formatted_address[] = esc_html($labels[$key] . ' ' . $value);
								}
							}

							// Выводим отформатированный адрес
							if (!empty($formatted_address)) {
								echo implode(', ', $formatted_address);
							} else {
								esc_html_e('Адрес не указан', 'woocommerce');
							}
						?>
						</p>
					</div>
				<?php endif;?>


				<!-- Комментарий -->
				<div class="block-details">
					<p class="subtitle-details"><?php esc_html_e( 'Комментарий:', 'woocommerce' ); ?></p>
					<p class="text-details">
						<?php 
						// Получаем комментарий из мета-данных заказа
						$comment = $order->get_meta('_billing_comment'); 
						
						// Проверяем, есть ли комментарий, и выводим его
						if (!empty($comment)) {
							echo wp_kses_post($comment); 
						} else {
							esc_html_e('Нет комментариев', 'woocommerce');
						}
						?>
					</p>
				</div>

				<!-- Способ доставки -->
				<div class="block-details">
					<p class="subtitle-details">Доставка</p>
					<p class="text-details">
						<?php echo $shipping_label; ?>
					</p>
				</div>

				<!-- Стоимость доставки -->
				<div class="block-details">
					<p class="subtitle-details">Стоимость доставки</p>
					<p class="text-details">
						<?php 
							echo  $shipping_cost;
						?>
					</p>
				</div>
				

				<?php
					/**
					 * Action hook fired after an address in the order customer details.
					 *
					 * @since 8.7.0
					 * @param string $address_type Type of address (billing or shipping).
					 * @param WC_Order $order Order object.
					 */
					do_action( 'woocommerce_order_details_after_customer_address', 'billing', $order );
				?>
			</div>

			<ul style="display: none;" class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created(), 'Y-m-d H:i:s' ); // Выводит дату и время в формате YYYY-MM-DD HH:MM:SS ?></strong>
				</li>


				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php /*do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );*/ ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
