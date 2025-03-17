<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Foogra
 * @since Foogra 1.0
 */
/*
*Template Name: Dashboard Template
*/
get_header();
global $post;
$sidebar_configs = foogra_get_page_layout_configs();
$layout = get_post_meta( $post->ID, 'apus_page_layout', true );
?>
<section class="page-dashboard <?php echo esc_attr($layout); ?>">
	<section id="main-container" class="p-0 <?php echo apply_filters('foogra_page_content_class', 'container');?> <?php echo esc_attr(get_post_meta( $post->ID, 'apus_page_layout', true )); ?> ">
		<div class="inner-dashboard">
			<?php foogra_before_content( $sidebar_configs ); ?>
			<div class="row m-0">
				<?php foogra_display_sidebar_left( $sidebar_configs ); ?>
				<div id="main-content" class="main-page">
					<?php if(get_post_meta( $post->ID, 'apus_page_show_breadcrumb', true )){ ?>
						<div class="apus-breadscrumb-dashboard d-flex">
							<?php foogra_breadcrumbs(); ?>
						</div>
					<?php } ?>
					<div id="main" class="site-main clearfix" role="main">

						<?php
						// Start the loop.
						while ( have_posts() ) : the_post();
							
							// Include the page content template.
							the_content();

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						// End the loop.
						endwhile;
						?>
					</div><!-- .site-main -->
					<?php
		    		wp_link_pages( array(
		    			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'foogra' ) . '</span>',
		    			'after'       => '</div>',
		    			'link_before' => '<span>',
		    			'link_after'  => '</span>',
		    			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'foogra' ) . ' </span>%',
		    			'separator'   => '',
		    		) );
		    		?>
				</div><!-- .content-area -->
				<?php foogra_display_sidebar_right( $sidebar_configs ); ?>
			</div>
		</div>
	</section>
</section>
<?php get_footer(); ?>