<div id="apus-mobile-menu" class="apus-offcanvas d-block d-xl-none"> 
    <div class="apus-offcanvas-body flex-column d-flex">
            <div class="header-offcanvas">
                <div class="container">
                    <div class="d-flex align-items-center">
                        <?php
                            $logo_url = foogra_get_config('media-mobile-logo');
                        ?>
                        <?php if( isset($logo_url) && !empty($logo_url) ): ?>
                            <div class="logo">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="logo logo-theme">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" >
                                    <img src="<?php echo esc_url_raw( get_template_directory_uri().'/images/logo.svg'); ?>" alt="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="ms-auto">
                            <a class="btn-toggle-canvas" data-toggle="offcanvas">
                                <i class="icon_close"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="offcanvas-content">
                <div class="middle-offcanvas">

                    <nav id="menu-main-menu-navbar" class="navbar navbar-offcanvas" role="navigation">
                        <?php
                            $mobile_menu = 'primary';
                            $menus = get_nav_menu_locations();
                            if( !empty($menus['mobile-primary']) && wp_get_nav_menu_items($menus['mobile-primary'])) {
                                $mobile_menu = 'mobile-primary';
                            }
                            $args = array(
                                'theme_location' => $mobile_menu,
                                'container_class' => '',
                                'menu_class' => '',
                                'fallback_cb' => '',
                                'menu_id' => '',
                                'container' => 'div',
                                'container_id' => 'mobile-menu-container',
                                'walker' => new Foogra_Mobile_Menu()
                            );
                            wp_nav_menu($args);

                        ?>
                    </nav>
                </div>
            </div>

            <div class="header-offcanvas-bottom">
                <?php if ( foogra_is_wp_listings_directory_activated() && foogra_get_config('header_mobile_add_listing_btn', true) ) {
                    $page_id = wp_listings_directory_get_option('submit_listing_form_page_id');
                    $page_id = WP_Listings_Directory_Mixes::get_lang_post_id($page_id, 'page');
                ?>
                    <div class="submit-job">
                        <a class="btn btn-theme btn-sm w-100" href="<?php echo esc_url( get_permalink( $page_id ) ); ?>"><?php esc_html_e('+ Add Listing','foogra') ?></a>
                    </div>
                <?php } ?>
            </div>
    </div>
</div>
<div class="over-dark"></div>