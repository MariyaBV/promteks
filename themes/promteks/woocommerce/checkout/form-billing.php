<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
$selected_shipping_method = WC()->session->get('selected_shipping_method');
$shipping_label = WC()->session->get('selected_shipping_label');
$shipping_cost = WC()->session->get('selected_shipping_cost');
?>
<div class="thankyou-alert">
	<div class="thankyou-alert__wrapper">
		<div class="thankyou-alert__block">
			<h2 class="thankyou-alert__subtitle">Ваш заказ подтвежден.</h2>
			<p class="thankyou-alert__text txt">Мы перезвоним, чтобы уточнить детали и подтвердить заказ.</p>
			<button class="thankyou-alert__button txt-s">OK</button>
		</div>
	</div>
</div>
<div class="woocommerce-billing-fields">
	<p class="txt subtitle-checkout">Данные получателя</p>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">

		<?php
			$fields = $checkout->get_checkout_fields( 'billing' );

			if ( $selected_shipping_method === 'local_pickup:8') {
				?>
				<style>
					#billing_city_field,
					.custom-address-fields {
						display: none;
					}
				</style>
				<?php
			}
				
			$ordered_fields = [
				'billing_first_name',
				'billing_last_name',
				'billing_phone',
				'billing_email',
				'billing_country',
				'billing_state',
				'billing_postcode',
				'billing_city',
			];

			foreach ( $ordered_fields as $key ) {
				if ( isset( $fields[ $key ] ) ) {

					// if (in_array($key, ['billing_country', 'billing_state', 'billing_postcode', 'billing_city'])) {
					// 	if ($selected_shipping_method === 'local_pickup:8') {
					// 		continue;
					// 	} 
					// }
					woocommerce_form_field( $key, $fields[ $key ], $checkout->get_value( $key ) );
				}
			}

			
		?>
		<div class="custom-address-fields">
			<?php
			$additional_fields = [
				'billing_address_1',
				'billing_address_2',
				'billing_address_3',
				'billing_address_4',
				'billing_apartment',
				'billing_code',
			];

			foreach ( $additional_fields as $key ) {
				if ( isset( $fields[ $key ] ) ) {
					// if (in_array($key, ['billing_address_1', 'billing_address_2', 'billing_address_3', 'billing_address_4', 'billing_apartment', 'billing_code'])) {
					// 	if ($selected_shipping_method === 'local_pickup:8') {
					// 		continue;
					// 	} 
					// }
					woocommerce_form_field( $key, $fields[ $key ], $checkout->get_value( $key ) );
				}
			}
			?>
		</div>
		<?php
			$additional_fields = [
				'billing_comment'
			];

			foreach ( $additional_fields as $key ) {
				if ( isset( $fields[ $key ] ) ) {
					woocommerce_form_field( $key, $fields[ $key ], $checkout->get_value( $key ) );
				}
			}
			?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>

