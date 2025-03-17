<?php 
global $post;
$thumbsize = !isset($thumbsize) ? foogra_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
$thumb = foogra_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-grid'); ?>>
    <?php
        if ( !empty($thumb) ) {
            ?>
            <div class="top-image">
                <a href="<?php the_permalink(); ?>" class="btn-readmore"><?php echo esc_html__( 'Read more', 'foogra' )?></a>
                <?php
                    echo trim($thumb);
                ?>
             </div>
            <?php
        }
    ?>
    <div class="col-content">
        <div class="top-info">
            <?php 
                $cat = wp_get_post_categories( $post->ID );
                if( count($cat) > 0 ) {
            ?>
                <?php foogra_post_categories_first($post); ?> - 
            <?php } ?>
            <?php the_time( get_option('date_format', 'd M, Y') ); ?>
        </div>
        <?php if (get_the_title()) { ?>
            <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        <?php } ?>
        <div class="description"><?php echo foogra_substring( get_the_excerpt(),20, '...' ); ?></div>
        <div class="bottom-info d-flex align-items-center">
            <a class="author-wrapper" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                <div class="d-flex align-items-center">
                    <div class="avatar-img flex-shrink-0">
                        <?php echo foogra_get_avatar( get_the_author_meta( 'ID' ),40 ); ?>
                    </div>
                    <div class="author-title flex-grow-1">
                        <?php echo get_the_author(); ?>
                    </div>
                </div>
            </a>
            <span class="comment ms-auto">
                <i class="icon_comment_alt"></i><?php echo get_comments_number($post->ID); ?>
            </span>
        </div>
    </div>
</article>