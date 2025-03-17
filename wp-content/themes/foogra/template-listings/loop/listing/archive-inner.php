<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



$listings_display_mode = foogra_get_listings_display_mode();
$listing_inner_style = foogra_get_listings_inner_style();
$layout_type = foogra_get_listings_layout_type();
$filter_type = foogra_get_listings_half_map_filter_type();

$filter_sidebar = 'listings-filter';
if ( $layout_type == 'half-map' && $filter_type == 'offcanvas' && is_active_sidebar( $filter_sidebar ) ) {
	add_action( 'wp_listings_directory_before_listing_archive', 'foogra_listing_display_filter_btn', 2 );
}
?>
<div class="listings-listing-wrapper main-items-wrapper" data-display_mode="<?php echo esc_attr($listings_display_mode); ?>">
	<?php
	/**
	 * wp_listings_directory_before_listing_archive
	 */
	do_action( 'wp_listings_directory_before_listing_archive', $listings );
	?>

	<?php if ( !empty($listings) && !empty($listings->posts) ) : ?>
		<?php
		/**
		 * wp_listings_directory_before_loop_listing
		 */
		do_action( 'wp_listings_directory_before_loop_listing', $listings );
		?>
		<div class="listings-wrapper items-wrapper clearfix">
			<?php
				$addclass = '';
				if ( $listings_display_mode == 'grid' ) {
					$columns = foogra_get_listings_columns();
					$addclass = 'col-sm-6 col-md-6 col-12';
				} else {
					$columns = foogra_get_listings_list_columns();
					$addclass = 'col-12';
				}
				$bcol = $columns ? 12/$columns : 3;
				if($layout_type == 'half-map'){
					$ct = ($columns && $columns >= 2) ? 6 : 1;
				}else{
					$ct = '12';
				}
				$i = 0;
			?>
			<div class="row">
				<?php while ( $listings->have_posts() ) : $listings->the_post(); ?>
					<div class="<?php echo esc_attr($addclass); ?> col-lg-<?php echo esc_attr($bcol); ?>">
						<?php echo WP_Listings_Directory_Template_Loader::get_template_part( 'listings-styles/inner-'.$listing_inner_style ); ?>
					</div>
				<?php $i++; endwhile; ?>
			</div>

		</div>

		<?php
		/**
		 * wp_listings_directory_after_loop_listing
		 */
		do_action( 'wp_listings_directory_after_loop_listing', $listings );
		
		wp_reset_postdata();
		?>

	<?php else : ?>
		<div class="not-found text-center"><?php esc_html_e('No listing found.', 'foogra'); ?></div>
	<?php endif; ?>

	<?php
	/**
	 * wp_listings_directory_after_listing_archive
	 */
	do_action( 'wp_listings_directory_after_listing_archive', $listings );
	?>
</div>