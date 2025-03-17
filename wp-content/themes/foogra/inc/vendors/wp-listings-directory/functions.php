<?php

function foogra_get_listings( $params = array() ) {
	$params = wp_parse_args( $params, array(
		'limit' => -1,
		'post_status' => 'publish',
		'get_listings_by' => 'recent',
		'orderby' => '',
		'order' => '',
		'post__in' => array(),
		'fields' => null, // ids
		'author' => null,
		'category' => array(),
		'type' => array(),
		'location' => array(),
		'amenity' => array(),
		'material' => array(),
		'label' => array(),
	));
	extract($params);

	$query_args = array(
		'post_type'         => 'listing',
		'posts_per_page'    => $limit,
		'post_status'       => $post_status,
		'orderby'       => $orderby,
		'order'       => $order,
	);

	$meta_query = array();
	switch ($get_listings_by) {
		case 'recent':
			$query_args['orderby'] = 'date';
			$query_args['order'] = 'DESC';
			break;
		case 'featured':
			$meta_query[] = array(
				'key' => WP_LISTINGS_DIRECTORY_LISTING_PREFIX.'featured',
	           	'value' => 'on',
	           	'compare' => '=',
			);
			break;
	}

	if ( !empty($post__in) ) {
    	$query_args['post__in'] = $post__in;
    }

    if ( !empty($fields) ) {
    	$query_args['fields'] = $fields;
    }

    if ( !empty($author) ) {
    	$query_args['author'] = $author;
    }

    $tax_query = array();

    $tax_keys = apply_filters('foogra-listing-get-tax-keys', array('type', 'category', 'feature', 'location', 'amenity', 'material', 'label'));
    foreach ($tax_keys as $tax_key) {
    	if ( !empty($params[$tax_key]) ) {
    		$tax_query[] = array(
	            'taxonomy'      => 'listing_'.$tax_key,
	            'field'         => 'slug',
	            'terms'         => $params[$tax_key],
	            'operator'      => 'IN'
	        );
    	}
    }
    
    if ( !empty($tax_query) ) {
    	$query_args['tax_query'] = $tax_query;
    }
    
    if ( !empty($meta_query) ) {
    	$query_args['meta_query'] = $meta_query;
    }

	return new WP_Query( $query_args );
}

if ( !function_exists('foogra_listing_content_class') ) {
	function foogra_listing_content_class( $class ) {
		$prefix = 'listings';
		if ( is_singular( 'listing' ) ) {
            $prefix = 'listing';
        }
		if ( foogra_get_config($prefix.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'foogra_listing_content_class', 'foogra_listing_content_class', 1 , 1  );

function foogra_listing_template_folder_name($folder) {
	$folder = 'template-listings';
	return $folder;
}
add_filter( 'wp-listings-directory-theme-folder-name', 'foogra_listing_template_folder_name', 10 );

if ( !function_exists('foogra_get_listings_layout_configs') ) {
	function foogra_get_listings_layout_configs() {
		$layout_sidebar = foogra_get_listings_layout_sidebar();

		$sidebar = foogra_get_listings_filter_sidebar();
		switch ( $layout_sidebar ) {
		 	case 'left-main':
		 		$configs['left'] = array( 'sidebar' => $sidebar, 'class' => 'sidebar-listing col-lg-3 col-12'  );
		 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
		 		break;
		 	case 'main-right':
		 	default:
		 		$configs['right'] = array( 'sidebar' => $sidebar,  'class' => 'sidebar-listing col-lg-3 col-12' ); 
		 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-12' );
	 			break;
		}
		return $configs; 
	}
}

function foogra_get_listings_layout_sidebar() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$layout_type = get_post_meta( $post->ID, 'apus_page_layout', true );
	}
	if ( empty($layout_type) ) {
		$layout_type = foogra_get_config('listings_layout_sidebar', 'main-right');
	}
	return apply_filters( 'foogra_get_listings_layout_sidebar', $layout_type );
}

function foogra_get_listings_layout_type() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$layout_type = get_post_meta( $post->ID, 'apus_page_layout_type', true );
	}
	if ( empty($layout_type) ) {
		$layout_type = foogra_get_config('listings_layout_type', 'default');
	}
	return apply_filters( 'foogra_get_listings_layout_type', $layout_type );
}

function foogra_get_listings_half_map_filter_type() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$layout_type = get_post_meta( $post->ID, 'apus_page_listings_half_map_filter_type', true );
	}
	if ( empty($layout_type) ) {
		$layout_type = foogra_get_config('listings_half_map_filter_type', 'offcanvas');
	}
	return apply_filters( 'foogra_get_listings_half_map_filter_type', $layout_type );
}

function foogra_get_listings_display_mode() {
	global $post;
	if ( !empty($_GET['filter-display-mode']) ) {
		$display_mode = $_GET['filter-display-mode'];
	} else {
		if ( is_page() && is_object($post) ) {
			$display_mode = get_post_meta( $post->ID, 'apus_page_display_mode', true );
		}
		if ( empty($display_mode) ) {
			$display_mode = foogra_get_config('listings_display_mode', 'grid');
		}
	}
	return apply_filters( 'foogra_get_listings_display_mode', $display_mode );
}

