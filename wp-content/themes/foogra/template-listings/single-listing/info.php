<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
$socials = get_post_meta($post->ID, '_listing_socials', true);
?>
<div class="info-detail-listing">
    <h3 class="title-small"><?php echo esc_html__('Address','foogra') ?></h3>
    <?php foogra_listing_display_full_location($post); ?>
    <?php foogra_listing_display_location_btn($post); ?>
    <!-- socials -->
    <?php if ( $socials ) {
        $all_socials = WP_Listings_Directory_Mixes::get_socials_network();
    ?>
        <div class="all-socials">
            <h3 class="title-socials"><?php echo esc_html__('Follow Us','foogra') ?></h3>
            <ul class="socials-list list">
                <?php foreach ($socials as $social) { ?>
                    <?php if ( !empty($social['url']) && !empty($social['network']) ) {
                        $icon_class = !empty( $all_socials[$social['network']]['icon'] ) ? $all_socials[$social['network']]['icon'] : '';
                    ?>
                        <li>
                            <a href="<?php echo esc_html($social['url']); ?>">
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <?php do_action('wp-listings-directory-single-listing-information', $post); ?>

</div>