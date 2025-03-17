<?php
/**
 * foogra functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Foogra
 * @since Foogra 1.0.20
 */

define( 'FOOGRA_THEME_VERSION', '1.0.20' );
define( 'FOOGRA_DEMO_MODE', false );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

if ( ! function_exists( 'foogra_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Foogra 1.0
 */
function foogra_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on foogra, use a find and replace
	 * to change 'foogra' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'foogra', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
	add_image_size( 'foogra-listing-list', 610, 200, true );
	add_image_size( 'foogra-listing-grid', 580, 380, true );

	add_image_size( 'foogra-gallery-large', 824, 450, true );
	add_image_size( 'foogra-gallery-full', 1920, 470, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'foogra' ),
		'mobile-primary' => esc_html__( 'Primary Mobile Menu', 'foogra' ),
		'user-menu' => esc_html__( 'User Account Menu', 'foogra' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_theme_support( "woocommerce", array('gallery_thumbnail_image_width' => 410) );
	
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = foogra_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'foogra_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Enqueue editor styles.
	add_editor_style('css/style-editor.css');

	foogra_get_load_plugins();
}
endif; // foogra_setup
add_action( 'after_setup_theme', 'foogra_setup' );

/**
 * Load Google Front
 */
function foogra_get_fonts_url() {
    $fonts_url = '';

    $main_font = foogra_get_config('main-font');
	$main_font = !empty($main_font) ? json_decode($main_font, true) : array();
	if (  !empty($main_font['fontfamily']) ) {
		$main_font_family = $main_font['fontfamily'];
		$main_font_weight = !empty($main_font['fontweight']) ? $main_font['fontweight'] : '300,400,500,600,700,800,900';
		$main_font_subsets = !empty($main_font['subsets']) ? $main_font['subsets'] : 'latin,latin-ext';
	} else {
		$main_font_family = 'Poppins';
		$main_font_weight = '300,400,500,600,700,800,900';
		$main_font_subsets = 'latin,latin-ext';
	}

	$heading_font = foogra_get_config('heading-font');
	$heading_font = !empty($heading_font) ? json_decode($heading_font, true) : array();
	if (  !empty($heading_font['fontfamily']) ) {
		$heading_font_family = $heading_font['fontfamily'];
		$heading_font_weight = !empty($heading_font['fontweight']) ? $heading_font['fontweight'] : '300,400,500,600,700,800,900';
		$heading_font_subsets = !empty($heading_font['subsets']) ? $heading_font['subsets'] : 'latin,latin-ext';
	} else {
		$heading_font_family = 'Poppins';
		$heading_font_weight = '300,400,500,600,700,800,900';
		$heading_font_subsets = 'latin,latin-ext';
	}

	if ( $main_font_family == $heading_font_family ) {
		$font_weight = $main_font_weight.','.$heading_font_weight;
		$font_subsets = $main_font_subsets.','.$heading_font_subsets;
		$fonts = array(
			$main_font_family => array(
				'weight' => $font_weight,
				'subsets' => $font_subsets,
			),
		);
	} else {
		$fonts = array(
			$main_font_family => array(
				'weight' => $main_font_weight,
				'subsets' => $main_font_subsets,
			),
			$heading_font_family => array(
				'weight' => $heading_font_weight,
				'subsets' => $heading_font_subsets,
			),
		);
	}

	$font_families = array();
	$subset = array();

	foreach ($fonts as $key => $opt) {
		$font_families[] = $key.':'.$opt['weight'];
		$subset[] = $opt['subsets'];
	}



    $query_args = array(
        'family' => implode( '|', $font_families ),
        'subset' => urlencode( implode( ',', $subset ) ),
    );
		
		$protocol = is_ssl() ? 'https:' : 'http:';
    $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    
 
    return esc_url( $fonts_url );
}

/**
 * Enqueue styles.
 *
 * @since Foogra 1.0
 */
function foogra_enqueue_styles() {
	
	// load font
	wp_enqueue_style( 'foogra-theme-fonts', foogra_get_fonts_url(), array(), null );

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );

	//load font icon
	wp_enqueue_style( 'foogra-icons', get_template_directory_uri() . '/css/icons.css', array(), '1.0.0' );
			
	// load animate version 3.6.0
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), '3.6.0' );

	// load bootstrap style
	if( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap.rtl.css', array(), '5.0.2' );
	} else {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '5.0.2' );
	}
	// slick
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css', array(), '1.8.0' );
	// magnific-popup
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', array(), '1.1.0' );
	// perfect scrollbar
	wp_enqueue_style( 'perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', array(), '0.6.12' );
	
	// mobile menu
	wp_enqueue_style( 'sliding-menu', get_template_directory_uri() . '/css/sliding-menu.min.css', array(), '0.3.0' );

	// main style
	if( is_rtl() ){
		wp_enqueue_style( 'foogra-template', get_template_directory_uri() . '/css/template.rtl.css', array(), '1.0' );
	} else {
		wp_enqueue_style( 'foogra-template', get_template_directory_uri() . '/css/template.css', array(), '1.0' );
	}
	
	$custom_style = foogra_custom_styles();
	if ( !empty($custom_style) ) {
		wp_add_inline_style( 'foogra-template', $custom_style );
	}
	wp_enqueue_style( 'foogra-style', get_template_directory_uri() . '/style.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'foogra_enqueue_styles', 100 );

function foogra_admin_enqueue_styles() {

	// load font
	wp_enqueue_style( 'foogra-theme-fonts', foogra_get_fonts_url(), array(), null );

	//load font awesome
	wp_enqueue_style( 'all-awesome', get_template_directory_uri() . '/css/all-awesome.css', array(), '5.11.2' );

	//load font icon
	wp_enqueue_style( 'foogra-icons', get_template_directory_uri() . '/css/icons.css', array(), '1.0.0' );

}
add_action( 'admin_enqueue_scripts', 'foogra_admin_enqueue_styles', 100 );

function foogra_login_enqueue_styles() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.5.0' );
	wp_enqueue_style( 'foogra-login-style', get_template_directory_uri() . '/css/login-style.css', array(), '1.0' );
}
add_action( 'login_enqueue_scripts', 'foogra_login_enqueue_styles', 10 );
/**
 * Enqueue scripts.
 *
 * @since Foogra 1.0
 */