function foogra_get_listings_item_style() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$item_style = get_post_meta( $post->ID, 'apus_page_item_style', true );
	}
	if ( empty($item_style) ) {
		$item_style = foogra_get_config('listings_item_style', 'grid');
	}
	return apply_filters( 'foogra_get_listings_item_style', $item_style );
}

function foogra_get_listings_inner_style() {
	$display_mode = foogra_get_listings_display_mode();
	$inner_style = foogra_get_listings_item_style();
	return apply_filters( 'foogra_get_listings_inner_style', $inner_style );
}

function foogra_get_listings_columns() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_listings_columns', true );
	}
	if ( empty($columns) ) {
		$columns = foogra_get_config('listings_columns', 3);
	}
	return apply_filters( 'foogra_get_listings_columns', $columns );
}

function foogra_get_listings_list_columns() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$columns = get_post_meta( $post->ID, 'apus_page_listings_list_columns', true );
	}
	if ( empty($columns) ) {
		$columns = foogra_get_config('listings_list_columns', 1);
	}
	return apply_filters( 'foogra_get_listings_list_columns', $columns );
}

function foogra_get_listings_pagination() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$pagination = get_post_meta( $post->ID, 'apus_page_listings_pagination', true );
	}
	if ( empty($pagination) ) {
		$pagination = foogra_get_config('listings_pagination', 'default');
	}
	return apply_filters( 'foogra_get_listings_pagination', $pagination );
}

function foogra_get_listing_layout_type() {
	global $post;
	if ( defined('FOOGRA_DEMO_MODE') && FOOGRA_DEMO_MODE ) {
		$layout_type = get_post_meta($post->ID, WP_LISTINGS_DIRECTORY_LISTING_PREFIX.'layout_type', true);
	}
	
	if ( empty($layout_type) ) {
		$layout_type = foogra_get_config('listing_layout_type', 'v1');
	}
	return apply_filters( 'foogra_get_listing_layout_type', $layout_type );
}

function foogra_listing_scripts() {
	
	wp_enqueue_style( 'leaflet' );
	wp_enqueue_script( 'jquery-highlight' );
    wp_enqueue_script( 'leaflet' );
    wp_enqueue_script( 'control-geocoder' );
    wp_enqueue_script( 'esri-leaflet' );
    wp_enqueue_script( 'esri-leaflet-geocoder' );
    wp_enqueue_script( 'leaflet-markercluster' );
    wp_enqueue_script( 'leaflet-HtmlIcon' );
    
    if ( wp_listings_directory_get_option('map_service') == 'google-map' ) {
    	wp_enqueue_script( 'leaflet-GoogleMutant' );
    }
    
	wp_register_script( 'foogra-listing', get_template_directory_uri() . '/js/listing.js', array( 'jquery', 'wp-listings-directory-main', 'perfect-scrollbar', 'imagesloaded' ), '20150330', true );

	$current_currency = WP_Listings_Directory_Price::get_current_currency();
	$multi_currencies = WP_Listings_Directory_Price::get_currencies_settings();

	if ( !empty($multi_currencies) && !empty($multi_currencies[$current_currency]) ) {
		$currency_args = $multi_currencies[$current_currency];
	}

	if ( !empty($currency_args) ) {
		$currency_symbol = !empty($currency_args['custom_symbol']) ? $currency_args['custom_symbol'] : '';
		if ( empty($currency_symbol) ) {
			$currency = !empty($currency_args['currency']) ? $currency_args['currency'] : 'USD';
			$currency_symbol = WP_Listings_Directory_Price::currency_symbol($currency);
		}
	}

	$currency_symbol = ! empty( $currency_symbol ) ? $currency_symbol : '$';
	$dec_point = ! empty( wp_listings_directory_get_option('money_dec_point') ) ? wp_listings_directory_get_option('money_dec_point') : '.';
	$thousands_separator = ! empty( wp_listings_directory_get_option('money_thousands_separator') ) ? wp_listings_directory_get_option('money_thousands_separator') : '';

	wp_localize_script( 'foogra-listing', 'foogra_listing_opts', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),

		'dec_point' => $dec_point,
		'thousands_separator' => $thousands_separator,
		'currency' => esc_attr($currency_symbol),
		'monthly_text' => esc_html__('Monthly Payment: ', 'foogra'),
		'favorite_added_tooltip_title' => esc_html__('Remove Favorite', 'foogra'),
		'favorite_add_tooltip_title' => esc_html__('Add Favorite', 'foogra'),

		'template' => apply_filters( 'foogra_autocompleate_search_template', '<a href="{{url}}" class="d-flex align-items-center autocompleate-media">
			<div class="wrapper-img flex-shrink-0">
				<img src="{{image}}" class="media-object" height="50" width="50">
			</div>
			<div class="info-body flex-grow-1">
				<h4>{{title}}</h4>
				{{{price}}}
				{{{metas}}}
				</div></a>' ),
        'empty_msg' => apply_filters( 'foogra_autocompleate_search_empty_msg', esc_html__( 'Unable to find any listing that match the currenty query', 'foogra' ) ),
	));
	wp_enqueue_script( 'foogra-listing' );

	$here_map_api_key = '';
	$here_style = '';
	$mapbox_token = '';
	$mapbox_style = '';
	$custom_style = '';
	$googlemap_type = wp_listings_directory_get_option('googlemap_type', 'roadmap');
	if ( empty($googlemap_type) ) {
		$googlemap_type = 'roadmap';
	}
	$map_service = wp_listings_directory_get_option('map_service', '');
	if ( $map_service == 'mapbox' ) {
		$mapbox_token = wp_listings_directory_get_option('mapbox_token', '');
		$mapbox_style = wp_listings_directory_get_option('mapbox_style', 'streets-v11');
		if ( empty($mapbox_style) || !in_array($mapbox_style, array( 'streets-v11', 'light-v10', 'dark-v10', 'outdoors-v11', 'satellite-v9' )) ) {
			$mapbox_style = 'streets-v11';
		}
	} elseif ( $map_service == 'here' ) {
		$here_map_api_key = wp_listings_directory_get_option('here_map_api_key', '');
		$here_style = wp_listings_directory_get_option('here_map_style', 'normal.day');
	} else {
		$custom_style = wp_listings_directory_get_option('google_map_style', '');
	}

	wp_register_script( 'foogra-listing-map', get_template_directory_uri() . '/js/listing-map.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'foogra-listing-map', 'foogra_listing_map_opts', array(
		'map_service' => $map_service,
		'mapbox_token' => $mapbox_token,
		'mapbox_style' => $mapbox_style,
		'here_map_api_key' => $here_map_api_key,
		'here_style' => $here_style,
		'custom_style' => $custom_style,
		'googlemap_type' => $googlemap_type,
		'default_latitude' => wp_listings_directory_get_option('default_maps_location_latitude', '43.6568'),
		'default_longitude' => wp_listings_directory_get_option('default_maps_location_longitude', '-79.4512'),
		'default_pin' => wp_listings_directory_get_option('default_maps_pin', ''),
		
	));
	wp_enqueue_script( 'foogra-listing-map' );
}
add_action( 'wp_enqueue_scripts', 'foogra_listing_scripts', 10 );

