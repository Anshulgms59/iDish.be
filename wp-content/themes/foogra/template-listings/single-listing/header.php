<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
?>
<div class="top-header-detail-listing">
    <div class="container d-md-flex align-items-end">

        <div class="col-12 col-md-7">  
            <div class="header-detail-top">
                <?php foogra_listing_display_rating2($post); ?>
                <?php the_title( '<h1 class="listing-title">', '</h1>' ); ?>
                <div class="listing-metas d-flex flex-wrap metas-space align-items-center">
                    <?php
                        foogra_listing_display_short_location($post, false);
                    ?>
                    <span class="space">-</span>
                    <?php foogra_listing_display_full_location($post); ?>
                    <span class="space">-</span>
                    <?php foogra_listing_display_location_btn($post); ?>
                </div>
            </div>
        </div>

        <div class="listing-action-detail col-12 col-md-5">
            <div class="list-action float-md-end">
                <?php if ( has_post_thumbnail() ) { ?>
                    <a class="btn-viewphoto" href="<?php echo esc_url( get_the_post_thumbnail_url($post, 'full') ); ?>" data-elementor-lightbox-slideshow="foogra-gallery" class="p-popup-image">
                        <i class="icon_image"></i><?php echo esc_html__('View photos','foogra'); ?>
                    </a>
                <?php } ?>
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
        </div>

    </div>
</div>