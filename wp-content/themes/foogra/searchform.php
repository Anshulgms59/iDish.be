<?php
/**
 *
 * Search form.
 * @since 1.0.0
 * @version 1.0.0
 *
 */

if ( foogra_is_wp_listings_directory_activated() ) {
	$search_page_url = WP_Listings_Directory_Mixes::get_listings_page_url();
} else {
	$search_page_url = home_url( '/' );
}
?>
<div class="widget_search">
	<form action="<?php echo esc_url( $search_page_url ); ?>" method="get">
		<div class="input-group position-relative">
			<input type="text" placeholder="<?php esc_attr_e( 'What are you looking for?', 'foogra' ); ?>" name="filter-title" class="form-control"/>
			<button type="submit" class="btn btn-theme btn-search"><?php echo esc_html__('Search','foogra'); ?></button>
		</div>
	</form>
</div>