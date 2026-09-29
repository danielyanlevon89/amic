<?php

class WPDocs_Walker_Nav_Menu extends Walker_Nav_Menu
{

    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        // Depth-dependent classes.
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
        $display_depth = ($depth + 1); // because it counts the first submenu as 0
        $classes = array(
            'sub-menu',
            ($display_depth % 2 ? 'menu-odd' : 'menu-even'),
            ($display_depth >= 2 ? 'sub-sub-menu' : ''),
            'menu-depth-' . $display_depth
        );
        $class_names = implode(' ', $classes);

        // Build HTML for output.
        $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
    }

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param array $args An array of arguments. @see wp_nav_menu()
     * @param int $id Current item ID.
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        global $wp_query;
        $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent

        // Depth-dependent classes.
        $depth_classes = array(
            ($depth == 0 ? 'main-menu-item' : 'sub-menu-item'),
            ($depth >= 2 ? 'sub-sub-menu-item' : ''),
            ($depth % 2 ? 'menu-item-odd' : 'menu-item-even'),
            'menu-item-depth-' . $depth
        );
        $depth_class_names = esc_attr(implode(' ', $depth_classes));

        // Passed classes.
        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

        // Build HTML.
        $output .= $indent . '<li  class="menu-item ' . $class_names . '">';

        // Link attributes.
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="menu-link ' . ($depth > 0 ? 'sub-menu-link' : 'main-menu-link') . '"';

        // Build HTML output and pass through the proper filter.
        $item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $args->before,
            $attributes,
            $args->link_before,
            apply_filters('the_title', $item->title, $item->ID),
            $args->link_after,
            $args->after
        );
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

class Custom_Page_Title
{
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_custom_page_title_meta_boxes'));
        add_action('save_post', array($this, 'save_custom_page_title_meta_data'));
    }

    function add_custom_page_title_meta_boxes()
    {
        add_meta_box(
            'custom_page_title',
            esc_html__('Custom Page Title', 'dor_raboti'),
            array($this, 'custom_page_title'),
            array('post', 'page'),
            'side'
        );
    }

    function custom_page_title()
    {
        $html = '';
        $custom_page_title = get_post_meta(get_the_ID(), 'custom_page_title', true);
        $html .= '<input type="text" name="custom_page_title" value="' . $custom_page_title . '" "/>';


        echo $html;
    }

    function save_custom_page_title_meta_data($id)
    {
        update_post_meta($id, 'custom_page_title', $_POST['custom_page_title']);
    }

}

$custom_page_title = new Custom_Page_Title();

class Custom_Meta_Tags
{
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_custom_meta_tags_meta_boxes'));
        add_action('save_post', array($this, 'save_custom_meta_tags_meta_data'));
    }

    function add_custom_meta_tags_meta_boxes()
    {
        add_meta_box(
            'custom_meta_tags',
            esc_html__('SEO Meta Tags', 'dor_raboti'),
            array($this, 'custom_meta_tags'),
            array('post', 'page'),
            'side'
        );
    }

    function custom_meta_tags()
    {
        $html = '';
        $custom_meta_tags = get_post_meta(get_the_ID(), 'custom_meta_tags', true);
        $custom_meta_tags_arr = explode("[--1--]", $custom_meta_tags);
        $html .= '<table><tr><td>' . esc_html__('Keyword', 'dor_raboti') . '</td><td><textarea  name="custom_meta_tags_key" />' . $custom_meta_tags_arr[0] . '</textarea></textarea></td></tr>';
        $html .= '<tr><td>' . esc_html__('Description', 'dor_raboti') . '</td><td><textarea  name="custom_meta_tags_desc" />' . $custom_meta_tags_arr[1] . '</textarea></td></tr></table>';


        echo $html;
    }

    function save_custom_meta_tags_meta_data($id)
    {
        $custom_meta_tags_arr = array($_POST['custom_meta_tags_key'],$_POST['custom_meta_tags_desc']);
        $custom_meta_tags =  implode("[--1--]",$custom_meta_tags_arr);
        update_post_meta($id, 'custom_meta_tags', $custom_meta_tags);
    }

}

$custom_meta_tags = new Custom_Meta_Tags();



