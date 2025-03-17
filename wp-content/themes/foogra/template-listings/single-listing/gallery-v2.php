<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_Listings_Directory_Listing_Meta::get_instance($post->ID);

$gallery = $meta_obj->get_post_meta( 'gallery' );
if ( has_post_thumbnail() || $gallery ) {
    $gallery_size = !empty($gallery_size) ? $gallery_size : 'foogra-gallery-large';
?>
<div class="listing-detail-gallery listing-detail-gallery-v2 clearfix">
    
    <div class="listing-single-gallery-wrapper">
        <?php foogra_listing_display_featured_icon($post, true); ?>
        <div class="list-action action2">
            <?php
                if ( foogra_get_config('listing_enable_favorite', true) ) {
                    $args = array(
                        'added_icon_class' => 'icon_heart',
                        'add_icon_class' => 'icon_heart',
                        'show_text' => true,
                        'add_text' => esc_html__('Wishlist', 'foogra'),
                        'added_text' => esc_html__('Wishlist', 'foogra'),
                    );
                    WP_Listings_Directory_Favorite::display_favorite_btn($post->ID, $args);
                }
            ?>
        </div>
        <div class="slick-carousel no-gap listing-single-gallery" data-carousel="slick" data-items="1" data-large="1" data-medium="1" data-small="1" data-smallest="1" data-pagination="true" data-nav="false">
            <?php if ( has_post_thumbnail() ) {
                $thumbnail_id = get_post_thumbnail_id($post);
            ?>
                <a href="<?php echo esc_url( get_the_post_thumbnail_url($post, 'full') ); ?>" data-elementor-lightbox-slideshow="foogra-gallery" class="p-popup-image2">
                    <?php echo foogra_get_attachment_thumbnail($thumbnail_id, $gallery_size);?>
                </a>
            <?php } ?>

            <?php if ( $gallery ) {
                foreach ( $gallery as $id => $src ) {
                ?>
                    <a href="<?php echo esc_url( $src ); ?>" data-elementor-lightbox-slideshow="foogra-gallery" class="p-popup-image2">
                        <?php echo foogra_get_attachment_thumbnail( $id, $gallery_size ); ?>
                    </a>
                <?php }
            } ?>
        </div>
    </div>
</div>
<?php }