function foogra_enqueue_scripts() {
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// bootstrap
	wp_enqueue_script( 'bootstrap-bundle', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array( 'jquery' ), '5.0.2', true );
	// slick
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.8.0', true );
	// countdown
	wp_register_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array( 'jquery' ), '20150315', true );
	wp_localize_script( 'countdown', 'foogra_countdown_opts', array(
		'days' => esc_html__('Days', 'foogra'),
		'hours' => esc_html__('Hrs', 'foogra'),
		'mins' => esc_html__('Mins', 'foogra'),
		'secs' => esc_html__('Secs', 'foogra'),
	));
	
	// popup
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
	// unviel
	wp_enqueue_script( 'jquery-unveil', get_template_directory_uri() . '/js/jquery.unveil.js', array( 'jquery' ), '1.1.0', true );
	
	// perfect scrollbar
	wp_enqueue_script( 'perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.min.js', array( 'jquery' ), '1.5.0', true );
	
	if ( foogra_get_config('keep_header') ) {
		wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/sticky.min.js', array( 'jquery', 'elementor-waypoints' ), '4.0.1', true );
	}

	// mobile menu script
	wp_enqueue_script( 'sliding-menu', get_template_directory_uri() . '/js/sliding-menu.min.js', array( 'jquery' ), '0.3.0', true );

	// main script
	wp_register_script( 'foogra-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'foogra-functions', 'foogra_opts', array(
		'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
		'previous' => esc_html__('Previous', 'foogra'),
		'next' => esc_html__('Next', 'foogra'),
		'menu_back_text' => esc_html__('Back', 'foogra')
	));
	wp_enqueue_script( 'foogra-functions' );
	
	wp_add_inline_script( 'foogra-functions', "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_enqueue_scripts', 'foogra_enqueue_scripts', 1 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Foogra 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function foogra_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'foogra_search_form_modify' );


function foogra_get_config($name, $default = '') {
	global $foogra_theme_options;
	
	if ( empty($foogra_theme_options) ) {
		$foogra_theme_options = get_option('foogra_theme_options');
	}

    if ( isset($foogra_theme_options[$name]) ) {
        return $foogra_theme_options[$name];
    }
    return $default;
}

function foogra_set_exporter_ocdi_settings_option_keys($option_keys) {
	return array(
		'foogra_theme_options',
		'elementor_disable_color_schemes',
		'elementor_disable_typography_schemes',
		'elementor_allow_tracking',
		'elementor_cpt_support',
		'wp_listings_directory_settings',
		'wp_listings_directory_fields_data',
	);
}
add_filter( 'apus_exporter_ocdi_settings_option_keys', 'foogra_set_exporter_ocdi_settings_option_keys' );

function foogra_disable_one_click_import() {
	return false;
}
add_filter('apus_frammework_enable_one_click_import', 'foogra_disable_one_click_import');

function foogra_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Default', 'foogra' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'foogra' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Listings filter sidebar', 'foogra' ),
		'id'            => 'listings-filter',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'foogra' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Listings filter Top', 'foogra' ),
		'id'            => 'listings-filter-top',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'foogra' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Listings filter Top Map', 'foogra' ),
		'id'            => 'listings-filter-top-map',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'foogra' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Listing single sidebar', 'foogra' ),
		'id'            => 'listing-single-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'foogra' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );


	register_sidebar( array(
		'name'          => esc_html__( 'User Profile sidebar', 'foogra' ),
		'id'            => 'user-profile-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'foogra' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Blog sidebar', 'foogra' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'foogra' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop sidebar', 'foogra' ),
		'id'            => 'shop-sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'foogra' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

}
add_action( 'widgets_init', 'foogra_widgets_init' );

function foogra_get_load_plugins() {
	$plugins[] = array(
		'name'                     => esc_html__( 'Apus Framework For Themes', 'foogra' ),
        'slug'                     => 'apus-frame',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/apus-frame.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Elementor Page Builder', 'foogra' ),
	    'slug'                     => 'elementor',
	    'required'                 => true,
	);
	
	$plugins[] = array(
		'name'                     => esc_html__( 'Revolution Slider', 'foogra' ),
        'slug'                     => 'revslider',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/revslider.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Cmb2', 'foogra' ),
	    'slug'                     => 'cmb2',
	    'required'                 => true,
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'MailChimp for WordPress', 'foogra' ),
	    'slug'                     => 'mailchimp-for-wp',
	    'required'                 =>  true
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'Contact Form 7', 'foogra' ),
	    'slug'                     => 'contact-form-7',
	    'required'                 => true,
	);

	// woocommerce plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'Woocommerce', 'foogra' ),
	    'slug'                     => 'woocommerce',
	    'required'                 => true,
	);
	
	// Listing plugins
	$plugins[] = array(
		'name'                     => esc_html__( 'WP Listings Directory', 'foogra' ),
        'slug'                     => 'wp-listings-directory',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-listings-directory.zip'
	);

	$plugins[] = array(
		'name'                     => esc_html__( 'WP Listings Directory - WooCommerce Paid Listings', 'foogra' ),
        'slug'                     => 'wp-listings-directory-wc-paid-listings',
        'required'                 => true ,
        'source'				   => get_template_directory() . '/inc/plugins/wp-listings-directory-wc-paid-listings.zip'
	);
	
	$plugins[] = array(
        'name'                  => esc_html__( 'One Click Demo Import', 'foogra' ),
        'slug'                  => 'one-click-demo-import',
        'required'              => false,
    );

	tgmpa( $plugins );
}

