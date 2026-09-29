<?php

class Features_Widget extends WP_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            'features_widget', // Base ID
            __('Features Widget', 'dor_raboti'), // Name
            array('description' => __('Displays one of your Features Widgets.', 'dor_raboti')) // Args
        );
        add_filter('excerpt_length', array($this, 'feature_excerpt_length'), 999);
        add_filter('excerpt_more', array($this, 'feature_excerpt_more'));
    }


    function feature_excerpt_more($more)
    {
        return '';
    }

    function feature_excerpt_length($length)
    {
        return 10;
    }


    public function widget($args, $instance)
    {
        $id = ($instance['feature-widget-id']) ? $instance['feature-widget-id'] : 0;
        $show_title = (isset($instance['show_title'])) ? $instance['show_title'] : 1;
        $post = get_post($id);

        $checkfield = maybe_unserialize(get_post_meta($post->ID, "checkfield", true));
        $checkfield_category = maybe_unserialize(get_post_meta($post->ID, "checkfield_category", true));
        $features_type = get_post_meta($post->ID, "features_type", true);
        $background_class = get_post_meta($post->ID, "background_class", true);
        $show_feature_read_more = get_post_meta($post->ID, "show_feature_read_more", true);
        $background_image = get_post_meta($post->ID, 'custom_background', true);
        $show_background = get_post_meta($post->ID, 'show_background', true);

        $section_class = ' ';
        $title_class = ' title ';
        if (isset($background_image['url']) && isset($show_background) && $show_background) {
            $background = 'style="background: url(' . $background_image['url'] . ')"';
            $title_class .= ' wht ';
        }
        if ($features_type == 'card') {
            $title_class .= ' custom_text_title ';
        }
        if ($background_class) {
            $section_class .= $background_class;
        }

        echo $args['before_widget'];
        echo '<section ' . $background . '  class="features ' . $section_class . '">
    <div class="container">
        <div class="row">';
        if (!empty($id) && $post) {

            if ($checkfield_category) {
                $pages = get_posts(array(
                    'orderby'        => 'rand',
                    'numberposts'       => -1,
                    'category' => $checkfield_category[0]
                ));
            } elseif ($checkfield) {

                $pages = get_pages(array(
                    'include' => implode( ',',$checkfield)
                ));

            }


            if ($show_title) {

                $title = (isset($instance['title'])) ? $instance['title'] : $post->post_title;
                $title = apply_filters('widget_title', $title);
                echo $args['before_title'] . '
                     <div class="col-md-12">
                        <h2 class="' . $title_class . '">' . $title . '</h2>
                     </div>
                  ' . $args['after_title'];
            }

            if ($pages) {
                if ($features_type == 'static') { ?>
                    <div class="col-md-12">
                        <div class="row projects-content-static">
                            <?php
                            foreach ($pages as $page) :?>
                                <div class=" col-md-4 projects-item-static ">
                                    <div class="featured <?php if (!$show_title) { ?>featured-push-top<?php } ?>">
                                        <div class="featured-header">
                                            <?php
                                            if (has_post_thumbnail($page)) {
                                                $post_thumbnail_id = get_post_thumbnail_id($page);
                                                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                                                ?>
                                                <img title="<?php echo apply_filters('the_title', $page->post_title, $page->ID); ?>"
                                                     alt="<?php echo apply_filters('the_title', $page->post_title, $page->ID); ?>"
                                                     class="wp-post-image" src="<?php echo $post_thumbnail_url; ?>"
                                                     style="width:100%; height:202px;    object-fit: cover;">
                                            <?php } ?>
                                        </div>
                                        <div class="featured-content">
                                            <h3 class="featured-title text-uppercase"><?php echo apply_filters('the_title', $page->post_title, $page->ID); ?></h3>
                                            <p class="featured-desc"><?php echo wp_strip_all_tags(get_the_excerpt($page)); ?></p>
                                            <?php
                                            if ($show_feature_read_more) {
                                                $more = sprintf('<a href="%1$s" target="_blank"  class="btn btn-md btn-gradient btn-shadow">%2$s &gt;&gt;</a>',
                                                    get_permalink($page->ID),
                                                    __('Read More', 'dor_raboti')
                                                );
                                                echo $more;
                                            } ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                }
                elseif ($features_type == 'card') {

                    foreach ($pages as $page) : ?>
                        <?php
                        if (has_post_thumbnail($page)) {
                            $post_thumbnail_id = get_post_thumbnail_id($page);
                            $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                            $custom_social_links = get_post_meta($page->ID, 'custom_social_links', true);
                            $custom_social_links_arr = explode("[--1--]", $custom_social_links);
                            ?>


                        <div class="col-md-3 col-sm-6">
                            <div class="col-item">

                                <div class="photo">
                                    <a href="<?= get_permalink($page->ID); ?>">
                                        <img src="<?php echo $post_thumbnail_url; ?>" alt="<?php echo apply_filters('the_title', $page->post_title, $page->ID); ?>">
                                    </a>
                                </div>
                                <div class="info">
                                    <div class="name"><?php echo apply_filters('the_title', $page->post_title, $page->ID); ?></div>
                                    <div class="social-connect">
                                        <?php  if($custom_social_links_arr[0]){echo '<a href="'.$custom_social_links_arr[0].'"><i class="fa fa-globe"></i></a>';} ?>
                                        <?php  if($custom_social_links_arr[1]){echo '<a href="'.$custom_social_links_arr[1].'"><i class="fa fa-facebook"></i></a>';} ?>
                                        <?php  if($custom_social_links_arr[2]){echo '<a href="'.$custom_social_links_arr[2].'"><i class="fa fa-instagram"></i></a>';} ?>
                                        <?php  if($custom_social_links_arr[3]){echo '<a href="'.$custom_social_links_arr[3].'"><i class="fa fa-linkedin"></i></a>';} ?>
                                        <?php  if($custom_social_links_arr[4]){echo '<a href="'.$custom_social_links_arr[4].'"><i class="fa fa-youtube"></i></a>';} ?>
                                        <?php  if($custom_social_links_arr[5]){echo '<a href="'.$custom_social_links_arr[5].'"><i class="fa fa-twitter"></i></a>';} ?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                    <?php }
                        endforeach;
                }
                elseif ($features_type == 'slider') {
                    echo '<div class="col-md-12">
                            <div class="projects-slider projects">
                            <div class="row projects-track">';
                    foreach ($pages as $page) : ?>


                        <div class="projects-item">
                            <div class="projects-item-wrap">
                                <?php
                                if (has_post_thumbnail($page)) {
                                    $post_thumbnail_id = get_post_thumbnail_id($page);
                                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                                    ?>
                                <a href="<?= get_permalink($page->ID); ?>">
                                    <img src="<?php echo $post_thumbnail_url; ?>" style="height:150px;object-fit: fill;"
                                         alt="<?php echo apply_filters('the_title', $page->post_title, $page->ID); ?>">
                                </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach;
                    echo '</div>';
                }
                elseif ($features_type == 'gallery') {
                    echo '<div class="col-md-12">
                        <div class="row projects-content">';
                    foreach ($pages as $page) : ?>


                        <div class="projects-item col-md-4">
                            <div class="projects-item-wrap">
                                <?php
                                if (has_post_thumbnail($page)) {
                                    $post_thumbnail_id = get_post_thumbnail_id($page);
                                    $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                                    ?>
                                    <img src="<?php echo $post_thumbnail_url; ?>" style="height: 202px;width: 100%;    object-fit: cover;"
                                         alt="<?php echo apply_filters('the_title', $page->post_title, $page->ID); ?>">
                                <?php } ?>
                                <div class="project-hover">
                                    <h3 class="project-title text-uppercase"><?php echo apply_filters('the_title', $page->post_title, $page->ID); ?></h3>
                                    <p class="project-desc"><?php echo wp_strip_all_tags(get_the_excerpt($page)); ?></p>
                                    <?php
                                    $more = sprintf('<a href="%1$s" target="_blank"  class="btn btn-md">%2$s &gt;&gt;</a>',
                                        get_permalink($page->ID),
                                        __('Read More', 'dor_raboti')
                                    );
                                    echo $more; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                    echo '</div>
                </div>';
                }
            }


        } elseif (current_user_can('manage_options')) { ?>
            <p>
                <?php if (empty($id)) {
                    _e('Please select a feature to show in this area.', 'dor_raboti');
                } else {
                    printf(__('No feature found with ID %d, please select an existing feature in the widget settings.', 'dor_raboti'), $id);
                } ?>
            </p>
            <?php
        }

        echo $args['after_widget'];
        echo '</div>
    </div>
</section>';

    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     * @see WP_Widget::update()
     *
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['feature-widget-id'] = isset($new_instance['feature-widget-id']) ? $new_instance['feature-widget-id'] : 0;
        $instance['show_title'] = (isset($new_instance['show_title']) && $new_instance['show_title'] == 1) ? 1 : 0;
        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @param array $instance Previously saved values from database.
     * @return string|void
     * @see WP_Widget::form()
     *
     */
    public function form($instance)
    {

        $posts = (array)get_posts(array(
            'post_type' => 'features-widget',
            'numberposts' => -1
        ));

        $show_title = isset($instance['show_title']) ? $instance['show_title'] : 1;
        $selected_widget_id = isset($instance['feature-widget-id']) ? $instance['feature-widget-id'] : 0;
        $title = ($selected_widget_id) ? get_the_title($selected_widget_id) : __('No feature selected.', 'dor_raboti');
        ?>

        <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
               type="hidden" value="<?php echo esc_attr($title); ?>"/>

        <p>
            <label for="<?php echo $this->get_field_id('feature-widget-id'); ?>"><?php _e('Feature to show:', 'dor_raboti'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('feature-widget-id'); ?>"
                    name="<?php echo $this->get_field_name('feature-widget-id'); ?>" required>
                <option value="0" disabled <?php selected($selected_widget_id, 0); ?>>
                    <?php if (empty($posts)) {
                        _e('No feature found', 'dor_raboti');
                    } else {
                        _e('Select a feature', 'dor_raboti');
                    } ?>
                </option>
                <?php foreach ($posts as $p) { ?>
                    <option value="<?php echo $p->ID; ?>" <?php selected($selected_widget_id, $p->ID); ?>><?php echo $p->post_title; ?></option>
                <?php } ?>
            </select>
        </p>

        <p>
            <label><input type="checkbox" id="<?php echo $this->get_field_id('show_title'); ?>"
                          name="<?php echo $this->get_field_name('show_title'); ?>"
                          value="1" <?php checked($show_title, 1); ?> /> <?php _e("Show title?", "dor_raboti"); ?>
            </label>
        </p>

        <p class="help"><?php printf(__('Manage your features %shere%s', 'dor_raboti'), '<a target="_blank" href="' . admin_url('post.php?post=' . $selected_widget_id . '&action=edit') . '">', '</a>'); ?></p>
        <?php
    }

}