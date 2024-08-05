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

    if (is_order_received_page()) {
        wp_enqueue_script('html2pdf-js', 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js', array(), _S_VERSION, true);
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
			'slider' => [
				'description' => __('Блок со слайдером', 'promteks'),
				'title' => __('Блок со слайдером', 'promteks'),
				'keywords' => array('Блок-со-слайдером', 'баннер')
			],
			'product-category' => [
				'description' => __('Блок вывода товаров из 1 категории', 'promteks'),
				'title' => __('Блок вывода товаров из 1 категории', 'promteks'),
				'keywords' => array('блок-товаров-1-категории', 'баннер')
			],
			'list-with-img' => [
				'description' => __('Список с заголовком и картинками', 'promteks'),
				'title' => __('Список с заголовком и картинками', 'promteks'),
				'keywords' => array('Список-заголовком-картинками', 'баннер')
			],
			'list-img' => [
				'description' => __('Список с картинкой', 'promteks'),
				'title' => __('Список с картинкой', 'promteks'),
				'keywords' => array('Список-с-картинкой', 'баннер')
			],
			'images-text' => [
				'description' => __('Блок текст на картинке', 'promteks'),
				'title' => __('Блок текст на картинке', 'promteks'),
				'keywords' => array('Блок-текст-на-картинке', 'баннер')
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
            <span class="icon-typeDefault-1"></span>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
    </div>
    <?php
}

//ф-я вывода понравившихся товаров header и карточки
/*function custom_woocommerce_header_wishlist() {
	if ( function_exists( 'YITH_WCWL' ) ) : ?>
		<div class="header-wishlist">
			<a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>">
				<i class="fa fa-heart-o-white"></i>
				<span class="wishlist-count"><?php echo YITH_WCWL()->count_products(); ?></span>
			</a>
		</div>
	<?php endif;
}*/

function custom_add_woocomerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'custom_add_woocomerce_support' );


//Обработчик для обновления количества товаров в корзине
function update_cart_count() {
    wp_send_json_success(array(
        'cart_count' => WC()->cart->get_cart_contents_count()
    ));
}
add_action('wp_ajax_update_cart_count', 'update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count');

//Блок вы смотрели начало
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
 
	if ( sizeof( $viewed_products ) > 3 ) {
		array_shift( $viewed_products ); 
	}
 
 	// устанавливаем в куки
	wc_setcookie( 'woocommerce_recently_viewed_custom', join( '|', $viewed_products ) );
 
}
add_action( 'template_redirect', 'custom_recently_viewed_product_cookie', 20 );


// Функция для отображения последних просмотренных товаров
function custom_recently_viewed_products() {
 
	if( empty( $_COOKIE[ 'woocommerce_recently_viewed_custom' ] ) ) {
		return; //$viewed_products = array();
	} 
    
	$viewed_products = (array) explode( '|', $_COOKIE[ 'woocommerce_recently_viewed_custom' ] );
 
	// отображаем последние просмотренные
	$viewed_products = array_reverse( array_map( 'absint', $viewed_products ) );
 
	$title = '<h2 class="you-watched">Вы смотрели</h2>';
 
	$product_ids = join( ",", $viewed_products );
 
	$output = '<section class="recently-viewed-products">' . $title . do_shortcode( "[products ids='$product_ids']" ) . '</section>';
 
	return $output;
 
}
add_shortcode( 'recently_viewed_products', 'custom_recently_viewed_products' );


function my_custom_sidebar_widget() {
    if (is_product()) {
        echo do_shortcode('[recently_viewed_products]'); 
    }
}
add_action('woocommerce_after_single_product_summary', 'my_custom_sidebar_widget', 15);
//блок вы смотрели конец 

