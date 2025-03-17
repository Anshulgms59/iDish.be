<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <svg style="display: none;">
    <symbol id="idish-arrow" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
      <path d="M426.666667 736V597.333333H128v-170.666666h298.666667V288L650.666667 512 426.666667 736M341.333333 85.333333h384a85.333333 85.333333 0 0 1 85.333334 85.333334v682.666666a85.333333 85.333333 0 0 1-85.333334 85.333334H341.333333a85.333333 85.333333 0 0 1-85.333333-85.333334v-170.666666h85.333333v170.666666h384V170.666667H341.333333v170.666666H256V170.666667a85.333333 85.333333 0 0 1 85.333333-85.333334z" />
    </symbol>
  </svg>


  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid px-lg-4 m-auto col-md-10">

        <!-- Logo Section -->
        <?php if (has_custom_logo()) : ?>
          <?php the_custom_logo(); ?>
        <?php else : ?>
          <a class="navbar-brand" href="<?php echo home_url(); ?>">Idish</a>
        <?php endif; ?>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Offcanvas Menu -->
        <div class="offcanvas offcanvas-start" id="offcanvasNavbar" tabindex="-1" aria-labelledby="offcanvasNavbarLabel">



          <!-- Offcanvas Header -->
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?php echo has_custom_logo() ? get_custom_logo() . 'Menu' : ''; ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <!-- Offcanvas Body with Menu -->
          <div class="offcanvas-body justify-content-end align-items-center">

            <?php
            wp_nav_menu(array(
              'theme_location'  => 'foogra-menu', // Ensure this is registered in functions.php
              'container'       => 'div',
              'container_class' => 'foogra-nav',
              'menu_class'      => 'foogra-menu-list d-flex flex-column flex-md-row list-unstyled gap-3 custom-li-class mb-0 text-dark fw-medium',
            ));
            ?>

            <?php if (!is_user_logged_in()) : ?>
              <button type="button" class="btn btn-primary mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#signInModal">
                Sign in
                <svg class="svg-icon" style="width: 1em; height: 1em; fill: currentColor;">
                  <use href="#idish-arrow"></use>
                </svg>
              </button>
            <?php else : ?>
              <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-danger mt-3 mt-md-0">
                Logout
              </a>
            <?php endif; ?>

          </div>



        </div>

      </div>
    </nav>



    <!-- Sign In Modal -->
    <div class="modal fade" id="signInModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">

          <!-- Modal Header -->
          <div class="modal-header">
            <h5 class="modal-title fs-5" id="signInModalLabel">Sign In</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body">
            <form class="p-3 small" method="POST" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">

              <!-- Username or Email -->
              <div class="mb-3">
                <input type="text" class="form-control shadow-none" name="log" placeholder="Username or Email" required>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <input type="password" class="form-control shadow-none" name="pwd" placeholder="Password" required>
              </div>

              <!-- Links: Sign Up & Forgot Password -->
              <div class="d-flex justify-content-between mb-4">
                <small>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#idishSignUp">Sign Up</a></small>
                <small><a href="#" data-bs-toggle="modal" data-bs-target="#idishForgot">Forgot Password?</a></small>
              </div>

              <!-- Submit Button -->
              <div class="text-center">
                <button class="btn btn-success w-100" type="submit" name="signIn">Sign In</button>
              </div>

              <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>

            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Sign Up Modal -->
    <div class="modal fade" id="idishSignUp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="signUpLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">

          <!-- Modal Header -->
          <div class="modal-header">
            <h5 class="modal-title fs-5" id="signUpLabel">Sign Up</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body">
            <!-- Error Message Area -->
            <div id="signup-error" style="color: red; font-size: 14px; margin-bottom: 10px;"></div>

            <!-- Sign Up Form -->
            <form id="signup-form" class="p-3 small">

              <!-- Full Name -->
              <div class="mb-3">
                <input type="text" class="form-control shadow-none" name="full_name" placeholder="Full Name" required>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <input type="email" class="form-control shadow-none" name="email" placeholder="Email" required>
              </div>

              <!-- Username -->
              <div class="mb-3">
                <input type="text" class="form-control shadow-none" name="username" placeholder="Username" required>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <input type="password" class="form-control shadow-none" name="password" placeholder="Password" required>
              </div>

              <!-- Confirm Password -->
              <div class="mb-3">
                <input type="password" class="form-control shadow-none" name="confirm_password" placeholder="Confirm Password" required>
              </div>

              <!-- Sign In Link -->
              <div class="d-flex justify-content-between mb-4">
                <small>Already have an account?
                  <a href="#" id="signInModalBtn" data-bs-toggle="modal" data-bs-target="#signInModal">Sign In</a>
                </small>
              </div>

              <!-- Submit Button -->
              <div class="text-center">
                <button class="btn btn-success" type="submit">Sign Up</button>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="idishForgot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="forgotLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">

          <!-- Modal Header -->
          <div class="modal-header">
            <h5 class="modal-title fs-5" id="forgotLabel">Forgot Password</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body">

            <!-- Error Message Area -->
            <div id="forgot-error" style="color: red; font-size: 14px; margin-bottom: 10px;"></div>
            
            <?php
            /*
            <!-- Forgot Password Form -->
            <form id="forgot-form" class="p-3 small">

              <!-- Email Input -->
              <div class="mb-3">
                <input type="email" class="form-control shadow-none" name="user_email" placeholder="Enter your email address" required>
              </div>

              <!-- Submit Button -->
              <div class="text-center">
                <button class="btn btn-success" type="submit">Reset Password</button>
              </div>

            </form>
            */
            ?>
            
            <!-- Forgot Password Form -->
            <form method="POST" action="<?php echo esc_url(site_url('wp-login.php?action=lostpassword')); ?>" class="p-3 small">
                <div class="mb-3">
                    <input type="email" class="form-control shadow-none" name="user_login" placeholder="Enter your email address" required>
                </div>
                <div class="text-center">
                    <button class="btn btn-success" type="submit">Reset Password</button>
                </div>
            </form>


          </div>
        </div>
      </div>
    </div>



  </header>