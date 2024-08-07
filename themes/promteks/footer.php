<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package promteks
 */

$options = get_fields('options');
?>
	<footer>
		<div class="footer-content">
			<div class="custom wrap">
				<div class="footer-left">
					<a class="logo-container" href="<?= home_url(); ?>">
						<img src="<?= $options['logo']; ?>" alt="Промтекс" class="footer-logo" />
						<span class="logo-text-year"><?= $options['yeas']; ?></span>
					</a>
					<a href="/contacts/" class="icon-container">
						<span class="icon-place-2"></span>
						<p><?= $options['actual-address']; ?></p>
					</a>
					<a href="tel:<?= $options['phone']; ?>" class="icon-container">
						<span class="icon-phone-2"></span>
						<div>
							<p class="txt-s"><?= $options['phone']; ?></p>
							<p class="subtitle-xs">
								<?= $options['operating_mode']['Mon-Fri']; ?> / <?= $options['operating_mode']['Sat']; ?>
							</p>
						</div>
					</a>
				</div>

				<div class="footer-right txt">
					<?php wp_nav_menu('menu=bottom-menu');?>
				</div>
			</div>
		</div>
	</footer>
	<?php wp_footer(); ?>
</body>
</html>
