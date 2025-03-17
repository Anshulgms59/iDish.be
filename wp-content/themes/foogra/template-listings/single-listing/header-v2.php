<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
?>
<div class="top-header-detail-listing v2">
    <div class="d-md-flex align-items-center">
        <div class="header-detail-top-v2 col-12 col-md-8">
            <?php the_title( '<h1 class="listing-title">', '</h1>' ); ?>
            <div class="listing-metas d-flex flex-wrap metas-space align-items-center">
                <?php foogra_listing_display_full_location($post); ?>
                <span class="space">-</span>
                <?php foogra_listing_display_location_btn($post); ?>
            </div>
            <?php foogra_listing_display_tageline($post); ?>
        </div>

        <div class="listing-action-detail col-12 col-md-4 d-md-flex justify-content-end">
            <?php foogra_listing_display_rating($post); ?>
        </div>

    </div>
</div>