require get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';
get_template_part( '/inc/functions-helper' );
get_template_part( '/inc/functions-frontend' );

/**
 * Implement the Custom Header feature.
 *
 */
get_template_part( '/inc/custom-header' );
get_template_part( '/inc/classes/megamenu' );
get_template_part( '/inc/classes/mobilemenu' );

/**
 * Custom template tags for this theme.
 *
 */
get_template_part( '/inc/template-tags' );

/**
 * Customizer additions.
 *
 */
get_template_part( '/inc/customizer/font/custom-controls' );
get_template_part( '/inc/customizer/customizer-custom-control' );
get_template_part( '/inc/customizer/customizer' );


if( foogra_is_cmb2_activated() ) {
	get_template_part( '/inc/vendors/cmb2/page' );
}

if( foogra_is_woocommerce_activated() ) {
	get_template_part( '/inc/vendors/woocommerce/functions' );
	get_template_part( '/inc/vendors/woocommerce/customizer' );
}

if( foogra_is_wp_listings_directory_activated() ) {
	get_template_part( '/inc/vendors/wp-listings-directory/customizer' );
	get_template_part( '/inc/vendors/wp-listings-directory/functions' );

	get_template_part( '/inc/vendors/wp-listings-directory/functions-listing-display' );
}

if ( foogra_is_wp_listings_directory_wc_paid_listings_activated() ) {
	get_template_part( '/inc/vendors/wp-listings-directory-wc-paid-listings/functions' );
}

function foogra_register_load_widget() {
	get_template_part( '/inc/widgets/custom_menu' );
	get_template_part( '/inc/widgets/recent_post' );
	get_template_part( '/inc/widgets/search' );
	
	get_template_part( '/inc/widgets/elementor-template' );
	
	if ( foogra_is_wp_listings_directory_activated() ) {
		
		get_template_part( '/inc/widgets/listing-list' );
		get_template_part( '/inc/widgets/user-short-profile' );
		
		get_template_part( '/inc/widgets/contact-form' );

		// listing details
		get_template_part( '/inc/widgets/listing-contact-form' );
		get_template_part( '/inc/widgets/listing-author' );
		get_template_part( '/inc/widgets/listing-categories' );
		get_template_part( '/inc/widgets/listing-contact-info' );
		get_template_part( '/inc/widgets/listing-hours' );
		get_template_part( '/inc/widgets/listing-price' );
		
		get_template_part( '/inc/widgets/author-contact-info' );
		get_template_part( '/inc/widgets/author-description' );
		
		if ( foogra_is_wp_private_message() ) {
			get_template_part( '/inc/widgets/private-message-form' );
		}
	}
}
add_action( 'widgets_init', 'foogra_register_load_widget' );

