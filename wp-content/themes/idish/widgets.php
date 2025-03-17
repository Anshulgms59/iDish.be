<?php
function idish_register_widgets() {
    register_sidebar(array(
        'name' => __('Sidebar', 'idish-child'),
        'id' => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'idish_register_widgets');
