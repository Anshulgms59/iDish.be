<div id="apus-header-mobile" class="header-mobile d-block d-xl-none clearfix">   
    <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-3">
                    <?php if ( foogra_get_config('header_mobile_menu', true) ) { ?>
                        <a href="#navbar-offcanvas" class="btn-showmenu">
                            <i class="mobile-menu-icon"></i>
                        </a>
                    <?php } ?>
                </div>
                <div class="col-6">
                    <?php
                        $logo_url = foogra_get_config('media-mobile-logo');
                    ?>
                    <?php if( !empty($logo_url) ): ?>
                        <div class="logo text-center">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="logo logo-theme text-center">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <img src="<?php echo esc_url( get_template_directory_uri().'/images/logo.svg'); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-3 d-flex align-items-center justify-content-end">
                    
                    <?php
                        if ( foogra_get_config('header_mobile_login', true) && foogra_is_wp_listings_directory_activated() ) {
                            if ( is_user_logged_in() ) {
                                $user_id = get_current_user_id();
                                $menu_nav = 'user-menu';
                                
                                if ( !empty($menu_nav) && has_nav_menu( $menu_nav ) ) {
                                ?>
                                    <div class="top-wrapper-menu author-verify">
                                        <a class="drop-dow" href="javascript:void(0);">
                                            <div class="infor-account d-flex align-items-center">
                                                <div class="avatar-wrapper">
                                                    <?php echo foogra_get_avatar($user_id, 40); ?>
                                                </div>
                                            </div>
                                        </a>
                                        <?php
                                            
                                            $args = array(
                                                'theme_location' => $menu_nav,
                                                'container_class' => 'inner-top-menu',
                                                'menu_class' => 'nav navbar-nav topmenu-menu',
                                                'fallback_cb' => '',
                                                'menu_id' => '',
                                                'walker' => new Foogra_Nav_Menu()
                                            );
                                            wp_nav_menu($args);
                                            
                                        ?>
                                    </div>
                                    <?php } ?>
                        <?php } else {
                            $login_page_id = wp_listings_directory_get_option('login_page_id');
                        ?>
                                <div class="top-wrapper-menu">
                                    <a class="drop-dow btn-menu-account" href="<?php echo esc_url( get_permalink( $login_page_id ) ); ?>">
                                        <i class="glyphter-sign"></i>
                                    </a>
                                </div>
                        <?php }
                    }
                    ?>

                </div>
            </div>
    </div>
</div>