<?php
/*
Template Name: With Right Sidebar And Gallery
Template Post Type: post
*/


?>
<?php get_header(); ?>
    <main class="site-main">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php $id = get_the_ID();
                $custom_page_title = get_post_meta($post->ID, 'custom_page_title', true);
                $background_image = get_post_meta($post->ID, 'custom_background', true);
                $show_background = get_post_meta($post->ID, 'show_background', true);
                $custom_gallery = get_post_meta($post->ID, 'custom_gallery', true);
                $background = '';
                if (isset($background_image['url']) && isset($show_background) && $show_background) {
                    $background = 'style="background: url(' . $background_image['url'] . ')"';
                }
                ?>
                <div class="page-header-sm" <?php echo $background; ?>>
                    <h1 class="text-uppercase page-title"><?php echo $custom_page_title; ?></h1>
                </div>
                <?php get_template_part('breadcrumbs'); ?>
                <section class="section padding-small">
                    <div class="container">
                        <div class="row">


                            <div class="col-sm-6">
                                <h3 class="title text-uppercase"><?php the_title(); ?></h3>
                                <?php the_content(); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                if (has_post_thumbnail($post)) {
                                    $post_thumbnail_id = get_post_thumbnail_id($post);
                                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

                                    ?>
                                    <img class="shadow"
                                         title="<?php echo apply_filters('the_title', $post->post_title, $post->ID); ?>"
                                         alt="<?php echo apply_filters('the_title', $post->post_title, $post->ID); ?>"
                                         src="<?php echo $post_thumbnail_url; ?>">
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </section>


                <section class="section padding-small">
                    <div class="container">
                        <div class="row">
                            <div class="page-content col-md-9 padding-bottom-xl">
                                <div class="gallery row">
                                    <?php
                                    $gallery_image_small = '';
                                    if (isset($custom_gallery)) {
                                        foreach ($custom_gallery as $k => $file) {
                                            $this_file = $file['url'];
                                            if ($this_file != '') {
                                                $gallery_image_small .= '<div class="col-xs-4">
                                                                   <figure class="gallery-item">
                                                                        <div class="gallery-icon" onclick="openModal();currentSlide(' . ($k + 1) . ')">
                                                                          <div class="img_column"><img style="width:100%; height:202px;    object-fit: cover;"  alt="' . $custom_page_title . '" src="' . $this_file . '" class="hover-shadow cursor"></div>
                                                                        </div>
                                                                   </figure>
                                                                </div>';
                                                $gallery_image_big .= '<div class="gallery_slider">
                                                                        <div class="numbertext">' . ($k + 1) . ' / ' . count($custom_gallery) . '</div>
                                                                        <img src="' . $this_file . '">
                                                                    </div>';
                                            }
                                        }
                                    }
                                    echo $gallery_image_small;
                                    ?>

                                </div>
                            </div>
                            <?php
                            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('page-right-sidebar')) : endif;
                            ?>
                        </div>
                    </div>
                </section>
                <div id="Gallery_Modal" class="modal">
                    <span class="close cursor" onclick="closeModal()">&times;</span>
                    <div class="modal-content">
                        <?php echo $gallery_image_big; ?>
                        <a class="prev" onclick="plusSlides(-1)"><span
                                    class="slider_arrow">&#10094;</span></a>
                        <a class="next" onclick="plusSlides(1)"><span
                                    class="slider_arrow">&#10095;</span></a>
                    </div>
                </div>

                <script>

                    function openModal() {
                        if (window.innerWidth < 800) {
                            return e.preventDefault();
                        }
                        jQuery(window).scrollTop(150);
                        document.getElementById("Gallery_Modal").style.display = "block";
                    }

                    function closeModal() {
                        document.getElementById("Gallery_Modal").style.display = "none";
                    }

                    var slideIndex = 1;
                    showSlides(slideIndex);

                    function plusSlides(n) {
                        showSlides(slideIndex += n);
                    }

                    function currentSlide(n) {
                        showSlides(slideIndex = n);
                    }

                    function showSlides(n) {
                        var i;
                        var slides = document.getElementsByClassName("gallery_slider");
                        if (n > slides.length) {
                            slideIndex = 1
                        }
                        if (n < 1) {
                            slideIndex = slides.length
                        }
                        for (i = 0; i < slides.length; i++) {
                            slides[i].style.display = "none";
                        }
                        slides[slideIndex - 1].style.display = "block";
                    }

                    jQuery(document).click(function (event) {
                        if (!jQuery(event.target).closest(".modal-content,.gallery-icon").length) {
                            document.getElementById("Gallery_Modal").style.display = "none";
                        }
                    });

                </script>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('page-sidebar')) : endif;
        ?>
    </main>
<?php get_footer(); ?>