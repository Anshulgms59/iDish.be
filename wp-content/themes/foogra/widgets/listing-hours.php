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

if ( !$meta_obj->check_post_meta_exist('hours') || !($hours = $meta_obj->get_post_meta( 'hours' )) ) {
    return;
}
extract( $args );
extract( $instance );


if ( empty($hours['day']) ) {
    return;
} else {
    $hours = $hours['day'];
}
$days = foogra_get_day_hours($hours);

if ( ! empty ( $days ) ) {
    $timezone = !empty($hours['timezone']) ? $hours['timezone'] : '';
    $current = foogra_get_current_time($timezone);
    $output = '';
    foreach ($days as $day => $times) {
        $day_time = '';
        if ( $times == 'open' ) {
            $day_time = '<span class="open-text">'.esc_html__('Open All Day', 'foogra').'</span>';
        } elseif ( $times == 'closed' ) {
            $day_time = '<span class="close-text">'.esc_html__('Closed All Day', 'foogra').'</span>';
        } elseif ( is_array($times) ) {
            foreach ($times as $time) {
                $day_time .= '<div class="time-items">';
                    if ($time[0]) {
                        $day_time .= '<span class="start">'.$time[0].'</span>';
                    }
                    if ($time[1]) {
                        $day_time .= ' - <span class="end">'.$time[1].'</span>';
                    }
                $day_time .= '</div>';
            }
        }
        $current_day_class = '';
        if ( strtolower($current['day']) === strtolower($day) ) {
            $current_day_class = 'current';
        }
        if ( !empty($day_time) ) {
            $output .= '<div class="listing-day d-flex align-items-center'.$current_day_class.'">';
                $output .= '<span class="day">'.$day.'</span>';
                $output .= '<div class="bottom-inner ms-auto">'.$day_time.'</div>';
            $output .= '</div>';
        }
    }
    if ( !empty($output) ) {
        echo trim($before_widget);
        $title = apply_filters('widget_title', $instance['title']);
    ?>
        <div class="listing-detail-hours">
            <div class="top-widget-listing-detail text-center">
                <?php echo '<h3 class="title">' . trim( $title ) . '</h3>'; ?>
                <?php foogra_display_time_status($post); ?>
            </div>
            <div class="clearfix">
                <?php echo wp_kses_post($output); ?>
                <?php do_action('foogra-single-listing-hours', $post); ?>
            </div>
        </div>
        <?php echo trim($after_widget);
    }
}