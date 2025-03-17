<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('detail-post-top'); ?>>
    <div class="entry-content-detail header-info-blog">
        <?php if(has_post_thumbnail()) { ?>
            <div class="entry-thumb">
                <?php
                    $thumb = foogra_post_thumbnail();
                    echo trim($thumb);
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="inner-detail-blog">
        <div class="header-info-blog-inner">
            <?php if (get_the_title()) { ?>
                <h1 class="detail-title">
                    <?php the_title(); ?>
                </h1>
            <?php } ?>
            <div class="top-detail-info clearfix">
                <?php foogra_post_categories($post); ?>
                <span class="date">
                    <i class="icon_calendar"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?>
                </span>
                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                    <i class="icon_pencil-edit"></i><?php echo get_the_author(); ?>
                </a>
                <span class="comment">
                    <i class="icon_comment_alt"></i><?php comments_number( esc_html__('(0) Comments', 'foogra'), esc_html__('(1) Comment', 'foogra'), esc_html__('(%) Comments', 'foogra') ); ?>
                </span>
            </div>
        </div>
        <div class="entry-content-detail <?php echo esc_attr((!has_post_thumbnail())?'not-img-featured':'' ); ?>">

            <div class="single-info info-bottom">
                <div class="entry-description clearfix">
                    <?php
                        the_content();
                    ?>
                </div><!-- /entry-content -->
                <?php
                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'foogra' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'foogra' ) . ' </span>%',
                    'separator'   => '',
                ) );
                ?>
                <?php  
                    $posttags = get_the_tags();
                ?>
                <?php if( !empty($posttags) || foogra_get_config('show_blog_social_share', false) ){ ?>
                    <div class="tag-social d-md-flex align-items-center">
                        <?php if( foogra_get_config('show_blog_social_share', false) ) { ?>
                            <?php get_template_part( 'template-parts/sharebox' ); ?>
                        <?php } ?>
                        <?php if(!empty($posttags)){ ?>
                            <div class="<?php echo esc_attr( (foogra_get_config('show_blog_social_share', false))?'ms-auto':'' ); ?>">
                                <?php foogra_post_tags(); ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</article>