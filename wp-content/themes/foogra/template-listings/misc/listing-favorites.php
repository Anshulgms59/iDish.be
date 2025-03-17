<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
foogra_load_select2();
?>
<?php
if ( !empty($listing_ids) && is_array($listing_ids) ) {
	if ( get_query_var( 'paged' ) ) {
	    $paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
	    $paged = get_query_var( 'page' );
	} else {
	    $paged = 1;
	}
	$query_args = array(
		'post_type'         => 'listing',
		'posts_per_page'    => get_option('posts_per_page'),
		'paged'    			=> $paged,
		'post_status'       => 'publish',
		'post__in'       	=> $listing_ids,
	);
	if ( isset($_GET['search']) ) {
		$query_vars['s'] = $_GET['search'];
	}
	if ( isset($_GET['orderby']) ) {
		switch ($_GET['orderby']) {
			case 'menu_order':
				$query_vars['orderby'] = array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
					'ID'         => 'DESC',
				);
				break;
			case 'newest':
				$query_vars['orderby'] = 'date';
				$query_vars['order'] = 'DESC';
				break;
			case 'oldest':
				$query_vars['orderby'] = 'date';
				$query_vars['order'] = 'ASC';
				break;
		}
	}

	$listings = new WP_Query($query_args);
	if ( $listings->have_posts() ) { ?>
		<div class="box-white-dashboard">
			<div class="clearfix">
					<div class="d-sm-flex align-items-center top-dashboard-search">
						<div class="search-listings-favorite-form widget-search search-listings-form">
							<form action="" method="get">
								<div class="input-group">
									<input type="text" placeholder="<?php echo esc_html__( 'Search ...', 'foogra' ); ?>" class="form-control" name="search" value="<?php echo esc_attr(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
									<button class="search-submit btn btn-search" name="submit">
										<i class="icon_search"></i>
									</button>
								</div>
								<input type="hidden" name="paged" value="1" />
							</form>
						</div>
						<div class="sort-listings-favorite-form sortby-form ms-auto">
							<?php
								$orderby_options = apply_filters( 'wp_listings_directory_my_listings_orderby', array(
									'menu_order'	=> esc_html__( 'Default', 'foogra' ),
									'newest' 		=> esc_html__( 'Newest', 'foogra' ),
									'oldest'     	=> esc_html__( 'Oldest', 'foogra' ),
								) );

								$orderby = isset( $_GET['orderby'] ) ? wp_unslash( $_GET['orderby'] ) : 'newest'; 
							?>

							<div class="orderby-wrapper d-flex align-items-center">
								<span class="text-sort">
									<?php echo esc_html__('Sort by: ','foogra'); ?>
								</span>
								<form class="my-listings-ordering" method="get">
									<select name="orderby" class="orderby">
										<?php foreach ( $orderby_options as $id => $name ) : ?>
											<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
										<?php endforeach; ?>
									</select>
									<input type="hidden" name="paged" value="1" />
									<?php WP_Listings_Directory_Mixes::query_string_form_fields( null, array( 'orderby', 'submit', 'paged' ) ); ?>
								</form>
							</div>
						</div>
					</div>
			</div>


		<div class="inner border-my-listings">
			<div class="layout-my-listings d-flex align-items-center header-layout">
				<div class="listing-thumbnail-wrapper">
					<?php echo esc_html__('Image','foogra') ?>
				</div>
				<div class="layout-left d-flex align-items-center inner-info">
					<div class="inner-info-left">
						<?php echo esc_html__('Information','foogra') ?>
					</div>
					<div class="d-none d-md-block">
						<?php echo esc_html__('Expiry','foogra') ?>
					</div>
					<div class="d-none d-md-block">
						<?php echo esc_html__('Status','foogra') ?>
					</div>
					<div>
						<?php echo esc_html__('Action','foogra') ?>
					</div>
				</div>
			</div>
			<?php while ( $listings->have_posts() ) : $listings->the_post(); global $post;
				?>
				<div class="my-listings-item listing-item listing-favorite-wrapper">
					<div class="d-flex align-items-center layout-my-listings">
						<div class="listing-thumbnail-wrapper">
							<?php foogra_listing_display_image( $post, 'thumbnail' ); ?>
						</div>
						<div class="inner-info d-flex align-items-center layout-left">
							<div class="inner-info-left">
								<h3 class="listing-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	            				<?php foogra_listing_display_price($post, 'no-icon-title', true); ?>
							</div>
							<div class="listing-info-date-expiry d-none d-md-block">
								<div class="listing-table-info-content-expiry">
									<?php
										$expires = get_post_meta( $post->ID, WP_LISTINGS_DIRECTORY_LISTING_PREFIX.'expiry_date', true);
										if ( $expires ) {
											echo '<span>' . esc_html( date_i18n( get_option( 'date_format' ), strtotime( $expires ) ) ) . '</span>';
										} else {
											echo '--';
										}
									?>
								</div>
							</div>
							<div class="status-listing-wrapper d-none d-md-block">
								<span class="status-listing <?php echo esc_attr($post->post_status); ?>">
									<?php
										$post_status = get_post_status_object( $post->post_status );
										if ( !empty($post_status->label) ) {
											echo esc_html($post_status->label);
										} else {
											echo esc_html($post->post_status);
										}
									?>
								</span>
							</div>
							<div class="warpper-action-listing">
								<a href="javascript:void(0)" class="btn-remove-listing-favorite btn-action-icon" data-listing_id="<?php echo esc_attr($post->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce( 'wp-listings-directory-remove-listing-favorite-nonce' )); ?>"><i class="icon_close"></i></a>
							</div>
						</div>
					</div>

				</div>
				<?php
			endwhile; ?>

			<?php wp_reset_postdata();

			WP_Listings_Directory_Mixes::custom_pagination( array(
				'max_num_pages' => $listings->max_num_pages,
				'prev_text'     => '«',
				'next_text'     => '»',
				'wp_query' 		=> $listings
			)); ?>
		</div>
	</div>
		<?php
	}
?>

<?php } else { ?>
	<div class="not-found alert alert-warning"><?php esc_html_e('No listings found.', 'foogra'); ?></div>
<?php } ?>