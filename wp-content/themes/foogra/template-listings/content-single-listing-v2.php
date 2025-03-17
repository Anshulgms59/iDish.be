<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

wp_enqueue_script( 'sticky-kit' );
?>

<?php do_action( 'wp_listings_directory_before_listing_detail', $post->ID ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('listing-single-layout listing-single-v2'); ?>>
	<div class="<?php echo apply_filters('foogra_listing_content_class', 'container');?>">		
		<!-- Main content -->
		<div class="content-listing-detail">

			<div class="row listing-v-wrapper">
				<div class="col-12 listing-detail-main col-lg-<?php echo esc_attr( is_active_sidebar( 'listing-single-sidebar' ) ? 8 : 12); ?>">

					<?php do_action( 'wp_listings_directory_before_listing_content', $post->ID ); ?>
					<?php echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/header-v2' ); ?>
					<?php echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/gallery-v2' ); ?>
					<ul class="nav nav-tabs tabs-detail-listing" id="myTab" role="tablist">
					  	<li class="nav-item" role="presentation">
					    	<button class="nav-link active" id="pills-content-tab" data-bs-toggle="tab" data-bs-target="#pills-content" type="button" role="tab" aria-controls="pills-content" aria-selected="true"><?php echo esc_html__('Information','foogra') ?></button>
					  	</li>
					  	<?php if ( WP_Listings_Directory_Review::review_enable() ) { ?>
						  	<li class="nav-item" role="presentation">
						    	<button class="nav-link" id="pills-comments-tab" data-bs-toggle="tab" data-bs-target="#pills-comments" type="button" role="tab" aria-controls="pills-comments" aria-selected="false"><?php echo esc_html__('Reviews','foogra') ?></button>
						  	</li>
						<?php } ?>
					</ul>

					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active pills-detail-listing" id="pills-content">
							<?php
							if ( foogra_get_config('show_listing_description', true) ) {
								echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/description' );
							}
							?>

							<?php
							if ( foogra_get_config('show_listing_photos', true) ) {
								echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/photos' );
							}
							?>

							<?php
							if ( foogra_get_config('show_listing_menu_prices', true) ) {
								echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/menu-prices' );
							}
							?>

							<?php
							if ( foogra_get_config('show_listing_faq', true) ) {
								echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/faq' );
							}
							?>

					   		<?php
							if ( foogra_get_config('show_listing_video', true) ) {
								echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/video' );
							}
							?>
							<div class="box-dark">
								<h3 class="title-box"><?php echo esc_html__('How to get to ','foogra'); ?><?php the_title(); ?></h3>
								<div class="row">
									<div class="col-md-6 col-12">
										<?php
											echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/info' );
										?>
									</div>
									<div class="col-md-6 col-12">
										<?php
										if ( foogra_get_config('show_listing_feature', true) ) {
											echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/features' );
										}
										?>
									</div>
								</div>
							</div>
						</div>

						<?php if ( WP_Listings_Directory_Review::review_enable() ) { ?>
							<div class="tab-pane fade pills-detail-listing" id="pills-comments">
								<?php comments_template(); ?>
							</div>
						<?php } ?>
					</div>
					<?php do_action( 'wp_listings_directory_after_listing_content', $post->ID ); ?>
				</div>
				
				<?php if ( is_active_sidebar( 'listing-single-sidebar' ) ): ?>
					<div class="col-12 col-lg-4 sidebar-wrapper">
				   		<div class="sidebar sidebar-listing-inner sidebar-right">
					   		<?php dynamic_sidebar( 'listing-single-sidebar' ); ?>
					   		<?php get_template_part('template-parts/sharebox'); ?>
				   		</div>
				   	</div>
			   	<?php endif; ?>
			   	
			</div>
		</div>
	</div>
	<?php
	if ( foogra_get_config('show_listing_related', true) ) {
		echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/related' );
	}
	?>
</article><!-- #post-## -->

<?php do_action( 'wp_listings_directory_after_listing_detail', $post->ID ); ?>