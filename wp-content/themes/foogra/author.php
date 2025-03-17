<?php
get_header();
$sidebar_configs = foogra_get_user_layout_configs();

global $foogra_author_obj;
$author_obj = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$foogra_author_obj = $author_obj;
?>
<section id="main-container" class="pt-0 main-content inner">
	
	<?php echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-user/header', array('author_obj' => $author_obj) ); ?>
	<div class="single-user-wrapper <?php echo apply_filters('foogra_user_content_class', 'container');?>">
		<?php foogra_before_content( $sidebar_configs ); ?>
		<div class="row row-40">
			<?php foogra_display_sidebar_left( $sidebar_configs ); ?>
			<div id="main-content" class="col-sm-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
				<div id="main" class="site-main layout-user" role="main">
					<div class="single-user-content-wrapper">
						<?php
						if ( foogra_get_config('show_user_listings', true) ) {
							echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-user/listings', array('author_obj' => $author_obj) );
						}
						?>

						<?php
						if ( foogra_get_config('show_user_reviews', true) ) {
							echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-user/reviews', array('author_obj' => $author_obj) );
						}
						?>
					</div>
				</div><!-- .site-main -->
			</div><!-- .content-area -->
			<?php foogra_display_sidebar_right( $sidebar_configs ); ?>
		</div>
	</div>
	
</section>
<?php get_footer(); ?>