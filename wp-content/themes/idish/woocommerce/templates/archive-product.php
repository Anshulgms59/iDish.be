<?php
get_header(); ?>

<div class="idish-shop-container">
    <h1 class="shop-title"><?php woocommerce_page_title(); ?></h1>

    <div class="idish-shop-sidebar">
        <?php dynamic_sidebar('shop-sidebar'); ?>
    </div>

    <div class="idish-shop-products">
        <?php if (woocommerce_product_loop()) : ?>
            <div class="products-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php wc_get_template_part('content', 'product'); ?>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
