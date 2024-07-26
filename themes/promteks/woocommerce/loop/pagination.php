<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// $total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
// $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
// $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
// $format  = isset( $format ) ? $format : '';

global $wp_query;

$total = $wp_query->max_num_pages;
$current = max(1, get_query_var('paged'));

if ($total <= 1) {
    return;
}
?>
<nav class="woocommerce-pagination">
    <?php
    $pagination = '';

    // Кнопка "Предыдущая"
    if ($current > 1) {
        $pagination .= '<a class="prev page-numbers" href="' . get_pagenum_link($current - 1) . '">&lt;</a>';
    }

    // Первая страница
    $pagination .= '<a class="page-numbers' . ($current == 1 ? ' current' : '') . '" href="' . get_pagenum_link(1) . '">1</a>';

    // Пробелы и промежуточные страницы
    if ($total > 2) {
        if ($current > 3) {
            $pagination .= ' ... ';
        }

        for ($i = max(2, $current - 1); $i <= min($total - 1, $current + 1); $i++) {
            $pagination .= '<a class="page-numbers' . ($current == $i ? ' current' : '') . '" href="' . get_pagenum_link($i) . '">' . $i . '</a>';
        }

        if ($current < $total - 2) {
            $pagination .= ' ... ';
        }
    }

    // Последняя страница
    if ($total > 1) {
        $pagination .= '<a class="page-numbers' . ($current == $total ? ' current' : '') . '" href="' . get_pagenum_link($total) . '">' . $total . '</a>';
    }

    // Кнопка "Следующая"
    if ($current < $total) {
        $pagination .= '<a class="next page-numbers" href="' . get_pagenum_link($current + 1) . '">&gt;</a>';
    }

    echo $pagination;
    ?>
</nav>
