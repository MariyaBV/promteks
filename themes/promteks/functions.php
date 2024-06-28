<?php
/**
 * promteks functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package promteks
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function promteks_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on promteks, use a find and replace
		* to change 'promteks' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'promteks', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'top-menu' => esc_html__( 'Top Menu', 'promteks' ),
			'bottom-menu' => esc_html__( 'Bottom Menu', 'promteks' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'promteks_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'promteks_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function promteks_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'promteks_content_width', 640 );
}
add_action( 'after_setup_theme', 'promteks_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function promteks_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'promteks' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'promteks' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'promteks_widgets_init' );

/**
 * Enqueue scripts and styles.
 */

function promteks_scripts() {
    wp_enqueue_style( 'promteks-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_style_add_data( 'promteks-style', 'rtl', 'replace' );

    wp_enqueue_script('promteks-swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), _S_VERSION, true);

    wp_register_script('promteks-main', get_template_directory_uri() . '/js/main.min.js', array('jquery'), _S_VERSION, true);

    // Локализация скрипта для передачи AJAX URL и других данных
    wp_localize_script('promteks-main', 'custom_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));

    wp_enqueue_script('promteks-main');

    wp_enqueue_script( 'promteks-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'promteks_scripts' );

 
function true_jquery_register() {
	if ( !is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', ( 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' ), false, null, true );
		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'init', 'true_jquery_register' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_action('acf/init', 'promteks_blocks');
function promteks_blocks() {
	// check function exists
	if (function_exists('acf_register_block')) {

		$blocks = [
			'banner-top' => [
				'description' => __('Верхний блок', 'promteks'),
				'title' => __('Верхний блок', 'promteks'),
				'keywords' => array('верхний-блок', 'баннер')
			],
			'product-category' => [
				'description' => __('Блок вывода товаров из 1 категории', 'promteks'),
				'title' => __('Блок вывода товаров из 1 категории', 'promteks'),
				'keywords' => array('блок-товаров-1-категории', 'баннер')
			]
		];

		foreach ($blocks as $title => $arr) {
			acf_register_block(
				array(
					'name' => $title,
					'title' => $arr['title'],
					'description' => $arr['description'],
					'render_callback' => 'promteks_block',
					'category' => 'formatting',
					'icon' => 'admin-comments',
					'keywords' => $arr['keywords'],
					'mode' => 'edit'
				)
			);
		}

	}
}

// function promteks_block($block) {

// 	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
// 	$slug = str_replace('acf/', '', $block['name']);

// 	// include a template part from within the "template-parts/block" folder
// 	if (file_exists(get_theme_file_path("/template-parts/block-{$slug}.php"))) {
// 		include (get_theme_file_path("/template-parts/block-{$slug}.php"));
// 	}
// }

function promteks_block($block) {
    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);

    // include a template part from within the "template-parts/block" folder
    $template_path = get_theme_file_path("/template-parts/block-{$slug}.php");
    if (file_exists($template_path)) {
        include ($template_path);
    } else {
        echo "Template not found: " . $template_path;
    }
}


//ф-я вывода корзины в header
function custom_woocommerce_header_cart() {
    ?>
    <div class="header-cart">
        <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'your-theme-slug' ); ?>">
            <i class="fa fa-cart-custom"></i>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
    </div>
    <?php
}

//ф-я вывода понравившихся товаров header и карточки
function custom_woocommerce_header_wishlist() {
	if ( function_exists( 'YITH_WCWL' ) ) : ?>
		<div class="header-wishlist">
			<a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>">
				<i class="fa fa-heart-o"></i>
				<span class="wishlist-count"><?php echo YITH_WCWL()->count_products(); ?></span>
			</a>
		</div>
	<?php endif;
}

// Обработчик для обновления количества товаров в корзине
function update_cart_count() {
    wp_send_json_success(array(
        'cart_count' => WC()->cart->get_cart_contents_count()
    ));
}
add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');

function custom_add_woocomerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'custom_add_woocomerce_support' );
 
function custom_recently_viewed_product_cookie() {
	// проверка на стр продукта или нет
	if ( ! is_product() ) {
		return;
	}
 
	if ( empty( $_COOKIE[ 'woocommerce_recently_viewed_custom' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_custom' ] );
	}
 
	// добавляем в массив текущий товар
	if ( ! in_array( get_the_ID(), $viewed_products ) ) {
		$viewed_products[] = get_the_ID();
	}
 
	if ( sizeof( $viewed_products ) > 6 ) {
		array_shift( $viewed_products ); 
	}
 
 	// устанавливаем в куки
	wc_setcookie( 'woocommerce_recently_viewed_custom', join( '|', $viewed_products ) );
 
}
add_action( 'template_redirect', 'custom_recently_viewed_product_cookie', 20 );

// Функция для отображения последних просмотренных товаров
function custom_recently_viewed_products() {
 
	if( empty( $_COOKIE[ 'woocommerce_recently_viewed_custom' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_custom' ] );
	}
 
	if ( empty( $viewed_products ) ) {
		return;
	}

	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
 
	// отображаем последние просмотренные
	$viewed_products = array_reverse( array_map( 'absint', $viewed_products ) );
 
	$title = '<h2 class="you-watched">Вы смотрели</h2>';
 
	$product_ids = join( ",", $viewed_products );
 
	$output = '<section class="recently-viewed-block"><div class="recently-viewed-products">' . $title . do_shortcode( "[products ids='$product_ids']" ) . '</div></section>';
 
	return $output;
 
}
add_shortcode( 'recently_viewed_products', 'custom_recently_viewed_products' );


function my_custom_sidebar_widget() {
    if (is_product()) {
        echo do_shortcode('[recently_viewed_products]'); 
    }
}
add_action('woocommerce_sidebar', 'my_custom_sidebar_widget', 10);

// Меняем текст добавления в корзину на странице продукта
function woocommerce_add_to_cart_button_text_single() {
    return __( 'Купить', 'woocommerce' ); 
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_add_to_cart_button_text_single' ); 
function woocommerce_add_to_cart_button_text_archives() {
    return __( 'Купить', 'woocommerce' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_add_to_cart_button_text_archives' ); 

// Функция для замены текста "Бренд" на "Производитель" Perfect Brands for WooCommerce
function replace_brand_with_producer( $text ) {
    return str_replace( 'Бренды', 'Производитель', $text );
}
add_filter( 'gettext', 'replace_brand_with_producer', 20 );
add_filter( 'ngettext', 'replace_brand_with_producer', 20 );

// Изменяем стандартную функцию показа заголовка категории на стр каталог
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title' );
add_action( 'woocommerce_shop_loop_subcategory_title', 'custom_woocommerce_template_loop_category_title' );
function custom_woocommerce_template_loop_category_title( $category ) {
    ?>
    <h4 class="woocommerce-loop-category__title">
        <?php
        echo esc_html( $category->name );

        if ( $category->count > 0 ) {
            echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">(' . esc_html( $category->count ) . ')</span>', $category );
        }
        ?>
    </h4>
    <?php
}

//меняем символ валюты
function change_existing_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'RUB':
            $currency_symbol = 'р.';
            break;
    }
    return $currency_symbol;
}
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

// Убираем блок "Похожие товары"
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// Изменение заголовка "Вам также будет интересно" для сопутствующих товаров
function custom_related_products_title( $translated_text, $text, $domain ) {
    if ( $text === 'You may also like&hellip;' && $domain === 'woocommerce' ) {
        $translated_text = 'С этим товаром покупают';
    }
    return $translated_text;
}
add_filter( 'gettext', 'custom_related_products_title', 10, 3 );

function custom_woocommerce_ajax_add_to_cart() {
    // Получаем идентификатор товара и количество из POST-запроса
    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    
    // Проверяем, валидно ли добавление товара в корзину
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    // Если добавление валидно и статус товара "publish", добавляем товар в корзину
    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity) && 'publish' === $product_status) {
        
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        // Если опция перенаправления после добавления включена, добавляем сообщение
        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        // Возвращаем обновленные фрагменты корзины
        WC_AJAX::get_refreshed_fragments();
    } else {
        // Если добавление не удалось, возвращаем ошибку и URL товара
        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
        );

        echo wp_send_json($data);
    }

    wp_die();
}
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'custom_woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'custom_woocommerce_ajax_add_to_cart');

function custom_template_single_brand() {
    global $product;

    // Получаем ID выбранного производителя для текущего товара
    $brand_ids = wp_get_post_terms( $product->get_id(), 'pwb-brand', array( 'fields' => 'ids' ) );

	// Получаем название блока
    $taxonomy_label = $taxonomy ? $taxonomy->labels->singular_name : 'Производитель';


    // Проверяем, что производитель (бренд) выбран для товара
    if ( ! empty( $brand_ids ) ) {
        $brand_id = reset( $brand_ids ); // Берем первый выбранный бренд (если товар может иметь несколько брендов, нужно адаптировать логику)
        $brand = get_term( $brand_id, 'pwb-brand' ); // Получаем данные о бренде

        if ( ! is_wp_error( $brand ) && $brand ) {
            // Выводим информацию о бренде
            ?>
            <div class="pwb-single-product-brands pwb-clearfix">
                <span class="pwb-text-before-brands-links"><?php echo esc_html($taxonomy_label); ?>:</span>
                <a href="<?php echo esc_url( get_term_link( $brand ) ); ?>" title="<?php echo esc_attr( $brand->name ); ?>">
                    <?php echo esc_html( $brand->name ); ?>
                </a>
            </div>
            <?php
        }
    }
}
add_action( 'woocommerce_single_product_summary', 'custom_template_single_brand', 1 );

if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function woocommerce_template_loop_product_title() {
		echo '<h5 class="txt ' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h5>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
