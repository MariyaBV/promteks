<?php
    $r = get_fields();
    global $product;
?>
<section class="product-category" id="<?php echo $block['id']; ?>">
    <div class="product-category__content">
        <div class="product-category__header">
            <h2 class="product-category__title">
                <?php echo $r['title']; ?>
            </h2>
            <a class="txt product-category__link" href="<?php echo $r['watch-all']['link']; ?>" class="product-category__link"><?php echo $r['watch-all']['title']; ?></a>
        </div>
        <div class="__slider">
            <div class="swiper" id="id<?php echo $block['id']; ?>">
                <div class="swiper-wrapper product-category__wrapper">
                    <?php
                    $products = wc_get_products(array(
                        'category' => array($r['category-label']),
                        'limit' => 12,
                        'orderby' => 'title',
                    ));

                    foreach ($products as $product) {
                        echo '<div class="swiper-slide product-category__slide">';
                        echo '<a href="' . get_permalink($product->get_id()) . '">';
                        echo $product->get_image();
                        echo '<div class="product-price-wishlist">';
                        echo '<p class="' . esc_attr(apply_filters('woocommerce_product_price_class', 'price')) . '">';
                        echo $product->get_price_html();
                        echo '</p>';
                        //echo do_shortcode('[yith_wcwl_add_to_wishlist]');
                        echo '</div>';
                        echo '<h5 class="txt">' . $product->get_name() . '</h5>';
                        echo '</a>';
                        if ( function_exists( 'custom_template_single_brand' ) ) {
                            echo custom_template_single_brand();
                        }
                        echo '<div class="product-item">';
                        echo '<div class="block-quantity-button">';
                        echo '<button class="quantity-arrow-minus"> - </button>';
                        echo '<div class="quantity">';
                        echo '<input type="number" class="qty" name="quantity" value="1" min="1" />';
                        echo '</div>';
                        echo '<button class="quantity-arrow-plus"> + </button>';
                        echo '<a class="add-to-cart button add_to_cart_button ajax_add_to_cart" data-product-id="';
                        echo esc_attr( $product->get_id() );
                        echo '"><span class="add-to-cart-text">Купить</span></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="swiper-button-next product-category__nextid<?php echo $block['id']; ?>"></div>
        </div>
    </div>
</section>
