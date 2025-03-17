<?php

if ( ! function_exists( 'foogra_body_classes' ) ) {
	function foogra_body_classes( $classes ) {
		global $post;
		$show_footer_mobile = foogra_get_config('show_footer_mobile', true);

		if ( is_page() && is_object($post) ) {
			$class = get_post_meta( $post->ID, 'apus_page_extra_class', true );
			if ( !empty($class) ) {
				$classes[] = trim($class);
			}
			if(get_post_meta( $post->ID, 'apus_page_header_transparent',true) && get_post_meta( $post->ID, 'apus_page_header_transparent',true) == 'yes' ){
				$classes[] = 'header_transparent';
			}
			if(get_post_meta( $post->ID, 'apus_page_header_fixed',true) && get_post_meta( $post->ID, 'apus_page_header_fixed',true) == 'yes' ){
				$classes[] = 'header_fixed';
			}
			// layout
			if(get_post_meta( $post->ID, 'apus_page_layout', true )){
				$classes[] = get_post_meta( $post->ID, 'apus_page_layout', true );
			}
		}

		if ( foogra_get_config('preload', true) ) {
			$classes[] = 'apus-body-loading';
		}
		if ( foogra_get_config('image_lazy_loading') ) {
			$classes[] = 'image-lazy-loading';
		}
		if ( $show_footer_mobile ) {
			$classes[] = 'body-footer-mobile';
		}
		if ( foogra_is_wp_listings_directory_activated() ) {
			if ( foogra_is_listings_page() ) {
				$layout_type = foogra_get_listings_layout_type();
				if ( $layout_type == 'half-map' ) {
					$classes[] = 'no-footer';
					$classes[] = 'fix-header';
				}
			}

		}
		if ( foogra_get_config('keep_header') ) {
			$classes[] = 'has-header-sticky';
		}
		
		return $classes;
	}
	add_filter( 'body_class', 'foogra_body_classes' );
}

if ( !function_exists('foogra_get_header_layouts') ) {
	function foogra_get_header_layouts() {
		$headers = array();
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'apus_header',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$headers[$post->post_name] = $post->post_title;
		}
		return $headers;
	}
}

if ( !function_exists('foogra_get_header_layout') ) {
	function foogra_get_header_layout() {
		global $post;
		if ( is_page() && is_object($post) && isset($post->ID) ) {
			global $post;
			$header = get_post_meta( $post->ID, 'apus_page_header_type', true );
			if ( empty($header) || $header == 'global' ) {
				return foogra_get_config('header_type');
			}
			return $header;
		}
		return foogra_get_config('header_type');
	}
	add_filter( 'foogra_get_header_layout', 'foogra_get_header_layout' );
}

function foogra_display_header_builder($header_slug) {
	$args = array(
		'name'        => $header_slug,
		'post_type'   => 'apus_header',
		'post_status' => 'publish',
		'numberposts' => 1,
		'fields' => 'ids'
	);
	$post_ids = get_posts($args);
	foreach ( $post_ids as $post_id ) {
		$post_id = foogra_get_lang_post_id($post_id, 'apus_header');
		$post = get_post($post_id);

		if ( foogra_get_config('keep_header') ) {
			$classes = array('apus-header d-none d-xl-block');
		}else{
			$classes = array('apus-header no_keep_header d-none d-xl-block');
		}
		$classes[] = $post->post_name.'-'.$post->ID;

		echo '<div id="apus-header" class="'.esc_attr(implode(' ', $classes)).'">';
		if ( foogra_get_config('keep_header') ) {
	        echo '<div class="main-sticky-header">';
	    }
			echo apply_filters( 'foogra_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID);
		if ( foogra_get_config('keep_header') ) {
			echo '</div>';
	    }
		echo '</div>';
	}
}

if ( !function_exists('foogra_get_footer_layouts') ) {
	function foogra_get_footer_layouts() {
		$footers = array();
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'apus_footer',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$footers[$post->post_name] = $post->post_title;
		}
		return $footers;
	}
}

if ( !function_exists('foogra_get_footer_layout') ) {
	function foogra_get_footer_layout() {
		if ( is_page() ) {
			global $post;
			$footer = '';
			if ( is_object($post) && isset($post->ID) ) {
				$footer = get_post_meta( $post->ID, 'apus_page_footer_type', true );
				if ( empty($footer) || $footer == 'global' ) {
					return foogra_get_config('footer_type', '');
				}
			}
			return $footer;
		}
		return foogra_get_config('footer_type', '');
	}
	add_filter('foogra_get_footer_layout', 'foogra_get_footer_layout');
}

