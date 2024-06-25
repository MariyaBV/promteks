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
	wp_enqueue_script('promteks-main', get_template_directory_uri() . '/js/main.min.js', array(), _S_VERSION, true);
		

	wp_enqueue_script( 'promteks-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'promteks_scripts' );

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
function promteks_blocks()
{

	// check function exists
	if (function_exists('acf_register_block')) {

		$blocks = [
			'banner-top' => [
				'description' => __('Верхний блок', 'promteks'),
				'title' => __('Верхний блок', 'promteks'),
				'keywords' => array('верхний-блок', 'баннер')
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

function promteks_block($block)
{

	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);

	// include a template part from within the "template-parts/block" folder
	if (file_exists(get_theme_file_path("/template-parts/block-{$slug}.php"))) {
		include (get_theme_file_path("/template-parts/block-{$slug}.php"));
	}
}

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

function custom_add_woocomerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'custom_add_woocomerce_support' );
 
function custom_recently_viewed_product_cookie() {
 
	// если находимся не на странице товара, ничего не делаем
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
 
	if ( sizeof( $viewed_products ) > 7 ) {
		array_shift( $viewed_products ); 
	}
 
 	// устанавливаем в куки
	wc_setcookie( 'woocommerce_recently_viewed_custom', join( '|', $viewed_products ) );
 
}
add_action( 'template_redirect', 'custom_recently_viewed_product_cookie', 20 );

// функция отображения последних просмотренных
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
 
	$title = '<h3>Вы смотрели</h3>';
 
	$product_ids = join( ",", $viewed_products );
 
	return $title . do_shortcode( "[products ids='$product_ids']" );
 
}
add_shortcode( 'recently_viewed_products', 'custom_recently_viewed_products' );


// добавление в БД статуса доставки
function save_custom_shipping_zone_fields( $zone_id, $zone ) {
	if ( isset( $_POST['zone_shipping_type'] ) ) {
		$zone->add_meta_data( 'zone_shipping_type', 'pickup', true );
	} else {
		$zone->add_meta_data( 'zone_shipping_type', 'paid', true );
	}
	$zone->save();
}
add_action( 'woocommerce_update_shipping_zone', 'save_custom_shipping_zone_fields', 10, 2 );

function my_custom_sidebar_widget() {
    if (is_product()) {
        echo do_shortcode('[recently_viewed_products]'); 
    }
}
add_action('woocommerce_sidebar', 'my_custom_sidebar_widget', 10);

// Change add to cart text on single product page
function woocommerce_add_to_cart_button_text_single() {
    return __( 'Купить', 'woocommerce' ); 
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_add_to_cart_button_text_single' ); 

// Change add to cart text on product archives page
function woocommerce_add_to_cart_button_text_archives() {
    return __( 'Купить', 'woocommerce' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_add_to_cart_button_text_archives' ); 

function custom_delivery_options_fields() {
    // Функция для получения стоимости методов доставки
    function get_shipping_methods_costs() {
        $shipping_zones = WC_Shipping_Zones::get_zones();
        $shipping_costs = [];

        foreach ($shipping_zones as $zone) {
            $shipping_methods = $zone['shipping_methods'];

            foreach ($shipping_methods as $method) {
                $shipping_costs[] = [
                    'zone' => $zone['zone_name'],
                    'method_title' => $method->get_title(),
                    'method_cost' => $method->get_instance_option('cost')
                ];
            }
        }

        // Добавление опций самовывоза
        $pickup_options = get_option('woocommerce_pickup_location_settings');

        if (!empty($pickup_options)) {
            $shipping_costs[] = [
                'zone' => 'Самовывоз',
                'method_title' => $pickup_options['title'],
                'method_cost' => $pickup_options['cost']
            ];
        }

        return $shipping_costs;
    }

    $shipping_costs = get_shipping_methods_costs();
    $pickup = 0;
    $delivery_cost = 0;

    // Определение стоимости самовывоза и доставки
    foreach ($shipping_costs as $shipping_cost) {
        if ($shipping_cost['method_title'] == 'Самовывоз со склада') {
            $pickup = $shipping_cost['method_cost'];
        } elseif ($shipping_cost['method_title'] == 'Доставка по городу') {
            $delivery_cost = $shipping_cost['method_cost'];
        }
    }


    $selected_delivery_option = null; // Значение по умолчанию

    echo '<div class="custom-delivery-options">';

    woocommerce_form_field('delivery_option', array(
        'type'    => 'radio',
        'class'   => array('form-row-wide'),
        'options' => array(
            'pickup_location:0' => __('Самовывоз со склада <span>' . $pickup . ' р.</span>', 'woocommerce'),
            'flat_rate:3'       => __('Доставка в течение 1 часа <span>' . $delivery_cost . ' р.</span>', 'woocommerce')
        ),
        'default' => $selected_delivery_option
    ), null);

    echo '</div>';
}

add_action('woocommerce_after_add_to_cart_button', 'custom_delivery_options_fields', 15);

function save_delivery_option_in_session() {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    if (isset($_POST['delivery_option'])) {
        $selected_delivery_option = sanitize_text_field($_POST['delivery_option']);
        WC()->session->set('selected_delivery_option', $selected_delivery_option);

        
        echo '<script type="text/javascript">console.log("Обновлен выбранный способ доставки: ' . $selected_delivery_option . '")</script>';
    }
}
// Подключение к различным событиям для сохранения выбранного способа доставки
add_action('woocommerce_checkout_update_order_review', 'save_delivery_option_in_session', 10, 0);
add_action('woocommerce_cart_updated', 'save_delivery_option_in_session', 10, 0);
add_action('woocommerce_checkout_update_order_meta', 'save_delivery_option_in_session', 10, 0);

// Сброс выбранного способа доставки при очистке корзины
function reset_delivery_status() {
    if (WC()->session) {
        WC()->session->set('selected_delivery_option', null);
    }
}
add_action('woocommerce_cart_emptied', 'reset_delivery_status');




/*function custom_delivery_options_scripts() {
    if (is_product()) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
				$('input[name="delivery_option_pickup"]').change(function() {
					var selectedOption = $(this).val();
					$.ajax({
						url: wc_add_to_cart_params.ajax_url,
						type: 'POST',
						data: {
							action: 'save_delivery_option',
							delivery_option: selectedOption
						}
					});
				});
			});
        </script>
        <?php
    }
}
add_action('wp_footer', 'custom_delivery_options_scripts');*/

