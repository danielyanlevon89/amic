<?php get_header(); ?>
    <main class="site-main">
        <?php get_template_part('breadcrumbs'); ?>
        <?php global $wp_query;
        $i = 0; ?>
        <section class="post_blog_bg primary-bg">
            <div class="container">
                <div class="row">
                    <div class="page-content col-md-9">
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post();
                                $i++;
                                ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('blog_post'); ?> >
                                    <h3 class="title text-uppercase"><a
                                                href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h3>
                                    <div class="blog_post_img">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6"><a
                                                            href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                                                </div>
                                                <div class="col-md-6 short_content_text">
                                                    <?php $excerpt = get_the_content();
                                                    $excerpt = substr($excerpt, 0, 500);
                                                    $short_content = substr($excerpt, 0, strrpos($excerpt, ' '));
                                                    echo wp_strip_all_tags($short_content) . '... <a class="btn btn-md btn-gradient btn-shadow short_content_read_more" target="_blank"  href="' . get_the_permalink() . '">' . __('Read More', 'dor_raboti') . '</a>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>

                                <?php if ($i < $wp_query->found_posts) { ?>
                                    <hr class="search_result_separate">
                                <?php } ?>
                            <?php
                            endwhile; ?>
                        <?php else: ?>
                            <div class="blog_post no-results">
                                <?php esc_html_e('Nothing found!', 'dor_raboti'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('page-right-sidebar')) : endif;
                    ?>

                </div>
            </div>
        </section>
    </main>
<?php get_footer(); ?>