function foogra_is_listings_page() {
	if ( is_page() ) {
		$page_name = basename(get_page_template());
		if ( $page_name == 'page-listings.php' ) {
			return true;
		}
	} elseif( is_post_type_archive('listing') || is_tax('listing_category') || is_tax('listing_type') || is_tax('listing_feature') || is_tax('listing_location') ) {
		return true;
	}
	return false;
}


function foogra_listing_metaboxes($fields) {
	// listing

	if ( defined('FOOGRA_DEMO_MODE') && FOOGRA_DEMO_MODE ) {
		$prefix = WP_LISTINGS_DIRECTORY_LISTING_PREFIX;
		if ( !empty($fields) ) {
			$fields[ $prefix . 'tab-layout-version' ] = array(
				'id' => $prefix . 'tab-layout-version',
				'icon' => 'dashicons-admin-appearance',
				'title' => esc_html__( 'Layout Type', 'foogra' ),
				'fields' => array(
					array(
						'name'              => esc_html__( 'Layout Type', 'foogra' ),
						'id'                => $prefix . 'layout_type',
						'type'              => 'select',
						'options'			=> array(
			                '' => esc_html__('Global Settings', 'foogra'),
			                'v1' => esc_html__('Version 1', 'foogra'),
			                'v2' => esc_html__('Version 2', 'foogra'),
			            ),
					)
				)
			);
		}
	}
	
	return $fields;
}
add_filter( 'wp-listings-directory-admin-custom-fields', 'foogra_listing_metaboxes' );


remove_action( 'wp_listings_directory_before_listing_archive', array( 'WP_Listings_Directory_Listing', 'display_listings_results_filters' ), 5 );

function foogra_display_mode_form($display_mode, $form_url) {
	ob_start();
	?>
	<div class="listings-display-mode-wrapper">
		<form class="listings-display-mode" method="get" action="<?php echo esc_url($form_url); ?>">
			<div class="inner">
				<label for="filter-display-mode-grid">
					<input id="filter-display-mode-grid" type="radio" name="filter-display-mode" value="grid" <?php checked('grid', $display_mode); ?>> <i class="ti-view-grid"></i>
				</label>
				<label for="filter-display-mode-list">
					<input id="filter-display-mode-list" type="radio" name="filter-display-mode" value="list" <?php checked('list', $display_mode); ?>> <i class="ti-view-list-alt"></i>
				</label>
			</div>
			<?php WP_Listings_Directory_Mixes::query_string_form_fields( null, array( 'filter-display-mode', 'submit' ) ); ?>
		</form>
	</div>
	<?php
	$output = ob_get_clean();
	return $output;
}