// Меняем текст добавления в корзину на странице продукта
function woocommerce_add_to_cart_button_text_single() {
    return __( 'Купить', 'woocommerce' ); 
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_add_to_cart_button_text_single' ); 
function woocommerce_add_to_cart_button_text_archives() {
    return __( 'Купить', 'woocommerce' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_add_to_cart_button_text_archives' ); 


// Изменяем стандартную функцию показа заголовка категории на стр каталог
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title' );
add_action( 'woocommerce_shop_loop_subcategory_title', 'custom_woocommerce_template_loop_category_title' );
function custom_woocommerce_template_loop_category_title( $category ) {
    ?>
    <h4 class="woocommerce-loop-category__title">
        <?php
        echo esc_html( $category->name );

        // if ( $category->count > 0 ) {
        //     echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">(' . esc_html( $category->count ) . ')</span>', $category );
        // }
        ?>
    </h4>
    <?php
}

//меняем символ валюты
// function change_existing_currency_symbol( $currency_symbol, $currency ) {
//     switch( $currency ) {
//         case 'RUB':
//             $currency_symbol = '₽';
//             break;
//     }
//     return $currency_symbol;
// }
// add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

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

//вывод производителя на странице товара
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
            <div class="custom-block-brands">
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

// Функция для замены текста "Бренд" на "Производитель" Perfect Brands for WooCommerce в админке
function replace_brand_with_producer( $text ) {
    return str_replace( 'Бренды', 'Производитель', $text );
}
add_filter( 'gettext', 'replace_brand_with_producer', 20 );
add_filter( 'ngettext', 'replace_brand_with_producer', 20 );

//удаляем автоматический вывод бренда на странице продукта
// function remove_pwb_brand_action() {
//     $positions = array(4, 6, 11, 21, 31, 41, 51);

//     foreach ($positions as $position) {
//         remove_action('woocommerce_single_product_summary', array('WooCommerce', 'action_woocommerce_single_product_summary'), $position);
// 	}
//     remove_action('woocommerce_single_product_summary', array('Perfect_WooCommerce_Brands_Class', 'action_woocommerce_single_product_summary'), 41);

//     remove_action('woocommerce_single_product_summary', 'pwb_print_brand_in_single_product', 6);
// }
// add_action('init', 'remove_pwb_brand_action');

// remove_action('woocommerce_single_product_summary', 'action_woocommerce_single_product_summary');




if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function woocommerce_template_loop_product_title() {
		echo '<h5 class="txt ' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h5>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}


// Кастомный класс Walker для вывода миниатюр в списке категорий
class Walker_Category_Thumbnails extends Walker_Category {
    private $expanded_parents = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='children'>\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $cat_name = esc_attr( $category->name );
        $cat_name = apply_filters( 'list_cats', $cat_name, $category );

        $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
        $image_url = wp_get_attachment_url( $thumbnail_id );
        $link = get_term_link( $category );

        $active = '';
        $expanded = '';
        $my_category = get_queried_object();

        if (is_product_category() && ($my_category->term_id == $category->term_id)) {
            $active = 'selected';
        }

        if (is_product_category() && term_is_ancestor_of($category->term_id, $my_category->term_id, 'product_cat')) {
            $expanded = 'expanded';
        }

        if (is_product()) {
            $product_id = get_the_ID();
            $product_categories = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));

            if (in_array($category->term_id, $product_categories)) {
                $active = 'selected';

                // Если категория имеет родителя, отмечаем родителя для раскрытия
                if ($category->parent) {
                    $this->expanded_parents[] = $category->parent;
                }
            }
        }

        $output .= "\t<li id='cat-item-{$category->term_id}' class='cat-item cat-item-{$category->term_id} $active $expanded'>";
        $output .= "<a class='cat-link' href='" . esc_url( $link ) . "'>";
        if ( $depth == 0 && $image_url ) {
            // Показываем миниатюру только для верхнего уровня
            $output .= "<img class='cat-image' src='" . esc_url( $image_url ) . "' alt='" . esc_attr( $cat_name ) . "' />";
        }
        $output .= "<span class='cat-name'>" . "$cat_name" . "</span>";
        $output .= "</a>";
        if ( ! empty( $args['show_count'] ) ) {
            $output .= ' (' . number_format_i18n( $category->count ) . ')';
        }
    }

    // function end_el( &$output, $category, $depth = 0, $args = array() ) {
    //     $output .= "</li>\n";
    // }

    function end_el( &$output, $category, $depth = 0, $args = array() ) {
        // Добавляем класс expanded родительским категориям, если необходимо
        if (in_array($category->term_id, $this->expanded_parents)) {
            $output = str_replace("cat-item-{$category->term_id} ", "cat-item-{$category->term_id} expanded ", $output);
        }
        $output .= "</li>\n";
    }
}


