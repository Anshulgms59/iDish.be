<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Foogra_Elementor_Mailchimp extends Widget_Base {

	public function get_name() {
        return 'apus_element_mailchimp';
    }

	public function get_title() {
        return esc_html__( 'Apus MailChimp Sign-Up Form', 'foogra' );
    }
    
	public function get_categories() {
        return [ 'foogra-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'MailChimp Sign-Up Form', 'foogra' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'foogra' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your title here', 'foogra' ),
            ]
        );
        
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'foogra' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    '' => esc_html__('Default', 'foogra'),
                ),
                'default' => ''
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'foogra' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'foogra' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Style', 'foogra' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'foogra' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'foogra' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .widget-title',
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__( 'Input Color', 'foogra' ),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_placeholder_color',
            [
                'label' => esc_html__( 'Input Placeholder Color', 'foogra' ),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} input:-moz-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_bg_color',
            [
                'label' => esc_html__( 'Input Background', 'foogra' ),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} input' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__( 'Border Form', 'foogra' ),
                'selector' => '{{WRAPPER}} .input-group',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'foogra' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->start_controls_tabs(
                'style_tabs'
            );
                $this->start_controls_tab(
                    'button_normal_tab',
                        [
                            'label' => esc_html__( 'Normal', 'foogra' ),
                        ]
                    );
                    $this->add_control(
                        'btn_color',
                        [
                            'label' => esc_html__( 'Button Color', 'foogra' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                // Stronger selector to avoid section style from overwriting
                                '{{WRAPPER}} [type="submit"]' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'btn_bg_color',
                        [
                            'label' => esc_html__( 'Button Background', 'foogra' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                // Stronger selector to avoid section style from overwriting
                                '{{WRAPPER}} [type="submit"]' => 'background: {{VALUE}};',
                            ],
                        ]
                    );
                    $this->add_control(
                        'btn_br_color',
                        [
                            'label' => esc_html__( 'Button Border', 'foogra' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                // Stronger selector to avoid section style from overwriting
                                '{{WRAPPER}} [type="submit"]' => 'border-color: {{VALUE}};',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'box_button_shadow',
                            'label' => esc_html__( 'Box Shadow', 'foogra' ),
                            'selector' => '{{WRAPPER}} [type="submit"]',
                        ]
                    );

                $this->end_controls_tab();

                $this->start_controls_tab(
                    'button_hover_tab',
                        [
                            'label' => esc_html__( 'Hover', 'foogra' ),
                        ]
                    );
                    $this->add_control(
                        'btn_hover_color',
                        [
                            'label' => esc_html__( 'Button Color', 'foogra' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                // Stronger selector to avoid section style from overwriting
                                '{{WRAPPER}} [type="submit"]:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} [type="submit"]:focus' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'btn_hover_bg_color',
                        [
                            'label' => esc_html__( 'Button Background', 'foogra' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                // Stronger selector to avoid section style from overwriting
                                '{{WRAPPER}} [type="submit"]:hover' => 'background: {{VALUE}};',
                                '{{WRAPPER}} [type="submit"]:focus' => 'background: {{VALUE}};',
                            ],
                        ]
                    );
                    $this->add_control(
                        'btn_hover_br_color',
                        [
                            'label' => esc_html__( 'Button Border', 'foogra' ),
                            'type' => Controls_Manager::COLOR,
                            
                            'selectors' => [
                                // Stronger selector to avoid section style from overwriting
                                '{{WRAPPER}} [type="submit"]:hover' => 'border-color: {{VALUE}};',
                                '{{WRAPPER}} [type="submit"]:focus' => 'border-color: {{VALUE}};',
                            ],
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Box_Shadow::get_type(),
                        [
                            'name' => 'box_button_hv_shadow',
                            'label' => esc_html__( 'Box Shadow', 'foogra' ),
                            'selector' => '{{WRAPPER}} [type="submit"]:hover',
                            'selector' => '{{WRAPPER}} [type="submit"]:focus',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
        // end tab for button
    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        ?>
        <div class="widget-mailchimp widget m-0 <?php echo esc_attr($el_class.' '.$style); ?>">
            <?php if ( !empty($title) ) { ?>
                <h2 class="widget-title"><?php echo esc_html($title); ?></h2>
            <?php } ?>
            <?php mc4wp_show_form(''); ?>
        </div>
        <?php
    }
}
Plugin::instance()->widgets_manager->register( new Foogra_Elementor_Mailchimp );