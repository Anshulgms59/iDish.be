<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Foogra_Elementor_Testimonials extends Widget_Base {

    public function get_name() {
        return 'apus_element_testimonials';
    }

    public function get_title() {
        return esc_html__( 'Apus Testimonials', 'foogra' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return [ 'foogra-elements' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'foogra' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'img_src',
            [
                'name' => 'image',
                'label' => esc_html__( 'Choose Image', 'foogra' ),
                'type' => Controls_Manager::MEDIA,
                'placeholder'   => esc_html__( 'Upload Brand Image', 'foogra' ),
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'foogra' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'content', [
                'label' => esc_html__( 'Content', 'foogra' ),
                'type' => Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'listing',
            [
                'label' => esc_html__( 'Job', 'foogra' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'stars',
            [
                'label' => esc_html__( 'Star', 'foogra' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    1 => esc_html__('1 Star', 'foogra'),
                    2 => esc_html__('2 Stars', 'foogra'),
                    3 => esc_html__('3 Stars', 'foogra'),
                    4 => esc_html__('4 Stars', 'foogra'),
                    5 => esc_html__('5 Stars', 'foogra'),
                ),
                'default' => 5
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link To', 'foogra' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'Enter your social link here', 'foogra' ),
                'placeholder' => esc_html__( 'https://your-link.com', 'foogra' ),
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__( 'Testimonials', 'foogra' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
        
        $this->add_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'foogra' ),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'number',
                'default' => '1'
            ]
        );

        $this->add_control(
            'show_nav',
            [
                'label' => esc_html__( 'Show Nav', 'foogra' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'foogra' ),
                'label_off' => esc_html__( 'Show', 'foogra' ),
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__( 'Show Pagination', 'foogra' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => esc_html__( 'Hide', 'foogra' ),
                'label_off' => esc_html__( 'Show', 'foogra' ),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout', 'foogra' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'style1' => esc_html__('Style 1', 'foogra'),
                    'style2' => esc_html__('Style 2', 'foogra'),
                ),
                'default' => 'style1'
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
            'section_box_style',
            [
                'label' => esc_html__( 'Style Box', 'foogra' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_box',
                'label' => esc_html__( 'Border Box', 'foogra' ),
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_box',
                'label' => esc_html__( 'Box Shadow Box', 'foogra' ),
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_hv_box',
                'label' => esc_html__( 'Box Shadow Hover Box', 'foogra' ),
                'selector' => '{{WRAPPER}} .testimonials-item:hover .description',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_img',
                'label' => esc_html__( 'Box Shadow Image', 'foogra' ),
                'selector' => '{{WRAPPER}} .avarta',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow_hv_img',
                'label' => esc_html__( 'Box Shadow Hover Image', 'foogra' ),
                'selector' => '{{WRAPPER}} .testimonials-item:hover .avarta',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Style Info', 'foogra' ),
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
            'test_title_color',
            [
                'label' => esc_html__( 'Testimonial Title Color', 'foogra' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .name-client' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .name-client a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Testimonial Title Typography', 'foogra' ),
                'name' => 'test_title_typography',
                'selector' => '{{WRAPPER}} .name-client',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'foogra' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Content Typography', 'foogra' ),
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->add_control(
            'listing_color',
            [
                'label' => esc_html__( 'Listing Color', 'foogra' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .listing' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Listing Typography', 'foogra' ),
                'name' => 'listing_typography',
                'selector' => '{{WRAPPER}} .listing',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if ( !empty($testimonials) ) {
            ?>
            <div class="widget-testimonials <?php echo esc_attr($el_class.' '.$layout_type); ?>">

                <?php if ( $layout_type == 'style1' ) { ?>
                    <div class="slick-carousel testimonial-main <?php echo trim( ($columns >= count($testimonials))?'hidden-dots':'' ); ?>" data-items="<?php echo esc_attr($columns); ?>" data-large="1" data-medium="1" data-small="1" data-smallest="1" data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>" data-centerMode="true" data-infinite="true">
                        <?php foreach ($testimonials as $item) { ?>
                        <div class="item">
                            <div class="testimonials-item <?php echo trim( $layout_type ); ?>">
                                <span class="comma">“</span>
                                <?php if ( isset( $item['img_src']['id'] ) ) { ?>
                                <div class="wrapper-avarta">
                                    <div class="m-auto avarta d-flex justify-content-center align-items-center">
                                        <?php echo foogra_get_attachment_thumbnail($item['img_src']['id'], 'full'); ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="info-testimonials">
                                    <?php if ( !empty($item['name']) ) {

                                        $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                        if ( ! empty( $item['link']['url'] ) ) {
                                            $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                        }
                                        echo trim($title);
                                    ?>
                                    <?php } ?>
                                    <?php if ( !empty($item['listing']) ) { ?>
                                        <div class="listing"><?php echo esc_html($item['listing']); ?></div>
                                    <?php } ?> 
                                </div>
                            
                                <?php if ( !empty($item['content']) ) { ?>
                                    <div class="description"><?php echo trim($item['content']); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                <?php } else { ?>
                    <div class="slick-carousel testimonial-main <?php echo trim( ($columns >= count($testimonials))?'hidden-dots':'' ); ?>" data-items="<?php echo esc_attr($columns); ?>" data-large="1" data-medium="1" data-small="1" data-smallest="1" data-pagination="<?php echo esc_attr($show_pagination ? 'true' : 'false'); ?>" data-nav="<?php echo esc_attr($show_nav ? 'true' : 'false'); ?>">
                        <?php foreach ($testimonials as $item) { ?>
                        <div class="item">
                            <div class="testimonials-item clearfix <?php echo trim( $layout_type ); ?>">

                                <div class="top-info">
                                    <div class="star-rating"><span style="width:<?php echo esc_attr($item['stars']*20); ?>%"></span></div>
                                    <?php if ( !empty($item['content']) ) { ?>
                                        <div class="description"><?php echo trim($item['content']); ?></div>
                                    <?php } ?>
                                </div>

                                <div class="bottom-info">
                                    <div class="d-flex align-items-center">
                                        <?php if ( isset( $item['img_src']['id'] ) ) { ?>
                                            <div class="wrapper-avarta">
                                                <div class="avarta">
                                                    <?php echo foogra_get_attachment_thumbnail($item['img_src']['id'], 'full'); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="info-testimonials">
                                            <?php if ( !empty($item['name']) ) {

                                                $title = '<h3 class="name-client">'.$item['name'].'</h3>';
                                                if ( ! empty( $item['link']['url'] ) ) {
                                                    $title = sprintf( '<h3 class="name-client"><a href="'.esc_url($item['link']['url']).'" target="'.esc_attr($item['link']['is_external'] ? '_blank' : '_self').'" '.($item['link']['nofollow'] ? 'rel="nofollow"' : '').'>%1$s</a></h3>', $item['name'] );
                                                }
                                                echo trim($title);
                                            ?>
                                            <?php } ?>
                                            <?php if ( !empty($item['listing']) ) { ?>
                                                <div class="listing"><?php echo esc_html($item['listing']); ?></div>
                                            <?php } ?> 
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                    
            </div>
            <?php
        }
    }
}
Plugin::instance()->widgets_manager->register( new Foogra_Elementor_Testimonials );