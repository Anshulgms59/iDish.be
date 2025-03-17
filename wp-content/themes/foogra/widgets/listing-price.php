<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
extract( $args );

global $post;
if ( empty($post->post_type) || $post->post_type != 'listing' ) {
    return;
}

$meta_obj = WP_Listings_Directory_Listing_Meta::get_instance($post->ID);
if ( !( $price = $meta_obj->get_price_html() ) ) {
    return;
}
$price_from = $meta_obj->get_price_from_html();
$price_to = $meta_obj->get_price_to_html();

extract( $args );
extract( $instance );
echo trim($before_widget);
$title = apply_filters('widget_title', $instance['title']);

$price_range = foogra_listing_display_price_range($post, '', false);

$listing_is_claimed = get_post_meta( get_the_ID(), '_claimed', true );

?>
<div class="listing-detail-price">
    <?php if ( $title || $price ) { ?>
        <div class="top-widget-listing-detail text-center">
            <?php echo '<h3 class="title">' . trim( $title ) . '</h3>'; ?>
            <?php echo esc_html__('From ','foogra').trim($price_from).esc_html__(' to ','foogra').trim($price_to); ?>
        </div>
    <?php } ?>
    <div class="inner">
        <?php if ( $price_range ) { ?>
            <div class="price-range d-flex align-items-center">
                <div class="name"><?php echo trim($meta_obj->get_post_meta_title('price_range')); ?></div>   
                <div class="value ms-auto"><?php echo trim($price_range); ?></div>
            </div>
        <?php } ?>
        <?php if ( !$listing_is_claimed ) { ?>
            <div class="claim">
                <?php esc_html_e('Claim your free business page to have your changes published immediately.', 'foogra'); ?>
                <a href="#claim-listing-<?php echo esc_attr($post->ID); ?>" class="claim-this-business-btn"><?php esc_html_e( 'Claim this business', 'foogra' ); ?></a>
            </div>
            
            <div id="claim-listing-<?php echo esc_attr($post->ID); ?>" class="claim-listing-form-wrapper mfp-hide" data-effect="fadeIn">
                
                <h4 class="title"><?php esc_html_e('Claim this listing', 'foogra'); ?></h4>
                
                <form action="" class="claim-listing-form" method="post">
                    <input type="hidden" name="post_id" class="<?php echo esc_attr($post->ID); ?>">
                        
                    <div class="msg"></div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="fullname" placeholder="<?php esc_attr_e( 'Fullname', 'foogra' ); ?>" required="required">
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm" name="phone" placeholder="<?php esc_attr_e( 'Phone', 'foogra' ); ?>" required="required">
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <textarea class="form-control form-control-sm" name="message" placeholder="<?php esc_attr_e( 'Additional proof to expedite your claim approval...', 'foogra' ); ?>" cols="30" rows="5" required="required"></textarea>
                    </div><!-- /.form-group -->

                    <button class="button btn btn-sm btn-theme" name="submit-claim-listing" value=""><?php echo esc_html__( 'Claim This Business', 'foogra' ); ?></button>
                </form>

            </div>
        <?php } ?>
    </div>
</div>
<?php echo trim($after_widget);