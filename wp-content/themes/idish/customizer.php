<?php
function idish_customize_register($wp_customize) {
    $wp_customize->add_section('idish_options', array(
        'title' => __('Idish Settings', 'idish-child'),
        'priority' => 30,
    ));
}
add_action('customize_register', 'idish_customize_register');