function add_product_category_sidebar() {
    //if (!is_product()) {
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
                'walker'             => new Walker_Category_Thumbnails(),
                'hide_title_if_empty' => false,
                'separator'          => '<br />',
            );
            $categories = wp_list_categories($args);
            ?>
            <div id="catalog-sidebar" class="category-list-categories mobile">
                <h3>Каталог</h3>
                <a class="close-catalog-sidebar" href="" id="close-catalog-sidebar"><span class="icon-Close-1 close-catalog-sidebar"></span></a>
                <ul class="category-list">
                    <?php echo $categories; ?>
                </ul>
            </div>
        </aside>
        <?php
    //}
}
//add_action('woocommerce_sidebar', 'add_product_category_sidebar');

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
// вывод скидки в % на картинке карточки товара
add_action( 'woocommerce_before_shop_loop_item_title', 'genius_display_discount_badge', 10 );
function genius_display_discount_badge() {
    global $product;
    
    $discount = get_post_meta( $product->get_id(), '_pc_discount', true );
    if ( $discount && $discount > 0 ) {
        echo '<span class="discount-badge">-' . esc_html( $discount ) . '%</span>';
    }
}

function genius_display_discount_badge_return() {
    global $product;

    $discount = get_post_meta($product->get_id(), '_pc_discount', true);
    if ($discount && $discount > 0) {
        return '<span class="discount-badge">-' . esc_html($discount) . '%</span>';
    }
    return '';
}

//конец делаем выбор в админке скидки в % и вывод на карточке товара

// Удаляем стандартную форму сортировки перед списком товаров
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);


function custom_woocommerce_get_catalog_ordering_attr_args( $query ) {
    // Проверяем, что это основной запрос и не в админке
    if ( ! is_admin() && $query->is_main_query() && ( is_shop() || is_tax('product_cat') ) ) {
        // Получаем текущие параметры запроса
        $query_vars = $query->query_vars;

        // Инициализация массива tax_query, если он не существует
        if ( ! isset( $query_vars['tax_query'] ) ) {
            $query_vars['tax_query'] = array();
        }

        // Итерируемся по параметрам запроса и добавляем фильтрацию по атрибутам
        foreach ( $_GET as $key => $value ) {
            if ( strpos( $key, 'attribute_' ) === 0 && ! empty( $value ) ) {
                $attribute = str_replace( 'attribute_', '', $key );
                $taxonomy = 'pa_' . $attribute;

                // Добавляем фильтр в tax_query
                $query_vars['tax_query'][] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => sanitize_title( $value ),
                    'operator' => 'IN',
                );
            }
        }

        // Устанавливаем измененные параметры обратно в запрос
        $query->set( 'tax_query', $query_vars['tax_query'] );
    }
}
add_action( 'pre_get_posts', 'custom_woocommerce_get_catalog_ordering_attr_args' );


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

    $attribute_params = array_filter($current_params, function($key) {
        return strpos($key, 'attribute_') === 0;
    }, ARRAY_FILTER_USE_KEY);

    $non_attribute_params = array_filter($current_params, function($key) {
        return strpos($key, 'attribute_') !== 0;
    }, ARRAY_FILTER_USE_KEY);

    $has_non_empty_attribute = false;
    foreach ($attribute_params as $value) {
        if (!empty($value)) {
            $has_non_empty_attribute = true;
            break;
        }
    }

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
    
    if ($has_non_empty_attribute) {
        echo '<a href="' . esc_url($clear_filters_url) . '" class="clear-filters">Очистить фильтры</a>';
    }

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
        $attribute_name = $attribute->attribute_name;

        // Исключаем атрибут 'product-unit'
        if ($attribute_name === 'product-unit') {
            continue;
        }

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

//удаляем блок нет в наличии
function custom_availability_text( $availability, $product ) {
    // Возвращаем пустую строку, чтобы убрать текст доступности
    return '';
}
add_filter( 'woocommerce_get_availability_text', 'custom_availability_text', 10, 2 );


//удаляем хлебные крошки woocomerce
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);


//хлебные крошки yoast seo
function custom_breadcrumb_home_text($link_output) {
    if (!is_front_page()) {
        return str_replace('Главная страница', 'Главная', $link_output);
    }
    return $link_output;
}
add_filter('wpseo_breadcrumb_single_link', 'custom_breadcrumb_home_text');

//удаляем разделить в хлебных крошках yoast seo
function custom_breadcrumb_separator($output) {
    $output = str_replace('»', '', $output);
    return $output;
}
add_filter('wpseo_breadcrumb_separator', 'custom_breadcrumb_separator');

