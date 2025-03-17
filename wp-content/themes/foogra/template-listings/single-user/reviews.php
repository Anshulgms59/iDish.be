<?php

global $author_obj;

$args = array( 'user_id' => $author_obj->ID );
$comments = WP_Listings_Directory_Review::get_review_comments( $args );
$number = 25;
$max_page = ceil(count($comments)/$number);
$page = !empty($_GET['cpage']) ? $_GET['cpage'] : 1;
?>
<div class="author-reviews">
	<h4 class="title">
        <?php esc_html_e( 'My Reviews', 'foogra' ); ?>
    </h4>
    <div class="widget-content">
		<?php
		echo '<ul class="list-reviews comment-list">';
			wp_list_comments(array(
				'per_page' => $number,
				'page' => $page,
				'reverse_top_level' => false,
				'callback' => 'foogra_my_review'
			), $comments);
		echo '</ul>';


		$pargs = array(
			'base' => add_query_arg( 'cpage', '%#%' ),
			'format' => '',
			'total' => $max_page,
			'current' => $page,
			'echo' => true,
			'add_fragment' => '',
			'prev_text'     => '«',
            'next_text'     => '»',
		);
		foogra_paginate_links( $pargs );
		?>
	</div>
</div>