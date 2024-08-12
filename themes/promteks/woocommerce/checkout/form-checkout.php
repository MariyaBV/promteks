<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

$selected_shipping_method = WC()->session->get('selected_shipping_method');
$shipping_label = WC()->session->get('selected_shipping_label');
$shipping_cost = WC()->session->get('selected_shipping_cost');

$block_attention = '';

if ($selected_shipping_method === 'local_pickup:8') {
	$block_attention = 'style="display: none;"';
}

?>
<h2 class="title-checkout"><a href="<?php echo wc_get_cart_url(); ?>"><span class="icon-arrow"></span></a>Данные заказа</h2>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1 col-custom-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>
			<div class="col-2 col-custom-2">
				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>

					<div class="block-attention" <?php echo $block_attention; ?>>
						<p class="subtitle-attention">Внимание!</p>
						<p class="text-attention subtitle">Сумма заказа не включает стоимость доставки. Стоимость доставки будет уточнена после звонка менеджера. </p>
						<a href="<?php echo get_page_link( 40 ); ?>" class="link-attention txt">Условия доставки</a>
					</div>

				</div>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	
	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
