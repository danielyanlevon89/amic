<?php get_header();
?>


    <main class="site-main">
        <?php get_template_part('breadcrumbs'); ?>
        <?php global $wp_query;
        $i = 0; ?>
        <section class="post_blog_bg primary-bg">
            <div class="container">
                <div class="row">
                    <div class="page-content">
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post();

                                $custom_social_links = get_post_meta(get_the_ID(), 'custom_social_links', true);
                                $custom_social_links_arr = explode("[--1--]", $custom_social_links);

                                $i++;
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <article id="post-<?php the_ID(); ?>" <?php post_class('blog_post'); ?> >


                                    <?php
                                    $post = get_post();
                                    if (has_post_thumbnail($post)) {
                                        $post_thumbnail_id = get_post_thumbnail_id($post);
                                        $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

                                        ?>
                                    <div class="blog_post_img">
                                        <a  href="<?php the_permalink(); ?>">
                                        <img class="shadow"
                                             title="<?php echo apply_filters('the_title', $post->post_title, $post->ID); ?>"
                                             alt="<?php echo apply_filters('the_title', $post->post_title, $post->ID); ?>"
                                             src="<?php echo $post_thumbnail_url; ?>">
                                        </a>
                                    </div>
                                    <?php } ?>
                                    <div class="blog_post_social">
                                        <h3 class="title text-uppercase"><a
                                                    href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a></h3>
                                        <div class="social-connect">
                                            <?php  if($custom_social_links_arr[0]){echo '<a href="'.$custom_social_links_arr[0].'"><i class="fa fa-globe"></i> '.esc_html('Website', 'dor_raboti').'</a>';} ?>
                                            <?php  if($custom_social_links_arr[1]){echo '<a href="'.$custom_social_links_arr[1].'"><i class="fa fa-facebook"></i> '.esc_html('Facebook', 'dor_raboti').'</a>';} ?>
                                            <?php  if($custom_social_links_arr[2]){echo '<a href="'.$custom_social_links_arr[2].'"><i class="fa fa-instagram"></i> '.esc_html('Instagram', 'dor_raboti').'</a>';} ?>
                                            <?php  if($custom_social_links_arr[3]){echo '<a href="'.$custom_social_links_arr[3].'"><i class="fa fa-linkedin"></i> '.esc_html('Linkedin', 'dor_raboti').'</a>';} ?>
                                            <?php  if($custom_social_links_arr[4]){echo '<a href="'.$custom_social_links_arr[4].'"><i class="fa fa-youtube"></i> '.esc_html('Youtube', 'dor_raboti').'</a>';} ?>
                                            <?php  if($custom_social_links_arr[5]){echo '<a href="'.$custom_social_links_arr[5].'"><i class="fa fa-twitter"></i> '.esc_html('Twitter', 'dor_raboti').'</a>';} ?>
                                        </div>
                                        <a class="btn btn-md btn-gradient btn-shadow short_content_read_more" target="_blank"  href="<?=get_the_permalink()?>"><?= __('Read More', 'dor_raboti')?></a>
                                    </div>
                                </article>
                                </div>
                            <?php
                            endwhile; ?>
                        <?php else: ?>
                            <div class="blog_post no-results">
                                <?php esc_html_e('Nothing found!', 'dor_raboti'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </section>
    </main>
<?php get_footer(); ?>