function foogra_listings_display_mode_form() {
	$listings_page = WP_Listings_Directory_Mixes::get_listings_page_url();
	$display_mode = foogra_get_listings_display_mode();
	$output = foogra_display_mode_form($display_mode, $listings_page);
	
	echo trim($output);
}
//add_action( 'wp_listings_directory_before_listing_archive', 'foogra_listings_display_mode_form', 30 );

function foogra_listings_start_ordering_display_mode() {
	?>
	<div class="ordering-display-mode-wrapper d-flex align-items-center">
	<?php
}
function foogra_listings_end_ordering_display_mode() {
	?>
	</div>
	<?php
}
add_action( 'wp_listings_directory_before_listing_archive', 'foogra_listings_start_ordering_display_mode', 20 );
add_action( 'wp_listings_directory_before_listing_archive', 'foogra_listings_end_ordering_display_mode', 40 );



remove_action( 'wp_listings_directory_before_listing_archive', array( 'WP_Listings_Directory_Listing', 'display_listings_orderby_start' ), 15 );
add_action( 'wp_listings_directory_before_listing_archive', array( 'WP_Listings_Directory_Listing', 'display_listings_orderby_start' ), 1 );



// autocomplete search listings
add_action( 'wpld_ajax_foogra_autocomplete_search_listings', 'foogra_autocomplete_search_listings' );

function foogra_autocomplete_search_listings() {
    // Query for suggestions
    $suggestions = array();
    $args = array(
		'post_type' => 'listing',
		'posts_per_page' => 10,
		'fields' => 'ids'
	);
    $filter_params = isset($_REQUEST['data']) ? $_REQUEST['data'] : null;

	$listings = WP_Listings_Directory_Query::get_posts( $args, $filter_params );

	if ( !empty($listings->posts) ) {
		foreach ($listings->posts as $post_id) {
			$suggestion['title'] = get_the_title($post_id);
			$suggestion['url'] = get_permalink($post_id);

			if ( has_post_thumbnail( $post_id ) ) {
	            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
	            $suggestion['image'] = $image[0];
	        } else {
	            $suggestion['image'] = foogra_placeholder_img_src();
	        }
	        
	        $suggestion['price'] = foogra_listing_display_price($post_id, 'icon', false);

	        $post = get_post($post_id);
	        $meta_obj = WP_Listings_Directory_Listing_Meta::get_instance($post_id);
            $beds = foogra_listing_display_meta($post, 'beds', '', false, $meta_obj->get_post_meta_title( 'beds' ));
            $baths = foogra_listing_display_meta($post, 'baths', '', false, $meta_obj->get_post_meta_title( 'baths' ));

            $suffix = wp_listings_directory_get_option('measurement_unit_area');
            $lot_area = foogra_listing_display_meta($post, 'lot_area', '', false, $suffix);

            ob_start();
            if ( $lot_area || $beds || $baths ) {
            ?>
                <div class="listing-metas flex">
                    <?php
                        echo trim($beds);
                        echo trim($baths);
                        echo trim($lot_area);
                    ?>
                </div>
            <?php }
            $metas = ob_get_clean();
            $suggestion['metas'] = $metas;

        	$suggestions[] = $suggestion;
		}
		wp_reset_postdata();
	}
    echo json_encode( $suggestions );
 
    exit;
}


function foogra_user_display_phone($phone, $display_type = 'no-title', $echo = true, $always_show_phone = false) {
    ob_start();
    if ( $phone ) {
        $show_full = foogra_get_config('listing_show_full_phone', false);
        $hide_phone = $show_full ? false : true;
        $hide_phone = apply_filters('foogra_phone_hide_number', $hide_phone );
        if ( $always_show_phone ) {
        	$hide_phone = false;
        }
        $add_class = '';
        if ( $hide_phone ) {
            $add_class = 'phone-hide';
        }
        if ( $display_type == 'title' ) {
            ?>
            <div class="phone-wrapper agent-phone with-title <?php echo esc_attr($add_class); ?>">
                <span><?php esc_html_e('Phone: ', 'foogra'); ?></span>
            <?php
        } elseif ($display_type == 'icon') {
            ?>
            <div class="phone-wrapper agent-phone with-icon <?php echo esc_attr($add_class); ?>">
                <i class="icon_phone"></i><?php
        } else {
            ?>
            <div class="phone-wrapper agent-phone <?php echo esc_attr($add_class); ?>">
            <?php
        }
        ?><a class="phone" href="tel:<?php echo trim($phone); ?>"><?php echo trim($phone); ?></a>
            <?php if ( $hide_phone ) {
                $dispnum = substr($phone, 0, (strlen($phone)-3) ) . str_repeat("*", 3);
            ?>
                <span class="phone-show" onclick="this.parentNode.classList.add('show');"><?php echo trim($dispnum); ?> <span><?php esc_html_e('show', 'foogra'); ?></span></span>
            <?php } ?>
        </div>
        <?php
    }
    $output = ob_get_clean();
    if ( $echo ) {
        echo trim($output);
    } else {
        return $output;
    }
}


