<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Foogra_Elementor_Packages extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_packages';
    }

	public function get_title() {
        return esc_html__( 'Apus Packages', 'foogra' );
    }
    
	public function get_categories() {
        return [ 'foogra-elements' ];
    }

	protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
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
            'number',
            [
                'label' => esc_html__( 'Number Product', 'foogra' ),
                'type' => Elementor\Controls_Manager::NUMBER,
                'input_type' => 'number',
                'description' => esc_html__( 'Number Product to display', 'foogra' ),
                'default' => 3
            ]
        );
        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => 3,
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
            'section_title_style',
            [
                'label' => esc_html__( 'Button', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs( 'tabs_box_style' );

            $this->start_controls_tab(
                'tab_box_normal',
                [
                    'label' => esc_html__( 'Normal', 'foogra' ),
                ]
            ); 

            $this->add_control(
                'btn_color',
                [
                    'label' => esc_html__( 'Color', 'foogra' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .button' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .subwoo-inner .add-cart .button.loading::after' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'btn_bg_color',
                [
                    'label' => esc_html__( 'Background Color', 'foogra' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .button' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_control(
                'btn_br_color',
                [
                    'label' => esc_html__( 'Border Color', 'foogra' ),
                    'type' => Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        // Stronger selector to avoid section style from overwriting
                        '{{WRAPPER}} .subwoo-inner .add-cart .button' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->end_controls_tab();

            // tab hover
            $this->start_controls_tab(
                'tab_box_hover',
                [
                    'label' => esc_html__( 'Hover', 'foogra' ),
                ]
            );


                $this->add_control(
                    'btn_hv_color',
                    [
                        'label' => esc_html__( 'Color', 'foogra' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .subwoo-inner:hover .add-cart .button' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart' => 'color: {{VALUE}};',
                            '{{WRAPPER}} .subwoo-inner.is_featured .add-cart .button' => 'color: {{VALUE}};',
                        ],
                    ]
                );
                $this->add_control(
                    'btn_hv_bg_color',
                    [
                        'label' => esc_html__( 'Background Color', 'foogra' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .subwoo-inner:hover .add-cart .button' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .subwoo-inner.is_featured .add-cart .button' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );
                $this->add_control(
                    'btn_hv_br_color',
                    [
                        'label' => esc_html__( 'Border Color', 'foogra' ),
                        'type' => Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            // Stronger selector to avoid section style from overwriting
                            '{{WRAPPER}} .subwoo-inner:hover .add-cart .button' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .subwoo-inner .add-cart .added_to_cart' => 'border-color: {{VALUE}};',
                            '{{WRAPPER}} .subwoo-inner.is_featured .add-cart .button' => 'border-color: {{VALUE}};',
                        ],
                    ]
                );


            $this->end_controls_tab();

        $this->end_controls_tabs();
        // end tab normal and hover
        
        $this->end_controls_section();
    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        $loop = foogra_get_products(array(
            'product_type' => 'listing_package',
            'post_per_page' => $number,
            'orderby' => $orderby,
            'order' => $order
        ));
        ?>
        <div class="woocommerce widget-subwoo <?php echo esc_attr($el_class); ?>">
            <?php if ($loop->have_posts()): ?>
                <div class="row m-0">
                    <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                        <div class="p-0 col-12 col-sm-6 col-lg-<?php echo esc_attr(12/$columns); ?> <?php echo esc_attr($product->is_featured()?'col_is_featured':''); ?>">
                            <div class="subwoo-inner <?php echo esc_attr($product->is_featured()?'is_featured':''); ?>">
                                <div class="item">
                                    <div class="header-sub">
                                        <h3 class="title"><?php the_title(); ?></h3>
                                        <?php the_content(); ?>
                                    </div>
                                    <div class="bottom-sub">
                                        <div class="price"><?php echo (!empty($product->get_price())) ? $product->get_price_html() : esc_html__('Free','foogra'); ?></div>
                                        <?php if ( has_excerpt() ) { ?>
                                            <div class="short-des"><?php the_excerpt(); ?></div>
                                        <?php } ?>
                                        <div class="button-action"><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Foogra_Elementor_Packages );