class Custom_Social_links
{
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_custom_social_links_boxes'));
        add_action('save_post', array($this, 'save_custom_social_links'));
    }

    function add_custom_social_links_boxes()
    {
        add_meta_box(
                'custom_social_links',
                esc_html__('Social Links', 'dor_raboti'),
                array($this, 'custom_social_links'),
                array('post', 'page'),
                'side'
        );
    }

    function custom_social_links()
    {
        $html = '';
        $custom_social_links = get_post_meta(get_the_ID(), 'custom_social_links', true);
        $custom_social_links_arr = explode("[--1--]", $custom_social_links);
        $html .= '<table>';
        $html .= '<tr><td>' . esc_html__('Website', 'dor_raboti') . '</td><td><input  name="custom_social_link_website" value="' . $custom_social_links_arr[0] . '"/></td></tr>';
        $html .= '<tr><td>' . esc_html__('Facebook', 'dor_raboti') . '</td><td><input  name="custom_social_link_facebook"  value="' . $custom_social_links_arr[1] . '"></td></tr>';
        $html .= '<tr><td>' . esc_html__('Instagram', 'dor_raboti') . '</td><td><input  name="custom_social_link_instagram"  value="' . $custom_social_links_arr[2] . '"></td></tr>';
        $html .= '<tr><td>' . esc_html__('Linkedin', 'dor_raboti') . '</td><td><input  name="custom_social_link_linkedin"  value="' . $custom_social_links_arr[3] . '"></td></tr>';
        $html .= '<tr><td>' . esc_html__('Youtube', 'dor_raboti') . '</td><td><input  name="custom_social_link_youtube"  value="' . $custom_social_links_arr[4] . '"></td></tr>';
        $html .= '<tr><td>' . esc_html__('Twitter', 'dor_raboti') . '</td><td><input  name="custom_social_link_twitter"  value="' . $custom_social_links_arr[5] . '"></td></tr>';
        $html .= '</table>';


        echo $html;
    }

    function save_custom_social_links($id)
    {
        $custom_social_links_arr = [
                $_POST['custom_social_link_website'],
                $_POST['custom_social_link_facebook'],
                $_POST['custom_social_link_instagram'],
                $_POST['custom_social_link_linkedin'],
                $_POST['custom_social_link_youtube'],
                $_POST['custom_social_link_twitter'],
        ];
        $custom_social_links =  implode("[--1--]",$custom_social_links_arr);
        update_post_meta($id, 'custom_social_links', $custom_social_links);
    }

}

$custom_social_links = new Custom_Social_links();


class Custom_Background_Image
{
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_custom_backgroung_meta_boxes'));
        add_action('post_edit_form_tag', array($this, 'update_edit_form'));
        add_action('save_post', array($this, 'save_custom_background_meta_data'));
    }

    function add_custom_backgroung_meta_boxes()
    {
        add_meta_box(
            'custom_background',
            esc_html__('Background Image', 'dor_raboti'),
            array($this, 'custom_background'),
            array('post', 'page', 'custom_text-widget', 'features-widget'),
            'side'
        );
    }

//page background
    function custom_background()
    {


        $html = '';
        $filearray = get_post_meta(get_the_ID(), 'custom_background', true);
        $show_background = get_post_meta(get_the_ID(), 'show_background', true);
        $show_background_checked = '';
        if ($show_background) {
            $show_background_checked = 'checked';
        }
        if (isset($filearray['url'])) {

            $this_file = $filearray['url'];

            if ($this_file != '') {
                $html = '<div><p> ' . esc_html__('Current file path:', 'dor_raboti') . $this_file . '</p></div>';
                $html .= '<img src="' . $this_file . '" style="width:100%">';
            }
        }
        $html .= '<p class="description">' . esc_html__('Show Background.', 'dor_raboti') . '</p>';
        $html .= '<input type="checkbox" name="show_background" ' . $show_background_checked . ' "/>';
        $html .= '<p class="description">' . esc_html__('Upload your Page Background here.', 'dor_raboti') . '</p>';
        $html .= '<input id="custom_background" name="custom_background" size="25" type="file" value="" />';

        echo $html;
    }

    function save_custom_background_meta_data($id)
    {

        update_post_meta($id, 'show_background', $_POST['show_background']);
        if (!empty($_FILES['custom_background']['name'])) {
            $supported_types = array('image/png', 'image/jpg', 'image/jpeg');
            $arr_file_type = wp_check_filetype(basename($_FILES['custom_background']['name']));
            $uploaded_type = $arr_file_type['type'];
            if (in_array($uploaded_type, $supported_types)) {
                $upload = wp_upload_bits($_FILES['custom_background']['name'], null, file_get_contents($_FILES['custom_background']['tmp_name']));
                $ext = pathinfo($upload['url'], PATHINFO_EXTENSION);
                if (isset($upload['error']) && $upload['error'] != 0) {
                    wp_die(esc_html__('There was an error uploading your file. The error is: ', 'dor_raboti') . $upload['error']);
                } else {
                    if ($ext == '') {
                        $wp_filetype = wp_check_filetype($_FILES['custom_background']['name']);
                        $upload['url'] = $upload['url'] . '/' . sanitize_file_name($_FILES['custom_background']['name']);
                        $upload['file'] = $upload['path'] . '/' . sanitize_file_name($_FILES['custom_background']['name']);
                        $upload['type'] = $wp_filetype['type'];
                    }
                    update_post_meta($id, 'custom_background', $upload);
                }
            } else {
                wp_die(esc_html__("The file type that you've uploaded is not a supported.", 'dor_raboti'));
            }
        }

    }


    function update_edit_form()
    {
        echo ' enctype="multipart/form-data"';
    }
}

