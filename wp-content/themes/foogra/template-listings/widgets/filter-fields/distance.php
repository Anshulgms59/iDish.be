<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$style = isset($style) ? $style : '';
?>
<div class="form-group form-group-<?php echo esc_attr($key); ?> <?php echo esc_attr($style); ?> <?php echo esc_attr(!empty($field['toggle']) ? 'toggle-field' : ''); ?> <?php echo esc_attr(!empty($field['hide_field_content']) ? 'hide-content' : ''); ?>">
	<?php if ( !isset($field['show_title']) || $field['show_title'] ) { ?>
        <label class="heading-label">
            <?php echo trim($field['name']); ?>
            <?php if ( !empty($field['toggle']) ) { ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            <?php } ?>
        </label>
    <?php } ?>
    <div class="form-group-inner inner">
		<?php
			$distance_type = apply_filters( 'wp_listings_directory_filter_distance_type', 'miles' );
		?>
		<div class="search_distance_wrapper clearfix">
			<div class="search-distance-label">
				<?php
					$placeholder = !empty($field['placeholder']) ? $field['placeholder'] : esc_html__('Radius', 'foogra');
					echo sprintf(wp_kses(__('%s: <span class="text-distance">%s</span> %s', 'foogra'), array('span' => array('class' => array()))), $placeholder, $selected, $distance_type);
				?>
			</div>
			<div class="search-distance-wrapper">
				<input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_html($selected); ?>" />
				<div class="search-distance-slider"><div class="ui-slider-handle distance-custom-handle"></div></div>
			</div>
		</div>
	</div>
</div><!-- /.form-group -->