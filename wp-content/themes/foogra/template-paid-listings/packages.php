<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( $packages ) : ?>
	<div class="widget-packages widget-subwoo woocommerce">
		<div class="row m-0">
			<?php foreach ( $packages as $key => $package ) :
				$product = wc_get_product( $package );
				if ( ! $product->is_type( array( 'listing_package', 'listing_package_subscription' ) ) || ! $product->is_purchasable() ) {
					continue;
				}
				?>
				<div class="p-0 col-sm-6 col-lg-4 col-12 <?php echo esc_attr($product->is_featured()?'col_is_featured':''); ?>">
					<div class="subwoo-inner <?php echo esc_attr($product->is_featured()?'is_featured':''); ?>">
						<div class="item">
							<div class="header-sub">
								<h3 class="title"><?php echo trim($product->get_title()); ?></h3>
								<?php echo get_the_content(null, false, $product->get_id()); ?>
								
							</div>
							<div class="bottom-sub">
								<div class="price">
									<?php echo (!empty($product->get_price())) ? $product->get_price_html() : esc_html__('Free', 'foogra'); ?>
								</div>
								<div class="short-des"><?php echo apply_filters( 'the_excerpt', get_post_field('post_excerpt', $product->get_id()) ) ?></div>
								<div class="button-action">
									<div class="add-cart">
										<button class="button" type="submit" name="wpldwpl_listing_package" value="<?php echo esc_attr($product->get_id()); ?>" id="package-<?php echo esc_attr($product->get_id()); ?>">
											<?php esc_html_e('Get Started', 'foogra') ?>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach;
				wp_reset_postdata();
			?>
		</div>
	</div>
<?php endif; ?>