add_action( 'wp_ajax_nopriv_foogra_ajax_print_listing', 'foogra_ajax_print_listing' );
add_action( 'wp_ajax_foogra_ajax_print_listing', 'foogra_ajax_print_listing' );

add_action( 'wpld_ajax_foogra_ajax_print_listing', 'foogra_ajax_print_listing' );

function foogra_ajax_print_listing () {
	if ( !isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'foogra-printer-listing-nonce' )  ) {
		exit();
	}
	if( !isset($_POST['listing_id'])|| !is_numeric($_POST['listing_id']) ){
        exit();
    }

    $listing_id = intval($_POST['listing_id']);
    $the_post = get_post( $listing_id );

    if( $the_post->post_type != 'listing' || $the_post->post_status != 'publish' ) {
        exit();
    }
    setup_postdata( $GLOBALS['post'] =& $the_post );
    global $post;

    $dir = '';
    $body_class = '';
    if ( is_rtl() ) {
    	$dir = 'dir="rtl"';
    	$body_class = 'rtl';
    }

    print  '<html '.$dir.'><head><link href="'.get_stylesheet_uri().'" rel="stylesheet" type="text/css" />';
    if( is_rtl() ) {
    	print '<link href="'.get_template_directory_uri().'/css/bootstrap.rtl.css" rel="stylesheet" type="text/css" />';
    } else {
	    print  '<html><head><link href="'.get_template_directory_uri().'/css/bootstrap.css" rel="stylesheet" type="text/css" />';
	}
    print  '<html><head><link href="'.get_template_directory_uri().'/css/all-awesome.css" rel="stylesheet" type="text/css" />';
    print  '<html><head><link href="'.get_template_directory_uri().'/css/icons.css" rel="stylesheet" type="text/css" />';
    print  '<html><head><link href="'.get_template_directory_uri().'/css/template.css" rel="stylesheet" type="text/css" />';


    print '</head>';
    print '<script>window.onload = function() { window.print(); }</script>';
    print '<body class="'.$body_class.'">';

    $logo = foogra_get_config('print-logo');
    if( isset($logo['url']) && !empty($logo['url']) ) {
    	$print_logo = $logo['url'];
    } else {
    	$print_logo = get_template_directory_uri().'/images/logo.svg';
    }
    $title = get_the_title( $listing_id );

    $image_id = get_post_thumbnail_id( $listing_id );
    $full_img = wp_get_attachment_image_src($image_id, 'foogra-slider');
    $full_img = $full_img [0];

    ?>

    <section id="section-body">
        <!--start detail content-->
        <section class="section-detail-content">
            <div class="detail-bar print-detail">
                
                <?php if ( foogra_get_config('show_print_header', true) ) { ?>
	            	<div class="print-header-top">
	                    <div class="inner">
	                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="print-logo">
	                            <img src="<?php echo esc_url($print_logo); ?>" alt="<?php esc_attr_e('Logo', 'foogra'); ?>">
	                            <span class="tag-line"><?php bloginfo( 'description' ); ?></span>
	                        </a>
	                    </div>
	                </div>
	            <?php } ?>

                <div class="print-header-middle">
                    <div class="print-header-middle-left">
                        <h1><?php echo esc_attr($title); ?></h1>
                        <?php foogra_listing_display_full_location($post,'no-icon-title',true); ?>
                    </div>
                    <div class="print-header-middle-right">
                        <?php foogra_listing_display_price($post); ?>
                    </div>
                </div>

                <?php if( !empty($full_img) ) { ?>
	                <div class="print-banner">
	                    <div class="print-main-image">
                            <img src="<?php echo esc_url( $full_img ); ?>" alt="<?php echo esc_attr($title); ?>">
                            <?php if ( foogra_get_config('show_print_qrcode', true) ) { ?>
	                            <img class="qr-image" src="https://chart.googleapis.com/chart?chs=105x104&cht=qr&chl=<?php echo esc_url( get_permalink($listing_id) ); ?>&choe=UTF-8" title="<?php echo esc_attr($title); ?>" />
	                        <?php } ?>
	                    </div>
	                </div>
                <?php } ?>
                <?php
                
                if ( foogra_get_config('show_print_author', true) ) {
					$user_id = $post->post_author;
					$author_email = get_the_author_meta('user_email');
					$a_title = get_the_author_meta('display_name');
					$a_phone = get_user_meta($user_id, '_user_phone', true);
					$a_phone = foogra_user_display_phone($a_phone, 'no-title', false, true);
					$a_website = get_user_meta($user_id, '_user_url', true);

            	?>
                    <div class="print-block">
                    	<h3><?php esc_html_e( 'Contact Author', 'foogra' ); ?></h3>
                        <div class="agent-media">
                            <div class="media-image-left">
                                <?php echo foogra_get_avatar($post->post_author, 180); ?>
                            </div>
                            <div class="media-body-right">
                                
                                <h4 class="title"><?php echo trim($a_title); ?></h4>
								<div class="phone"><?php echo trim($a_phone); ?></div>
								<div class="email"><?php echo trim($author_email); ?></div>
								<div class="website"><?php echo trim($a_website); ?></div>

                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div id="listing-single-details">
					<?php
					if ( foogra_get_config('show_print_description', true) ) {
						?>
						<div class="description inner">
						    <h3 class="title"><?php esc_html_e('Overview', 'foogra'); ?></h3>
						    <div class="description-inner">
						        <?php the_content(); ?>
						        <?php do_action('wp-listings-directory-single-listing-description', $post); ?>
						    </div>
						</div>
						<?php
					}
					?>

					<?php
					if ( foogra_get_config('show_print_detail', true) ) {
						echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/detail' );
					}
					?>

				</div>

				<?php
				if ( foogra_get_config('show_print_features', true) ) {
					echo WP_Listings_Directory_Template_Loader::get_template_part( 'single-listing/features' );
				}
				?>

				<?php

				$obj_listing_meta = WP_Listings_Directory_Listing_Meta::get_instance($post->ID);
				$gallery = $obj_listing_meta->get_post_meta( 'gallery' );
				if ( foogra_get_config('show_print_gallery', true) && $gallery ) {
				?>
					<div class="print-gallery">
						<div class="detail-title-inner">
                            <h4 class="title-inner"><?php esc_html_e('Listing images', 'foogra'); ?></h4>
                        </div>
                        <div class="row">
							<?php foreach ( $gallery as $id => $src ) { ?>
				                <div class="print-gallery-image col-12 col-sm-6">
				                    <?php echo wp_get_attachment_image( $id, 'foogra-slider' ); ?>
				                </div>
			                <?php } ?>
		                </div>
		          	</div>
	          	<?php } ?>
				
            </div>
        </section>
    </section>


    <?php
    
    wp_reset_postdata();

    print '</body></html>';
    wp_die();
}