if ( foogra_is_wp_private_message() ) {
	get_template_part( '/inc/vendors/wp-private-message/functions' );
}

get_template_part( '/inc/vendors/elementor/functions' );
get_template_part( '/inc/vendors/one-click-demo-import/functions' );


/**
 * Custom Styles
 *
 */
get_template_part( '/inc/custom-styles' );



/*  Shortcode For Map 17 March 2025  */

function food_dish_finder_enqueue_scripts()
{
    // Custom Styles
    wp_enqueue_style('food-dish-finder-css', get_stylesheet_directory_uri() . '/assets/css/food-dish-finder.css', array(), wp_get_theme()->get('Version'));

    // Custom JS
    wp_enqueue_script('food-dish-finder-js', get_stylesheet_directory_uri() . '/assets/js/food-dish-finder.js', array('jquery'), wp_get_theme()->get('Version'), true);

    // Add Google Maps API
    wp_enqueue_script('google-maps-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyC5zdCNSYZMqOf89qVIKir4MKXcRsOjwww&libraries=marker', null, null, true);
}
add_action('wp_enqueue_scripts', 'food_dish_finder_enqueue_scripts');

// Add a shortcode for the image upload form and Google Map
function food_dish_finder_shortcode()
{
    ob_start();
?>

    <div class="container-fluid p-0 m-0">
        <div id="map" style="height: 350px; width: 100%;"></div>
    </div>


    <div class="container-fluid">
        <div class="container py-4">
            <!--<h2 class="text-center fw-bold">Upload a Food Dish Image</h2>-->
            <hr class="">

            <div class="d-flex justify-content-center align-items-center mb-3">
                <select id="citySelect" class="form-control  shadow-none w-75 mx-1">
                    <option value="brussels">Brussels</option>
                    <option value="belgium">Belgium</option>
                </select>
            </div>
            <div class="d-flex justify-content-center align-items-center my-2">
                <input type="text" class="form-control w-75 mx-1 shadow-none" id="dish_name" readonly="" style="display:none;">
            </div>


            <div class="d-flex justify-content-center align-items-center mb-3">
                <button class="btn btn-dark mx-1 shadow-none" id="uploadFileModalBtn" data-bs-toggle="modal" data-bs-target="#uploadFileModal">Upload File</button>
                <button class="btn btn-primary mx-1 shadow-none" id="takePhotoModalBtn" data-bs-toggle="modal" data-bs-target="#takePhotoModal">Take Photo</button>
            </div>

            <!-- ////////////////////////////////////////////////// Modal /////////////////////////////////////////// -->
            <!-- ////////////////////////////////////////////////// Modal /////////////////////////////////////////// -->
            <!-- ////////////////////////////////////////////////// Modal /////////////////////////////////////////// -->

            <div class="modal fade" id="uploadFileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">

                        <div class="modal-body">

                            <!-- Loader (Initially Hidden) -->
                            <div class="photo-loader-main text-center" id="upload-loader" style="display:none;">
                                <div class="">
                                    <i class="fa-solid fa-spinner fa-spin" id="upload-loader-icon"></i>
                                    <p class="text-center text-white mt-2" style="font-size: 12px;">Please Wait...</p>
                                </div>

                            </div>

                            <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
                                <div class="form-row my-3">
                                    <div class="col">
                                        <input type="file" name="image" class="form-control shadow-none" accept="image/*" required id="imageFile">
                                    </div>
                                </div>


                                <hr>

                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="reset" class="btn btn-sm btn-outline-dark mx-1" style="display: none;" id="resetBTN">reset</button>
                                    <button type="button" class="btn btn-sm btn-outline-success mx-1" id="searchBTN">Search</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger mx-1" id="cancelBTN" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="takePhotoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="takePhotoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-0">
                        <div class="modal-body">

                            <!-- Loader (Initially Hidden) -->
                            <div class="photo-loader-main text-center" id="photo-loader" style="display:none;">
                                <div class="">
                                    <i class="fa-solid fa-spinner fa-spin" id="photo-loader-icon"></i>
                                    <p class="text-center text-white mt-2" style="font-size: 12px;">Please Wait...</p>
                                </div>

                            </div>

                            <!-- Camera Section -->
                            <div id="cameraSection" style="display:none;">
                                <video id="camera" autoplay height="350px"></video>
                                <canvas id="canvas" style="display:none;"></canvas>
                                <img id="capturedImage" style="display:none; width: 100%; height: 350px;" />
                                <form id="cameraForm" action="" method="post">
                                    <input type="hidden" name="cameraImage" id="cameraImage">
                                </form>
                            </div>

                            <hr class="m-0 mt-1 mb-3 p-0">

                            <!-- Buttons -->
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-sm btn-outline-dark mx-1" id="resetBTn" style="display:none;">Reset</button>
                                <button type="button" class="btn btn-sm btn-outline-dark mx-1" id="captureBtn">Take Photo</button>
                                <button type="button" class="btn btn-sm btn-outline-success mx-1" id="searchButton" style="display:none;">Search</button>
                                <button type="button" class="btn btn-sm btn-outline-danger mx-1" id="cancelBtn" data-bs-dismiss="modal">Cancel</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Loader Styles -->
            <style>
                #photo-loader {
                    height: 93.5% !important;
                    width: 93.7% !important;
                    background: #0000004d;
                    position: absolute;
                    overflow: hidden;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                #photo-loader-icon {
                    font-size: 50px;
                    color: #fff;
                }

                #upload-loader {
                    height: 79.5% !important;
                    width: 93.7% !important;
                    background: #0000004d;
                    position: absolute;
                    overflow: hidden;
                    display: flex;
                    justify-content: center !important;
                    align-items: center !important;
                }

                #upload-loader-icon {
                    font-size: 50px;
                    color: #fff;
                }
                
                #citySelect{
                    border-radius:20px;
                    color:#8C8C8C;
                    border: 1px solid #9AB26DA6;
                    padding: 7px;
                    position: absolute;
                    top: 70%;
                }
                
                button#uploadFileModalBtn {
                    border-radius: 30px;
                    background-color: #74AD0BA6;
                    color: #fff;
                    border: none;
                    padding: 7px 30px;
                }
                                    
                button#takePhotoModalBtn {
                    border-radius: 30px;
                    background-color: #74AD0BA6;
                    border: none;
                    padding: 7px 30px;
                }
            </style>

            <script>
                jQuery(document).ready(function($) {

                    const video = $('#camera')[0];
                    const canvas = $('#canvas')[0];
                    const cameraImage = $('#cameraImage');
                    const capturedImage = $('#capturedImage');
                    const searchButton = $('#searchButton');
                    const resetButton = $('#resetBTn');
                    const cancelButton = $('#cancelBtn');
                    const captureButton = $('#captureBtn');
                    const cameraSection = $('#cameraSection');
                    const loader = $('#photo-loader');
                    const loadertwo = $('#upload-loader');

                    let map;
                    let markers = [];


                    // Initialize Google Map
                    function initMap() {
                        map = new google.maps.Map(document.getElementById("map"), {
                            center: {
                                lat: 50.8503,
                                lng: 4.3517
                            }, // Default center (Brussels, Belgium)
                            zoom: 10,
                            disableDefaultUI: true,
                            zoomControl: true
                        });
                    }


                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    const serachBTN = $('#searchBTN');
                    //$('#uploadFileModal').modal('show');


                    // Handle image upload and send to server
                    $('#searchBTN').on('click', function(e) {
                        e.preventDefault();
                        const file = $('#imageFile')[0].files[0];
                        const city = $('#citySelect').val(); // Get selected city

                        if (!file) {
                            alert('Please upload an image.');
                            $('#resetBTN').hide();
                            return;
                        }

                        $('#resetBTN').show();
                        $('#upload-loader').show();


                        const formData = new FormData();
                        formData.append('image', file);
                        formData.append('city', city); // Append selected city to the data
                        formData.append('action', 'food_dish_finder_upload');

                        var ajaxRequestOne = $.ajax({
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response) {
                                // Hide the loader when the request is complete
                                $('#upload-loader').hide();
                                $('#uploadForm').trigger('reset');
                                $('#uploadFileModal').modal('hide');
                                $('#map').show();

                                if (response.success) {

                                    $('#dish_name').val(response.data.dishName);
                                    $('#dish_name').show();

                                    // Remove all existing markers
                                    markers.forEach(marker => marker.setMap(null));
                                    markers = [];

                                    // Create new markers for locations returned by the server
                                    if (response.data.locations.length > 0) {
                                        const firstLocation = response.data.locations[0];
                                        const firstPosition = {
                                            lat: firstLocation.lat,
                                            lng: firstLocation.lng
                                        };

                                        // Adjust map to center and zoom on the first marker
                                        map.setCenter(firstPosition);
                                        map.setZoom(12); // Zoom in for better visibility

                                        response.data.locations.forEach(location => {
                                            const customIcon = {
                                                url: '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/spoon_fog_icon_red.png', // Path to your custom icon
                                                size: new google.maps.Size(32, 32), // Size of the icon
                                                scaledSize: new google.maps.Size(32, 32), // Scaled size if needed
                                                origin: new google.maps.Point(0, 0), // Origin of the image
                                                anchor: new google.maps.Point(16, 32) // Anchor point to position the icon
                                            };

                                            const marker = new google.maps.Marker({
                                                position: {
                                                    lat: location.lat,
                                                    lng: location.lng
                                                },
                                                map: map,
                                                title: location.name,
                                                icon: customIcon // Set the custom icon here
                                            });

                                            // Create a Bootstrap Card layout for the InfoWindow
                                            const infoWindowContent = `
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">${location.name}</h5>
                                                <p class="card-text">
                                                    ${location.formatted_address}<br>
                                                    Rating: ${location.rating}<br>
                                                    Total Reviews: ${location.user_ratings_total}
                                                </p>
                                            </div>
                                        </div>
                                    `;

                                            const infowindow = new google.maps.InfoWindow({
                                                content: infoWindowContent
                                            });

                                            // Add event listener to open the info window when the marker is clicked
                                            marker.addListener('click', function() {
                                                infowindow.open(map, marker);
                                            });

                                            markers.push(marker);
                                        });
                                    } else {
                                        alert('No restaurants found');
                                    }
                                } else {
                                    alert(response.data);
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#upload-loader').hide();
                                console.error(error);
                            }
                        });


                        $('#cancelBTN').click(function() {
                            if (ajaxRequestOne) {
                                ajaxRequestOne.abort();
                                console.log('AJAX request aborted.');
                            }
                        });
                    });




                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    function showCamera() {
                        cameraSection.show();
                        captureButton.show();
                        navigator.mediaDevices.getUserMedia({
                                video: {
                                    facingMode: {
                                        exact: 'environment'
                                    }
                                }
                            })
                            .then(stream => {
                                video.srcObject = stream;
                                $(video).show();
                            })
                            .catch(() => {
                                navigator.mediaDevices.getUserMedia({
                                        video: {
                                            facingMode: 'user'
                                        }
                                    })
                                    .then(stream => {
                                        video.srcObject = stream;
                                        $(video).show();
                                    })
                                    .catch(err => console.error('Camera access denied:', err));
                            });
                    }

                    function stopCamera() {
                        if (video.srcObject) {
                            video.srcObject.getTracks().forEach(track => track.stop());
                            video.srcObject = null;
                        }
                        $(video).hide();
                    }

                    function takePhoto() {
                        const context = canvas.getContext('2d');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);
                        const imageDataURL = canvas.toDataURL('image/png');
                        cameraImage.val(imageDataURL);
                        capturedImage.attr('src', imageDataURL).show();
                        searchButton.show();
                        resetButton.show();
                        captureButton.hide(); // Hide "Take Photo" button after capture

                        stopCamera();
                    }

                    function resetPhoto() {
                        capturedImage.hide().attr('src', '');
                        cameraImage.val('');
                        searchButton.hide();
                        resetButton.hide();
                        captureButton.show(); // Show "Take Photo" button on reset
                        showCamera();
                    }

                    function cancelProcess() {
                        stopCamera();
                        cameraSection.hide();
                        capturedImage.hide();
                        searchButton.hide();
                        resetButton.hide();
                        captureButton.show(); // Show "Take Photo" button on cancel
                        loader.hide(); // Ensure loader is hidden on cancel
                    }

                    $('#takePhotoModalBtn').click(function() {
                        showCamera();
                    });

                    $('#captureBtn').click(function() {
                        takePhoto();
                    });

                    $('#resetBTn').click(function() {
                        resetPhoto();
                    });

                    $('#cancelBtn').click(function() {
                        cancelProcess();
                    });

                    $('#searchButton').click(function() {
                        var cameraImageVal = $('#cameraImage').val();
                        var city = $('#citySelect').val();


                        if (cameraImageVal == '') {
                            alert('Captured image not found.');
                        } else {
                            loader.show();

                            var ajaxRequestTwo = $.ajax({
                                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                                type: 'post',
                                data: {
                                    'action': 'food_dish_finder_with_photo',
                                    'image': cameraImageVal,
                                    'city': city
                                },
                                success: function(response) {
                                    //alert('Image processed successfully');
                                    loader.hide();
                                    // resetPhoto();
                                    cancelProcess();

                                    $('#takePhotoModal').modal('hide');

                                    $('#map').show();

                                    if (response.success) {

                                        $('#dish_name').val(response.data.dishName);
                                        $('#dish_name').show();

                                        // Remove all existing markers
                                        markers.forEach(marker => marker.setMap(null));
                                        markers = [];

                                        // Create new markers for locations returned by the server
                                        if (response.data.locations.length > 0) {
                                            const firstLocation = response.data.locations[0];
                                            const firstPosition = {
                                                lat: firstLocation.lat,
                                                lng: firstLocation.lng
                                            };


                                            // console.log(response.data.locations);


                                            // Adjust map to center and zoom on the first marker
                                            map.setCenter(firstPosition);
                                            map.setZoom(12); // Zoom in for better visibility

                                            response.data.locations.forEach(location => {

                                                const customIcon = {
                                                    url: '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/spoon_fog_icon_red.png', // Path to your custom icon
                                                    size: new google.maps.Size(32, 32), // Size of the icon
                                                    scaledSize: new google.maps.Size(32, 32), // Scaled size if needed
                                                    origin: new google.maps.Point(0, 0), // Origin of the image
                                                    anchor: new google.maps.Point(16, 32) // Anchor point to position the icon
                                                };

                                                const marker = new google.maps.Marker({
                                                    position: {
                                                        lat: location.lat,
                                                        lng: location.lng
                                                    },
                                                    map: map,
                                                    title: location.name,
                                                    icon: customIcon // Set the custom icon here
                                                });

                                                // Create a Bootstrap Card layout for the InfoWindow
                                                const infoWindowContent = `
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">${location.name}</h5>
                                                <p class="card-text">
                                                    ${location.formatted_address}<br>
                                                    Rating: ${location.rating}<br>
                                                    Total Reviews: ${location.user_ratings_total}
                                                </p>
                                            </div>
                                        </div>
                                    `;

                                                const infowindow = new google.maps.InfoWindow({
                                                    content: infoWindowContent
                                                });

                                                // Add event listener to open the info window when the marker is clicked
                                                marker.addListener('click', function() {
                                                    infowindow.open(map, marker);
                                                });

                                                markers.push(marker);
                                            });
                                        } else {
                                            // Show  message
                                            alert("No restaurants found");
                                        }
                                    } else {
                                        alert(response.data) // Show message if there is an error or no data
                                    }


                                },
                                error: function() {
                                    alert('Error processing image.');
                                    loader.hide(); // Hide loader in case of error
                                }
                            });



                            $('#cancelBtn').click(function() {
                                if (ajaxRequestTwo) {
                                    ajaxRequestTwo.abort();
                                    console.log('AJAX request aborted.');
                                }
                            });




                        }
                    });

                    // Initialize the map once the script is loaded
                    window.addEventListener('load', initMap);

                });
            </script>


        </div>
    </div>

