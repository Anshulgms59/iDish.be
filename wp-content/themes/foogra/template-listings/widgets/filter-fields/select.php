<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


ob_start();
if ( !empty($options) ) {
    $i = 1;
    foreach ($options as $option) {
        if ( $option['value'] ) {
            ?>
            <option value="<?php echo esc_attr($option['value']); ?>" <?php selected($selected, $option['value']); ?>>
                <?php echo esc_attr($option['text']); ?>
            </option>
            <?php
            $i++;
        }
    }
}
$output = ob_get_clean();

if ( !empty($output) ) {
    $placeholder = !empty($field['placeholder']) ? $field['placeholder'] : sprintf(esc_html__('Filter by %s', 'foogra'), $field['name']);
?>
    <div class="form-group form-group-<?php echo esc_attr($key); ?> <?php echo esc_attr(!empty($field['toggle']) ? 'toggle-field' : ''); ?> <?php echo esc_attr(!empty($field['hide_field_content']) ? 'hide-content' : ''); ?>">
        <?php if ( !isset($field['show_title']) || $field['show_title'] ) { ?>
            <label class="heading-label">
                <?php echo trim($field['name']); ?>
                <?php if ( !empty($field['toggle']) ) { ?>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                <?php } ?>
            </label>
        <?php } ?>
        <div class="form-group-inner inner select-wrapper">
            <?php if ( !empty($field['icon']) ) { ?>
                <i class="<?php echo esc_attr( $field['icon'] ); ?>"></i>
            <?php } ?>
            <select name="<?php echo esc_attr($name); ?>" class="form-control" id="<?php echo esc_attr( $args['widget_id'] ); ?>_<?php echo esc_attr($key); ?>" data-placeholder="<?php echo esc_attr($placeholder); ?>">
                <option value=""><?php echo esc_html($placeholder); ?></option>
                <?php echo trim($output); ?>
            </select>
        </div>
    </div><!-- /.form-group -->
<?php }