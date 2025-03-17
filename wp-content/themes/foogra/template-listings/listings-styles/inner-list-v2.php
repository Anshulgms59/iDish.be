<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$meta_obj = WP_Listings_Directory_Listing_Meta::get_instance($post->ID);
$price_from = $meta_obj->get_price_from_html();
$price_to = $meta_obj->get_price_to_html();
if(!empty($price_from)){
    $price_from = esc_html__('From ','foogra').trim($price_from);
}
if(!empty($price_to)){
   $price_to = esc_html__('to ','foogra').trim($price_to);
}
?>

<?php do_action( 'wp_listings_directory_before_listing_content', $post->ID ); ?>

<article <?php post_class('map-item listing-list-v2 listing-item d-flex align-items-center'); ?> <?php foogra_listing_item_map_meta($post); ?>>
    <?php foogra_listing_display_rating3($post); ?>
    <div class="listing-thumbnail-wrapper flex-shrink-0">
        <?php foogra_listing_display_image( $post, 'foogra-listing-grid' ); ?>
    </div>

    <div class="content-info flex-grow-1">
        <div class="d-none d-sm-block">
            <?php foogra_listing_display_category_first($post); ?>
        </div>
        <?php the_title( sprintf( '<h2 class="listing-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        <?php foogra_listing_display_full_location($post, false); ?>
        <div class="price-avg">
            <?php echo trim($price_from).' '.trim($price_to); ?>
        </div>
    </div>
</article><!-- #post-## -->
<?php do_action( 'wp_listings_directory_after_listing_content', $post->ID ); ?>