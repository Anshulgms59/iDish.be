<?php get_header(); ?>
<div class="container mt-5">
    <h1>Archives</h1>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>