$custom_background = new Custom_Background_Image();


class Custom_Gallery_Images
{
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_custom_gallery_meta_boxes'));
        add_action('post_edit_form_tag', array($this, 'update_edit_form'));
        add_action('save_post', array($this, 'save_custom_gallery_meta_data'));
    }

    function add_custom_gallery_meta_boxes()
    {
        add_meta_box(
            'custom_gallery',
            esc_html__('Custom Gallery', 'dor_raboti'),
            array($this, 'custom_gallery'),
            array('post'),
            'normal'
        );
    }


    function custom_gallery()
    {
        $html = '';
        $filearray = get_post_meta(get_the_ID(), 'custom_gallery', true);
        if ($filearray) {

            foreach ($filearray as $file) {
                $this_file = $file['url'];
                if ($this_file != '') {
                    $html .= '<img src="' . $this_file . '" style="width:33%;float: left;">';
                }
            }
        }

        $html .= '<p class="description" style="clear: both;">' . esc_html__('Upload your Gallery Images here.', 'dor_raboti') . '</p>';
        $html .= '<input id="custom_gallery" name="custom_gallery[]" size="25" type="file" multiple value="" />';

        echo $html;
    }

    function save_custom_gallery_meta_data($id)
    {
        $uploaded_arr = array();
        if ($_FILES['custom_gallery']) {
            $countfiles = count($_FILES['custom_gallery']['name']);
            for ($i = 0; $i < $countfiles; $i++) {
                if (!empty($_FILES['custom_gallery']['name'][$i])) {
                    $supported_types = array('image/png', 'image/jpg', 'image/jpeg');
                    $arr_file_type = wp_check_filetype(basename($_FILES['custom_gallery']['name'][$i]));
                    $uploaded_type = $arr_file_type['type'];
                    if (in_array($uploaded_type, $supported_types)) {
                        $upload = wp_upload_bits($_FILES['custom_gallery']['name'][$i], null, file_get_contents($_FILES['custom_gallery']['tmp_name'][$i]));
                        $ext = pathinfo($upload['url'], PATHINFO_EXTENSION);
                        if (isset($upload['error']) && $upload['error'] != 0) {
                            wp_die(esc_html__('There was an error uploading your file. The error is: ', 'dor_raboti') . $upload['error']);
                        } else {
                            if ($ext == '') {
                                $wp_filetype = wp_check_filetype($_FILES['custom_gallery']['name'][$i]);
                                $upload['url'] = $upload['url'] . '/' . sanitize_file_name($_FILES['custom_gallery']['name'][$i]);
                                $upload['file'] = $upload['path'] . '/' . sanitize_file_name($_FILES['custom_gallery']['name'][$i]);
                                $upload['type'] = $wp_filetype['type'];
                            }
                            $uploaded_arr[] = $upload;
                        }
                    } else {
                        wp_die(esc_html__("The file type that you've uploaded is not a supported.", 'dor_raboti'));
                    }
                }
            }
        }

        if ($uploaded_arr) {
            update_post_meta($id, 'custom_gallery', $uploaded_arr);
        }

    }


    function update_edit_form()
    {
        echo ' enctype="multipart/form-data"';
    }
}

$custom_gallery = new Custom_Gallery_Images();


