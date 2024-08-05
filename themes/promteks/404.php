<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package promteks
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found  wrap">
			<header class="page-header margin-24-0">
				<h1 class="page-title"><?php esc_html_e( 'Oops! Такая страница не найдена', 'promteks' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content style-404">
				<p class="margin-24-0"><?php esc_html_e( 'Похоже, в этом месте ничего не найдено. Может быть, попробуете поиск?', 'promteks' ); ?></p>

					<?php
					get_search_form();

					/*the_widget( 'WP_Widget_Recent_Posts' );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'promteks' ); ?></h2>
						<ul>
							<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
							?>
						</ul>
					</div><!-- .widget -->

					<?php

					$promteks_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'promteks' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$promteks_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' );
					*/?>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
