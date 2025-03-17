<?php

function foogra_listing_paid_listing_template_folder_name($folder) {
	$folder = 'template-paid-listings';
	return $folder;
}
add_filter( 'wp-listings-directory-wc-paid-listings-theme-folder-name', 'foogra_listing_paid_listing_template_folder_name', 10 );

