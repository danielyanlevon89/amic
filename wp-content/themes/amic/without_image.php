<?php
/*
Template Name: Without image
Template Post Type: post, page
*/


?>
<?php get_header(); ?>
    <main class="site-main">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php $id = get_the_ID();?>
                <?php get_template_part('breadcrumbs'); ?>
                <section class="section padding-small">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="title text-uppercase text-amic-blue bolder-text"><?php the_title(); ?></h3>
                            </div>
                                <?php the_content(); ?>

                        </div>
                    </div>
                </section>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('page-sidebar')) : endif;
        ?>
    </main>
<?php get_footer(); ?>