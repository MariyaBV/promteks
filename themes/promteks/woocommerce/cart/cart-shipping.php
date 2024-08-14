<?php
/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
$block_attention = '';
?>
<div class="woocommerce-shipping-totals shipping shipping-block">
	<div class="shipping-subtitle txt">Выбор доставки</div>
	<div class="block-shipping-methods" data-title="<?php echo esc_attr( $package_name ); ?>">
		<?php if ( ! empty( $available_methods ) && is_array( $available_methods ) ) : ?>
			<ul id="shipping_method" class="woocommerce-shipping-methods custom-shipping-method txt">
				<span class="icon-Down-1"></span>
				<?php foreach ( $available_methods as $index => $method ) : ?>
					<?php 
						switch ($index) {
							case 'local_pickup:8':
								$iconClass = 'icon-iconoir_box-iso2';
								$sumShipping = '0 ₽';
								$block_attention = 'style="display: none;"';
								break;
							case 'flat_rate:3':
								$iconClass = 'icon-carbon_delivery-2';
								$sumShipping = 'от ';
								break;
							case 'flat_rate:7':
								$iconClass = 'icon-house-1';
								$sumShipping = '1 км / ';
								break;
							default:
								$iconClass = '';
								$sumShipping = '';
						}

						$label = wc_cart_totals_shipping_method_label( $method );
            
						// Используем регулярное выражение для разделения текста и суммы
						if (preg_match('/^(.*?)(<span.*)$/', $label, $matches)) {
							$label_text = $matches[1];
							$label_price = $matches[2];
						} else {
							$label_text = $label;
							$label_price = '';
						}
			
						$label_text = str_replace(':', '', $label_text);
						$label_price =  '<p>' . $sumShipping . $label_price . '</p>';
						
					?>
					<?php if ($index === 'local_pickup:8') : ?>
					<li class="init">
						<span class="icon-iconoir_box-iso2"></span>
						<?php
						// if ( 1 < count( $available_methods ) ) {
						// 	printf( '<input checked style="display:none;" type="radio" name="shipping_method[%1$s]" data-index="%1$s" id="shipping_method_%1$s_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
						// } else {
						// 	printf( '<input type="hidden" name="shipping_method[%1$s]" data-index="%1$s" id="shipping_method_%1$s_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
						// }
						/*printf( '<label class="shipping-method-label" for="shipping_method_%1$s_%2$s" id="shipping_method_%1$s_%2$s">%3$s %4$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), $label_text, $label_price ); */
						printf( '<label class="shipping-method-label" for="shipping_method_%1$s_%2$s">%3$s %4$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), $label_text, $label_price ); // WPCS: XSS ok.
						do_action( 'woocommerce_after_shipping_rate', $method, $index);
						?>
					</li>
					<?php endif; ?>
					<li>
						<span class="<?= $iconClass?>"></span>
						<?php
						if ( 1 < count( $available_methods ) ) {
							printf( '<input type="radio" name="shipping_method[%1$s]" data-index="%1$s" id="shipping_method_%1$s_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
						} else {
							printf( '<input type="hidden" name="shipping_method[%1$s]" data-index="%1$s" id="shipping_method_%1$s_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
						}
						/*printf( '<label class="shipping-method-label" for="shipping_method_%1$s_%2$s" id="shipping_method_%1$s_%2$s">%3$s %4$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), $label_text, $label_price ); */
						printf( '<label class="shipping-method-label" for="shipping_method_%1$s_%2$s">%3$s %4$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), $label_text, $label_price ); // WPCS: XSS ok.
						do_action( 'woocommerce_after_shipping_rate', $method, $index );
						?>
					</li>
				<?php endforeach; ?>
			</ul>

			<?php /*if ( is_cart() ) : ?>
				<p class="woocommerce-shipping-destination">
					<?php
					if ( $formatted_destination ) {
						// Translators: $s shipping destination.
						printf( esc_html__( 'Shipping to %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' );
						$calculator_text = esc_html__( 'Change address', 'woocommerce' );
					} else {
						echo wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'woocommerce' ) ) );
					}
					?>
				</p>
			<?php endif; */?>
			<?php
		elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
			if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'woocommerce' ) ) );
			} else {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'woocommerce' ) ) );
			}
		elseif ( ! is_cart() ) :
			echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce' ) ) );
		else :
			echo wp_kses_post(
				/**
				 * Provides a means of overriding the default 'no shipping available' HTML string.
				 *
				 * @since 3.0.0
				 *
				 * @param string $html                  HTML message.
				 * @param string $formatted_destination The formatted shipping destination.
				 */
				apply_filters(
					'woocommerce_cart_no_shipping_available_html',
					// Translators: $s shipping destination.
					sprintf( esc_html__( 'No shipping options were found for %s.', 'woocommerce' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ),
					$formatted_destination
				)
			);
			$calculator_text = esc_html__( 'Enter a different address', 'woocommerce' );
		endif;
		?>

		<?php if ( $show_package_details ) : ?>
			<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></p>'; ?>
		<?php endif; ?>

		<?php if ( $show_shipping_calculator ) : ?>
			<?php woocommerce_shipping_calculator( $calculator_text ); ?>
		<?php endif; ?>
	</div>
</div>
