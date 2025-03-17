<?php

function foogra_wp_cardealer_customize_register( $wp_customize ) {
    global $wp_registered_sidebars;
    $sidebars = array();

    if ( is_admin() && !empty($wp_registered_sidebars) ) {
        foreach ($wp_registered_sidebars as $sidebar) {
            $sidebars[$sidebar['id']] = $sidebar['name'];
        }
    }

    $columns = array( '1' => esc_html__('1 Column', 'foogra'),
        '2' => esc_html__('2 Columns', 'foogra'),
        '3' => esc_html__('3 Columns', 'foogra'),
        '4' => esc_html__('4 Columns', 'foogra'),
        '5' => esc_html__('5 Columns', 'foogra'),
        '6' => esc_html__('6 Columns', 'foogra'),
        '7' => esc_html__('7 Columns', 'foogra'),
        '8' => esc_html__('8 Columns', 'foogra'),
    );

    // Listings Panel
    $wp_customize->add_panel( 'foogra_settings_listing', array(
        'title' => esc_html__( 'Listings Settings', 'foogra' ),
        'priority' => 4,
    ) );

    // General Section
    $wp_customize->add_section('foogra_settings_listing_general', array(
        'title'    => esc_html__('General', 'foogra'),
        'priority' => 1,
        'panel' => 'foogra_settings_listing',
    ));

    // Breadcrumbs Setting ?
    $wp_customize->add_setting('foogra_theme_options[listing_breadcrumbs_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Foogra_WP_Customize_Heading_Control($wp_customize, 'listing_breadcrumbs_setting', array(
        'label'    => esc_html__('Breadcrumbs Settings', 'foogra'),
        'section'  => 'foogra_settings_listing_general',
        'settings' => 'foogra_theme_options[listing_breadcrumbs_setting]',
    )));

    // Breadcrumbs
    $wp_customize->add_setting('foogra_theme_options[show_listing_breadcrumbs]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 1,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_show_listing_breadcrumbs', array(
        'settings' => 'foogra_theme_options[show_listing_breadcrumbs]',
        'label'    => esc_html__('Breadcrumbs', 'foogra'),
        'section'  => 'foogra_settings_listing_general',
        'type'     => 'checkbox',
    ));

    // Breadcrumbs Background Color
    $wp_customize->add_setting('foogra_theme_options[listing_breadcrumb_color]', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'listing_breadcrumb_color', array(
        'label'    => esc_html__('Breadcrumbs Background Color', 'foogra'),
        'section'  => 'foogra_settings_listing_general',
        'settings' => 'foogra_theme_options[listing_breadcrumb_color]',
    )));

    // Breadcrumbs Background
    $wp_customize->add_setting('foogra_theme_options[listing_breadcrumb_image]', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',

    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'listing_breadcrumb_image', array(
        'label'    => esc_html__('Breadcrumbs Background', 'foogra'),
        'section'  => 'foogra_settings_listing_general',
        'settings' => 'foogra_theme_options[listing_breadcrumb_image]',
    )));

    // Other Setting ?
    $wp_customize->add_setting('foogra_theme_options[listing_other_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Foogra_WP_Customize_Heading_Control($wp_customize, 'listing_other_setting', array(
        'label'    => esc_html__('Other Settings', 'foogra'),
        'section'  => 'foogra_settings_listing_general',
        'settings' => 'foogra_theme_options[listing_other_setting]',
    )));

    // Show Full Phone Number
    $wp_customize->add_setting('foogra_theme_options[listing_show_full_phone]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_listing_show_full_phone', array(
        'settings' => 'foogra_theme_options[listing_show_full_phone]',
        'label'    => esc_html__('Show Full Phone Number', 'foogra'),
        'section'  => 'foogra_settings_listing_general',
        'type'     => 'checkbox',
    ));

    // Enable Favorite
    $wp_customize->add_setting('foogra_theme_options[listing_enable_favorite]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_listing_enable_favorite', array(
        'settings' => 'foogra_theme_options[listing_enable_favorite]',
        'label'    => esc_html__('Enable Favorite', 'foogra'),
        'section'  => 'foogra_settings_listing_general',
        'type'     => 'checkbox',
    ));



    // Listing Archives
    $wp_customize->add_section('foogra_settings_listing_archive', array(
        'title'    => esc_html__('Listing Archives', 'foogra'),
        'priority' => 2,
        'panel' => 'foogra_settings_listing',
    ));

    // General Setting ?
    $wp_customize->add_setting('foogra_theme_options[listings_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Foogra_WP_Customize_Heading_Control($wp_customize, 'listings_general_setting', array(
        'label'    => esc_html__('General Settings', 'foogra'),
        'section'  => 'foogra_settings_listing_archive',
        'settings' => 'foogra_theme_options[listings_general_setting]',
    )));

    // Is Full Width
    $wp_customize->add_setting('foogra_theme_options[listings_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_listings_fullwidth', array(
        'settings' => 'foogra_theme_options[listings_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'foogra'),
        'section'  => 'foogra_settings_listing_archive',
        'type'     => 'checkbox',
    ));

    // layout
    $wp_customize->add_setting( 'foogra_theme_options[listings_layout_type]', array(
        'default'        => 'default',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_archive_layout', array(
        'label'   => esc_html__('Listings Layout Style', 'foogra'),
        'section' => 'foogra_settings_listing_archive',
        'type'    => 'select',
        'choices' => array(
            'default' => esc_html__('Default', 'foogra'),
            'half-map' => esc_html__('Half Map', 'foogra'),
            'top-map' => esc_html__('Top Map', 'foogra'),
        ),
        'settings' => 'foogra_theme_options[listings_layout_type]',
        'description' => esc_html__('Select the variation you want to apply on your blog.', 'foogra'),
    ) );

    // layout
    $wp_customize->add_setting( 'foogra_theme_options[listings_layout_sidebar]', array(
        'default'        => 'left-main',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( new Foogra_WP_Customize_Radio_Image_Control( 
        $wp_customize, 
        'apus_settings_listings_layout_sidebar', 
        array(
            'label'   => esc_html__('Layout Type', 'foogra'),
            'section' => 'foogra_settings_listing_archive',
            'type'    => 'select',
            'choices' => array(
                'main' => array(
                    'title' => esc_html__('Main Only', 'foogra'),
                    'img' => get_template_directory_uri() . '/inc/assets/images/screen1.png'
                ),
                'left-main' => array(
                    'title' => esc_html__('Left - Main Sidebar', 'foogra'),
                    'img' => get_template_directory_uri() . '/inc/assets/images/screen2.png'
                ),
                'main-right' => array(
                    'title' => esc_html__('Main - Right Sidebar', 'foogra'),
                    'img' => get_template_directory_uri() . '/inc/assets/images/screen3.png'
                ),
            ),
            'settings' => 'foogra_theme_options[listings_layout_sidebar]',
            'description' => wp_kses(__('Select a sidebar layout for layout type <strong>"Default", "Top Map"</strong>.', 'foogra'), array('strong' => array())),
        ) 
    ));


    // Show Filter Top
    $wp_customize->add_setting('foogra_theme_options[listings_show_filter_top]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_listings_show_filter_top', array(
        'settings' => 'foogra_theme_options[listings_show_filter_top]',
        'label'    => esc_html__('Show Filter Top', 'foogra'),
        'section'  => 'foogra_settings_listing_archive',
        'type'     => 'checkbox',
    ));


    // Half Filter Type
    $wp_customize->add_setting( 'foogra_theme_options[listings_half_map_filter_type]', array(
        'default'        => 'offcanvas',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_archive_listings_half_map_filter_type', array(
        'label'   => esc_html__('Half Map Filter Type', 'foogra'),
        'section' => 'foogra_settings_listing_archive',
        'type'    => 'select',
        'choices' => array(
            'offcanvas' => esc_html__('Offcanvas Filter', 'foogra'),
            'filter-top' => esc_html__('Filter Top', 'foogra'),
        ),
        'settings' => 'foogra_theme_options[listings_half_map_filter_type]',
    ) );


    // Display Mode
    $wp_customize->add_setting( 'foogra_theme_options[listings_display_mode]', array(
        'default'        => 'grid',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_archive_display_mode', array(
        'label'   => esc_html__('Display Mode', 'foogra'),
        'section' => 'foogra_settings_listing_archive',
        'type'    => 'select',
        'choices' => array(
            'grid' => esc_html__('Grid', 'foogra'),
            'list' => esc_html__('List', 'foogra'),
        ),
        'settings' => 'foogra_theme_options[listings_display_mode]',
    ) );

    // Grid Columns
    $wp_customize->add_setting( 'foogra_theme_options[listings_columns]', array(
        'default'        => '3',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_archive_listings_columns', array(
        'label'   => esc_html__('Listings Grid Columns', 'foogra'),
        'section' => 'foogra_settings_listing_archive',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'foogra_theme_options[listings_columns]',
    ) );

    // List Columns
    $wp_customize->add_setting( 'foogra_theme_options[listings_list_columns]', array(
        'default'        => '2',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_archive_listings_list_columns', array(
        'label'   => esc_html__('Listings List Columns', 'foogra'),
        'section' => 'foogra_settings_listing_archive',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'foogra_theme_options[listings_list_columns]',
    ) );

    // Item Style
    $wp_customize->add_setting( 'foogra_theme_options[listings_item_style]', array(
        'default'        => '2',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_archive_listings_item_style', array(
        'label'   => esc_html__('Item Style', 'foogra'),
        'section' => 'foogra_settings_listing_archive',
        'type'    => 'select',
        'choices' => array(
            'grid' => esc_html__('Grid 1', 'foogra'),
            'grid-v2' => esc_html__('Grid 2', 'foogra'),
            'list' => esc_html__('List 1', 'foogra'),
            'list-v2' => esc_html__('List 2', 'foogra'),
        ),
        'settings' => 'foogra_theme_options[listings_item_style]',
    ) );

    // Pagination
    $wp_customize->add_setting( 'foogra_theme_options[listings_pagination]', array(
        'default'        => 'default',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_archive_listings_pagination', array(
        'label'   => esc_html__('Listings Pagination', 'foogra'),
        'section' => 'foogra_settings_listing_archive',
        'type'    => 'select',
        'choices' => array(
            'default' => esc_html__('Default', 'foogra'),
            'loadmore' => esc_html__('Load More Button', 'foogra'),
            'infinite' => esc_html__('Infinite Scrolling', 'foogra'),
        ),
        'settings' => 'foogra_theme_options[listings_pagination]',
    ) );



    // Single Listing
    $wp_customize->add_section('foogra_settings_listing_single', array(
        'title'    => esc_html__('Listing Single', 'foogra'),
        'priority' => 3,
        'panel' => 'foogra_settings_listing',
    ));

    // General Setting ?
    $wp_customize->add_setting('foogra_theme_options[listing_single_general_setting]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control( new Foogra_WP_Customize_Heading_Control($wp_customize, 'listing_single_general_setting', array(
        'label'    => esc_html__('General Settings', 'foogra'),
        'section'  => 'foogra_settings_listing_single',
        'settings' => 'foogra_theme_options[listing_single_general_setting]',
    )));

    // Is Full Width
    $wp_customize->add_setting('foogra_theme_options[listing_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_listing_fullwidth', array(
        'settings' => 'foogra_theme_options[listing_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'foogra'),
        'section'  => 'foogra_settings_listing_single',
        'type'     => 'checkbox',
    ));

    // Listing Layout
    $wp_customize->add_setting( 'foogra_theme_options[listing_layout_type]', array(
        'default'        => 'v1',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_single_listing_layout_type', array(
        'label'   => esc_html__('Listing Layout', 'foogra'),
        'section' => 'foogra_settings_listing_single',
        'type'    => 'select',
        'choices' => array(
            'v1' => esc_html__('Layout 1', 'foogra'),
            'v2' => esc_html__('Layout 2', 'foogra'),
        ),
        'settings' => 'foogra_theme_options[listing_layout_type]',
    ) );

    // Show Social Share
    $wp_customize->add_setting('foogra_theme_options[show_listing_social_share]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_show_listing_social_share', array(
        'settings' => 'foogra_theme_options[show_listing_social_share]',
        'label'    => esc_html__('Show Social Share', 'foogra'),
        'section'  => 'foogra_settings_listing_single',
        'type'     => 'checkbox',
    ));

    $contents = apply_filters('foogra_listing_single_sort_content', array(
        'description' => esc_html__('Description', 'foogra'),
        'features' => esc_html__('Features', 'foogra'),
        'photos' => esc_html__('Photos Gallery', 'foogra'),
        'menu_prices' => esc_html__('Menus Price', 'foogra'),
        'faq' => esc_html__('Frequently Asked Questions', 'foogra'),
        'video' => esc_html__('Video', 'foogra'),
        'related' => esc_html__('Related', 'foogra'),
    ));
    foreach ($contents as $key => $value) {
        // Show Social Share
        $wp_customize->add_setting('foogra_theme_options[show_listing_'.$key.']', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'       => '1',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('foogra_theme_options_show_listing_'.$key, array(
            'settings' => 'foogra_theme_options[show_listing_'.$key.']',
            'label'    => sprintf(esc_html__('Show %s', 'foogra'), $value),
            'section'  => 'foogra_settings_listing_single',
            'type'     => 'checkbox',
        ));
    }

    // Show Description View More
    $wp_customize->add_setting('foogra_theme_options[show_listing_desc_view_more]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_show_listing_desc_view_more', array(
        'settings' => 'foogra_theme_options[show_listing_desc_view_more]',
        'label'    => esc_html__('Show Description View More', 'foogra'),
        'section'  => 'foogra_settings_listing_single',
        'type'     => 'checkbox',
    ));

    // Number related listings
    $wp_customize->add_setting( 'foogra_theme_options[listing_related_number]', array(
        'default'        => '4',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_single_listing_related_number', array(
        'label'   => esc_html__('Number related listings', 'foogra'),
        'section' => 'foogra_settings_listing_single',
        'type'    => 'number',
        'settings' => 'foogra_theme_options[listing_related_number]',
    ) );

    // Related Listings Columns
    $wp_customize->add_setting( 'foogra_theme_options[listing_related_columns]', array(
        'default'        => '4',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_single_listing_related_columns', array(
        'label'   => esc_html__('Related Listings Columns', 'foogra'),
        'section' => 'foogra_settings_listing_single',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'foogra_theme_options[listing_related_columns]',
    ) );


    // Print Listing
    $wp_customize->add_section('foogra_settings_listing_print', array(
        'title'    => esc_html__('Listing Print', 'foogra'),
        'priority' => 4,
        'panel' => 'foogra_settings_listing',
    ));

    // Show Print Button
    $wp_customize->add_setting('foogra_theme_options[listing_enable_printer]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'       => '1',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_listing_enable_printer', array(
        'settings' => 'foogra_theme_options[listing_enable_printer]',
        'label'    => esc_html__('Show Print Button', 'foogra'),
        'section'  => 'foogra_settings_listing_print',
        'type'     => 'checkbox',
    ));

    // Print Logo
    $wp_customize->add_setting('foogra_theme_options[print-logo]', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',

    ));

    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'print-logo', array(
        'label'    => esc_html__('Print Logo', 'foogra'),
        'section'  => 'foogra_settings_listing_print',
        'settings' => 'foogra_theme_options[print-logo]',
    )));

    $contents = apply_filters('foogra_listing_single_print_content', array(
        'header' => esc_html__('Print Header', 'foogra'),
        'qrcode' => esc_html__('Qrcode', 'foogra'),
        'author' => esc_html__('Author', 'foogra'),
        'description' => esc_html__('Description', 'foogra'),
        'detail' => esc_html__('Detail', 'foogra'),
        'features' => esc_html__('Features', 'foogra'),
        'gallery' => esc_html__('Gallery', 'foogra'),
    ));

    foreach ($contents as $key => $value) {
        // Show Social Share
        $wp_customize->add_setting('foogra_theme_options[show_print_'.$key.']', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'       => '1',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('foogra_theme_options_show_print_'.$key, array(
            'settings' => 'foogra_theme_options[show_print_'.$key.']',
            'label'    => sprintf(esc_html__('Show %s', 'foogra'), $value),
            'section'  => 'foogra_settings_listing_print',
            'type'     => 'checkbox',
        ));
    }




    // User Profile Settings
    $wp_customize->add_section('foogra_settings_listing_user_profile', array(
        'title'    => esc_html__('User Profile Settings', 'foogra'),
        'priority' => 5,
        'panel' => 'foogra_settings_listing',
    ));

    // layout
    $wp_customize->add_setting( 'foogra_theme_options[user_single_layout]', array(
        'default'        => '',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_user_profile_layout', array(
        'label'   => esc_html__('Layout Type', 'foogra'),
        'section' => 'foogra_settings_listing_user_profile',
        'type'    => 'select',
        'choices' => array(
            'main' => esc_html__('Main Only', 'foogra'),
            'left-main' => esc_html__('Left - Main Sidebar', 'foogra'),
            'main-right' => esc_html__('Main - Right Sidebar', 'foogra'),
        ),
        'settings' => 'foogra_theme_options[user_single_layout]',
        'description' => esc_html__('Select the variation you want to apply on your blog.', 'foogra'),
    ) );

    // Is Full Width
    $wp_customize->add_setting('foogra_theme_options[user_profile_fullwidth]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_user_profile_fullwidth', array(
        'settings' => 'foogra_theme_options[user_profile_fullwidth]',
        'label'    => esc_html__('Is Full Width', 'foogra'),
        'section'  => 'foogra_settings_listing_user_profile',
        'type'     => 'checkbox',
    ));

    

    // Left Sidebar
    $wp_customize->add_setting( 'foogra_theme_options[user_profile_left_sidebar]', array(
        'default'        => '',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_user_profile_left_sidebar', array(
        'label'   => esc_html__('Archive Left Sidebar', 'foogra'),
        'section' => 'foogra_settings_listing_user_profile',
        'type'    => 'select',
        'choices' => $sidebars,
        'settings' => 'foogra_theme_options[user_profile_left_sidebar]',
        'description' => esc_html__('Choose a sidebar for left sidebar', 'foogra'),
    ) );

    // Right Sidebar
    $wp_customize->add_setting( 'foogra_theme_options[user_profile_right_sidebar]', array(
        'default'        => '',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_user_profile_right_sidebar', array(
        'label'   => esc_html__('Archive Right Sidebar', 'foogra'),
        'section' => 'foogra_settings_listing_user_profile',
        'type'    => 'select',
        'choices' => $sidebars,
        'settings' => 'foogra_theme_options[user_profile_right_sidebar]',
        'description' => esc_html__('Choose a sidebar for right sidebar', 'foogra'),
    ) );

    // Show User Listings
    $wp_customize->add_setting('foogra_theme_options[show_user_listings]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 1,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_show_user_listings', array(
        'settings' => 'foogra_theme_options[show_user_listings]',
        'label'    => esc_html__('Show User Listings', 'foogra'),
        'section'  => 'foogra_settings_listing_user_profile',
        'type'     => 'checkbox',
    ));

    // Show User Reviews
    $wp_customize->add_setting('foogra_theme_options[show_user_reviews]', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'default'    => 1,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('foogra_theme_options_show_user_reviews', array(
        'settings' => 'foogra_theme_options[show_user_reviews]',
        'label'    => esc_html__('Show User Reviews', 'foogra'),
        'section'  => 'foogra_settings_listing_user_profile',
        'type'     => 'checkbox',
    ));

    // Number user listings
    $wp_customize->add_setting( 'foogra_theme_options[user_listings_number]', array(
        'default'        => '4',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_user_profile_user_listings_number', array(
        'label'   => esc_html__('Number user listings', 'foogra'),
        'section' => 'foogra_settings_listing_user_profile',
        'type'    => 'number',
        'settings' => 'foogra_theme_options[user_listings_number]',
    ) );

    // Number user listings columnscolumns
    $wp_customize->add_setting( 'foogra_theme_options[user_listings_columns]', array(
        'default'        => '4',
        'type'           => 'option',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'foogra_settings_listing_user_profile_user_listings_columns', array(
        'label'   => esc_html__('Number user listings columns', 'foogra'),
        'section' => 'foogra_settings_listing_user_profile',
        'type'    => 'select',
        'choices' => $columns,
        'settings' => 'foogra_theme_options[user_listings_columns]',
    ) );
}
add_action( 'customize_register', 'foogra_wp_cardealer_customize_register', 15 );