class Get_Active_Shortcodes_Widget extends WP_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            'Get_Active_Shortcodes_Widget', // Base ID
            esc_html__('Get Active Shortcodes', 'dor_raboti'), // Name
            array('description' => __('Displays one of your Active Shortcodes.', 'dor_raboti')) // Args
        );
    }

    public function widget($args, $instance)
    {
        $id = ($instance['get_active_shotcodes-widget-id']) ? $instance['get_active_shotcodes-widget-id'] : 0;
        echo do_shortcode('[' . $id . ']');
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
        $instance['get_active_shotcodes-widget-id'] = isset($new_instance['get_active_shotcodes-widget-id']) ? $new_instance['get_active_shotcodes-widget-id'] : 0;
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

        global $shortcode_tags;
        $shortcodes = $shortcode_tags;
        ksort($shortcodes);


        $selected_widget_id = isset($instance['get_active_shotcodes-widget-id']) ? $instance['get_active_shotcodes-widget-id'] : 0;
        $title = ($selected_widget_id) ? get_the_title($selected_widget_id) : 'No Shortcode selected.';
        ?>

        <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
               type="hidden" value="<?php echo esc_attr($title); ?>"/>

        <p>
            <label for="<?php echo $this->get_field_id('get_active_shotcodes-widget-id'); ?>"><?php _e('Shortcodes to show:', 'dor_raboti'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('get_active_shotcodes-widget-id'); ?>"
                    name="<?php echo $this->get_field_name('get_active_shotcodes-widget-id'); ?>" required>
                <option value="0" disabled <?php selected($selected_widget_id, 0); ?>>
                    <?php if (empty($shortcodes)) {
                        _e('No Shortcodes found', 'dor_raboti');
                    } else {
                        _e('Select a shortcode', 'dor_raboti');
                    } ?>
                </option>
                <?php foreach ($shortcodes as $shortcode => $value) { ?>
                    <option value="<?php echo $shortcode; ?>" <?php selected($selected_widget_id, $shortcode); ?>><?php echo $shortcode; ?></option>
                <?php } ?>
            </select>
        </p>
        <?php
    }

}



class Custom_Category_Background_Image
{
    public function __construct()
    {
        // Add field to Add Category page
        add_action('category_add_form_fields', array($this, 'add_field'));

        // Add field to Edit Category page
        add_action('category_edit_form_fields', array($this, 'edit_field'));

        // Save meta
        add_action('created_category', array($this, 'save_meta'));
        add_action('edited_category', array($this, 'save_meta'));
    }

    // Add field (Add Category screen)
    public function add_field()
    {
        ?>
        <div class="form-field">
            <label for="custom_background"><?php esc_html_e('Background Image', 'dor_raboti'); ?></label>
            <input type="file" name="custom_background" id="custom_background" />
            <p>
                <label>
                    <input type="checkbox" name="show_background" value="1">
                    <?php esc_html_e('Show Background', 'dor_raboti'); ?>
                </label>
            </p>
        </div>
        <?php
    }

    // Edit field (Edit Category screen)
    public function edit_field($term)
    {
        $filearray = get_term_meta($term->term_id, 'custom_background', true);
        $show_background = get_term_meta($term->term_id, 'show_background', true);
        ?>
        <tr class="form-field">
            <th scope="row">
                <label for="custom_background"><?php esc_html_e('Background Image', 'dor_raboti'); ?></label>
            </th>
            <td>
                <?php if (!empty($filearray['url'])) : ?>
                    <p><?php esc_html_e('Current file:', 'dor_raboti'); ?></p>
                    <img src="<?php echo esc_url($filearray['url']); ?>" style="max-width:200px;">
                <?php endif; ?>

                <input type="file" name="custom_background" id="custom_background" />

                <p>
                    <label>
                        <input type="checkbox" name="show_background" value="1" <?php checked($show_background, 1); ?>>
                        <?php esc_html_e('Show Background', 'dor_raboti'); ?>
                    </label>
                </p>
            </td>
        </tr>
        <?php
    }

    // Save meta
    public function save_meta($term_id)
    {
        // Save checkbox
        $show = isset($_POST['show_background']) ? 1 : 0;
        update_term_meta($term_id, 'show_background', $show);

        // Handle file upload
        if (!empty($_FILES['custom_background']['name'])) {

            $supported_types = array('image/png', 'image/jpg', 'image/jpeg');
            $filetype = wp_check_filetype(basename($_FILES['custom_background']['name']));
            $uploaded_type = $filetype['type'];

            if (in_array($uploaded_type, $supported_types)) {

                $upload = wp_upload_bits(
                        $_FILES['custom_background']['name'],
                        null,
                        file_get_contents($_FILES['custom_background']['tmp_name'])
                );

                if (empty($upload['error'])) {
                    update_term_meta($term_id, 'custom_background', $upload);
                } else {
                    wp_die('Upload error: ' . $upload['error']);
                }

            } else {
                wp_die(__('Unsupported file type.', 'dor_raboti'));
            }
        }
    }
}

new Custom_Category_Background_Image();

add_action('admin_head', function() {
    echo '<script>
        jQuery(document).ready(function($){
            $("form").attr("enctype", "multipart/form-data");
        });
    </script>';
});

