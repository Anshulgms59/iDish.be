<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
?>

<?php do_action( 'wp_listings_directory_before_listing_content', $post->ID ); ?>

<article <?php post_class('map-item listing-grid listing-item'); ?> <?php foogra_listing_item_map_meta($post); ?>>

    <div class="listing-thumbnail-wrapper">
        <?php foogra_listing_display_image( $post, 'foogra-listing-list' ); ?>
        
        <div class="top-label">
            <div class="d-flex align-items-center">
                <?php foogra_listing_display_category_first($post); ?>
            </div>
        </div>

        <div class="bottom-label">
            <?php the_title( sprintf( '<h2 class="listing-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php foogra_listing_display_full_location($post, false); ?>
        </div>

    </div>

    <div class="top-info">
        <div class="listing-information d-flex align-items-center">
            <?php foogra_listing_display_view_map($post); ?>
            <div class="ms-auto">
                <?php foogra_listing_display_rating($post); ?>
            </div>
        </div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_listings_directory_after_listing_content', $post->ID ); ?>