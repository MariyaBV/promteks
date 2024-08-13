<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$attachment_ids    = $product->get_gallery_image_ids();
$wrapper_classes   = apply_filters(
    'woocommerce_single_product_image_gallery_classes',
    array(
        'woocommerce-product-gallery',
        'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
        'woocommerce-product-gallery--columns-' . absint( $columns ),
        'images',
    )
);

$categories = wc_get_product_category_list( $product->get_id());

?>

<div class="product-categories-link"><span class="icon-Vector-13"></span><?php echo $categories; ?></div>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 1; transition: opacity .25s ease-in-out;">
    <div class="woocommerce-product-gallery__wrapper swiper desktop">
        <div class="swiper-container  product-gallery-swiper">
            <div class="swiper-wrapper swiper-wrapper-vertical woocommerce-product-gallery__wrapper">
                <?php
                if ($attachment_ids) {
                    foreach ($attachment_ids as $attachment_id) {
                        $full_size_image = wp_get_attachment_image_src($attachment_id, 'full');
                        $thumbnail_image = wp_get_attachment_image($attachment_id, 'thumbnail');
                        echo '<div class="swiper-slide">';
                        echo '<a href="' . esc_url($full_size_image[0]) . '" data-fancybox="gallery">' . $thumbnail_image . '</a>';
                        echo '</div>';
                    }
				}
                ?>
            </div>
            <div class="swiper-button-prev product-gallery__swiper-button-prev icon-Vector-9"></div>
            <div class="swiper-button-next product-gallery__swiper-button-next icon-Down-1"></div>
        </div>
		<?php
		if ($post_thumbnail_id) {
            $full_size_image = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            echo '<a href="' . esc_url($full_size_image[0]) . '" data-fancybox="gallery">' . wp_get_attachment_image($post_thumbnail_id, 'large') . genius_display_discount_badge_return() . '</a>';
        } else {
            genius_display_discount_badge();
            echo sprintf('<img src="%s" alt="%s" class="wp-post-image" style="width: 520px; height: 520px;" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'woocommerce'));
        }
		?>
    </div>
    <div class="__slider slider-mobile">
        <?php
        if ($post_thumbnail_id) {
            $full_size_image = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            echo '<a class="img-big-mobile" href="' . esc_url($full_size_image[0]) . '" data-fancybox="gallery">' . wp_get_attachment_image($post_thumbnail_id, 'large') . genius_display_discount_badge_return() . '</a>';
        } else {
            genius_display_discount_badge();
            echo sprintf('<img src="%s" alt="%s" class="wp-post-image" style="width: 520px; height: 520px;" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'woocommerce'));
        }
        ?>
        <div class="swiper mobile">
            <div class="swiper-container-mobile  product-gallery-swiper-mobile">
                <div class="swiper-wrapper swiper-wrapper-mobile">
                    <?php
                    if ($attachment_ids) {
                        foreach ($attachment_ids as $attachment_id) {
                            $full_size_image = wp_get_attachment_image_src($attachment_id, 'full');
                            $thumbnail_image = wp_get_attachment_image($attachment_id, 'thumbnail');
                            echo '<div class="swiper-slide">';
                            echo '<a href="' . esc_url($full_size_image[0]) . '" data-fancybox="gallery">' . $thumbnail_image . '</a>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
                <div class="swiper-button-prev product-gallery__swiper-button-prev-mobile icon-Vector-13"></div>
                <div class="swiper-button-next product-gallery__swiper-button-next-mobile icon-Vector-14"></div>
            </div>
        </div>
    </div>
</div>