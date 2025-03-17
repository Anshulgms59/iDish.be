<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'Foogra_Elementor_Extensions' ) ) {
    final class Foogra_Elementor_Extensions {

        private static $_instance = null;

        
        public function __construct() {
            add_action( 'elementor/elements/categories_registered', array( $this, 'add_widget_categories' ) );
            add_action( 'init', array( $this, 'elementor_widgets' ),  100 );
            add_filter( 'foogra_generate_post_builder', array( $this, 'render_post_builder' ), 10, 2 );

            add_action( 'elementor/controls/controls_registered', array( $this, 'modify_controls' ), 10, 1 );
            add_action('elementor/editor/before_enqueue_styles', array( $this, 'style' ) );
        }

        public static function instance () {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        public function add_widget_categories( $elements_manager ) {
            $elements_manager->add_category(
                'foogra-elements',
                [
                    'title' => esc_html__( 'Foogra Elements', 'foogra' ),
                    'icon' => 'fa fa-shopping-bag',
                ]
            );

            $elements_manager->add_category(
                'foogra-header-elements',
                [
                    'title' => esc_html__( 'Foogra Header Elements', 'foogra' ),
                    'icon' => 'fa fa-shopping-bag',
                ]
            );

        }

        public function elementor_widgets() {
            // general elements
            get_template_part( 'inc/vendors/elementor/widgets/heading' );
            get_template_part( 'inc/vendors/elementor/widgets/posts' );
            get_template_part( 'inc/vendors/elementor/widgets/call_to_action' );
            get_template_part( 'inc/vendors/elementor/widgets/features_box' );
            get_template_part( 'inc/vendors/elementor/widgets/address_box' );
            get_template_part( 'inc/vendors/elementor/widgets/social_links' );
            get_template_part( 'inc/vendors/elementor/widgets/testimonials' );
            get_template_part( 'inc/vendors/elementor/widgets/brands' );
            get_template_part( 'inc/vendors/elementor/widgets/popup_video' );
            get_template_part( 'inc/vendors/elementor/widgets/banner' );
            get_template_part( 'inc/vendors/elementor/widgets/banners' );
            get_template_part( 'inc/vendors/elementor/widgets/banner_account' );
            get_template_part( 'inc/vendors/elementor/widgets/countdown' );
            get_template_part( 'inc/vendors/elementor/widgets/nav_menu' );
            get_template_part( 'inc/vendors/elementor/widgets/team' );
            get_template_part( 'inc/vendors/elementor/widgets/achievements' );
            get_template_part( 'inc/vendors/elementor/widgets/list_icon' );

            // header elements
            get_template_part( 'inc/vendors/elementor/header-widgets/logo' );
            get_template_part( 'inc/vendors/elementor/header-widgets/primary_menu' );
            get_template_part( 'inc/vendors/elementor/header-widgets/nav_bar' );
            

            if ( foogra_is_mailchimp_activated() ) {
                get_template_part( 'inc/vendors/elementor/widgets/mailchimp' );
            }
            
            if ( foogra_is_revslider_activated() ) {
                get_template_part( 'inc/vendors/elementor/widgets/revslider' );
            }

            if ( foogra_is_wp_listings_directory_activated() ) {
                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/listings' );
                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/listings_tabs' );

                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/category_banner' );
                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/listings_categories' );
                
                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/location_banner' );
                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/listing_locations' );

                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/search_form' );

                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/user_info' );
                
                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/favorite-btn' );
                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/submit-btn' );
                get_template_part( 'inc/vendors/elementor/wp-listings-directory-widgets/currencies' );
            }

            if ( foogra_is_wp_listings_directory_wc_paid_listings_activated() ) {
                get_template_part( 'inc/vendors/elementor/wc-paid-listings-widgets/packages' );
                get_template_part( 'inc/vendors/elementor/wc-paid-listings-widgets/user_packages' );
                get_template_part( 'inc/vendors/elementor/wc-paid-listings-widgets/transactions' );
            }

            if ( foogra_is_wp_private_message() ) {
                get_template_part( 'inc/vendors/elementor/wp-private-message-widgets/header-notification' );
            }
        }
        public function style() {
            wp_enqueue_style('foogra-icons',  get_template_directory_uri() . '/css/icons.css');
            wp_enqueue_style('line-font',  get_template_directory_uri() . '/css/line-font.css');
        }

        public function modify_controls( $controls_registry ) {
            // Get existing icons
            $icons = $controls_registry->get_control( 'icon' )->get_settings( 'options' );
            
            $new_icons = array_merge(array(
                'icon-food_icon_cake_2' => 'icon-food_icon_cake_2','icon-food_icon_fish' => 'icon-food_icon_fish','icon-food_icon_chicken' => 'icon-food_icon_chicken','icon-food_icon_bread_2' => 'icon-food_icon_bread_2','icon-food_icon_coffee' => 'icon-food_icon_coffee','icon-food_icon_dish' => 'icon-food_icon_dish','icon-food_icon_cloche' => 'icon-food_icon_cloche','icon-food_icon_glass' => 'icon-food_icon_glass','icon-food_icon_fish_2' => 'icon-food_icon_fish_2','icon-food_icon_hair' => 'icon-food_icon_hair','icon-food_icon_cake_3' => 'icon-food_icon_cake_3','icon-food_icon_icecream_2' => 'icon-food_icon_icecream_2','icon-food_icon_burgher' => 'icon-food_icon_burgher','icon-food_icon_beer' => 'icon-food_icon_beer','icon-food_icon_burrito' => 'icon-food_icon_burrito','icon-clock_2' => 'icon-clock_2','icon-food_icon_pizza' => 'icon-food_icon_pizza','icon-user_2' => 'icon-user_2','icon-food_icon_chinese' => 'icon-food_icon_chinese','icon-food_icon_vegetarian' => 'icon-food_icon_vegetarian','icon-food_icon_chili' => 'icon-food_icon_chili','icon-food_icon_sushi' => 'icon-food_icon_sushi','icon-food_icon_delivery' => 'icon-food_icon_delivery','icon-food_icon_shop' => 'icon-food_icon_shop','icon-food_icon_highlight' => 'icon-food_icon_highlight','arrow_up' => 'arrow_up','arrow_down' => 'arrow_down','arrow_left' => 'arrow_left','arrow_right' => 'arrow_right','arrow_left-up' => 'arrow_left-up','arrow_right-up' => 'arrow_right-up','arrow_right-down' => 'arrow_right-down','arrow_left-down' => 'arrow_left-down','arrow-up-down' => 'arrow-up-down','arrow_up-down_alt' => 'arrow_up-down_alt','arrow_left-right_alt' => 'arrow_left-right_alt','arrow_left-right' => 'arrow_left-right','arrow_expand_alt2' => 'arrow_expand_alt2','arrow_expand_alt' => 'arrow_expand_alt','arrow_expand' => 'arrow_expand','arrow_move' => 'arrow_move','arrow_carrot-up' => 'arrow_carrot-up','arrow_carrot-down' => 'arrow_carrot-down','arrow_carrot-left' => 'arrow_carrot-left','arrow_carrot-right' => 'arrow_carrot-right','arrow_carrot-2up' => 'arrow_carrot-2up','arrow_carrot-2down' => 'arrow_carrot-2down','arrow_carrot-2left' => 'arrow_carrot-2left','arrow_carrot-2right' => 'arrow_carrot-2right','arrow_carrot-up_alt2' => 'arrow_carrot-up_alt2','arrow_carrot-down_alt2' => 'arrow_carrot-down_alt2','arrow_carrot-left_alt2' => 'arrow_carrot-left_alt2','arrow_carrot-right_alt2' => 'arrow_carrot-right_alt2','arrow_carrot-2up_alt2' => 'arrow_carrot-2up_alt2','arrow_carrot-2down_alt2' => 'arrow_carrot-2down_alt2','arrow_carrot-2left_alt2' => 'arrow_carrot-2left_alt2','arrow_carrot-2right_alt2' => 'arrow_carrot-2right_alt2','arrow_triangle-up' => 'arrow_triangle-up','arrow_triangle-down' => 'arrow_triangle-down','arrow_triangle-left' => 'arrow_triangle-left','arrow_triangle-right' => 'arrow_triangle-right','arrow_triangle-up_alt2' => 'arrow_triangle-up_alt2','arrow_triangle-down_alt2' => 'arrow_triangle-down_alt2','arrow_triangle-left_alt2' => 'arrow_triangle-left_alt2','arrow_triangle-right_alt2' => 'arrow_triangle-right_alt2','arrow_back' => 'arrow_back','icon_minus-06' => 'icon_minus-06','icon_plus' => 'icon_plus','icon_close' => 'icon_close','icon_check' => 'icon_check','icon_minus_alt2' => 'icon_minus_alt2','icon_plus_alt2' => 'icon_plus_alt2','icon_close_alt2' => 'icon_close_alt2','icon_check_alt2' => 'icon_check_alt2','icon_zoom-out_alt' => 'icon_zoom-out_alt','icon_zoom-in_alt' => 'icon_zoom-in_alt','icon_search' => 'icon_search','icon_box-empty' => 'icon_box-empty','icon_box-selected' => 'icon_box-selected','icon_minus-box' => 'icon_minus-box','icon_plus-box' => 'icon_plus-box','icon_box-checked' => 'icon_box-checked','icon_circle-empty' => 'icon_circle-empty','icon_circle-slelected' => 'icon_circle-slelected','icon_stop_alt2' => 'icon_stop_alt2','icon_stop' => 'icon_stop','icon_pause_alt2' => 'icon_pause_alt2','icon_pause' => 'icon_pause','icon_menu' => 'icon_menu','icon_menu-square_alt2' => 'icon_menu-square_alt2','icon_menu-circle_alt2' => 'icon_menu-circle_alt2','icon_ul' => 'icon_ul','icon_ol' => 'icon_ol','icon_adjust-horiz' => 'icon_adjust-horiz','icon_adjust-vert' => 'icon_adjust-vert','icon_document_alt' => 'icon_document_alt','icon_documents_alt' => 'icon_documents_alt','icon_pencil' => 'icon_pencil','icon_pencil-edit_alt' => 'icon_pencil-edit_alt','icon_pencil-edit' => 'icon_pencil-edit','icon_folder-alt' => 'icon_folder-alt','icon_folder-open_alt' => 'icon_folder-open_alt','icon_folder-add_alt' => 'icon_folder-add_alt','icon_info_alt' => 'icon_info_alt','icon_error-oct_alt' => 'icon_error-oct_alt','icon_error-circle_alt' => 'icon_error-circle_alt','icon_error-triangle_alt' => 'icon_error-triangle_alt','icon_question_alt2' => 'icon_question_alt2','icon_question' => 'icon_question','icon_comment_alt' => 'icon_comment_alt','icon_chat_alt' => 'icon_chat_alt','icon_vol-mute_alt' => 'icon_vol-mute_alt','icon_volume-low_alt' => 'icon_volume-low_alt','icon_volume-high_alt' => 'icon_volume-high_alt','icon_quotations' => 'icon_quotations','icon_quotations_alt2' => 'icon_quotations_alt2','icon_clock_alt' => 'icon_clock_alt','icon_lock_alt' => 'icon_lock_alt','icon_lock-open_alt' => 'icon_lock-open_alt','icon_key_alt' => 'icon_key_alt','icon_cloud_alt' => 'icon_cloud_alt','icon_cloud-upload_alt' => 'icon_cloud-upload_alt','icon_cloud-download_alt' => 'icon_cloud-download_alt','icon_image' => 'icon_image','icon_images' => 'icon_images','icon_lightbulb_alt' => 'icon_lightbulb_alt','icon_gift_alt' => 'icon_gift_alt','icon_house_alt' => 'icon_house_alt','icon_genius' => 'icon_genius','icon_mobile' => 'icon_mobile','icon_tablet' => 'icon_tablet','icon_laptop' => 'icon_laptop','icon_desktop' => 'icon_desktop','icon_camera_alt' => 'icon_camera_alt','icon_mail_alt' => 'icon_mail_alt','icon_cone_alt' => 'icon_cone_alt','icon_ribbon_alt' => 'icon_ribbon_alt','icon_bag_alt' => 'icon_bag_alt','icon_creditcard' => 'icon_creditcard','icon_cart_alt' => 'icon_cart_alt','icon_paperclip' => 'icon_paperclip','icon_tag_alt' => 'icon_tag_alt','icon_tags_alt' => 'icon_tags_alt','icon_trash_alt' => 'icon_trash_alt','icon_cursor_alt' => 'icon_cursor_alt','icon_mic_alt' => 'icon_mic_alt','icon_compass_alt' => 'icon_compass_alt','icon_pin_alt' => 'icon_pin_alt','icon_pushpin_alt' => 'icon_pushpin_alt','icon_map_alt' => 'icon_map_alt','icon_drawer_alt' => 'icon_drawer_alt','icon_toolbox_alt' => 'icon_toolbox_alt','icon_book_alt' => 'icon_book_alt','icon_calendar' => 'icon_calendar','icon_film' => 'icon_film','icon_table' => 'icon_table','icon_contacts_alt' => 'icon_contacts_alt','icon_headphones' => 'icon_headphones','icon_lifesaver' => 'icon_lifesaver','icon_piechart' => 'icon_piechart','icon_refresh' => 'icon_refresh','icon_link_alt' => 'icon_link_alt','icon_link' => 'icon_link','icon_loading' => 'icon_loading','icon_blocked' => 'icon_blocked','icon_archive_alt' => 'icon_archive_alt','icon_heart_alt' => 'icon_heart_alt','icon_star_alt' => 'icon_star_alt','icon_star-half_alt' => 'icon_star-half_alt','icon_star' => 'icon_star','icon_star-half' => 'icon_star-half','icon_tools' => 'icon_tools','icon_tool' => 'icon_tool','icon_cog' => 'icon_cog','icon_cogs' => 'icon_cogs','arrow_up_alt' => 'arrow_up_alt','arrow_down_alt' => 'arrow_down_alt','arrow_left_alt' => 'arrow_left_alt','arrow_right_alt' => 'arrow_right_alt','arrow_left-up_alt' => 'arrow_left-up_alt','arrow_right-up_alt' => 'arrow_right-up_alt','arrow_right-down_alt' => 'arrow_right-down_alt','arrow_left-down_alt' => 'arrow_left-down_alt','arrow_condense_alt' => 'arrow_condense_alt','arrow_expand_alt3' => 'arrow_expand_alt3','arrow_carrot_up_alt' => 'arrow_carrot_up_alt','arrow_carrot-down_alt' => 'arrow_carrot-down_alt','arrow_carrot-left_alt' => 'arrow_carrot-left_alt','arrow_carrot-right_alt' => 'arrow_carrot-right_alt','arrow_carrot-2up_alt' => 'arrow_carrot-2up_alt','arrow_carrot-2dwnn_alt' => 'arrow_carrot-2dwnn_alt','arrow_carrot-2left_alt' => 'arrow_carrot-2left_alt','arrow_carrot-2right_alt' => 'arrow_carrot-2right_alt','arrow_triangle-up_alt' => 'arrow_triangle-up_alt','arrow_triangle-down_alt' => 'arrow_triangle-down_alt','arrow_triangle-left_alt' => 'arrow_triangle-left_alt','arrow_triangle-right_alt' => 'arrow_triangle-right_alt','icon_minus_alt' => 'icon_minus_alt','icon_plus_alt' => 'icon_plus_alt','icon_close_alt' => 'icon_close_alt','icon_check_alt' => 'icon_check_alt','icon_zoom-out' => 'icon_zoom-out','icon_zoom-in' => 'icon_zoom-in','icon_stop_alt' => 'icon_stop_alt','icon_menu-square_alt' => 'icon_menu-square_alt','icon_menu-circle_alt' => 'icon_menu-circle_alt','icon_document' => 'icon_document','icon_documents' => 'icon_documents','icon_pencil_alt' => 'icon_pencil_alt','icon_folder' => 'icon_folder','icon_folder-open' => 'icon_folder-open','icon_folder-add' => 'icon_folder-add','icon_folder_upload' => 'icon_folder_upload','icon_folder_download' => 'icon_folder_download','icon_info' => 'icon_info','icon_error-circle' => 'icon_error-circle','icon_error-oct' => 'icon_error-oct','icon_error-triangle' => 'icon_error-triangle','icon_question_alt' => 'icon_question_alt','icon_comment' => 'icon_comment','icon_chat' => 'icon_chat','icon_vol-mute' => 'icon_vol-mute','icon_volume-low' => 'icon_volume-low','icon_volume-high' => 'icon_volume-high','icon_quotations_alt' => 'icon_quotations_alt','icon_clock' => 'icon_clock','icon_lock' => 'icon_lock','icon_lock-open' => 'icon_lock-open','icon_key' => 'icon_key','icon_cloud' => 'icon_cloud','icon_cloud-upload' => 'icon_cloud-upload','icon_cloud-download' => 'icon_cloud-download','icon_lightbulb' => 'icon_lightbulb','icon_gift' => 'icon_gift','icon_house' => 'icon_house','icon_camera' => 'icon_camera','icon_mail' => 'icon_mail','icon_cone' => 'icon_cone','icon_ribbon' => 'icon_ribbon','icon_bag' => 'icon_bag','icon_cart' => 'icon_cart','icon_tag' => 'icon_tag','icon_tags' => 'icon_tags','icon_trash' => 'icon_trash','icon_cursor' => 'icon_cursor','icon_mic' => 'icon_mic','icon_compass' => 'icon_compass','icon_pin' => 'icon_pin','icon_pushpin' => 'icon_pushpin','icon_map' => 'icon_map','icon_drawer' => 'icon_drawer','icon_toolbox' => 'icon_toolbox','icon_book' => 'icon_book','icon_contacts' => 'icon_contacts','icon_archive' => 'icon_archive','icon_heart' => 'icon_heart','icon_profile' => 'icon_profile','icon_group' => 'icon_group','icon_grid-2x2' => 'icon_grid-2x2','icon_grid-3x3' => 'icon_grid-3x3','icon_music' => 'icon_music','icon_pause_alt' => 'icon_pause_alt','icon_phone' => 'icon_phone','icon_upload' => 'icon_upload','icon_download' => 'icon_download','social_facebook' => 'social_facebook','social_twitter' => 'social_twitter','social_pinterest' => 'social_pinterest','social_googleplus' => 'social_googleplus','social_tumblr' => 'social_tumblr','social_tumbleupon' => 'social_tumbleupon','social_wordpress' => 'social_wordpress','social_instagram' => 'social_instagram','social_dribbble' => 'social_dribbble','social_vimeo' => 'social_vimeo','social_linkedin' => 'social_linkedin','social_rss' => 'social_rss','social_deviantart' => 'social_deviantart','social_share' => 'social_share','social_myspace' => 'social_myspace','social_skype' => 'social_skype','social_youtube' => 'social_youtube','social_picassa' => 'social_picassa','social_googledrive' => 'social_googledrive','social_flickr' => 'social_flickr','social_blogger' => 'social_blogger','social_spotify' => 'social_spotify','social_delicious' => 'social_delicious','social_facebook_circle' => 'social_facebook_circle','social_twitter_circle' => 'social_twitter_circle','social_pinterest_circle' => 'social_pinterest_circle','social_googleplus_circle' => 'social_googleplus_circle','social_tumblr_circle' => 'social_tumblr_circle','social_stumbleupon_circle' => 'social_stumbleupon_circle','social_wordpress_circle' => 'social_wordpress_circle','social_instagram_circle' => 'social_instagram_circle','social_dribbble_circle' => 'social_dribbble_circle','social_vimeo_circle' => 'social_vimeo_circle','social_linkedin_circle' => 'social_linkedin_circle','social_rss_circle' => 'social_rss_circle','social_deviantart_circle' => 'social_deviantart_circle','social_share_circle' => 'social_share_circle','social_myspace_circle' => 'social_myspace_circle','social_skype_circle' => 'social_skype_circle','social_youtube_circle' => 'social_youtube_circle','social_picassa_circle' => 'social_picassa_circle','social_googledrive_alt2' => 'social_googledrive_alt2','social_flickr_circle' => 'social_flickr_circle','social_blogger_circle' => 'social_blogger_circle','social_spotify_circle' => 'social_spotify_circle','social_delicious_circle' => 'social_delicious_circle','social_facebook_square' => 'social_facebook_square','social_twitter_square' => 'social_twitter_square','social_pinterest_square' => 'social_pinterest_square','social_googleplus_square' => 'social_googleplus_square','social_tumblr_square' => 'social_tumblr_square','social_stumbleupon_square' => 'social_stumbleupon_square','social_wordpress_square' => 'social_wordpress_square','social_instagram_square' => 'social_instagram_square','social_dribbble_square' => 'social_dribbble_square','social_vimeo_square' => 'social_vimeo_square','social_linkedin_square' => 'social_linkedin_square','social_rss_square' => 'social_rss_square','social_deviantart_square' => 'social_deviantart_square','social_share_square' => 'social_share_square','social_myspace_square' => 'social_myspace_square','social_skype_square' => 'social_skype_square','social_youtube_square' => 'social_youtube_square','social_picassa_square' => 'social_picassa_square','social_googledrive_square' => 'social_googledrive_square','social_flickr_square' => 'social_flickr_square','social_blogger_square' => 'social_blogger_square','social_spotify_square' => 'social_spotify_square','social_delicious_square' => 'social_delicious_square','icon_printer' => 'icon_printer','icon_calulator' => 'icon_calulator','icon_building' => 'icon_building','icon_floppy' => 'icon_floppy','icon_drive' => 'icon_drive','icon_search-2' => 'icon_search-2','icon_id' => 'icon_id','icon_id-2' => 'icon_id-2','icon_puzzle' => 'icon_puzzle','icon_like' => 'icon_like','icon_dislike' => 'icon_dislike','icon_mug' => 'icon_mug','icon_currency' => 'icon_currency','icon_wallet' => 'icon_wallet','icon_pens' => 'icon_pens','icon_easel' => 'icon_easel','icon_flowchart' => 'icon_flowchart','icon_datareport' => 'icon_datareport','icon_briefcase' => 'icon_briefcase','icon_shield' => 'icon_shield','icon_percent' => 'icon_percent','icon_globe' => 'icon_globe','icon_globe-2' => 'icon_globe-2','icon_target' => 'icon_target','icon_hourglass' => 'icon_hourglass','icon_balance' => 'icon_balance','icon_rook' => 'icon_rook','icon_printer-alt' => 'icon_printer-alt','icon_calculator_alt' => 'icon_calculator_alt','icon_building_alt' => 'icon_building_alt','icon_floppy_alt' => 'icon_floppy_alt','icon_drive_alt' => 'icon_drive_alt','icon_search_alt' => 'icon_search_alt','icon_id_alt' => 'icon_id_alt','icon_id-2_alt' => 'icon_id-2_alt','icon_puzzle_alt' => 'icon_puzzle_alt','icon_like_alt' => 'icon_like_alt','icon_dislike_alt' => 'icon_dislike_alt','icon_mug_alt' => 'icon_mug_alt','icon_currency_alt' => 'icon_currency_alt','icon_wallet_alt' => 'icon_wallet_alt','icon_pens_alt' => 'icon_pens_alt','icon_easel_alt' => 'icon_easel_alt','icon_flowchart_alt' => 'icon_flowchart_alt','icon_datareport_alt' => 'icon_datareport_alt','icon_briefcase_alt' => 'icon_briefcase_alt','icon_shield_alt' => 'icon_shield_alt','icon_percent_alt' => 'icon_percent_alt','icon_globe_alt' => 'icon_globe_alt','icon_clipboard' => 'icon_clipboard'

            ), $icons);

            // Then we set a new list of icons as the options of the icon control
            $controls_registry->get_control( 'icon' )->set_settings( 'options', $new_icons );
        }
        public function render_page_content($post_id) {
            if ( class_exists( 'Elementor\Core\Files\CSS\Post' ) ) {
                $css_file = new Elementor\Core\Files\CSS\Post( $post_id );
                $css_file->enqueue();
            }

            return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
        }

        public function render_post_builder($html, $post) {
            if ( !empty($post) && !empty($post->ID) ) {
                return $this->render_page_content($post->ID);
            }
            return $html;
        }
    }
}

if ( did_action( 'elementor/loaded' ) ) {
    // Finally initialize code
    Foogra_Elementor_Extensions::instance();
}