//добавляем доп спан чтобы правильно применялись стили для текста
function wrap_breadcrumbs_link_text($link_output) {
    if (preg_match('/<a[^>]*>(.*?)<\/a>/', $link_output, $matches)) {
        $new_link_output = str_replace($matches[1], '<span class="breadcrums-link-text">' . $matches[1] . '</span>', $link_output);
        return $new_link_output;
    }
    return $link_output;
}
add_filter('wpseo_breadcrumb_single_link', 'wrap_breadcrumbs_link_text');


function custom_delivery_options_fields() {
    function get_shipping_methods_costs() {
        // Получаем зоны доставки
        $shipping_zones = WC_Shipping_Zones::get_zones();
        $shipping_costs = [];
    
        foreach ($shipping_zones as $zone) {
            // Получаем методы доставки для каждой зоны
            $shipping_methods = $zone['shipping_methods'];
            
            foreach ($shipping_methods as $method) {
                $shipping_costs[] = [
                    'zone' => $zone['zone_name'],
                    'method_title' => $method->get_title(),
                    'method_cost' => $method->get_instance_option('cost')
                ];
            }
        }
    
        return $shipping_costs;
    }

    $shipping_costs = get_shipping_methods_costs();
    $pickup = $delivery_cost = '';

    foreach ($shipping_costs as $shipping_cost) {
        if ($shipping_cost['method_title'] == 'Самовывоз') {
            $pickup = '0';
        } elseif ($shipping_cost['method_title'] == 'Доставка по Брянску') {
            $delivery_cost = $shipping_cost['method_cost'];
        }
    }

    echo '<div class="custom-delivery-block">';
    if ($pickup !== '') {
        echo '<div class="delivery-text delivery-text__pickup"><p><span class="icon-iconoir_box-iso2"></span>Самовывоз со склада:</p> <span>' . $pickup . ' р.</span></div>';
    }
    if ($delivery_cost !== '') {
        echo '<div class="delivery-text"><p><span class="icon-carbon_delivery-2"></span>Доставка в течение 1&nbsp;часа:</p> <span> ' . $delivery_cost . ' р.</span></div>';
    }
    echo '</div>';
}

function custom_attribute_unit($product_id) {
    $product = wc_get_product($product_id);
    if (!$product) {
        return;
    }

    $attributes = $product->get_attributes();
    if (!$attributes || !isset($attributes['pa_product-unit'])) {
        // Если атрибут отсутствует, подставляем значение "шт."
        echo "шт.";
        return;
    }

    $attribute = $attributes['pa_product-unit'];
    if (!$attribute) {
        echo "шт.";
        return;
    }

    $terms = wc_get_product_terms($product_id, $attribute->get_name(), array('fields' => 'names'));
    
    if (!empty($terms)) {
        echo implode(' ', $terms);
    } else {
        echo "шт.";
    }

    return;
}


//добавление кнопки очистить корзину начало
add_action( 'woocommerce_before_cart', 'true_empty_cart_btn' );
function true_empty_cart_btn(){
	echo '<a class="clear-filters clear-filters-cart" href="' . WC()->cart->get_cart_url() . '?empty-cart">Очистить корзину</a>';
}
 
add_action( 'init', 'true_empty_cart' );
function true_empty_cart() {
	if ( isset( $_GET[ 'empty-cart' ] ) ) {
		WC()->cart->empty_cart();
	}
}
//добавление кнопки очистить корзину конец

