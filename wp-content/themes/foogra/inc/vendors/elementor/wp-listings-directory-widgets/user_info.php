<?php

//namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Foogra_Elementor_User_Info extends Elementor\Widget_Base {

    public function get_name() {
        return 'apus_element_user_info';
    }

    public function get_title() {
        return esc_html__( 'Apus Header User Info', 'foogra' );
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

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__( 'Layout Type', 'foogra' ),
                'type' => Elementor\Controls_Manager::SELECT,
                'options' => array(
                    'popup' => esc_html__('Popup', 'foogra'),
                    'page' => esc_html__('Page', 'foogra'),
                ),
                'default' => 'popup'
            ]
        );

        $this->add_control(
            'login_text',
            [
                'label' => esc_html__( 'Login Text', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => 'Login/Sign Up'
            ]
        );

        $this->add_control(
            'login_tab_text',
            [
                'label' => esc_html__( 'Login Tab Title', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => 'Sign In'
            ]
        );

        $this->add_control(
            'register_tab_text',
            [
                'label' => esc_html__( 'Register Tab Title', 'foogra' ),
                'type' => Elementor\Controls_Manager::TEXT,
                'default' => 'Register'
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
                    '{{WRAPPER}} .name-acount' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .top-wrapper-menu >a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .space' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_hover_color',
            [
                'label' => esc_html__( 'Color Hover Link', 'foogra' ),
                'type' => Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wrapper-menu >a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .top-wrapper-menu >a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();

        extract( $settings );

        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $userdata = get_userdata($user_id);
            $user_name = $userdata->display_name;
            
            $menu_nav = 'user-menu';
            
            ?>
            <div class="top-wrapper-menu author-verify <?php echo esc_attr($el_class); ?>">
                <a class="drop-dow" href="javascript:void(0);">
                    <div class="infor-account d-flex align-items-center">
                        <div class="avatar-wrapper">
                            <?php echo foogra_get_avatar($user_id, 54); ?>
                        </div>
                        <div class="name-acount"><?php echo esc_html($user_name); ?> 
                            <?php if ( !empty($menu_nav) && has_nav_menu( $menu_nav ) ) { ?>
                                <i class="fas fa-chevron-down"></i>
                            <?php } ?>
                        </div>
                    </div>
                </a>
                <?php
                    if ( !empty($menu_nav) && has_nav_menu( $menu_nav ) ) {
                        $args = array(
                            'theme_location' => $menu_nav,
                            'container_class' => 'inner-top-menu',
                            'menu_class' => 'nav navbar-nav topmenu-menu',
                            'fallback_cb' => '',
                            'menu_id' => '',
                            'walker' => new Foogra_Nav_Menu()
                        );
                        wp_nav_menu($args);
                    }
                ?>
            </div>
        <?php } else { ?>

            <div class="top-wrapper-menu <?php echo esc_attr($el_class); ?>">
                <?php if ( $layout_type == 'page' ) {
                    $login_page_id = wp_listings_directory_get_option('login_page_id');
                    $login_page_id = WP_Listings_Directory_Mixes::get_lang_post_id($login_page_id);
                ?>
                    <a class="btn-login" href="<?php echo esc_url( get_permalink( $login_page_id ) ); ?>" title="<?php echo esc_attr($login_text); ?>">
                        <i class="glyphter-sign"></i><?php echo esc_html($login_text); ?>
                    </a>
                <?php } else { ?>

                    <a class="btn-login btn-login-register-popup-btn" href="#apus_login_register_form" title="<?php echo esc_attr($login_text); ?>">
                        <i class="glyphter-sign"></i>
                    </a>

                    <div id="apus_login_register_form" class="apus_login_register_form mfp-hide" data-effect="fadeIn">
                        <div class="form-login-register-inner">
                            <div class="top-login d-flex align-items-center">
                                <ul class="nav nav-tabs">
                                    <li><a class="active" data-bs-toggle="tab" href="#apus_login_forgot_form"><?php echo esc_html($login_tab_text); ?></a></li>
                                    <li><a data-bs-toggle="tab" href="#apus_register_form"><?php echo esc_html($register_tab_text); ?></a></li>
                                </ul>
                                <a href="javascript:void(0);" class="close-magnific-popup ms-auto"><i class="icon_close"></i></a>
                            </div>
                            <div class="tab-content">
                                <div id="apus_login_forgot_form" class="tab-pane fade show active">
                                    <?php echo do_shortcode( '[wp_listings_directory_login popup="true"]' ); ?>
                                </div>

                                <div id="apus_register_form" class="tab-pane fade">
                                    <?php echo do_shortcode( '[wp_listings_directory_register popup="true"]' ); ?>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php }
    }
}

Elementor\Plugin::instance()->widgets_manager->register( new Foogra_Elementor_User_Info );