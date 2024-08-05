<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package promteks
 */

?>

<section class="no-results not-found wrap">
	<header class="page-header margin-24-0">
		<h1 class="page-title"><?php esc_html_e( 'Ничего не найдено', 'promteks' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content style-404">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p class="margin-24-0">' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'promteks' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p class="margin-24-0"><?php esc_html_e( 'Извините, но ничего не соответствует вашим поисковым запросам. Попробуйте еще раз с другими ключевыми словами.', 'promteks' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p class="margin-24-0"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'promteks' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
