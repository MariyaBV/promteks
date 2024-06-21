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
	wp_enqueue_script('promteks-main', get_template_directory_uri() . '/js/main.min.js', array('formula-swiper'), _S_VERSION, true);
		

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
