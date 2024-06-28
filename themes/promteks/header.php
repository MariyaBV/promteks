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
			<div class="wrap header-top__block">
				<div class="header-block-delivery">
					<p class="header-block-delivery__city"><?= $options['city']; ?></p>
					<div class="header-block-delivery__delivery">
						<img src="<?= $options['title-top-header']['logo']; ?>"/>
						<h4><?= $options['title-top-header']['title']; ?></h4>
					</div>
				</div>
				<div class="header-block-contacts">
					<p class="header-block-contacts__phone"><?= $options['phone']; ?></p>
					<p class="header-block-contacts__operating-mode"><?= $options['operating_mode']; ?></p>
				</div>
			</div>
		</div>
		<div class="header-bottom">
			<div class="wrap header-bottom__block">
				<div class="header-block-logo">
					<a href="<?= home_url(); ?>">
						<img src="<?= $options['logo']; ?>"/>
					</a>
				</div>
				<div class="header-block-menu">
					<?php wp_nav_menu('menu=top-menu'); ?>
				</div>
				<div class="header-block-search">
					<form role="search" method="get" class="woocommerce-product-search header-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php /*echo esc_attr__( 'Search products&hellip;', 'woocommerce' ); */?>" value="<?php echo get_search_query(); ?>" name="s" />
						<button class="header-search__button" type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>"></button>
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
		</div>
	</header>