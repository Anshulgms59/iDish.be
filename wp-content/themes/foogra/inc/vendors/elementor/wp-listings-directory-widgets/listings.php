<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Foogra_Elementor_Listings_Directory_Listings extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_listings';
    }

	public function get_title() {
        return esc_html__( 'Apus Listings', 'foogra' );
    }
    
	public function get_categories() {
        return [ 'foogra-elements' ];
    }

    public function get_tax_keys() {
        return array('type', 'category', 'feature', 'location');
    }

	protected function register_controls() {
        $meta_obj = WP_Listings_Directory_Listing_Meta::get_instance(0);

        $fields = $meta_obj->get_metas();

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Listings', 'foogra' ),
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

        $this->add_control(
            'content',
            [
                'label' => esc_html__( 'Description', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXTAREA,
            ]
        );

        $tax_keys = $this->get_tax_keys();

        foreach( $tax_keys as $tax_key ) {
            if ( $meta_obj->check_post_meta_exist($tax_key) ) {
                $this->add_control(
                    $tax_key.'_slugs',
                    [
                        'label' => sprintf(esc_html__( '%s Slug', 'foogra' ), $fields[WP_LISTINGS_DIRECTORY_LISTING_PREFIX.$tax_key]['name']),
                        'type' => Elementor\Controls_Manager::TEXTAREA,
                        'rows' => 1,
                        'default' => '',
                        'placeholder' => esc_html__( 'Enter slugs spearate by comma(,)', 'foogra' ),
                    ]
                );
            }
        }

        $this->add_control(
            'limit',
            [
                'label' => esc_html__( 'Limit', 'foogra' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Limit listings to display', 'foogra' ),
                'default' => 4
            ]
        );
        
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order by', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'foogra'),
                    'date' => esc_html__('Date', 'foogra'),
                    'ID' => esc_html__('ID', 'foogra'),
                    'author' => esc_html__('Author', 'foogra'),
                    'title' => esc_html__('Title', 'foogra'),
                    'modified' => esc_html__('Modified', 'foogra'),
                    'rand' => esc_html__('Random', 'foogra'),
                    'comment_count' => esc_html__('Comment count', 'foogra'),
                    'menu_order' => esc_html__('Menu order', 'foogra'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Sort order', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'foogra'),
                    'ASC' => esc_html__('Ascending', 'foogra'),
                    'DESC' => esc_html__('Descending', 'foogra'),
                ),
                'default' => ''
            ]
        );

        $this->add_control(
            'get_listings_by',
            [
                'label' => esc_html__( 'Get Listings By', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'featured' => esc_html__('Featured Listings', 'foogra'),
                    'recent' => esc_html__('Recent Listings', 'foogra'),
                ),
                'default' => 'recent'
            ]
        );

        $this->add_control(
            'listing_item_style',
            [
                'label' => esc_html__( 'Listing Item Style', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'grid' => esc_html__('Grid 1', 'foogra'),
                    'grid-v2' => esc_html__('Grid 2', 'foogra'),
                    'list' => esc_html__('List V1', 'foogra'),
                    'list-v2' => esc_html__('List V2', 'foogra'),
                ),
                'default' => 'grid'
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
            'style_action',
            [
                'label' => esc_html__( 'Style Pagination, Navigation', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'foogra'),
                    'st_white' => esc_html__('White', 'foogra'),
                ),
                'default' => '',
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
            'view_all',
            [
                'label' => esc_html__( 'View All', 'foogra' ),
                'type' => Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'foogra' ),
                'label_off' => esc_html__( 'Show', 'foogra' ),
            ]
        );

        $this->add_control(
            'text_view',
            [
                'label' => esc_html__( 'Text View All', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'text',
                'default' => 'See All Listings',
                'condition' => [
                    'view_all' => ['yes'],
                ]
            ]
        );

        $this->add_control(
            'link_view',
            [
                'label' => esc_html__( 'View Link', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'url',
                'placeholder' => esc_html__( 'Enter your Link here', 'foogra' ),
                'condition' => [
                    'view_all' => ['yes'],
                ]
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

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        $args = array(
            'limit' => $limit,
            'get_listings_by' => $get_listings_by,
            'orderby' => $orderby,
            'order' => $order
        );
        
        $tax_keys = $this->get_tax_keys();
        foreach( $tax_keys as $tax_key ) {
            $args[$tax_key] = !empty($settings[$tax_key.'_slugs']) ? array_map('trim', explode(',', $settings[$tax_key.'_slugs'])) : array();
        }
        
        $loop = foogra_get_listings($args);
        if ( $loop->have_posts() ) {
            $columns = !empty($columns) ? $columns : 3;
            $columns_tablet = !empty($columns_tablet) ? $columns_tablet : 2;
            $columns_mobile = !empty($columns_mobile) ? $columns_mobile : 1;
            
            $slides_to_scroll = !empty($slides_to_scroll) ? $slides_to_scroll : $columns;
            $slides_to_scroll_tablet = !empty($slides_to_scroll_tablet) ? $slides_to_scroll_tablet : $slides_to_scroll;
            $slides_to_scroll_mobile = !empty($slides_to_scroll_mobile) ? $slides_to_scroll_mobile : 1;
            ?>
            <div class="widget-listings <?php echo esc_attr($layout_type.' item-'.$listing_item_style); ?> <?php echo esc_attr($el_class); ?>">
                <?php if ( $title || !empty($content) || ( $view_all == 'yes' && !(empty($link_view)) && !(empty($text_view)) ) ) { ?>
                    <span class="main_title"><em></em></span>
                    <div class="top-info-widget d-md-flex align-items-end">
                        <div class="info-left">
                            <?php if ( $title ) { ?>
                                <h2 class="title"><?php echo esc_html($title); ?></h2>
                            <?php } ?>
                            <?php if ( !empty($content) ) { ?>
                                <div class="description"><?php echo trim($content); ?></div>
                            <?php } ?>
                        </div>
                        <?php if ( $view_all == 'yes' && !(empty($link_view)) && !(empty($text_view)) ) { ?>
                            <div class="ms-auto">
                                <a href="<?php echo esc_url( $link_view ); ?>" class="btn-view">
                                    <?php echo esc_html($text_view); ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="widget-content">
                    <?php if ( $layout_type == 'carousel' ): ?>
                        <div class="slick-carousel <?php echo esc_attr($style_action); ?>"
                            data-items="<?php echo esc_attr($columns); ?>"
                            data-large="<?php echo esc_attr( $columns_tablet ); ?>"
                            data-medium="2"
                            data-small="<?php echo esc_attr($columns_mobile); ?>"

                            data-slidestoscroll="<?php echo esc_attr($slides_to_scroll); ?>"
                            data-slidestoscroll_smallmedium="<?php echo esc_attr( $slides_to_scroll_tablet ); ?>"
                            data-slidestoscroll_extrasmall="<?php echo esc_attr($slides_to_scroll_mobile); ?>"

                            data-pagination="<?php echo esc_attr( $show_pagination ? 'true' : 'false' ); ?>" data-nav="<?php echo esc_attr( $show_nav ? 'true' : 'false' ); ?>" data-rows="<?php echo esc_attr( $rows ); ?>" data-infinite="<?php echo esc_attr( $infinite_loop ? 'true' : 'false' ); ?>" data-autoplay="<?php echo esc_attr( $slider_autoplay ? 'true' : 'false' ); ?>">
                            <?php while ( $loop->have_posts() ): $loop->the_post(); ?>
                                <div class="item">
                                    <?php echo WP_Listings_Directory_Template_Loader::get_template_part( 'listings-styles/inner-'. $listing_item_style ); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <?php
                            $mdcol = 12/$columns;
                            $smcol = 12/$columns_tablet;
                            $xscol = 12/$columns_mobile;
                        ?>
                        <div class="row">
                            <?php while ( $loop->have_posts() ) : $loop->the_post();
                    
                                if($listing_item_style == 'list' || $listing_item_style == 'list-v1'){
                                    $smcol = 12;
                                }
                            ?>
                                <div class="col-xl-<?php echo esc_attr($mdcol); ?> col-md-<?php echo esc_attr($smcol); ?> col-<?php echo esc_attr( $xscol ); ?> list-item">
                                    <?php echo WP_Listings_Directory_Template_Loader::get_template_part( 'listings-styles/inner-'. $listing_item_style ); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        }
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Foogra_Elementor_Listings_Directory_Listings );