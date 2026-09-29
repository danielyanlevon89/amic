<?php

class Features_Widgets_Admin
{

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_meta_box'), 20);
        add_action('save_post', array($this, 'features_meta_save'), 10, 2);
    }

    public function add_meta_box()
    {
        add_meta_box(
            'features-widget-meta-box',
            __('More..', 'dor_raboti'),
            array($this, 'features_meta_box'),
            'features-widget',
            'side',
            'low'
        );
    }

    public function features_meta_box($post)
    {
        // we store data as an array, we need to unserialize it
        $checkfield = maybe_unserialize(get_post_meta($post->ID, "checkfield", true));
        $checkfield_category = maybe_unserialize(get_post_meta($post->ID, "checkfield_category", true));
        $features_type = get_post_meta($post->ID, "features_type", true);
        $background_class = get_post_meta($post->ID, "background_class", true);
        $show_feature_read_more = get_post_meta($post->ID, "show_feature_read_more", true);

        // Nonce to verify intention later
        wp_nonce_field('save_post', 'custom_nonce');
        ?>
        <link rel="stylesheet" id="features_style" href="<?php echo plugin_dir_url(__FILE__); ?>style.css" media="all">
        <script src="<?php echo plugin_dir_url(__FILE__); ?>script.js" type="text/javascript" defer=""></script>
        <div style="margin-top: 30px;">
            <h4 class="accordion"><?php _e('Choose Category To Display', 'dor_raboti'); ?></h4>
            <div class="panel">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'parent' => 0,
                    'hide_empty' => false
                ));

                foreach ($categories as $category) { ?>
                    <input id="category_<?php echo $category->cat_ID; ?>" type="checkbox" name="checkfield_category[]"
                           value="<?php echo $category->cat_ID; ?>" <?php if (in_array($category->cat_ID, (array)$checkfield_category)) { ?> checked <?php } ?>/>
                    <label for="category_<?php echo $category->cat_ID; ?>"><?php echo $category->name; ?></label> <br>
                <?php } ?>
            </div>
        </div>
        <div style="margin-top: 30px;">
            <h4 class="accordion"><?php _e('Choose Pages To Display', 'dor_raboti'); ?></h4>
            <div class="panel">
                <?php
                $pages = get_pages();
                foreach ($pages as $page) { ?>
                    <input id="page_<?php echo $page->ID; ?>" type="checkbox" name="checkfield[]"
                           value="<?php echo $page->ID; ?>" <?php if (in_array($page->ID, (array)$checkfield)) { ?> checked <?php } ?>/>
                    <label for="page_<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></label> <br>
                    <?php
                }
                ?>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <h4><?php _e('Choose Feature Type', 'dor_raboti'); ?></h4>
            <select name="features_type">
                <option value="static" <?php if ('static' == $features_type) { ?> selected <?php } ?>><?php echo esc_html__('Static', 'dor_raboti') ?></option>
                <option value="slider" <?php if ('slider' == $features_type) { ?> selected <?php } ?>><?php echo esc_html__('Slider', 'dor_raboti') ?></option>
                <option value="card" <?php if ('card' == $features_type) { ?> selected <?php } ?>><?php echo esc_html__('Card', 'dor_raboti') ?></option>
                <option value="gallery" <?php if ('gallery' == $features_type) { ?> selected <?php } ?>><?php echo esc_html__('Gallery', 'dor_raboti') ?></option>
            </select>
        </div>
        <div style="margin-top: 30px;">
            <h4><?php _e('Background Class', 'dor_raboti'); ?></h4>
            <input type="text" name="background_class" value="<?php echo $background_class; ?>"/>

        </div>
        <div style="margin-top: 30px;">
            <h4><?php _e('Show Read More', 'dor_raboti'); ?></h4>
            <input type="checkbox" name="show_feature_read_more"
                   value="<?php echo $page->ID; ?>" <?php if ($show_feature_read_more) { ?> checked <?php } ?>"/>
        </div>


        <?php
    }

//save the meta box
    function features_meta_save($post_id, $post)
    {
        if (wp_verify_nonce($_POST['custom_nonce'], 'save_post')) {
            update_post_meta($post_id, "checkfield", $_POST['checkfield']);
            update_post_meta($post_id, "checkfield_category", $_POST['checkfield_category']);
            update_post_meta($post_id, "features_type", $_POST['features_type']);
            update_post_meta($post_id, "background_class", $_POST['background_class']);
            update_post_meta($post_id, "show_feature_read_more", $_POST['show_feature_read_more']);
        }
    }
}