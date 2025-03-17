<?php

if ( !function_exists( 'foogra_page_metaboxes' ) ) {
	function foogra_page_metaboxes(array $metaboxes) {
		global $wp_registered_sidebars;
        $sidebars = array();

        if ( !empty($wp_registered_sidebars) ) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }
        $headers = array_merge( array('global' => esc_html__( 'Global Setting', 'foogra' )), foogra_get_header_layouts() );
        $footers = array_merge( array('global' => esc_html__( 'Global Setting', 'foogra' )), foogra_get_footer_layouts() );

		$prefix = 'apus_page_';

        $columns = array(
            '' => esc_html__( 'Global Setting', 'foogra' ),
            '1' => esc_html__('1 Column', 'foogra'),
            '2' => esc_html__('2 Columns', 'foogra'),
            '3' => esc_html__('3 Columns', 'foogra'),
            '4' => esc_html__('4 Columns', 'foogra'),
            '6' => esc_html__('6 Columns', 'foogra')
        );

        // Listings Page
        $fields = array(
            array(
                'name' => esc_html__( 'Listings Layout', 'foogra' ),
                'id'   => $prefix.'layout_type',
                'type' => 'select',
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'foogra' ),
                    'default' => esc_html__('Default', 'foogra'),
                    'half-map' => esc_html__('Half Map', 'foogra'),
                    'top-map' => esc_html__('Top Map', 'foogra'),
                )
            ),
            array(
                'id' => $prefix.'display_mode',
                'type' => 'select',
                'name' => esc_html__('Default Display Mode', 'foogra'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'foogra' ),
                    'grid' => esc_html__('Grid', 'foogra'),
                    'list' => esc_html__('List', 'foogra'),
                )
            ),
            array(
                'id' => $prefix.'listings_columns',
                'type' => 'select',
                'name' => esc_html__('Grid Listing Columns', 'foogra'),
                'options' => $columns,
            ),
            array(
                'id' => $prefix.'listings_list_columns',
                'type' => 'select',
                'name' => esc_html__('List Listing Columns', 'foogra'),
                'options' => $columns,
            ),
            array(
                'id' => $prefix.'item_style',
                'type' => 'select',
                'name' => esc_html__('Item Style', 'foogra'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'foogra' ),
                    'grid' => esc_html__('Grid 1', 'foogra'),
                    'grid-v2' => esc_html__('Grid 2', 'foogra'),
                    'list' => esc_html__('List 1', 'foogra'),
                    'list-v2' => esc_html__('List 2', 'foogra'),
                )
            ),

            array(
                'id' => $prefix.'listings_pagination',
                'type' => 'select',
                'name' => esc_html__('Pagination Type', 'foogra'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'foogra' ),
                    'default' => esc_html__('Default', 'foogra'),
                    'loadmore' => esc_html__('Load More Button', 'foogra'),
                    'infinite' => esc_html__('Infinite Scrolling', 'foogra'),
                ),
            ),

            array(
                'id' => $prefix.'listings_show_filter_top',
                'type' => 'select',
                'name' => esc_html__('Show Filter Top', 'foogra'),
                'options' => array(
                    '' => esc_html__( 'Global Setting', 'foogra' ),
                    'no' => esc_html__('No', 'foogra'),
                    'yes' => esc_html__('Yes', 'foogra')
                ),
            ),

            array(
                'id' => $prefix.'listings_half_map_filter_type',
                'type' => 'select',
                'name' => esc_html__('Half Map Filter Type', 'foogra'),
                'options' => array(
                    '' => esc_html__('Global Setting', 'foogra'),
                    'offcanvas' => esc_html__('Offcanvas Filter', 'foogra'),
                    'filter-top' => esc_html__('Filter Top', 'foogra'),
                ),
                'default' => ''
            ),
        );
        
        $metaboxes[$prefix . 'listings_setting'] = array(
            'id'                        => $prefix . 'listings_setting',
            'title'                     => esc_html__( 'Listings Settings', 'foogra' ),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        // General
	    $fields = array(
			array(
				'name' => esc_html__( 'Select Layout', 'foogra' ),
				'id'   => $prefix.'layout',
				'type' => 'select',
				'options' => array(
					'main' => esc_html__('Main Content Only', 'foogra'),
					'left-main' => esc_html__('Left Sidebar - Main Content', 'foogra'),
					'main-right' => esc_html__('Main Content - Right Sidebar', 'foogra')
				)
			),
			array(
                'id' => $prefix.'fullwidth',
                'type' => 'select',
                'name' => esc_html__('Is Full Width?', 'foogra'),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__('No', 'foogra'),
                    'yes' => esc_html__('Yes', 'foogra')
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'foogra'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'foogra'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'foogra'),
                'options' => array(
                    'no' => esc_html__('No', 'foogra'),
                    'yes' => esc_html__('Yes', 'foogra')
                ),
                'default' => 'yes',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'foogra')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'foogra')
            ),

            array(
                'id' => $prefix.'header_type',
                'type' => 'select',
                'name' => esc_html__('Header Layout Type', 'foogra'),
                'description' => esc_html__('Choose a header for your website.', 'foogra'),
                'options' => $headers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_transparent',
                'type' => 'select',
                'name' => esc_html__('Header Transparent', 'foogra'),
                'description' => esc_html__('Choose a header for your website.', 'foogra'),
                'options' => array(
                    'no' => esc_html__('No', 'foogra'),
                    'yes' => esc_html__('Yes', 'foogra')
                ),
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'header_fixed',
                'type' => 'select',
                'name' => esc_html__('Header Fixed Top', 'foogra'),
                'description' => esc_html__('Choose a header position', 'foogra'),
                'options' => array(
                    'no' => esc_html__('No', 'foogra'),
                    'yes' => esc_html__('Yes', 'foogra')
                ),
                'default' => 'no'
            ),
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'foogra'),
                'description' => esc_html__('Choose a footer for your website.', 'foogra'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'foogra'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'foogra')
            )
    	);
		
	    $metaboxes[$prefix . 'display_setting'] = array(
			'id'                        => $prefix . 'display_setting',
			'title'                     => esc_html__( 'Display Settings', 'foogra' ),
			'object_types'              => array( 'page' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => $fields
		);

	    return $metaboxes;
	}
}
add_filter( 'cmb2_meta_boxes', 'foogra_page_metaboxes' );

if ( !function_exists( 'foogra_cmb2_style' ) ) {
	function foogra_cmb2_style() {
        wp_enqueue_style( 'foogra-cmb2-style', get_template_directory_uri() . '/inc/vendors/cmb2/assets/style.css', array(), '1.0' );
		wp_enqueue_script( 'foogra-admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ), '20150330', true );
	}
}
add_action( 'admin_enqueue_scripts', 'foogra_cmb2_style' );