<?php
    return ob_get_clean();
}
add_shortcode('food_dish_finder', 'food_dish_finder_shortcode');

// AJAX handler for image upload
add_action('wp_ajax_food_dish_finder_with_photo', 'food_dish_finder_with_photo_callback');
add_action('wp_ajax_nopriv_food_dish_finder_with_photo', 'food_dish_finder_with_photo_callback');

function food_dish_finder_with_photo_callback()
{
    $cameraImage = isset($_POST['image']) ? sanitize_text_field($_POST['image']) : '';
    $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : 'brussels';

    $imageData = null;
    if (isset($cameraImage) && !empty($cameraImage)) {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $cameraImage));
    }

    if ($imageData) {
        $client = new ImageAnnotatorClient();
        $image = (new Image())->setContent($imageData);

        // First, check if the image contains food using LABEL_DETECTION
        $foodFeature = (new Feature())->setType(Feature\Type::LABEL_DETECTION);
        $request = (new AnnotateImageRequest())
            ->setImage($image)
            ->setFeatures([$foodFeature]);

        $batchRequest = new BatchAnnotateImagesRequest();
        $batchRequest->setRequests([$request]);
        $response = $client->batchAnnotateImages($batchRequest);

        $labelDetection = $response->getResponses()[0]->getLabelAnnotations();

        $isFoodDetected = false;
        $dishName = "Unknown";

        // Loop through label detection results to check if any labels relate to food
        foreach ($labelDetection as $label) {
            $description = strtolower($label->getDescription());
            if (strpos($description, 'food') !== false || strpos($description, 'dish') !== false || strpos($description, 'meal') !== false) {
                $isFoodDetected = true;
                break;
            }
        }

        if ($isFoodDetected) {
            // If food is detected, proceed to detect the dish name using WEB_DETECTION
            $webFeature = (new Feature())->setType(Feature\Type::WEB_DETECTION);
            $requestWeb = (new AnnotateImageRequest())
                ->setImage($image)
                ->setFeatures([$webFeature]);

            $batchRequestWeb = new BatchAnnotateImagesRequest();
            $batchRequestWeb->setRequests([$requestWeb]);
            $responseWeb = $client->batchAnnotateImages($batchRequestWeb);

            $webDetection = $responseWeb->getResponses()[0]->getWebDetection();

            if ($webDetection && $webDetection->getWebEntities()) {
                foreach ($webDetection->getWebEntities() as $entity) {
                    if (!empty($entity->getDescription())) {
                        $dishName = htmlspecialchars($entity->getDescription());
                        break;
                    }
                }
            }

            // echo "<h3>Detected Dish:</h3><p>" . $dishName . "</p>";

            // Get restaurants based on the detected dish name in Brussels
            $locations = getRestaurantsByDish($dishName, $city);
            wp_send_json_success([
                'locations' => $locations,
                'dishName'  => $dishName
            ]);
        } else {
            wp_send_json_error('The uploaded image does not appear to be food. Please upload a valid food image.');
        }

        $client->close();
    }


    wp_die();
}