//все фильтры на странице магазина
function get_all_product_attributes() {
    global $wpdb;

    // Получаем все ID продуктов в магазине
    $product_ids = $wpdb->get_col("
        SELECT DISTINCT object_id
        FROM {$wpdb->term_relationships}
    ");

    if (empty($product_ids)) {
        return false;
    }

    $all_attributes = wc_get_attribute_taxonomies();
    $attributes = array();

    foreach ($all_attributes as $attribute) {
        $attribute_name = $attribute->attribute_name;

        // Исключаем атрибут 'product-unit'
        if ($attribute_name === 'product-unit') {
            continue;
        }

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
function print_filters_shop() {
    // Проверяем, что это страница магазина
    if (!is_shop()) {
        return;
    }

    $attributes = get_all_product_attributes();
    if (!$attributes) {
        return;
    }

    $current_params = $_GET;

    $attribute_params = array_filter($current_params, function($key) {
        return strpos($key, 'attribute_') === 0;
    }, ARRAY_FILTER_USE_KEY);


    // Фильтруем параметры, чтобы удалить атрибуты
    $non_attribute_params = array_filter($current_params, function($key) {
        return strpos($key, 'attribute_') !== 0;
    }, ARRAY_FILTER_USE_KEY);

    $has_non_empty_attribute = false;
    foreach ($attribute_params as $value) {
        if (!empty($value)) {
            $has_non_empty_attribute = true;
            break;
        }
    }

    // Создаем ссылку для очистки фильтров
    $clear_filters_url = add_query_arg($non_attribute_params, get_permalink(get_option('woocommerce_shop_page_id')));

    echo '<h2>Фильтры</h2>';
    echo '<div class="attribute-filters"><form method="get" action="#">';

    // Скрытые поля для всех текущих параметров, не являющихся атрибутами
    foreach ($current_params as $key => $value) {
        if (strpos($key, 'attribute_') !== 0) {
            echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        }
    }

    // Вывод фильтров по атрибутам
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
    
    if ($has_non_empty_attribute) {
        echo '<a href="' . esc_url($clear_filters_url) . '" class="clear-filters">Очистить фильтры</a>';
    }

    echo '</div>';
}
add_action('woocommerce_before_shop_loop', 'print_filters_shop', 20);

// Устанавливаем стоимость доставки = 0 для всех методов дотсавки чтобы не приабвлялось к сумме заказа
// function make_all_shipping_methods_free( $rates, $package ) {
//     foreach ( $rates as $rate_id => $rate ) {
//         $rates[$rate_id]->cost = 0;     }
//     return $rates;
// }
// add_filter( 'woocommerce_package_rates', 'make_all_shipping_methods_free', 10, 2 );

//фильтр для кастомизации полей в форме доставки
function customize_billing_fields($fields) {
    // Удаление ненужных полей
    /*unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_2']);*/

    // Добавление новых полей
    $fields['billing']['billing_state'] = array(
        'type'        => 'text',
        'label'       => __('Область', 'woocommerce'),
        'required'    => false,
        'class'       => array('form-row-wide'),
        'priority'    => 70,
        'placeholder' => __('Область', 'woocommerce'),
        'default'     => 'Брянская область',
    );
    $fields['billing']['billing_country'] = array(
        'type'        => 'text',
        'label'       => __('Страна', 'woocommerce'),
        'required'    => false,
        'class'       => array('form-row-wide'),
        'priority'    => 80,
        'placeholder' => __('Страна', 'woocommerce'),
        'default'     => 'Россия',
    );
    $fields['billing']['billing_postcode'] = array(
        'type'        => 'number',
        'label'       => __('Почтовый индекс', 'woocommerce'),
        'required'    => false,
        'class'       => array('form-row-wide'),
        'priority'    => 90,
        'placeholder' => __('Почтовый индекс', 'woocommerce'),
        'default'     => '241000',
    );
    $fields['billing']['billing_first_name'] = array(
        'type'        => 'text',
        'label'       => __('Имя', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 100,
        'placeholder' => __('Иван *', 'woocommerce'),
    );
    $fields['billing']['billing_last_name'] = array(
        'type'        => 'text',
        'label'       => __('Фамилия', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 110,
        'placeholder' => __('Иванов *', 'woocommerce'),
    );
    $fields['billing']['billing_phone'] = array(
        'type'        => 'text',
        'label'       => __('Телефон', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 120,
        'placeholder' => __('+7(xxx)xxx-xx-xx *', 'woocommerce'),
    );

    $fields['billing']['billing_email'] = array(
        'type'        => 'email',
        'label'       => __('e-mail', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 130,
        'placeholder' => __('mail@mail.ru *', 'woocommerce'),
    );

    $fields['billing']['billing_city'] = array(
        'type'        => 'text',
        'label'       => __('Адрес доставки', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 140,
        'placeholder' => __('Населенный пункт *', 'woocommerce'),
    );

    $fields['billing']['billing_address_1'] = array(
        'type'        => 'text',
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 150,
        'placeholder' => __('Улица *', 'woocommerce'),
    );

    $fields['billing']['billing_address_2'] = array(
        'type'        => 'text',
        'required'    => true,
        'class'       => array('form-row-one'),
        'priority'    => 160,
        'placeholder' => __('Дом *', 'woocommerce'),
    );

    $fields['billing']['billing_address_3'] = array(
        'type'        => 'text',
        'required'    => false,
        'class'       => array('form-row-two'),
        'priority'    => 170,
        'placeholder' => __('Корпус', 'woocommerce'),
    );

    $fields['billing']['billing_address_4'] = array(
        'type'        => 'text',
        'required'    => false,
        'class'       => array('form-row-three'),
        'priority'    => 180,
        'placeholder' => __('Квартира', 'woocommerce'),
    );

    $fields['billing']['billing_apartment'] = array(
        'type'        => 'text',
        'required'    => false,
        'class'       => array('form-row-first'),
        'priority'    => 190,
        'placeholder' => __('Подъезд', 'woocommerce'),
    );

    $fields['billing']['billing_code'] = array(
        'type'        => 'text',
        'required'    => false,
        'class'       => array('form-row-last'),
        'priority'    => 200,
        'placeholder' => __('Код от подъезда', 'woocommerce'),
    );

    $fields['billing']['billing_comment'] = array(
        'type'        => 'textarea',
        'label'       => __('Комментарий', 'woocommerce'),
        'required'    => false,
        'class'       => array('form-row-wide'),
        'priority'    => 210,
        'placeholder' => __('Комментарий', 'woocommerce'),
    );

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'customize_billing_fields');


// // Установка заказа как оплаченный
// add_action('woocommerce_checkout_order_processed', 'custom_woocommerce_checkout_order_processed', 20, 3);
// function custom_woocommerce_checkout_order_processed($order_id, $posted_data, $order) {
//     $order->payment_complete();
// }


//перенесем кнопку подтвердить заказ в конец формы
function move_payment_block() {
    remove_action( 'woocommerce_review_order_after_order_total', 'woocommerce_checkout_payment', 20 );
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

    add_action( 'woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment', 20 );
}
add_action( 'wp_loaded', 'move_payment_block' );

// сохраняем выбранный метод доставки
function save_selected_shipping_method() {
    if (isset($_POST['shipping_method'])) {
        $shipping_method = sanitize_text_field($_POST['shipping_method']);
        $shipping_label = sanitize_text_field($_POST['shipping_label']);
        $shipping_cost = sanitize_text_field($_POST['shipping_cost']);

        // Обновляем метод доставки в сессии
        WC()->session->set('selected_shipping_method', $shipping_method);
    }
}
add_action('wp_ajax_save_selected_shipping_method', 'save_selected_shipping_method');
add_action('wp_ajax_nopriv_save_selected_shipping_method', 'save_selected_shipping_method');

// Сохраняем метод доставки в мета-данные заказа
function save_order_shipping_method($order_id) {
    if ($shipping_method = WC()->session->get('selected_shipping_method')) {
        update_post_meta($order_id, '_selected_shipping_method', sanitize_text_field($shipping_method));
    }
}
add_action('woocommerce_checkout_update_order_meta', 'save_order_shipping_method');

// изменяем поле адреса на не обязательное в случае если самовывоз
function customize_checkout_fields_based_on_shipping($fields) {
    $chosen_methods = WC()->session->get('chosen_shipping_methods');
    $selected_shipping_method = isset($chosen_methods[0]) ? $chosen_methods[0] : '';

    if ($selected_shipping_method === 'local_pickup:8') {
        // Установка полей как необязательных
        $fields['billing']['billing_country']['required'] = false;
        $fields['billing']['billing_postcode']['required'] = false;
        $fields['billing']['billing_state']['required'] = false;
        $fields['billing']['billing_city']['required'] = false;
        $fields['billing']['billing_address_1']['required'] = false;
        $fields['billing']['billing_address_2']['required'] = false;
        $fields['billing']['billing_address_3']['required'] = false;
        $fields['billing']['billing_address_4']['required'] = false;
        $fields['billing']['billing_apartment']['required'] = false;
        $fields['billing']['billing_code']['required'] = false;

        // Установка значений по умолчанию
        $fields['billing']['billing_country']['default'] = 'RU';
        $fields['billing']['billing_postcode']['default'] = '241000';
        $fields['billing']['billing_state']['default'] = 'Брянская область';
        $fields['billing']['billing_city']['default'] = 'Брянск';
        $fields['billing']['billing_address_1']['default'] = 'Карачевкое шоссе';
        $fields['billing']['billing_address_2']['default'] = '4 км.';
        $fields['billing']['billing_address_3']['default'] = '-';
        $fields['billing']['billing_address_4']['default'] = '-';
        $fields['billing']['billing_apartment']['default'] = '-';
        $fields['billing']['billing_code']['default'] = '-';
    }

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'customize_checkout_fields_based_on_shipping');

// выводим информацию о выбранном методе доставки
function display_shipping_info() {
    $shipping_label = WC()->session->get('selected_shipping_label');
    $shipping_cost = WC()->session->get('selected_shipping_cost');

    if ($shipping_label && $shipping_cost) {
        echo '<div class="woocommerce-shipping-info" style="display: none;">';
        echo '<p>' . __('Shipping Method: ', 'woocommerce') . $shipping_label . '</p>';
        echo '<p>' . __('Shipping Cost: ', 'woocommerce') . $shipping_cost . '</p>';
        echo '</div>';
    }
}
add_action('woocommerce_review_order_before_payment', 'display_shipping_info');

// Выводим метод доставки в админке на странице редактирования заказа
add_action('woocommerce_admin_order_data_after_shipping_address', 'display_shipping_method_in_admin_order_meta', 10, 1);
function display_shipping_method_in_admin_order_meta($order) {
    $shipping_method = get_post_meta($order->get_id(), '_selected_shipping_method', true);
    if ($shipping_method) {
        switch ($shipping_method) {
            case 'local_pickup:8':
                $shipping_method_text = 'Самовывоз';
                break;
            case 'flat_rate:3':
                $shipping_method_text = 'Доставка по Брянску';
                break;
            case 'flat_rate:7':
                $shipping_method_text = 'Доставка по области';
                break;
            default:
                $shipping_method_text = '';
        }
        echo '<p><strong>' . __('Метод доставки:') . '</strong> ' . esc_html($shipping_method_text) . '</p>';
    }
}

// Добавляем метод доставки в колонки на странице заказов
function add_shipping_method_column_to_order_list($columns) {
    $columns['shipping_method'] = __('Метод доставки');
    return $columns;
}
add_filter('manage_edit-shop_order_columns', 'add_shipping_method_column_to_order_list');

function display_shipping_method_column_data($column) {
    global $post;

    if ($column == 'shipping_method') {
        $order = wc_get_order($post->ID);
        $shipping_method = get_post_meta($order->get_id(), '_selected_shipping_method', true);
        if ($shipping_method) {
            echo esc_html($shipping_method);
        }
    }
}
add_action('manage_shop_order_posts_custom_column', 'display_shipping_method_column_data');

// Скрываем блок id="order_shipping_line_items" - доставка 0,00 руб в админке WooCommerce
function hide_order_shipping_line_items() {
    echo '
    <style>
        #order_shipping_line_items {
            display: none !important;
        }
    </style>
    ';
}
add_action('admin_head', 'hide_order_shipping_line_items');


function custom_checkout_alert_script() {
    if (is_checkout()) { 
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(document).on('click', '#place_order', function(event) {
                    event.preventDefault();
                    
                    // Показываем блок с сообщением
                    $('.thankyou-alert').fadeIn();

                    // Обработка клика на кнопку "OK"
                    $('.thankyou-alert__button').on('click', function() {
                        $('.thankyou-alert').fadeOut();
                        $('form.checkout').submit();
                    });
                });
            });
        </script>
    <?php
    }
}
add_action('wp_footer', 'custom_checkout_alert_script');

//стиль к item menu на странице которой находимся
function get_menu_items_with_classes($menu_name) {
    $locations = get_nav_menu_locations();
    $menu_id = isset($locations[$menu_name]) ? $locations[$menu_name] : 0;
    $menu_items = wp_get_nav_menu_items($menu_id);
    
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request));
    $current_path = trim(parse_url($current_url, PHP_URL_PATH), '/');

    foreach ($menu_items as $menu_item) {
        $menu_path = trim(parse_url($menu_item->url, PHP_URL_PATH), '/');

        if ($menu_item->url === '#catalog') {
            continue;
        }

        if ($menu_path === $current_path) {
            $menu_item->classes[] = 'selected-item-menu';
        }
    }

    return $menu_items;
}


//перенос пагинации в хук woocommerce_after_main_content
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
add_action('woocommerce_after_main_content', 'woocommerce_pagination', 20);

// Удаляем цену из списка продуктов
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
