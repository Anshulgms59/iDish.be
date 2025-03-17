<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_Listings_Directory_Listing_Meta::get_instance($post->ID);

if ( $meta_obj->check_post_meta_exist('gallery') && ($gallery = $meta_obj->get_post_meta( 'gallery' )) ) {
?>
    <div id="listing-detail-photo" class="listing-detail-photo">
    	<h4 class="title"><?php echo trim($meta_obj->get_post_meta_title('gallery')); ?></h4>
    	<div class="content-bottom">
	    	<div class="row-photo row">
		        <?php $i = 1; foreach ($gallery as $attach_id => $img_url) {
		        	$additional_class = '';
	                if ( $i > 5 ) {
	                    $additional_class = 'd-none';
	                }
	                $more_image_class = $more_image_html = '';
	                if ( $i == 5 && count($gallery) > 5 ) {
	                    $more_image_html = '<span class="view-more-gallery">+'.(count($gallery) - 5).'</span>';
	                    $more_image_class = 'view-more-image';
	                } else {
	                	$more_image_html = '';
	                }
	        	?>
		            <div class="item <?php echo esc_attr($additional_class); ?>">
		            	<div class="photo-item">
		            		<a href="<?php echo esc_url($img_url); ?>" data-elementor-lightbox-slideshow="foogra-gallery" class="popup-image-gallery <?php echo esc_attr($more_image_class); ?>">
		            			<?php echo foogra_get_attachment_thumbnail($attach_id, '170x170'); ?>
		            			<?php echo trim($more_image_html); ?>
		                	</a>
		                </div>
		            </div>
		        <?php $i++; } ?>
	        </div>

	        <?php do_action('wp-listings-directory-single-listing-photos', $post); ?>

        </div>
    </div>
<?php }