function foogra_get_listings_show_filter_top() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$show_filter_top = get_post_meta( $post->ID, 'apus_page_listings_show_filter_top', true );
	}
	if ( empty($show_filter_top) ) {
		$show_filter_top = foogra_get_config('listings_show_filter_top');
	} else {
		if ( $show_filter_top == 'yes' ) {
			$show_filter_top = true;
		} else {
			$show_filter_top = false;
		}
	}
	return apply_filters( 'foogra_get_listings_show_filter_top', $show_filter_top );
}

function foogra_get_listings_filter_sidebar() {
	return apply_filters( 'foogra_get_listings_filter_sidebar', 'listings-filter' );
}

function foogra_get_listings_filter_top_sidebar() {
	global $post;
	if ( is_page() && is_object($post) ) {
		$listings_filter_top_sidebar = get_post_meta( $post->ID, 'apus_page_listings_filter_top_sidebar', true );
	}
	if ( empty($listings_filter_top_sidebar) ) {
		$listings_filter_top_sidebar = foogra_get_config('listings_filter_top_sidebar', 'listings-filter-top');
	}
	return apply_filters( 'foogra_get_listings_filter_top_sidebar', $listings_filter_top_sidebar );
}

function foogra_locations_walk( $terms, $id_parent, &$dropdown ) {
    foreach ( $terms as $key => $term ) {
        if ( $term->parent == $id_parent ) {
            $dropdown = array_merge( $dropdown, array( $term ) );
            unset($terms[$key]);
            foogra_locations_walk( $terms, $term->term_id,  $dropdown );
        }
    }
}

function foogra_load_select2() {
	wp_enqueue_script('wpld-select2');
	wp_enqueue_style('wpld-select2');
}

function foogra_get_days_of_week() {
	$days = array(0, 1, 2, 3, 4, 5, 6);

	$start_day = get_option( 'start_of_week' );

	$first = array_splice( $days, $start_day, count( $days ) - $start_day );

	$second = array_splice( $days, 0, $start_day );

	$days = array_merge( $first, $second );

	return $days;
}

function foogra_get_day_hours($hours) {
	global $wp_locale;
	if (empty($hours) || !is_array($hours)) {
		return;
	}
    $numericdays = foogra_get_days_of_week();
    $days = array();

    foreach ( $numericdays as $key => $i ) {
        $day = $wp_locale->get_weekday( $i );
        if ( isset($hours[ $i ][ 'type' ]) && $hours[ $i ][ 'type' ] == 'enter_hours' ) {
        	if ( !empty($hours[ $i ][ 'from' ]) && !empty($hours[ $i ][ 'to' ]) ) {
        		$t_day = array();
        		foreach ($hours[ $i ][ 'from' ] as $key => $value) {
        			$start = $value;
        			$end = !empty($hours[ $i ][ 'to' ][$key]) ? $hours[ $i ][ 'to' ][$key] : false;
        			if ( $start && $end ) {
        				$start = strtotime($start);
        				$end = strtotime($end);
	        			$t_day[] = array( date(get_option('time_format'), $start), date(get_option('time_format'), $end) );
	        		}
        		}
        		$days[ $day ] = $t_day;
        	}

	    } elseif ( isset($hours[ $i ][ 'type' ]) && $hours[ $i ][ 'type' ] == 'open_all_day' ) {
	    	$days[ $day ] = 'open';
	    } elseif ( isset($hours[ $i ][ 'type' ]) && $hours[ $i ][ 'type' ] == 'closed_all_day' ) {
	    	$days[ $day ] = 'closed';
	    }
    }
    return $days;
}