function foogra_display_footer_builder($footer_slug) {
	$show_footer_desktop_mobile = foogra_get_config('show_footer_desktop_mobile', false);
	$args = array(
		'name'        => $footer_slug,
		'post_type'   => 'apus_footer',
		'post_status' => 'publish',
		'numberposts' => 1,
		'fields' => 'ids'
	);
	$post_ids = get_posts($args);
	foreach ( $post_ids as $post_id ) {
		$post_id = foogra_get_lang_post_id($post_id, 'apus_footer');
		$post = get_post($post_id);
		
		$classes = array('apus-footer footer-builder-wrapper');
		if ( !$show_footer_desktop_mobile ) {
			$classes[] = '';
		}
		$classes[] = $post->post_name;


		echo '<div id="apus-footer" class="'.esc_attr(implode(' ', $classes)).'">';
		echo '<div class="apus-footer-inner">';
		echo apply_filters( 'foogra_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID);
		echo '</div>';
		echo '</div>';
	}
}

if ( !function_exists('foogra_blog_content_class') ) {
	function foogra_blog_content_class( $class ) {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		if ( foogra_get_config('blog_'.$page.'_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'foogra_blog_content_class', 'foogra_blog_content_class', 1 , 1  );


if ( !function_exists('foogra_get_blog_layout_configs') ) {
	function foogra_get_blog_layout_configs() {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		$left = foogra_get_config('blog_'.$page.'_left_sidebar');
		$right = foogra_get_config('blog_'.$page.'_right_sidebar');

		switch ( foogra_get_config('blog_'.$page.'_layout') ) {
		 	case 'left-main':
			 	if ( is_active_sidebar( $left ) ) {
			 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'sidebar-blog col-lg-3 col-12'  );
			 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
			 	}
		 		break;
		 	case 'main-right':
		 		if ( is_active_sidebar( $right ) ) {
			 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'sidebar-blog col-lg-3 col-12' ); 
			 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
			 	}
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-12' );
	 			break;
		 	default:
		 		if ( is_active_sidebar( 'sidebar-default' ) ) {
			 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'sidebar-blog col-lg-3 col-12' ); 
			 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
			 	} else {
			 		$configs['main'] = array( 'class' => 'col-12' );
			 	}
		 		break;
		}
		if ( empty($configs) ) {
			if ( is_active_sidebar( 'sidebar-default' ) ) {
		 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'sidebar-blog col-lg-3 col-12' ); 
		 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
		 	} else {
		 		$configs['main'] = array( 'class' => 'col-12' );
		 	}
		}
		return $configs; 
	}
}

if ( !function_exists('foogra_page_content_class') ) {
	function foogra_page_content_class( $class ) {
		global $post;
		if (is_object($post)) {
			$fullwidth = get_post_meta( $post->ID, 'apus_page_fullwidth', true );
			if ( !$fullwidth || $fullwidth == 'no' ) {
				return $class;
			}
		}
		return 'container-fluid';
	}
}
add_filter( 'foogra_page_content_class', 'foogra_page_content_class', 1 , 1  );

if ( !function_exists('foogra_get_page_layout_configs') ) {
	function foogra_get_page_layout_configs() {
		global $post;
		if ( is_object($post) ) {
			$left = get_post_meta( $post->ID, 'apus_page_left_sidebar', true );
			$right = get_post_meta( $post->ID, 'apus_page_right_sidebar', true );

			switch ( get_post_meta( $post->ID, 'apus_page_layout', true ) ) {
			 	case 'left-main':
			 		if ( is_active_sidebar( $left ) ) {
				 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'page-sidebar col-lg-3 col-12'  );
				 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
				 	}
			 		break;
			 	case 'main-right':
			 		if ( is_active_sidebar( $right ) ) {
				 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'page-sidebar col-lg-3 col-12' ); 
				 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
				 	}
			 		break;
		 		case 'main':
		 			$configs['main'] = array( 'class' => 'col-12' );
		 			break;
			 	default:
			 		if ( foogra_is_woocommerce_activated() && (is_cart() || is_checkout()) ) {
			 			$configs['main'] = array( 'class' => 'col-12' );
			 		} elseif ( is_active_sidebar( 'sidebar-default' ) ) {
				 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'page-sidebar col-lg-3 col-12' ); 
				 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
				 	} else {
				 		$configs['main'] = array( 'class' => 'col-12' );
				 	}
			 		break;
			}

			if ( empty($configs) ) {
				if ( is_active_sidebar( 'sidebar-default' ) ) {
			 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'page-sidebar col-lg-3 col-12' ); 
			 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
			 	} else {
			 		$configs['main'] = array( 'class' => 'col-12' );
			 	}
			}
		} else {
			$configs['main'] = array( 'class' => 'col-12' );
		}
		return $configs; 
	}
}

