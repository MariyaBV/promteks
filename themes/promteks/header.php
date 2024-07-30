<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package promteks
 */
$options = get_fields('options');

//$menuBottom = wp_nav_menu('menu=bottom-menu');
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'promteks' ); ?></a>

	<header id="main-header" class="site-header">
		<div class="header-top">
			<div class="wrap-header header-top__block">
				<div class="header-block-delivery">
					<p class="header-block-delivery__city"><span class="icon-place-2"></span><?= $options['city']; ?></p>
					<div class="header-block-delivery__delivery">
						<img src="<?= $options['title-top-header']['logo']; ?>"/>
						<h4><?= $options['title-top-header']['title']; ?></h4>
					</div>
				</div>
				<div class="header-block-contacts">
					<p class="header-block-contacts__phone"><?= $options['phone']; ?></p>
					<p class="header-block-contacts__operating-mode">
						<?= $options['operating_mode']['Mon-Fri']; ?> | <?= $options['operating_mode']['Sat']; ?>
					</p>
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="wrap-header header-bottom__block">
				<a class="header-block-logo" href="<?= home_url(); ?>">
					<img src="<?= $options['logo']; ?>"/>
					<span class="logo-text-year"><?= $options['yeas']; ?></span>
				</a>
				<div class="header-block-menu">
					<?php /*wp_nav_menu('menu=top-menu');*/?> 
					<div class="menu-top-menu-container">
						<?php
						$menu_name = 'top-menu';
						$menu_items = get_menu_items_with_classes($menu_name);
				
						echo '<ul id="menu-top-menu" class="menu">';
						foreach ($menu_items as $menu_item) {
							$classes = implode(' ', $menu_item->classes);
							echo '<li class="' . esc_attr($classes) . '">';
							echo '<a href="' . esc_url($menu_item->url) . '">' . esc_html($menu_item->title) . '</a>';
							echo '</li>';
						}
						echo '</ul>';
						?>
					</div>
				</div>
				<div class="header-block-search">
					<form role="search" method="get" class="woocommerce-product-search header-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php /*echo esc_attr__( 'Search products&hellip;', 'woocommerce' ); */?>" value="<?php echo get_search_query(); ?>" name="s" />
						<button class="header-search__button" type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>"><span class="icon-Search-2"></span></button>
						<input type="hidden" name="post_type" value="product" />
					</form>
					<?php if ( function_exists( 'custom_woocommerce_header_wishlist' ) ) {
						custom_woocommerce_header_wishlist();
					} ?>
					<?php if ( function_exists( 'custom_woocommerce_header_cart' ) ) {
						custom_woocommerce_header_cart();
					} ?>
				</div>
				
			</div>
			<button class="menu-burger" id="burger-menu"><span class="middle"></span></button>
			<nav id="site-navigation" class="header-block-nav">
				<?php wp_nav_menu('menu=top-menu');?>
			</nav>
		</div>

		


		<div id="block-catalog" class="block-catalog">
			<div class="wrap-header block-catalog__block">
				<div class="block-categories">
					<?php echo do_shortcode('[product_categories parent="0"]'); ?>
				</div>
				<div class="block-offers">
					<?php foreach( $options['advertising_insert_in_catalog_in_menu'] as $item): ?>
						<div class="block-offers__item">
							<div class="block-offers__content">
								<p class="block-offers__subtitle"><?= $item['subtitle']; ?></p>
								<p class="block-offers__text subtitle"><?= $item['text']; ?></p>
							</div>
							<img class="block-offers__img" src="<?= $item['img']; ?>" alt="offer image"/>
							<a class="block-offers__link" href="<?= $item['link']; ?>"></a>
						</div>
					<?php endforeach; ?>
				</div>
				<a href="" id="close-catalog-menu"><span class="icon-Close-1 close-catalog-menu"></span></a>
			</div>
		</div>
	</header>



	<?php if (!is_front_page() && !is_cart() && !is_checkout() && !is_account_page()) : ?>
		<div class="wrap">
			<?php if (function_exists('yoast_breadcrumb')) {
				yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
			} ?>
		</div>
	<?php endif; ?>

