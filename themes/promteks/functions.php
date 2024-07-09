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

	if (is_product()) {
        wp_enqueue_style('fancybox-css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css', array(), '3.5.7');
        wp_enqueue_script('fancybox-js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', array('jquery'), '3.5.7', true);
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
			],
			'three-blocks' => [
				'description' => __('3 блока', 'promteks'),
				'title' => __('3 блока', 'promteks'),
				'keywords' => array('3-блока', 'баннер')
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

function promteks_block($block) {
    $slug = str_replace('acf/', '', $block['name']);
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
    $taxonomy_label = 'Производитель';

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

//удаляем автоматический вывод бренда на странице продукта
function remove_pwb_brand_action() {
    $positions = array(4, 6, 11, 21, 31, 41, 51);

    foreach ($positions as $position) {
        remove_action('woocommerce_single_product_summary', array('WooCommerce', 'action_woocommerce_single_product_summary'), $position);
	}
}
add_action('init', 'remove_pwb_brand_action');

remove_action('woocommerce_single_product_summary', 'action_woocommerce_single_product_summary');



if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function woocommerce_template_loop_product_title() {
		echo '<h5 class="txt ' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h5>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}


function add_product_category_sidebar() {
    if (!is_product()) {
        ?>
        <aside class="product-category-sidebar">
            <?php
            $args = array(
                'show_option_all'    => '',
                'show_option_none'   => __('No categories'),
                'orderby'            => 'name',
                'order'              => 'ASC',
                'style'              => 'list',
                'show_count'         => 0,
                'hide_empty'         => 1,
                'use_desc_for_title' => 0,
                'child_of'           => 0,
                'feed'               => '',
                'feed_type'          => '',
                'feed_image'         => '',
                'exclude'            => '',
                'exclude_tree'       => '',
                'include'            => '',
                'hierarchical'       => true,
                'title_li'           => '',
                'number'             => NULL,
                'echo'               => 0,
                'depth'              => 0,
                'current_category'   => 0,
                'pad_counts'         => 0,
                'taxonomy'           => 'product_cat',
                'walker'             => new Walker_Category(),
                'hide_title_if_empty' => false,
                'separator'          => '<br />',
            );
            $categories = wp_list_categories($args);
            ?>
            <div class="category-slider">
                <ul class="category-list">
                    <?php echo $categories; ?>
                </ul>
            </div>
        </aside>
        <?php
    }
}
add_action('woocommerce_sidebar', 'add_product_category_sidebar');

function custom_orderby_option( $sortby ) {
	$sortby['discount'] = 'Только со скидкой';
	return $sortby;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_orderby_option' );
add_filter( 'woocommerce_catalog_orderby', 'custom_orderby_option' );

//удаляем исходную сортировку из видов сортировки
function remove_orderby_options( $sortby ) {
	unset( $sortby[ 'menu_order' ] ); // исходная сортировка
	return $sortby;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'remove_orderby_options' );
add_filter( 'woocommerce_catalog_orderby', 'remove_orderby_options' );

function custom_woocommerce_get_catalog_ordering_args( $args ) {
    if ( isset( $_GET['orderby'] ) && 'discount' === $_GET['orderby'] ) {
        $args['meta_query'][] = array(
            'key' => '_pc_discount',
            'value' => 0,
            'compare' => '>',
            'type' => 'NUMERIC'
        );
        $args['orderby'] = array(
            'meta_value_num' => 'ASC'
        );
        $args['meta_key'] = '_pc_discount';
    }
    return $args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );

function custom_pre_get_posts( $query ) {
    if ( ! is_admin() && $query->is_main_query() && isset( $_GET['orderby'] ) && 'discount' === $_GET['orderby'] ) {
        $meta_query = $query->get('meta_query', array());
        $meta_query[] = array(
            'key' => '_pc_discount',
            'value' => 0,
            'compare' => '>',
            'type' => 'NUMERIC'
        );
        $query->set('meta_query', $meta_query);
        $query->set('orderby', 'meta_value_num');
        $query->set('meta_key', '_pc_discount');
        $query->set('order', 'ASC');
    }
}
add_action( 'pre_get_posts', 'custom_pre_get_posts' );

//начало делаем выбор в админке скидки в % и вывод на карточке товара
add_action( 'woocommerce_product_options_pricing', 'genius_set_percentage_discount' );
function genius_set_percentage_discount() {
   global $product_object;
   woocommerce_wp_select(
      array(
         'id' => '_pc_discount',
         'value' => get_post_meta( $product_object->get_id(), '_pc_discount', true ),
         'label' => 'Discount %',
         'options' => array(
            '0' => '0',
			'5' => '5',
            '10' => '10',
			'15' => '15',
			'20' => '20',
            '25' => '25',
			'30' => '30',
            '50' => '50',
         ),
      )
   );
}
 
add_action( 'save_post_product', 'genius_save_percentage_discount' );
function genius_save_percentage_discount( $product_id ) {
    global $typenow;
    if ( 'product' === $typenow ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
      if ( isset( $_POST['_pc_discount'] ) ) {
            update_post_meta( $product_id, '_pc_discount', $_POST['_pc_discount'] );
        }
    }
}
  
add_filter( 'woocommerce_get_price_html', 'genius_alter_price_display', 9999, 2 );
function genius_alter_price_display( $price_html, $product ) {
    if ( is_admin() ) return $price_html;
    if ( '' === $product->get_price() ) return $price_html;
    if ( get_post_meta( $product->get_id(), '_pc_discount', true ) && get_post_meta( $product->get_id(), '_pc_discount', true ) > 0 ) {
        $orig_price = wc_get_price_to_display( $product );
        $price_html = wc_format_sale_price( $orig_price, $orig_price * ( 100 - get_post_meta( $product->get_id(), '_pc_discount', true ) ) / 100 );
    }
    return $price_html;
}
  
add_action( 'woocommerce_before_calculate_totals', 'genius_alter_price_cart', 9999 );
function genius_alter_price_cart( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;
    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
      if ( get_post_meta( $product->get_id(), '_pc_discount', true ) && get_post_meta( $product->get_id(), '_pc_discount', true ) > 0 ) {
           $price = $product->get_price();
           $cart_item['data']->set_price( $price * ( 100 - get_post_meta( $product->get_id(), '_pc_discount', true ) ) / 100 );
      }
    }
}
//конец делаем выбор в админке скидки в % и вывод на карточке товара

// Удаляем стандартную форму сортировки перед списком товаров
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

function custom_woocommerce_get_catalog_ordering_attr_args($query) {
    if (!is_admin() && $query->is_main_query() && is_tax('product_cat')) {
        // Получаем текущие параметры запроса
        $query_vars = $query->query_vars;

        // Инициализация массива tax_query, если он не существует
        if (!isset($query_vars['tax_query'])) {
            $query_vars['tax_query'] = array();
        }

        // Итерируемся по параметрам запроса и добавляем фильтрацию по атрибутам
        foreach ($_GET as $key => $value) {
            if (strpos($key, 'attribute_') === 0 && !empty($value)) {
                $attribute = str_replace('attribute_', '', $key);
                $taxonomy = 'pa_' . $attribute;

                // Добавляем фильтр в tax_query
                $query_vars['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => $value,
                );
            }
        }

        // Устанавливаем измененные параметры обратно в запрос
        $query->set('tax_query', $query_vars['tax_query']);
    }
}
add_action('pre_get_posts', 'custom_woocommerce_get_catalog_ordering_attr_args');


function print_filters() {
    $category = get_queried_object();
    if (!$category) {
        return;
    }
    $category_id = $category->term_id;
    $attributes = get_category_product_attributes($category_id);
    if (!$attributes) {
        return;
    }

    $current_params = $_GET;

    $non_attribute_params = array_filter($current_params, function($key) {
        return strpos($key, 'attribute_') !== 0;
    }, ARRAY_FILTER_USE_KEY);

    $clear_filters_url = add_query_arg($non_attribute_params, get_term_link($category));

    echo '<h2>Фильтры</h2>';
    echo '<div class="attribute-filters"><form method="get" action="#">';

    foreach ($current_params as $key => $value) {
        if (strpos($key, 'attribute_') !== 0) {
            echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        }
    }

    foreach ($attributes as $attribute) {
        $attribute_name = $attribute->attribute_name;
        $attribute_label = $attribute->attribute_label;

        $terms = get_terms(array(
            'taxonomy' => 'pa_' . $attribute_name,
            'hide_empty' => true,
        ));

        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<span class="attribute-filters__select"><select name="attribute_' . esc_attr($attribute_name) . '" id="attribute_' . esc_attr($attribute_name) . '">';
            echo '<option value="">' . esc_html($attribute_label) . '</option>';
            foreach ($terms as $term) {
                $selected = isset($current_params['attribute_' . esc_attr($attribute_name)]) && $current_params['attribute_' . esc_attr($attribute_name)] === $term->slug ? ' selected' : '';
                echo '<option value="' . esc_attr($term->slug) . '"' . $selected . '>' . esc_html($term->name) . '</option>';
            }
            echo '</select><span class="vertical-line"></span><span class="reset-button">×</span></span>';
        }
    }
    echo '<input type="submit" value="Применить фильтры">';
    echo '</form>';
    echo '<a href="' . esc_url($clear_filters_url) . '" class="clear-filters">Очистить фильтры</a>';
    echo '</div>';
}
add_action('woocommerce_before_shop_loop', 'print_filters', 20);

function get_category_product_attributes($category_id) {
    global $wpdb;

    // Получаем ID всех продуктов в данной категории
    $product_ids = $wpdb->get_col($wpdb->prepare("
        SELECT object_id
        FROM {$wpdb->term_relationships}
        WHERE term_taxonomy_id = %d
    ", $category_id));

    if (empty($product_ids)) {
        return false;
    }

    $all_attributes = wc_get_attribute_taxonomies();

    // Отфильтровываем только те атрибуты, которые используются в данных продуктах
    $attributes = array();
    foreach ($all_attributes as $attribute) {
        $taxonomy = 'pa_' . $attribute->attribute_name;
        $term_count = $wpdb->get_var($wpdb->prepare("
            SELECT COUNT(DISTINCT tr.term_taxonomy_id)
            FROM {$wpdb->term_relationships} AS tr
            INNER JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            WHERE tt.taxonomy = %s
            AND tr.object_id IN (" . implode(',', array_map('intval', $product_ids)) . ")
        ", $taxonomy));

        if ($term_count > 0) {
            $attributes[] = $attribute;
        }
    }

    return $attributes;
}
 
//меняем разделить в хлебных крошках
function true_woo_breadcrumbs_delimiter( $defaults ) {
 
	$defaults[ 'delimiter' ] = '&nbsp;&gt;&nbsp;'; 

	return $defaults;
 
}
add_filter( 'woocommerce_breadcrumb_defaults', 'true_woo_breadcrumbs_delimiter' );

//удаляем блок нет в наличии
function custom_availability_text( $availability, $product ) {
    // Возвращаем пустую строку, чтобы убрать текст доступности
    return '';
}
add_filter( 'woocommerce_get_availability_text', 'custom_availability_text', 10, 2 );