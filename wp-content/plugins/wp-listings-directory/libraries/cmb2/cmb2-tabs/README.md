# cmb2-tabs

Extensions the tabs to the library CMB2

### Preview
![tabs](https://github.com/dThemeStudio/cmb2-tabs/raw/master/screenshots/metabox-horizontal.png)

### Changelog

*   1.2.3 Added license to the project
*   1.2.2 Support vertical layout
*   1.2.1 Support for custom attributes for the tabs container
*   1.0.1 Added support the "options page"
*   1.0.0 Init

### Example metabox

```php
add_filter( 'cmb2_init', 'example_tabs_metaboxes' );
function example_tabs_metaboxes() {
	$box_options = array(
		'id'           => 'example_tabs_metaboxes',
		'title'        => __( 'Example tabs', 'wp-listings-directory' ),
		'object_types' => array( 'page' ),
		'show_names'   => true,
	);

	// Setup meta box
	$cmb = new_cmb2_box( $box_options );

	// setting tabs
	$tabs_setting           = array(
		'config' => $box_options,
		//		'layout' => 'vertical', // Default : horizontal
		'tabs'   => array()
	);
	$tabs_setting['tabs'][] = array(
		'id'     => 'tab1',
		'title'  => __( 'Tab 1', 'wp-listings-directory' ),
		'fields' => array(
			array(
				'name' => __( 'Title', 'wp-listings-directory' ),
				'id'   => 'header_title',
				'type' => 'text'
			),
			array(
				'name' => __( 'Subtitle', 'wp-listings-directory' ),
				'id'   => 'header_subtitle',
				'type' => 'text'
			),
			array(
				'name'    => __( 'Background image', 'wp-listings-directory' ),
				'id'      => 'header_background',
				'type'    => 'file',
				'options' => array(
					'url' => false
				)
			)
		)
	);
	$tabs_setting['tabs'][] = array(
		'id'     => 'tab2',
		'title'  => __( 'Tab 2', 'wp-listings-directory' ),
		'fields' => array(
			array(
				'name' => __( 'Title', 'wp-listings-directory' ),
				'id'   => 'review_title',
				'type' => 'text'
			),
			array(
				'name' => __( 'Subtitle', 'wp-listings-directory' ),
				'id'   => 'review_subtitle',
				'type' => 'text'
			),
			array(
				'id'      => 'reviews',
				'type'    => 'group',
				'options' => array(
					'group_title'   => __( 'Review {#}', 'wp-listings-directory' ),
					'add_button'    => __( 'Add review', 'wp-listings-directory' ),
					'remove_button' => __( 'Remove review', 'wp-listings-directory' ),
					'sortable'      => false
				),
				'fields'  => array(
					array(
						'name' => __( 'Author name', 'wp-listings-directory' ),
						'id'   => 'name',
						'type' => 'text'
					),
					array(
						'name'    => __( 'Author avatar', 'wp-listings-directory' ),
						'id'      => 'avatar',
						'type'    => 'file',
						'options' => array(
							'url' => false
						)
					),
					array(
						'name' => __( 'Comment', 'wp-listings-directory' ),
						'id'   => 'comment',
						'type' => 'textarea'
					)
				)
			)
		)
	);

	// set tabs
	$cmb->add_field( array(
		'id'   => '__tabs',
		'type' => 'tabs',
		'tabs' => $tabs_setting
	) );
}
```
##### Preview
![metabox-horizontal](https://github.com/dThemeStudio/cmb2-tabs/raw/master/screenshots/metabox-horizontal.png)
![metabox-horizontal](https://github.com/dThemeStudio/cmb2-tabs/raw/master/screenshots/metabox-vertical.png)

### Example options page
```php
add_action( 'cmb2_admin_init', 'example_options_page_metabox' );
function example_options_page_metabox() {
	$box_options = array(
		'id'          => 'myprefix_option_metabox',
		'title'       => __( 'Example tabs', 'wp-listings-directory' ),
		'show_names'  => true,
		'object_type' => 'options-page',
		'show_on'     => array(
			// These are important, don't remove
			'key'   => 'options-page',
			'value' => array( 'myprefix_options' )
		),
	);

	// Setup meta box
	$cmb = new_cmb2_box( $box_options );

	// setting tabs
	$tabs_setting = array(
		'config' => $box_options,
		//		'layout' => 'vertical', // Default : horizontal
		'tabs'   => array()
	);

	$tabs_setting['tabs'][] = array(
		'id'     => 'tab1',
		'title'  => __( 'Tab 1', 'wp-listings-directory' ),
		'fields' => array(
			array(
				'name' => __( 'Title', 'wp-listings-directory' ),
				'id'   => 'header_title',
				'type' => 'text'
			),
			array(
				'name' => __( 'Subtitle', 'wp-listings-directory' ),
				'id'   => 'header_subtitle',
				'type' => 'text'
			),
			array(
				'name'    => __( 'Background image', 'wp-listings-directory' ),
				'id'      => 'header_background',
				'type'    => 'file',
				'options' => array(
					'url' => false
				)
			)
		)
	);
	$tabs_setting['tabs'][] = array(
		'id'     => 'tab2',
		'title'  => __( 'Tab 2', 'wp-listings-directory' ),
		'fields' => array(
			array(
				'name' => __( 'Title', 'wp-listings-directory' ),
				'id'   => 'review_title',
				'type' => 'text'
			),
			array(
				'name' => __( 'Subtitle', 'wp-listings-directory' ),
				'id'   => 'review_subtitle',
				'type' => 'text'
			),
			array(
				'id'      => 'reviews',
				'type'    => 'group',
				'options' => array(
					'group_title'   => __( 'Review {#}', 'wp-listings-directory' ),
					'add_button'    => __( 'Add review', 'wp-listings-directory' ),
					'remove_button' => __( 'Remove review', 'wp-listings-directory' ),
					'sortable'      => false
				),
				'fields'  => array(
					array(
						'name' => __( 'Author name', 'wp-listings-directory' ),
						'id'   => 'name',
						'type' => 'text'
					),
					array(
						'name'    => __( 'Author avatar', 'wp-listings-directory' ),
						'id'      => 'avatar',
						'type'    => 'file',
						'options' => array(
							'url' => false
						)
					),
					array(
						'name' => __( 'Comment', 'wp-listings-directory' ),
						'id'   => 'comment',
						'type' => 'textarea'
					)
				)
			)
		)
	);

	$cmb->add_field( array(
		'id'   => '__tabs',
		'type' => 'tabs',
		'tabs' => $tabs_setting
	) );
}
```

##### Preview
![options-page-horizontal](https://github.com/dThemeStudio/cmb2-tabs/raw/master/screenshots/options-page-horizontal.png)
![options-page-vertical](https://github.com/dThemeStudio/cmb2-tabs/raw/master/screenshots/options-page-vertical.png)

### License
**cmb2-tabs** is an open source project that is licensed under the [MIT license](http://opensource.org/licenses/MIT).