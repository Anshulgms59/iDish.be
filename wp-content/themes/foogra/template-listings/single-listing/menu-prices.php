<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;

$meta_obj = WP_Listings_Directory_Listing_Meta::get_instance($post->ID);

if ( $meta_obj->check_post_meta_exist('menu_prices') && ($menu_prices = $meta_obj->get_post_meta('menu_prices')) ) {
    ?>
    <div id="listing-detail-photo" class="listing-detail-photo">
        <h4 class="title"><?php echo trim($meta_obj->get_post_meta_title('menu_prices')); ?></h4>
        <div class="inner">
            <div class="row">
                <?php foreach ($menu_prices as $menu) {
                ?>
                    <div class="col-12 menu-price-item d-flex align-items-center">
                        <?php if ( !empty($menu['profile_image_id']) ) { ?>
                            <div class="image flex-shrink-0">
                                <a href="<?php echo esc_url(wp_get_attachment_image_url($menu['profile_image_id'])); ?>" data-elementor-lightbox-slideshow="menu-price">
                                    <?php echo foogra_get_attachment_thumbnail($menu['profile_image_id'], 'thumbnail'); ?>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="content flex-grow-1">
                            <div class="top-content d-flex">
                                <?php if ( !empty($menu['title']) ) { ?>
                                    <h5 class="title-price"><?php echo esc_html($menu['title']); ?></h5>
                                <?php } ?>
                                <?php if ( !empty($menu['price']) ) { ?>
                                    <div class="price ms-auto"><?php echo esc_html($menu['price']); ?></div>
                                <?php } ?>
                            </div>
                            <?php if ( !empty($menu['description']) ) { ?>
                                <div class="description"><?php echo trim($menu['description']); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php do_action('wp-listings-directory-single-listing-menu-prices', $post); ?>

        </div>
    </div>
    <?php
}