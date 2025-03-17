<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_Listings_Directory_Listing_Meta::get_instance($post->ID);
if ( has_post_thumbnail() ) {
    $thumbnail_id = get_post_thumbnail_id($post);
?>
<div class="listing-detail-gallery listing-detail-gallery-v1">
    
    <div class="listing-single-gallery-wrapper">
        <?php echo foogra_get_attachment_thumbnail($thumbnail_id, 'foogra-gallery-full');?>
    </div>
</div>
<?php }