<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Foogra_Elementor_Listings_Directory_Listing_Locations extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_listing_locations';
    }

	public function get_title() {
        return esc_html__( 'Apus Listing Locations', 'foogra' );
    }
    
	public function get_categories() {
        return [ 'foogra-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Locations Banner', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'foogra' ),
            ]
        );

        $repeater->add_control(
            'slug',
            [
                'label' => esc_html__( 'Type Slug', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your Type Slug here', 'foogra' ),
            ]
        );

        $repeater->add_control(
            'custom_url',
            [
                'label' => esc_html__( 'Custom URL', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your custom url here', 'foogra' ),
            ]
        );

        $repeater->add_control(
            'img_bg_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Image', 'foogra' ),
                'type' => Elementor\Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Image Here', 'foogra' ),
            ]
        );

        $this->add_control(
            'locations',
            [
                'label' => esc_html__( 'Locations Box', 'foogra' ),
                'type' => Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'show_nb_listings',
            [
                'label' => esc_html__( 'Show Number Listings', 'foogra' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'foogra' ),
                'label_off' => esc_html__( 'Show', 'foogra' ),
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'foogra'),
                    'style2' => esc_html__('Style 2', 'foogra'),
                ),
                'default' => 'style1'
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid', 'foogra'),
                    'carousel' => esc_html__('Carousel', 'foogra'),
                ),
                'default' => 'grid'
            ]
        );

        $columns = range( 1, 12 );
        $columns = array_combine( $columns, $columns );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => $columns,
                'frontend_available' => true,
                'default' => 3,
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label' => esc_html__( 'Slides to Scroll', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'foogra' ),
                'options' => $columns,
                'condition' => [
                    'columns!' => '1',
                    'layout_type' => 'carousel',
                ],
                'frontend_available' => true,
                'default' => 1,
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__( 'Rows', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'placeholder' => esc_html__( 'Enter your rows number here', 'foogra' ),
                'default' => 1,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label'         => esc_html__( 'Show Navigation', 'foogra' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'foogra' ),
                'label_off'     => esc_html__( 'Hide', 'foogra' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'         => esc_html__( 'Show Pagination', 'foogra' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Show', 'foogra' ),
                'label_off'     => esc_html__( 'Hide', 'foogra' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'slider_autoplay',
            [
                'label'         => esc_html__( 'Autoplay', 'foogra' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'foogra' ),
                'label_off'     => esc_html__( 'No', 'foogra' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'         => esc_html__( 'Infinite Loop', 'foogra' ),
                'type'          => Elementor\Controls_Manager::SWITCHER,
                'label_on'      => esc_html__( 'Yes', 'foogra' ),
                'label_off'     => esc_html__( 'No', 'foogra' ),
                'return_value'  => true,
                'default'       => true,
                'condition' => [
                    'layout_type' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'foogra' ),
                'type'          => Elementor\Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'foogra' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_overlay',
            [
                'label' => esc_html__( 'Background Overlay', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'foogra' ),
                'type' => Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1440,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .banner-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'style' => 'style1',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

            $this->start_controls_tab(
                'tab_bg_normal',
                [
                    'label' => esc_html__( 'Normal', 'foogra' ),
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_overlay',
                    'selector' => '{{WRAPPER}} .type-banner-inner .banner-image::before',
                ]
            );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'tab_bg_hover',
                [
                    'label' => esc_html__( 'Hover', 'foogra' ),
                ]
            );

            $this->add_group_control(
                Elementor\Group_Control_Background::get_type(),
                [
                    'name' => 'background_hvoer_overlay',
                    'selector' => '{{WRAPPER}} .type-banner-inner:hover .banner-image::before',
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Typography', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'foogra' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__( 'Number Color', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Number Typography', 'foogra' ),
                'name' => 'number_typography',
                'selector' => '{{WRAPPER}} .number',
            ]
        );

        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($locations) ) {
            if ( $image_size == 'custom' ) {
                
                if ( $image_custom_dimension['width'] && $image_custom_dimension['height'] ) {
                    $thumbsize = $image_custom_dimension['width'].'x'.$image_custom_dimension['height'];
                } else {
                    $thumbsize = 'full';
                }
            } else {
                $thumbsize = $image_size;
            }

            $columns = !empty($columns) ? $columns : 3;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 2;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
        ?>
            <div class="widget-listing-locations <?php echo esc_attr($el_class); ?>">
                <?php if ( $layout_type == 'carousel' ) {
                    
                    $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
                    $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
                    $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;
                ?>
                    <div class="slick-carousel <?php echo ( ( $columns >= count($locations))?'hidden-dots':'' ); ?>"
                        data-items="<?php echo esc_attr($columns); ?>"
                        data-smallmedium="<?php echo esc_attr( $columns_tablet ); ?>"
                        data-extrasmall="<?php echo esc_attr($columns_mobile); ?>"

                        data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                        data-slidestoscroll_smallmedium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                        data-slidestoscroll_extrasmall="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                        data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $slider_autoplay ? 'true' : 'false' ); ?>">

                        <?php foreach ($locations as $item) {
                            $term = get_term_by( 'slug', $item['slug'], 'listing_location' );
                            $link = $item['custom_url'];
                            $title = $item['title'];
                            if ($term) {
                                if ( empty($link) ) {
                                    $link = get_term_link( $term, 'listing_location' );
                                }
                                if ( empty($title) ) {
                                    $title = $term->name;
                                }
                            }

                            ?>
                            <div class="item">
                                <a class="type-banner-inner <?php echo esc_attr($style); ?>" href="<?php echo esc_url($link); ?>">
                                    
                                    <?php
                                    if ( !empty($item['img_bg_src']['id']) ) {
                                    ?>
                                        <div class="banner-image">
                                            <?php echo foogra_get_attachment_thumbnail($item['img_bg_src']['id'], $thumbsize); ?>
                                        </div>
                                    <?php } ?>

                                    <div class="inner">
                                        <div class="info-city">
                                            
                                            <?php if ( !empty($title) ) { ?>
                                                <h4 class="title">
                                                    <?php echo trim($title); ?>
                                                </h4>
                                            <?php } ?>
                                            <?php if ( $show_nb_listings ) {
                                                    $args = array(
                                                        'fields' => 'ids',
                                                        'location' => array($item['slug']),
                                                        'limit' => 1
                                                    );
                                                    $query = foogra_get_listings($args);
                                                    $count = $query->found_posts;
                                                    $number_listings = $count ? WP_Listings_Directory_Mixes::format_number($count) : 0;
                                            ?>
                                            <div class="number"><?php echo sprintf(_n('<span>%d</span> Listing', '<span>%d</span> Listings', $count, 'foogra'), $number_listings); ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <?php
                            $mdcol = 12/$columns;
                            $smcol = 12/$columns_tablet;
                            $xscol = 12/$columns_mobile;
                        ?>
                        <?php $i=1; foreach ($locations as $item) {
                            $classes = '';
                            if ( $i%$columns == 1 ) {
                                $classes .= ' md-clearfix lg-clearfix';
                            }
                            if ( $i%$columns_tablet == 1 ) {
                                $classes .= ' sm-clearfix';
                            }
                            if ( $i%$columns_mobile == 1 ) {
                                $classes .= ' xs-clearfix';
                            }

                            $term = get_term_by( 'slug', $item['slug'], 'listing_location' );
                            $link = $item['custom_url'];
                            $title = $item['title'];
                            if ($term) {
                                if ( empty($link) ) {
                                    $link = get_term_link( $term, 'listing_location' );
                                }
                                if ( empty($title) ) {
                                    $title = $term->name;
                                }
                            }

                            ?>
                            <div class="col-md-<?php echo esc_attr($mdcol); ?> col-sm-<?php echo esc_attr($smcol); ?> col-xs-<?php echo esc_attr( $xscol ); ?> list-item <?php echo esc_attr($classes); ?>">
                                <a class="type-banner-inner <?php echo esc_attr($style); ?>" href="<?php echo esc_url($link); ?>">
                                    
                                    <?php
                                    if ( !empty($item['img_bg_src']['id']) ) {
                                    ?>
                                        <div class="banner-image">
                                            <?php echo foogra_get_attachment_thumbnail($item['img_bg_src']['id'], $thumbsize); ?>
                                        </div>
                                    <?php } ?>

                                    <div class="inner">
                                        <div class="info-city">
                                            
                                            <?php if ( !empty($title) ) { ?>
                                                <h4 class="title">
                                                    <?php echo trim($title); ?>
                                                </h4>
                                            <?php } ?>
                                            <?php if ( $show_nb_listings ) {
                                                    $args = array(
                                                        'fields' => 'ids',
                                                        'location' => array($item['slug']),
                                                        'limit' => 1
                                                    );
                                                    $query = foogra_get_listings($args);
                                                    $count = $query->found_posts;
                                                    $number_listings = $count ? WP_Listings_Directory_Mixes::format_number($count) : 0;
                                            ?>
                                            <div class="number"><?php echo sprintf(_n('<span>%d</span> Listing', '<span>%d</span> Listings', $count, 'foogra'), $number_listings); ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php $i++; } ?>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
    }
}
Elementor\Plugin::instance()->widgets_manager->register( new Foogra_Elementor_Listings_Directory_Listing_Locations );