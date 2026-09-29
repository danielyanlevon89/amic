<?php
/*
Template Name: Without  Sidebar And left image
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


                                <?php
                                if (has_post_thumbnail($post)) {
                                    $post_thumbnail_id = get_post_thumbnail_id($post);
                                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

                                    ?>
                                    <img class="shadow post_image"
                                         title="<?php echo apply_filters('the_title', $post->post_title, $post->ID); ?>"
                                         alt="<?php echo apply_filters('the_title', $post->post_title, $post->ID); ?>"
                                         src="<?php echo $post_thumbnail_url; ?>">
                                <?php } ?>

                                <h3 class="title text-uppercase text-amic-blue bolder-text"><?php the_title(); ?></h3>
                                <?php the_content(); ?>




                    </div>
                </section>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('page-sidebar')) : endif;
        ?>
    </main>
<?php get_footer(); ?>