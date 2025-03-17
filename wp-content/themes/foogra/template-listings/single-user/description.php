<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$description = get_user_meta( $userdata->ID, 'description', true );
?>
<div id="listing-detail-description" class="description inner">
	
    <h3 class="title"><?php esc_html_e('Overview', 'foogra'); ?></h3>
    <div class="description-inner">
    	<div class="description-inner-wrapper">
        	<?php echo trim($description); ?>
        </div>
        <?php if ( foogra_get_config('show_listing_desc_view_more', true) ) { ?>
	        <div class="show-more-less-wrapper">
	        	<a href="javascript:void(0);" class="show-more text-hover-link"><?php esc_html_e('Show more', 'foogra'); ?></a>
	        	<a href="javascript:void(0);" class="show-less text-hover-link"><?php esc_html_e('Show less', 'foogra'); ?></a>
	        </div>
	    <?php } ?>

    </div>
</div>