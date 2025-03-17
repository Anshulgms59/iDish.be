<?php
global $post;
wp_enqueue_script('addthis');
?>
<div class="apus-social-share">
	<div class="bo-social-icons">
		
		<?php if ( foogra_get_config('facebook_share', 1) ): ?>
 
			<a class="facebook" href="https://www.facebook.com/sharer.php?s=100&u=<?php the_permalink(); ?>&i=<?php echo urlencode($img); ?>" target="_blank" title="<?php echo esc_attr__('Share on facebook', 'foogra'); ?>">
				<i class="social_facebook"></i><?php echo esc_html__('Facebook', 'foogra'); ?>
			</a>
 
		<?php endif; ?>
		<?php if ( foogra_get_config('twitter_share', 1) ): ?>
			<a class="twitter" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank" title="<?php echo esc_attr__('Share on Twitter', 'foogra'); ?>">
				<i class="social_twitter"></i><?php echo esc_html__('Twitter', 'foogra'); ?>
			</a>
 
		<?php endif; ?>
		<?php if ( foogra_get_config('linkedin_share', 1) ): ?>
 
			<a class="linkedin" href="https://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank" title="<?php echo esc_attr__('Share on LinkedIn', 'foogra'); ?>">
				<i class="social_linkedin"></i><?php echo esc_html__('LinkedIn', 'foogra'); ?>
			</a>
 
		<?php endif; ?>

		<?php if ( foogra_get_config('pinterest_share', 1) ): ?>
 
			<a class="pinterest" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;media=<?php echo urlencode($img); ?>" target="_blank" title="<?php echo esc_attr__('Share on Pinterest', 'foogra'); ?>">
				<i class="social_pinterest"></i><?php echo esc_html__('Pinterest', 'foogra'); ?>
			</a>
 
		<?php endif; ?>
	</div>
</div>