function foogra_get_current_time($timezone) {
	global $wp_locale;
	$timezones = timezone_identifiers_list();

	if ( $timezone && in_array( $timezone, $timezones ) ) {
		$timezone_date = new DateTime( 'now', new DateTimeZone( $timezone ) );

		$time = $timezone_date->format(get_option('time_format'));
		$date = $timezone_date->format('Y-m-d');
	} else {
		$timezone  = get_option('gmt_offset');
		
		$time = gmdate(get_option('time_format'), time() + 3600*($timezone+date("I"))); 
		$date = gmdate('Y-m-d', time() + 3600*($timezone+date("I")));
	}

	$time = strtotime($time);
	$date = strtotime($date);

	$day_of_week = date('N',$date);
	if ( $day_of_week == 7 ) {
		$day_of_week = 0;
	}
	$day = $wp_locale->get_weekday( $day_of_week );
	
	$day = ucfirst($day);
	$return = array( 'day' => $day, 'time' => $time );
	return $return;
}

function foogra_get_current_time_status($listing_id) {
	$hours = get_post_meta( $listing_id, '_listing_hours', true );
	$timezone = !empty($hours['timezone']) ? $hours['timezone'] : '';
	
	$current = foogra_get_current_time($timezone);
	$current_day = strtolower($current['day']);
	$current_time = $current['time'];
	
	
	if ( !empty($hours['day']) ) {
		$days = foogra_get_day_hours($hours['day']);
		
		if ( !empty($days[$current_day]) || !empty($days[$current['day']]) ) {
			$times = !empty($days[$current_day]) ? $days[$current_day] : $days[$current['day']];
			
			if ( is_array($times) ) {
				foreach ($times as $time) {
					$opentime = strtotime($time[0]);	
					$closedtime = strtotime($time[1]);
					if ( $opentime <= $closedtime ) {
						if ( $current_time >= $opentime && $current_time <= $closedtime ) {
							return true;
						}
					} else {
						$is_open = true;
						if( $current_time < $opentime ){
				            if( $current_time > $closedtime ){
				                $is_open = false;
				            }
				        }
				        return $is_open;
					}
				}
			} elseif ( $times == 'open' ) {
				return true;
			} elseif ( $times == 'closed' ) {
				return false;
			}
		} else {
			return true;
		}
	}
	return false;
}

function foogra_display_time_status($post) {
	if ( foogra_get_config('listing_show_hour_status', true) ) {
		$status = foogra_get_current_time_status( $post->ID );

		if ( $status ) { ?>
			<div class="listing-time opening">
				<?php esc_html_e( 'Now: Open', 'foogra' ); ?>
			</div>
		<?php } else { ?>
			<div class="listing-time closed">
				<?php esc_html_e( 'Now: Closed', 'foogra' ); ?>
			</div>
		<?php }
	}
}


add_filter('wp-listings-directory-add-listing-favorite-return', 'foogra_add_listing_favorite_return', 10);
function foogra_add_listing_favorite_return($return) {
	$return['text'] = esc_html__('Wishlist', 'foogra');
	$return['text_tooltip'] = esc_html__('Remove Favorite', 'foogra');
	return $return;
}

add_filter('wp-listings-directory-remove-listing-favorite-return', 'foogra_remove_listing_favorite_return', 10);
function foogra_remove_listing_favorite_return($return) {
	$return['text'] = esc_html__('Wishlist', 'foogra');
	$return['text_tooltip'] = esc_html__('Add Favorite', 'foogra');
	return $return;
}

function foogra_my_review( $comment, $args, $depth ) {
    get_template_part( 'template-listings/single-user/review', array('comment' => $comment, 'args' => $args, 'depth' => $depth) );
}


add_filter( 'wp-listings-directory-types-filter-custom-fields', 'foogra_types_add_custom_fields', 100, 2);
function foogra_types_add_custom_fields($fields, $old_fields) {
	$fields['rating'] = array(
		'name' => __( 'Rating', 'foogra' ),
		'field_call_back' => 'foogra_filter_field_rating_select',
		'placeholder' => '',
		'toggle' => false,
		'for_post_type' => 'listing',
	);

	return $fields;
}

function foogra_filter_field_rating_select($instance, $args, $key, $field) {
	$name = WP_Listings_Directory_Abstract_Filter::filter_get_name($key, $field);
	$selected = !empty( $_GET[$name] ) ? $_GET[$name] : '';

	include WP_Listings_Directory_Template_Loader::locate( 'widgets/filter-fields/rating_select' );
}

