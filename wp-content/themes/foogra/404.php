<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Foogra
 * @since Foogra 1.0
 */
/*
*Template Name: 404 Page
*/
get_header();

$icon_url = foogra_get_config('404_icon_img');
$bg_img = foogra_get_config('404_bg_img');

$style = '';
if ( !empty($bg_img) ) {
	$style = 'style="background-image: url('.$bg_img.');"';
}

?>
<section class="page-404" <?php echo trim($style); ?>>
	<div id="main-container" class="inner">
		<div id="main-content" class="main-page">
			<section class="error-404 not-found clearfix">
				<div class="container">
					<div class="content-inner text-center">
						<div class="top-image">
							<?php if( !empty($icon_url) ) { ?>
								<img src="<?php echo esc_url( $icon_url); ?>" alt="<?php bloginfo( 'name' ); ?>">
							<?php }else{ ?>
								<img src="<?php echo esc_url( get_template_directory_uri().'/images/404.svg'); ?>" alt="<?php bloginfo( 'name' ); ?>">
							<?php } ?>
						</div>
						<div class="slogan">
							<h4 class="title-big">
								<?php
								$title = foogra_get_config('404_title');
								if ( !empty($title) ) {
									echo esc_html($title);
								} else {
									esc_html_e('Oh! Page Not Found', 'foogra');
								}
								?>
							</h4>
						</div>
						<div class="page-content">
							<?php get_search_form(); ?>
						</div><!-- .page-content -->
					</div>
				</div>
			</section><!-- .error-404 -->
		</div><!-- .content-area -->
	</div>
</section>
<?php get_footer(); ?>