// AJAX handler for image upload
add_action('wp_ajax_food_dish_finder_upload', 'food_dish_finder_image_upload');
add_action('wp_ajax_nopriv_food_dish_finder_upload', 'food_dish_finder_image_upload');

// Handle the image upload and process the dish recognition
function food_dish_finder_image_upload()
{
    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {

        $city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : 'brussels';

        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageData = file_get_contents($imageTmpPath);


        if ($imageData) {
            $client = new ImageAnnotatorClient();
            $image = (new Image())->setContent($imageData);

            // First, check if the image contains food using LABEL_DETECTION
            $foodFeature = (new Feature())->setType(Feature\Type::LABEL_DETECTION);
            $request = (new AnnotateImageRequest())
                ->setImage($image)
                ->setFeatures([$foodFeature]);

            $batchRequest = new BatchAnnotateImagesRequest();
            $batchRequest->setRequests([$request]);
            $response = $client->batchAnnotateImages($batchRequest);

            $labelDetection = $response->getResponses()[0]->getLabelAnnotations();

            $isFoodDetected = false;
            $dishName = "Unknown";

            // Loop through label detection results to check if any labels relate to food
            foreach ($labelDetection as $label) {
                $description = strtolower($label->getDescription());
                if (strpos($description, 'food') !== false || strpos($description, 'dish') !== false || strpos($description, 'meal') !== false) {
                    $isFoodDetected = true;
                    break;
                }
            }

            if ($isFoodDetected) {
                // If food is detected, proceed to detect the dish name using WEB_DETECTION
                $webFeature = (new Feature())->setType(Feature\Type::WEB_DETECTION);
                $requestWeb = (new AnnotateImageRequest())
                    ->setImage($image)
                    ->setFeatures([$webFeature]);

                $batchRequestWeb = new BatchAnnotateImagesRequest();
                $batchRequestWeb->setRequests([$requestWeb]);
                $responseWeb = $client->batchAnnotateImages($batchRequestWeb);

                $webDetection = $responseWeb->getResponses()[0]->getWebDetection();

                if ($webDetection && $webDetection->getWebEntities()) {
                    foreach ($webDetection->getWebEntities() as $entity) {
                        if (!empty($entity->getDescription())) {
                            $dishName = htmlspecialchars($entity->getDescription());
                            break;
                        }
                    }
                }

                // echo "<h3>Detected Dish:</h3><p>" . $dishName . "</p>";

                // Get restaurants based on the detected dish name in Brussels
                $locations = getRestaurantsByDish($dishName, $city);
                wp_send_json_success([
                    'locations' => $locations,
                    'dishName'  => $dishName
                ]);
            } else {
                wp_send_json_error('The uploaded image does not appear to be food. Please upload a valid food image.');
            }

            $client->close();
        }
    }

    wp_die();
}


