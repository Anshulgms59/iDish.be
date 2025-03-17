<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp_query;

if ( get_query_var( 'paged' ) ) {
    $paged = get_query_var( 'paged' );
} elseif ( get_query_var( 'page' ) ) {
    $paged = get_query_var( 'page' );
} else {
    $paged = 1;
}

$query_args = array(
	'post_type' => 'listing',
    'post_status' => 'publish',
    'post_per_page' => wp_listings_directory_get_option('number_listings_per_page', 10),
    'paged' => $paged,
);
$params = array();
$taxs = ['type', 'category', 'feature', 'location'];
foreach ($taxs as $tax) {
	if ( is_tax('listing_'.$tax) ) {
		$term = $wp_query->queried_object;
		if ( isset( $term->term_id) ) {
			$params['filter-'.$tax] = $term->term_id;
		}
	}
}

if ( WP_Listings_Directory_Abstract_Filter::has_filter() ) {
	$params = array_merge($params, $_GET);
}

$listings = WP_Listings_Directory_Query::get_posts($query_args, $params);

if ( isset( $_REQUEST['load_type'] ) && WP_Listings_Directory_Mixes::is_ajax_request() ) {
	if ( 'items' !== $_REQUEST['load_type'] ) {
        echo WP_Listings_Directory_Template_Loader::get_template_part('archive-listing-ajax-full', array('listings' => $listings));
	} else {
		echo WP_Listings_Directory_Template_Loader::get_template_part('archive-listing-ajax-listings', array('listings' => $listings));
	}

} else {
	get_header();

	$layout_type = foogra_get_listings_layout_type();

	if ( $layout_type == 'half-map' ) {

		$first_class = 'col-xl-4 col-lg-4 col-12 first_class p-0';
		$second_class = 'col-xl-8 col-lg-8 col-12 second_class p-0';
		
		$filter_type = foogra_get_listings_half_map_filter_type();

		if ( $filter_type == 'filter-top') {
			$sidebar = 'listings-filter-top-map';
			$sidebar_wrapper_class = 'listings-filter-top-map';
		} else {
			$sidebar = 'listings-filter';
			$sidebar_wrapper_class = 'offcanvas-filter-half-map';
		}
	?>
		<section id="main-container" class="inner layout-type-<?php echo esc_attr($layout_type); ?>">

   			<div class="mobile-groups-button d-block d-lg-none clearfix text-center">

				<button class=" btn btn-sm btn-theme btn-view-map" type="button"><i class="fas fa-map pre" aria-hidden="true"></i> <?php esc_html_e( 'Map View', 'foogra' ); ?></button>
				<button class=" btn btn-sm btn-theme btn-view-listing" type="button"><i class="fas fa-list pre" aria-hidden="true"></i> <?php esc_html_e( 'Listings View', 'foogra' ); ?></button>
			</div>

			<div class="row m-0">

				<div id="main-content" class="<?php echo esc_attr($first_class); ?>">
					<div class="inner-left">
						<?php if( is_active_sidebar( $sidebar ) ) { ?>
							<div class="wrapper-top-filter d-flex align-items-center">
								<?php echo WP_Listings_Directory_Template_Loader::get_template_part('loop/listing/orderby'); ?>
								<span class="filter-in-half-map-top filter ms-auto" title="<?php esc_html_e( 'Filter', 'foogra' ); ?>"><i class="icon_adjust-vert"></i></span>
							</div>

				   			<div class=" <?php echo esc_attr($sidebar_wrapper_class); ?>">
				   				<div class="inner">
						   			<?php dynamic_sidebar( $sidebar ); ?>
						   		</div>
						   	</div>
						   	<div class="over-dark-filter"></div>
					   	<?php } ?>
					   	<div class="content-listing">
					   		
							<?php
								echo WP_Listings_Directory_Template_Loader::get_template_part('loop/listing/archive-inner', array('listings' => $listings));

								echo WP_Listings_Directory_Template_Loader::get_template_part('loop/listing/pagination', array('listings' => $listings));
							?>

						</div>
					</div>
				</div><!-- .content-area -->

				<div class="<?php echo esc_attr($second_class); ?>">
					<div id="listings-google-maps" class="fix-map d-none d-lg-block"></div>
				</div>
			</div>
		</section>
	<?php
	} else {
		$sidebar_configs = foogra_get_listings_layout_configs();
		$filter_top_sidebar = foogra_get_listings_filter_top_sidebar();
	?>
		
		<section id="main-container" class="inner layout-type-<?php echo esc_attr($layout_type); ?> <?php echo esc_attr(foogra_get_listings_show_filter_top()?'has-filter-top':''); ?>">

			<?php if ( $layout_type == 'top-map' ) { ?>
				<div id="listings-google-maps" class="d-none d-lg-block top-map"></div>
			<?php } ?>

			<?php
				foogra_render_breadcrumbs_search();
			?>

			<?php
			if ( is_active_sidebar( $filter_top_sidebar ) && foogra_get_listings_show_filter_top() ) { ?>
				
				<div class="listings-filter-top-sidebar-wrapper">
					<div class="listings-filter-top-sidebar-wrapper-top">
						<div class="container">
							<div class="wrapper-top-filter d-flex align-items-center">
								<?php echo WP_Listings_Directory_Template_Loader::get_template_part('loop/listing/orderby'); ?>
								<span class="filter-in-half-map-top filter ms-auto" title="<?php esc_html_e( 'Filter', 'foogra' ); ?>"><i class="icon_adjust-vert"></i></span>
							</div>
						</div>
					</div>
					<div class="inner listings-filter-top-sidebar-wrapper-inner">
						<div class="container">
			   				<?php dynamic_sidebar( $filter_top_sidebar ); ?>
			   			</div>
			   		</div>
			   		
			   	</div>

			<?php } ?>


			<div class="main-content <?php echo apply_filters('foogra_listing_content_class', 'container');?> inner">
				
				<?php foogra_before_content( $sidebar_configs ); ?>
				
				<div class="row">
					<?php foogra_display_sidebar_left( $sidebar_configs ); ?>

					<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
						<main id="main" class="site-main layout-type-<?php echo esc_attr($layout_type); ?>" role="main">

							<?php
								echo WP_Listings_Directory_Template_Loader::get_template_part('loop/listing/archive-inner', array('listings' => $listings));

								echo WP_Listings_Directory_Template_Loader::get_template_part('loop/listing/pagination', array('listings' => $listings));
							?>

						</main><!-- .site-main -->
					</div><!-- .content-area -->
					
					<?php foogra_display_sidebar_right( $sidebar_configs ); ?>
				</div>

			</div>
		</section>
	<?php
	}

	get_footer();
}