function foogra_filter_field_rating_checkbox($instance, $args, $key, $field) {
	$name = WP_Listings_Directory_Abstract_Filter::filter_get_name($key, $field);
	$selected = !empty( $_GET[$name] ) ? $_GET[$name] : '';

	include WP_Listings_Directory_Template_Loader::locate( 'widgets/filter-fields/rating_checkbox' );
}

function foogra_filter_field_rating_radio($instance, $args, $key, $field) {
	$name = WP_Listings_Directory_Abstract_Filter::filter_get_name($key, $field);
	$selected = !empty( $_GET[$name] ) ? $_GET[$name] : '';

	include WP_Listings_Directory_Template_Loader::locate( 'widgets/filter-fields/rating_radio' );
}

add_filter('wp-listings-directory-add-listing-favorite-return', 'foogra_filter_add_listing_favorite_return');
function foogra_filter_add_listing_favorite_return($return) {
	$listings = WP_Listings_Directory_Favorite::get_listing_favorites();
	$return['count'] = !empty($listings) ? count($listings) : 0;
	return $return;
}


add_filter( 'wp-listings-directory-get-custom-fields-display-hooks', 'foogra_get_custom_fields_display_hooks', 10 );
function foogra_get_custom_fields_display_hooks($hooks) {
	$hooks = array(
        '' => esc_html__('Choose a position', 'wp-listings-directory'),
        'wp-listings-directory-single-listing-description' => esc_html__('Single Listing - Description', 'foogra'),
        'wp-listings-directory-single-listing-menu-prices' => esc_html__('Single Listing - Menu Prices', 'foogra'),
        'wp-listings-directory-single-listing-features' => esc_html__('Single Listing - Features', 'foogra'),
        'wp-listings-directory-single-listing-photos' => esc_html__('Single Listing - Photo', 'foogra'),
        'wp-listings-directory-single-listing-video' => esc_html__('Single Listing - Video', 'foogra'),
        'wp-listings-directory-single-listing-location' => esc_html__('Single Listing - Location', 'foogra'),
        'wp-listings-directory-single-listing-faq' => esc_html__('Single Listing - Faq', 'foogra'),
        'wp-listings-directory-single-listing-information' => esc_html__('Single Listing - Information', 'foogra'),
    );
	return $hooks;
}


// demo function
function foogra_check_demo_account() {
	if ( defined('FOOGRA_DEMO_MODE') && FOOGRA_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'demo') {
			$return = array( 'status' => false, 'msg' => esc_html__('Demo users are not allowed to modify information.', 'foogra') );
		   	echo wp_json_encode($return);
		   	exit;
		}
	}
}

add_action('wp-listings-directory-process-forgot-password', 'foogra_check_demo_account', 10);
add_action('wp-listings-directory-process-change-password', 'foogra_check_demo_account', 10);
add_action('wp-listings-directory-before-delete-profile', 'foogra_check_demo_account', 10);
add_action('wp-listings-directory-before-remove-listing-alert', 'foogra_check_demo_account', 10 );
add_action('wp-listings-directory-before-change-profile-normal', 'foogra_check_demo_account', 10 );
add_action('wp-listings-directory-process-add-agent', 'foogra_check_demo_account', 10 );
add_action('wp-listings-directory-process-remove-agent', 'foogra_check_demo_account', 10 );
add_action('wp-listings-directory-process-remove-before-save', 'foogra_check_demo_account', 10);

function foogra_check_demo_account2($error) {
	if ( defined('FOOGRA_DEMO_MODE') && FOOGRA_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'demo') {
			$error[] = esc_html__('Demo users are not allowed to modify information.', 'foogra');
		}
	}
	return $error;
}
add_filter('wp-listings-directory-submission-validate', 'foogra_check_demo_account2', 10, 2);
add_filter('wp-listings-directory-edit-validate', 'foogra_check_demo_account2', 10, 2);

function foogra_check_demo_account3($post_id, $prefix) {
	if ( defined('FOOGRA_DEMO_MODE') && FOOGRA_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'demo') {
			$_SESSION['messages'][] = array( 'danger', esc_html__('Demo users are not allowed to modify information.', 'foogra') );
			$redirect_url = get_permalink( wp_listings_directory_get_option('edit_profile_page_id') );
			WP_Listings_Directory_Mixes::redirect( $redirect_url );
			exit();
		}
	}
}
add_action('wp-listings-directory-process-profile-before-change', 'foogra_check_demo_account3', 10, 2);

function foogra_check_demo_account4() {
	if ( defined('FOOGRA_DEMO_MODE') && FOOGRA_DEMO_MODE ) {
		$user_id = get_current_user_id();
		$user_obj = get_user_by('ID', $user_id);
		if ( strtolower($user_obj->data->user_login) == 'demo') {
			$return['msg'] = esc_html__('Demo users are not allowed to modify information.', 'foogra');
			$return['status'] = false;
			echo json_encode($return); exit;
		}
	}
}
add_action('wp-private-message-before-reply-message', 'foogra_check_demo_account4');
add_action('wp-private-message-before-add-message', 'foogra_check_demo_account4');
add_action('wp-private-message-before-delete-message', 'foogra_check_demo_account4');