<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Foogra_Elementor_Listings_Directory_Search_Form extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_search_form';
    }

	public function get_title() {
        return esc_html__( 'Apus Listings Search Form', 'foogra' );
    }
    
	public function get_categories() {
        return [ 'foogra-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Search Form', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => esc_html__( 'Enter your title here', 'foogra' ),
            ]
        );

        $fields = apply_filters( 'wp-listings-directory-default-listing-filter-fields', array() );
        $search_fields = array( '' => esc_html__('Choose a field', 'foogra') );
        foreach ($fields as $key => $field) {
            $name = $field['name'];
            if ( empty($field['name']) ) {
                $name = $key;
            }
            $search_fields[$key] = $name;
        }

        $repeater = new Elementor\Repeater();

        $repeater->add_control(
            'filter_field',
            [
                'label' => esc_html__( 'Filter field', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $search_fields
            ]
        );
        
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
            ]
        );

        $repeater->add_control(
            'placeholder',
            [
                'label' => esc_html__( 'Placeholder', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
            ]
        );

        $repeater->add_control(
            'enable_autocompleate_search',
            [
                'label' => esc_html__( 'Enable autocompleate search', 'foogra' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Yes', 'foogra' ),
                'label_off' => esc_html__( 'No', 'foogra' ),
                'condition' => [
                    'filter_field' => 'title',
                ],
            ]
        );

        $custom_menus = array( '' => esc_html__('None', 'foogra'));
        $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
        if ( is_array( $menus ) && ! empty( $menus ) ) {
            foreach ( $menus as $menu ) {
                if ( is_object( $menu ) && isset( $menu->name, $menu->term_id ) ) {
                    $custom_menus[ $menu->term_id ] = $menu->name;
                }
            }
        }

        $repeater->add_control(
            'search_suggestions_menu',
            [
                'label' => esc_html__( 'Search Suggestions Menu', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $custom_menus,
                'default' => '',
                'condition' => [
                    'filter_field' => 'title',
                ],
            ]
        );

        $repeater->add_control(
            'style',
            [
                'label' => esc_html__( 'Price Style', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => [
                    'slider' => esc_html__('Price Slider', 'foogra'),
                    'text' => esc_html__('Pice Min/max Input Text', 'foogra'),
                    'list' => esc_html__('Price List', 'foogra'),
                ],
                'default' => 'slider',
                'condition' => [
                    'filter_field' => 'price_from',
                ],
            ]
        );
        $repeater->add_control(
            'price_range_size',
            [
                'label' => esc_html__( 'Price range size', 'foogra' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'text',
                'default' => 1000,
                'condition' => [
                    'filter_field' => 'price_from',
                    'style' => 'list',
                ],
            ]
        );
        $repeater->add_control(
            'price_range_max',
            [
                'label' => esc_html__( 'Max price ranges', 'foogra' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'text',
                'default' => 10,
                'condition' => [
                    'filter_field' => 'price_from',
                    'style' => 'list',
                ],
            ]
        );
        $repeater->add_control(
            'min_price_placeholder',
            [
                'label' => esc_html__( 'Min Price Placeholder', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Min Price',
                'condition' => [
                    'filter_field' => 'price_from',
                    'style' => 'text',
                ],
            ]
        );

        $repeater->add_control(
            'max_price_placeholder',
            [
                'label' => esc_html__( 'Max Price Placeholder', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Max Price',
                'condition' => [
                    'filter_field' => 'price_from',
                    'style' => 'text',
                ],
            ]
        );

        $repeater->add_control(
            'filter_layout',
            [
                'label' => esc_html__( 'Filter Layout', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'select' => esc_html__('Select', 'foogra'),
                    'radio' => esc_html__('Radio Button', 'foogra'),
                    'check_list' => esc_html__('Check Box', 'foogra'),
                ),
                'default' => 'select',
                'condition' => [
                    'filter_field' => ['category', 'type', 'feature', 'location', 'rating'],
                ],
            ]
        );
        
        $repeater->add_control(
            'number_style',
            [
                'label' => esc_html__( 'Layout Style', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => [
                    'number-plus' => esc_html__('Number +', 'foogra'),
                    'number' => esc_html__('Number', 'foogra'),
                ],
                'default' => 'number-plus',
                'condition' => [
                    'filter_field' => ['rating'],
                ],
            ]
        );

        for ($i=1; $i <= 5 ; $i++) { 
            $repeater->add_control(
                'rating_suffix_'.$i,
                [
                    'label' => sprintf(esc_html__( 'Suffix %s', 'foogra' ), $i),
                    'type' => Elementor\Controls_Manager::TEXT,
                    'default' => '',
                    'placeholder' => sprintf(esc_html__('Rating suffix %s', 'foogra'), $i),
                    'condition' => [
                        'filter_field' => ['rating'],
                    ],
                ]
            );
        }

        $columns = array();
        for ($i=1; $i <= 12 ; $i++) { 
            $columns[$i] = sprintf(esc_html__('%d Columns', 'foogra'), $i);
        }
        $repeater->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'default' => 1
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'foogra' ),
                'type' => Elementor\Controls_Manager::ICON
            ]
        );

        $repeater->add_control(
            'toggle',
            [
                'label' => esc_html__( 'Toggle', 'foogra' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Enable', 'foogra' ),
                'label_off' => esc_html__( 'Disable', 'foogra' ),
            ]
        );

        $repeater->add_control(
            'toggle_hide_content',
            [
                'label' => esc_html__( 'Hide Content', 'foogra' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Enable', 'foogra' ),
                'label_off' => esc_html__( 'Disable', 'foogra' ),
            ]
        );

        $this->add_control(
            'main_search_fields',
            [
                'label' => esc_html__( 'Main Search Fields', 'foogra' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'show_advance_search',
            [
                'label'         => esc_html__( 'Show Advanced Search', 'foogra' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'foogra' ),
                'label_off'     => esc_html__( 'Hide', 'foogra' ),
                'return_value'  => true,
                'default'       => true,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'advance_search_fields',
            [
                'label' => esc_html__( 'Advanced Search Fields', 'foogra' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'filter_btn_text',
            [
                'label' => esc_html__( 'Button Text', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Find Listing',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'advanced_btn_text',
            [
                'label' => esc_html__( 'Advanced Text', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Advanced',
            ]
        );

        $this->add_control(
            'btn_columns',
            [
                'label' => esc_html__( 'Button Columns', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'default' => 1
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'horizontal' => esc_html__('Horizontal', 'foogra'),
                    'vertical' => esc_html__('Vertical', 'foogra'),
                ),
                'default' => 'horizontal',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'style_df' => esc_html__('Default', 'foogra'),
                    'style_1' => esc_html__('Style 1', 'foogra'),
                ),
                'default' => 'style_df'
            ]
        );

        $this->add_control(
            'show_reset',
            [
                'label'         => esc_html__( 'Show Reset button', 'foogra' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'foogra' ),
                'label_off'     => esc_html__( 'Hide', 'foogra' ),
                'return_value'  => true,
                'default'       => true,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'reset_btn_text',
            [
                'label' => esc_html__( 'Reset Button Text', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'Reset Search',
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'foogra' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'foogra' ),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Typography', 'foogra' ),
                'name' => 'btn_typography',
                'selector' => '{{WRAPPER}} .btn-submit',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

            $this->start_controls_tab(
                'tab_button_normal',
                [
                    'label' => esc_html__( 'Normal', 'foogra' ),
                ]
            );
            
            $this->add_control(
                'button_color',
                [
                    'label' => esc_html__( 'Button Color', 'foogra' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_button',
                    'label' => esc_html__( 'Background', 'foogra' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .btn-submit',
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'border_button',
                    'label' => esc_html__( 'Border', 'foogra' ),
                    'selector' => '{{WRAPPER}} .btn-submit',
                ]
            );

            $this->add_control(
                'padding_button',
                [
                    'label' => esc_html__( 'Padding', 'foogra' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'btn_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'foogra' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'tab_button_hover',
                [
                    'label' => esc_html__( 'Hover', 'foogra' ),
                ]
            );

            $this->add_control(
                'button_hover_color',
                [
                    'label' => esc_html__( 'Button Color', 'foogra' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_button_hover',
                    'label' => esc_html__( 'Background', 'foogra' ),
                    'types' => [ 'classic', 'gradient', 'video' ],
                    'selector' => '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus',
                ]
            );

            $this->add_control(
                'button_hover_border_color',
                [
                    'label' => esc_html__( 'Border Color', 'foogra' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'condition' => [
                        'border_button_border!' => '',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'padding_button_hover',
                [
                    'label' => esc_html__( 'Padding', 'foogra' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'btn_hv_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'foogra' ),
                    'type' => Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .btn-submit:hover, {{WRAPPER}} .btn-submit:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();
        // end tab 

        $this->end_controls_section();


        $this->start_controls_section(
            'section_border_style',
            [
                'label' => esc_html__( 'Box', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'padding_box',
            [
                'label' => esc_html__( 'Padding', 'foogra' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .widget-listing-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bg_box',
            [
                'label' => esc_html__( 'Background Color', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-listing-search-form' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow', 'foogra' ),
                'selector' => '{{WRAPPER}} .widget-listing-search-form',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'foogra' ),
                'type' => Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .widget-listing-search-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_typography_style',
            [
                'label' => esc_html__( 'Typography', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-search' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .advance-search-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .circle-check' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .form-control' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .form-control::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .form-control:-ms-input-placeholder ' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .form-control::placeholder ' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .select2-selection--single .select2-selection__rendered' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .select2-selection--single .select2-selection__placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => esc_html__( 'Border Color', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-control' => 'border-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .select2-container--default.select2-container .select2-selection--single' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'border_hv_color',
            [
                'label' => esc_html__( 'Border Active Color', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-control:focus' => 'border-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .select2-container--default.select2-container.select2-container--open .select2-selection--single' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_advance_style',
            [
                'label' => esc_html__( 'Advance', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_advance_style' );

            $this->start_controls_tab(
                'tab_advance_normal',
                [
                    'label' => esc_html__( 'Normal', 'foogra' ),
                ]
            );

            $this->add_control(
                'color_ad',
                [
                    'label' => esc_html__( 'Button Color', 'foogra' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .advance-search-btn' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'tab_advance_hover',
                [
                    'label' => esc_html__( 'Hover', 'foogra' ),
                ]
            );

            $this->add_control(
                'color_ad_active',
                [
                    'label' => esc_html__( 'Button Active Color', 'foogra' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .advance-search-btn:hover,
                        {{WRAPPER}} .advance-search-btn:focus' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        
        $search_page_url = WP_Listings_Directory_Mixes::get_listings_page_url();

        foogra_load_select2();

        $filter_fields = apply_filters( 'wp-listings-directory-default-listing-filter-fields', array() );
        $instance = array();
        $widget_id = foogra_random_key();
        $args = array( 'widget_id' => $widget_id );
        ?>
        <div class="widget-listing-search-form <?php echo esc_attr($el_class.' '.$style.' '.$layout_type); ?>">
            
            <?php if ( $title ) { ?>
                <h2 class="title"><?php echo esc_html($title); ?></h2>
            <?php } ?>
            
            <form id="filter-listing-form-<?php echo esc_attr($widget_id); ?>" action="<?php echo esc_url($search_page_url); ?>" class="form-search filter-listing-form <?php echo esc_attr($style); ?>" method="GET">
                <div class="search-form-inner">
                    <?php if ( $layout_type == 'horizontal' ) { ?>
                        <div class="main-inner clearfix">
                            <div class="content-main-inner">
                                <div class="d-flex flex-wrap list-fileds">
                                    <?php
                                        $this->form_fields_display($main_search_fields, $filter_fields, $instance, $args);
                                    ?>
                                    <div class="col-12 col-md-<?php echo esc_attr($btn_columns); ?> form-group-search <?php echo trim( ($btn_columns == 1)?'width-10':'' ); ?>">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <?php if ( $show_advance_search && !empty($advance_search_fields) ) { ?>
                                                <div class="advance-link">
                                                    <a href="javascript:void(0);" class="advance-search-btn">
                                                        
                                                        <?php
                                                            if ( !empty($advanced_btn_text) ) {
                                                                echo esc_html($advanced_btn_text);
                                                            }
                                                        ?>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <button class="btn-submit btn w-100 btn-theme" type="submit">
                                                <?php if( !empty($filter_btn_text) ) { ?>
                                                    <?php echo trim($filter_btn_text); ?>
                                                <?php } ?>
                                            </button>

                                            <?php if ( $show_reset ) { ?>
                                                <a href="javascript:void(0);" class="reset-search-btn">
                                                    <?php
                                                        if ( !empty($reset_btn_text) ) {
                                                            echo esc_html($reset_btn_text);
                                                        }
                                                    ?>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php
                        if ( $show_advance_search && !empty($advance_search_fields) ) {
                            ?>
                            <div id="advance-search-wrapper-<?php echo esc_attr($widget_id); ?>" class="advance-search-wrapper">
                                <div class="advance-search-wrapper-fields form-theme">
                                    <div class="inner-search-advance">
                                        <div class="inner">
                                            <div class="row row-20">
                                                <?php
                                                    $this->form_fields_display($advance_search_fields, $filter_fields, $instance, $args);
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    <?php } else { ?>
                        <div class="main-inner clearfix">
                            <div class="content-main-inner">
                                <div class="row border-inside">
                                    <?php
                                        $this->form_fields_display($main_search_fields, $filter_fields, $instance, $args);
                                    ?>
                                    
                                    <div class="col-12 col-md-<?php echo esc_attr($btn_columns); ?> form-group-search">
                                        <button class="btn-submit btn btn-sm w-100 btn-theme" type="submit">
                                            <?php if( !empty($filter_btn_text) ) { ?>
                                                <?php echo trim($filter_btn_text); ?>
                                            <?php } ?>
                                        </button>
                                    </div>

                                    <?php if( $show_advance_search && !empty($advance_search_fields)) { ?>
                                        <div class="col-12">
                                            <div class="form-group space-20">
                                                <div class="advance-link">
                                                    <a href="javascript:void(0);" class="advance-search-btn">
                                                        
                                                        <?php
                                                            if ( !empty($advanced_btn_text) ) {
                                                                echo esc_html($advanced_btn_text);
                                                            }
                                                        ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>

                                <?php
                                if ( $show_advance_search && !empty($advance_search_fields) ) {
                                    ?>
                                    <div id="advance-search-wrapper-<?php echo esc_attr($widget_id); ?>" class="advance-search-wrapper">
                                        <div class="advance-search-wrapper-fields form-theme">

                                            <div class="inner-search-advance">
                                                <div class="inner">
                                                    <div class="row">
                                                        <?php
                                                            $this->form_fields_display($advance_search_fields, $filter_fields, $instance, $args);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                                <!-- Save Search -->
                                <?php if ( $show_reset ) { ?>
                                    <div class="row">
                                        <div class="col-12 search-action">
                                            <?php if ( $show_reset ) { ?>
                                                <a href="javascript:void(0);" class="reset-search-btn">
                                                    <?php
                                                        if ( !empty($reset_btn_text) ) {
                                                            echo esc_html($reset_btn_text);
                                                        }
                                                    ?>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                        
                        
                    <?php } ?>
                </div>
            </form>

        </div>
        <?php
    }

    public function form_fields_display($search_fields, $filter_fields, $instance, $args) {
        $i = 1;
        if ( !empty($search_fields) ) {
            $sub_class = '';
            $i = 1;
            foreach ($search_fields as $item) {

                if ( empty($filter_fields[$item['filter_field']]['field_call_back']) ) {
                    continue;
                }
                $filter_field = $filter_fields[$item['filter_field']];
                if ( $item['filter_field'] == 'title' ) {
                    if ($item['enable_autocompleate_search']) {
                        wp_enqueue_script( 'handlebars', get_template_directory_uri() . '/js/handlebars.min.js', array(), null, true);
                        wp_enqueue_script( 'typeahead-jquery', get_template_directory_uri() . '/js/typeahead.bundle.min.js', array('jquery', 'handlebars'), null, true);
                        $filter_field['add_class'] = 'apus-autocompleate-input';
                    }

                    if ( !empty($item['search_suggestions_menu']) ) {
                        $filter_field['suggestions_menu'] = $item['search_suggestions_menu'];
                    }
                } elseif ( $item['filter_field'] == 'price_from' ) {
                    $filter_field['style'] = $item['style'];
                    $filter_field['min_price_placeholder'] = $item['min_price_placeholder'];
                    $filter_field['max_price_placeholder'] = $item['max_price_placeholder'];
                    $filter_field['price_range_size'] = $item['price_range_size'];
                    $filter_field['price_range_max'] = $item['price_range_max'];
                } elseif ( in_array($item['filter_field'], ['rating']) ) {
                    $filter_field['number_style'] = $item['number_style'];
                    for ($i=1; $i <= 5; $i++) {
                        $filter_field['rating_suffix_'.$i] = $item['rating_suffix_'.$i];
                    }
                }
                if ( $item['toggle'] ) {
                    $filter_field['toggle'] = true;

                    if ( $item['toggle_hide_content'] ) {
                        $filter_field['hide_field_content'] = true;
                    }
                } else {
                    $filter_field['toggle'] = false;
                }
                
                if ( isset($item['icon']) ) {
                    $filter_field['icon'] = $item['icon'];
                }
                if ( isset($item['placeholder']) ) {
                    $filter_field['placeholder'] = $item['placeholder'];
                }
                
                if ( !empty($item['title']) ) {
                    $filter_field['name'] = $item['title'];
                    $filter_field['show_title'] = true;
                } else {
                    $filter_field['show_title'] = false;
                }

                if ( $item['filter_field'] == 'feature' ) {
                    $sub_class = 'wrapper-feature';
                } else {
                    $sub_class = '';
                }

                if ( $item['filter_layout'] && in_array($item['filter_field'], array('category', 'type', 'feature', 'location')) ) {
                    switch ($item['filter_layout']) {
                        case 'radio':
                            $filter_field['field_call_back'] = array( 'WP_Listings_Directory_Abstract_Filter', 'filter_field_taxonomy_hierarchical_radio_list');
                            break;
                        case 'check_list':
                            $filter_field['field_call_back'] = array( 'WP_Listings_Directory_Abstract_Filter', 'filter_field_taxonomy_hierarchical_check_list');
                            break;
                        default:
                            if ( $item['filter_field'] == 'location' ) {
                                $filter_field['field_call_back'] = array( 'WP_Listings_Directory_Abstract_Filter', 'filter_field_location_select');
                            } else {
                                $filter_field['field_call_back'] = array( 'WP_Listings_Directory_Abstract_Filter', 'filter_field_taxonomy_hierarchical_select');
                            }
                            break;
                    }
                } elseif ( $item['filter_layout'] && in_array($item['filter_field'], array('rating')) ) {
                    switch ($item['filter_layout']) {
                        case 'radio':
                            $filter_field['field_call_back'] = 'foogra_filter_field_rating_radio';
                            break;
                        case 'check_list':
                            $filter_field['field_call_back'] = 'foogra_filter_field_rating_checkbox';
                            break;
                        default:
                            $filter_field['field_call_back'] = 'foogra_filter_field_rating_select';
                            break;
                    }
                }

                $columns = !empty($item['columns']) ? $item['columns'] : 12;
                $columns_tablet = !empty($item['columns_tablet']) ? $item['columns_tablet'] : $columns;
                $columns_mobile = !empty($item['columns_mobile']) ? $item['columns_mobile'] : 12;

                ?>
                <div class="col-<?php echo esc_attr($columns_mobile); ?> col-md-<?php echo esc_attr($columns_tablet); ?> col-lg-<?php echo esc_attr($columns); ?> <?php echo esc_attr($sub_class); ?> <?php echo trim( ($item['icon'])?'has-icon':'' ); ?> <?php echo esc_attr( ( count($search_fields) == $i ) ? 'item-last':'' ); ?>">
                    <?php call_user_func( $filter_field['field_call_back'], $instance, $args, $item['filter_field'], $filter_field ); ?>

                    
                </div>
                <?php $i++;
            }
        }
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Foogra_Elementor_Listings_Directory_Search_Form );