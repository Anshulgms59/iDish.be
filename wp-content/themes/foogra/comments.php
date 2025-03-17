<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Foogra
 * @since Foogra 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<div class="box-comment">
	        <h3 class="comments-title"><?php comments_number( esc_html__('0 Comments', 'foogra'), esc_html__('1 Comment', 'foogra'), esc_html__('% Comments', 'foogra') ); ?></h3>
			<ol class="comment-list">
				<?php wp_list_comments('callback=foogra_comment_item'); ?>
			</ol><!-- .comment-list -->

			<?php foogra_comment_nav(); ?>
		</div>	
	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'foogra' ); ?></p>
	<?php endif; ?>

	<?php
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $comment_args = array(
                        'title_reply'=> esc_html__('Leave a Comment','foogra'),
                        'comment_field' => '<div class="form-group space-comment">
                                                <textarea rows="7" id="comment" class="form-control" placeholder="'.esc_attr__('Enter Your Comment', 'foogra').'" name="comment"'.$aria_req.'></textarea>
                                            </div>',
                        'fields' => apply_filters(
                        	'comment_form_default_fields',
	                    		array(
	                                'author' => '<div class="row row-20"><div class="col-12 col-sm-4"><div class="form-group ">
	                                            <input type="text" name="author" class="form-control" id="author" placeholder="'.esc_attr__('Name', 'foogra').'" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
	                                            </div></div>',
	                                'email' => ' <div class="col-12 col-sm-4"><div class="form-group ">
	                                            <input id="email"  name="email" class="form-control" type="text" placeholder="'.esc_attr__('Email', 'foogra').'" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
	                                            </div></div>',
	                                'Website' => ' <div class="col-12 col-sm-4"><div class="form-group ">
	                                            <input id="website" name="website" placeholder="'.esc_attr__('Website', 'foogra').'" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" ' . $aria_req . ' />
	                                            </div></div></div>',
	                            )
							),
	                        'label_submit' => esc_html__('Submit Comment', 'foogra'),
							'comment_notes_before' => '',
							'comment_notes_after' => '',
							'title_reply_before' => '<h4 class="comment-reply-title">',
							'title_reply_after'  => '</h4>',
							'class_submit' => 'btn btn-sm btn-theme'
                        );
    ?>

	<?php foogra_comment_form($comment_args); ?>
</div><!-- .comments-area -->