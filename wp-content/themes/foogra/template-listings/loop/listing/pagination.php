<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="listings-pagination-wrapper main-pagination-wrapper">
	<?php
		$pagination_type = foogra_get_listings_pagination();
		if ( $pagination_type == 'loadmore' || $pagination_type == 'infinite' ) {
			$next_link = get_next_posts_link( '&nbsp;', $listings->max_num_pages );
			if ( $next_link ) {
		?>
				<div class="ajax-pagination <?php echo trim($pagination_type == 'loadmore' ? 'loadmore-action' : 'infinite-action'); ?>">
					<div class="apus-pagination-next-link hidden"><?php echo trim($next_link); ?></div>
					<a href="#" class="apus-loadmore-btn"><?php esc_html_e( 'Load more', 'foogra' ); ?></a>
					<span class="apus-allproducts"><?php esc_html_e( 'All listings loaded.', 'foogra' ); ?></span>
				</div>
		<?php
			}
		} else {
			WP_Listings_Directory_Mixes::custom_pagination( array(
				'max_num_pages' => $listings->max_num_pages,
				'prev_text'     => '«',
				'next_text'     => '»',
				'wp_query' => $listings
			));
		}
	?>
</div>