<?php
/**
 * Listing Package
 *
 * @package    wp-listings-directory-wc-paid-listings
 * @author     Habq 
 * @license    GNU General Public License, version 3
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WP_Listings_Directory_Wc_Paid_Listings_Listing_Package {
	public static function init() {
		add_filter('wp-listings-directory-calculate-listing-expiry', array( __CLASS__, 'calculate_listing_expiry' ), 10, 2 );
		add_filter('wp-listings-directory-get-package-id-by-user-package', array( __CLASS__, 'get_package_id' ), 10, 2 );
	}

	public static function calculate_listing_expiry($duration, $listing_id) {
		if ( metadata_exists( 'post', $listing_id, WP_LISTINGS_DIRECTORY_LISTING_PREFIX.'package_duration' ) ) {
			$duration = get_post_meta( $listing_id, WP_LISTINGS_DIRECTORY_LISTING_PREFIX.'package_duration', true );
		}

		return $duration;
	}

	public static function get_package_id($package_id, $user_package_id) {
		$package_id = get_post_meta($user_package_id, WP_LISTINGS_DIRECTORY_WC_PAID_LISTINGS_PREFIX.'product_id', true);
		return $package_id;
	}
	
}

WP_Listings_Directory_Wc_Paid_Listings_Listing_Package::init();