<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;
$rating = get_comment_meta( $comment->comment_ID, '_rating_avg', true );

?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="the-comment">
		<div class="avatar-listing">
			<div class="avatar">
				<?php echo foogra_get_avatar( $comment->user_id, '70', '' ); ?>
			</div>
			<div class="name-comment">
				<?php comment_author(); ?>
			</div>
		</div>
		<div class="comment-box">
			<div class="d-flex align-items-center">
				<div class="review-avg-listing">
					<span class="review-avg"><?php echo number_format((float)$rating, 1, '.', ''); ?></span><span class="per">/5 </span>
					<?php echo esc_html__('Rating average','foogra') ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<span class="date-review ms-auto"><em><?php esc_html_e( 'Your comment is awaiting approval', 'foogra' ); ?></em></span>
				<?php else : ?>
					<span class="date-review ms-auto">
						<?php echo get_comment_date( get_option('date_format', 'd M, Y') ); ?>
					</span>
				<?php endif; ?>
			</div>
			<div class="comment-text">
				<?php comment_text(); ?>

				<?php WP_Listings_Directory_Review_Image::display_review_images(); ?>
			</div>
		</div>
	</div>