function getRestaurantsByDish($dishName, $city)
{

    $apiKey = 'AIzaSyC5zdCNSYZMqOf89qVIKir4MKXcRsOjwww';

    $locations = [];
    $next_page_token = null;

    $city_coords = [
        'brussels' => ['lat' => 50.8503, 'lng' => 4.3517],
        'belgium' => ['lat' => 50.8503, 'lng' => 4.3517],
    ];

    if (!isset($city_coords[$city])) {
        // Default to Brussels if city not found
        $city = 'brussels';
    }

    $cityLatitude = $city_coords[$city]['lat'];
    $cityLongitude = $city_coords[$city]['lng'];
    $radius = 50000;

    $googlePlacesUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . urlencode($dishName) . "&location=$cityLatitude,$cityLongitude&radius=$radius&key=$apiKey";

    $response = file_get_contents($googlePlacesUrl);
    $data = json_decode($response, true);

    if (isset($data['results']) && count($data['results']) > 0) {

        foreach ($data['results'] as $restaurant) {

            $locations[] = [

                'name' => $restaurant['name'] ?? '',
                'formatted_address' => $restaurant['formatted_address'] ?? '',
                'link' =>  $restaurant['place_id'],
                'url' =>  "https://www.google.com/maps/place/?q=place_id:" . $restaurant['place_id'] . "",
                'rating' => $restaurant['rating'] ?? 0,
                'types' => $restaurant['types'] ?? [],
                'user_ratings_total' => $restaurant['user_ratings_total'] ?? 0,
                'lat' => $restaurant['geometry']['location']['lat'] ?? null,
                'lng' => $restaurant['geometry']['location']['lng'] ?? null,
            ];
        }

        return $locations;
    } else {
        return "<p>No restaurants found for '$dishName' in Brussels within the specified radius.</p>";
    }
}


//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


























