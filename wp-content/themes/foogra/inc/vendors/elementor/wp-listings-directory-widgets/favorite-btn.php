<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Foogra_Elementor_Favorite_Btn extends Elementor\Widget_Base {

	public function get_name() {
        return 'apus_element_favorites_btn';
    }

	public function get_title() {
        return esc_html__( 'Apus Header Favorite Button', 'foogra' );
    }
    
	public function get_categories() {
        return [ 'foogra-header-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'foogra' ),
                'type' => Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'foogra' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'foogra' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'foogra' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
            'section_title_style',
            [
                'label' => esc_html__( 'Color', 'foogra' ),
                'tab' => Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Color Text', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-favorites' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__( 'Color Hover Text', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-favorites:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-favorites:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

	protected function render() {
        $settings = $this->get_settings();

        extract( $settings );
        $favorites_items = WP_Listings_Directory_Favorite::get_listing_favorites();
        if ( !empty($favorites_items) && is_array($favorites_items) ) {
            $favorites_items = count($favorites_items);
        } else {
            $favorites_items = 0;
        }
        $favorite_listings_page_id = wp_listings_directory_get_option('favorite_listings_page_id');
        $favorite_listings_page_id = WP_Listings_Directory_Mixes::get_lang_post_id($favorite_listings_page_id);
        ?>
        <div class="widget-favorites-btn <?php echo esc_attr($el_class); ?>">
            <a class="btn-favorites" href="<?php echo esc_url( get_permalink( $favorite_listings_page_id ) ); ?>" title="<?php esc_attr_e('Favorite', 'foogra'); ?>">
                <i class="icon_heart_alt"></i>
                <span class="count"><?php echo trim($favorites_items); ?></span>
            </a>
        </div>
        <?php
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Foogra_Elementor_Favorite_Btn );