if ( !function_exists( 'foogra_random_key' ) ) {
    function foogra_random_key($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $return = '';
        for ($i = 0; $i < $length; $i++) {
            $return .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $return;
    }
}

if ( !function_exists('foogra_substring') ) {
    function foogra_substring($string, $limit, $afterlimit = '[...]') {
        if ( empty($string) ) {
        	return $string;
        }
       	$string = explode(' ', wp_strip_all_tags( $string ), $limit);

        if (count($string) >= $limit) {
            array_pop($string);
            $string = implode(" ", $string) .' '. $afterlimit;
        } else {
            $string = implode(" ", $string);
        }
        $string = preg_replace('`[[^]]*]`','',$string);
        return strip_shortcodes( $string );
    }
}

function foogra_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) == 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) == 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'r' => $r, 'g' => $g, 'b' => $b );
}

function foogra_generate_rgba( $rgb, $opacity ) {
	$output = 'rgba('.$rgb['r'].', '.$rgb['g'].', '.$rgb['b'].', '.$opacity.');';

	return $output;
}

function foogra_is_apus_frame_activated() {
	return defined('APUS_FRAME_VERSION') ? true : false;
}

function foogra_is_cmb2_activated() {
	return defined('CMB2_LOADED') ? true : false;
}

function foogra_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

function foogra_is_revslider_activated() {
	return class_exists( 'RevSlider' ) ? true : false;
}

function foogra_is_mailchimp_activated() {
	return class_exists( 'MC4WP_Form_Manager' ) ? true : false;
}

function foogra_is_wp_listings_directory_activated() {
	return class_exists( 'WP_Listings_Directory' ) ? true : false;
}

function foogra_is_wp_listings_directory_wc_paid_listings_activated() {
	return class_exists( 'WP_Listings_Directory_Wc_Paid_Listings' ) ? true : false;
}

function foogra_is_wp_private_message() {
	return class_exists( 'WP_Private_Message' ) ? true : false;
}

function foogra_header_footer_templates( $template ) {
	$post_type = get_post_type();
	if ( $post_type ) {
		$custom_post_types = array( 'apus_footer', 'apus_header', 'apus_megamenu', 'elementor_library' );
		if ( in_array( $post_type, $custom_post_types ) ) {
			if ( is_single() ) {
				$post_type = str_replace('_', '-', $post_type);
				return get_template_directory() . '/single-apus-elementor.php';
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'foogra_header_footer_templates' );



if ( !function_exists('foogra_user_content_class') ) {
	function foogra_user_content_class( $class ) {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		if ( foogra_get_config('user_profile_fullwidth') ) {
			return 'container-fluid';
		}
		return $class;
	}
}
add_filter( 'foogra_user_content_class', 'foogra_user_content_class', 1 , 1  );


if ( !function_exists('foogra_get_user_layout_configs') ) {
	function foogra_get_user_layout_configs() {
		
		$left = foogra_get_config('user_profile_left_sidebar');
		$right = foogra_get_config('user_profile_right_sidebar');

		switch ( foogra_get_config('user_single_layout') ) {
		 	case 'left-main':
			 	if ( is_active_sidebar( $left ) ) {
			 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'sidebar-user col-lg-3 col-12'  );
			 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
			 	}
		 		break;
		 	case 'main-right':
		 		if ( is_active_sidebar( $right ) ) {
			 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'sidebar-user col-lg-3 col-12' ); 
			 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
			 	}
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-12' );
	 			break;
		 	default:
		 		if ( is_active_sidebar( 'sidebar-default' ) ) {
			 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'sidebar-user col-lg-3 col-12' ); 
			 		$configs['main'] = array( 'class' => 'col-lg-9 col-12' );
			 	} else {
			 		$configs['main'] = array( 'class' => 'col-12' );
			 	}
		 		break;
		}
		
		return $configs; 
	}
}

function foogra_get_lang_post_id($post_id, $post_type = 'page') {
    return apply_filters( 'wp-listings-directory-post-id', $post_id, $post_type);
}