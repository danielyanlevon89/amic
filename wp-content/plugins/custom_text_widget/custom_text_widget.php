<?php
/**
 * Plugin Name: Custom Text
 * Description: Easy to add and display custom text
 * Author: Custom
 * Version: 1.3.3
 * @package WordPress
 * @author WP OnlineSupport
 */

if (!defined('ABSPATH')) {
    exit;
}
if (!defined('CUSTOM_TEXT_PLUGIN_DIR')) {
    define('CUSTOM_TEXT_PLUGIN_DIR', dirname(__FILE__)); // Plugin dir
}

function custom_text_load_textdomain()
{
    load_theme_textdomain('dor_raboti', get_template_directory() . '/lang');
}

add_action('plugins_loaded', 'custom_text_load_textdomain');


/**
 * Register the Widget class
 */
function custom_text_register_widget()
{
    require_once CUSTOM_TEXT_PLUGIN_DIR . '/includes/class-widget.php';
    register_widget('Custom_Text_Widget');
}

add_action('widgets_init', 'custom_text_register_widget');


function custom_text_register_post_type()
{
    $labels = array(
        'name' => __('Custom Text', 'dor_raboti'),
        'singular_name' => __('Custom Text', 'dor_raboti'),
        'add_new' => __('New Custom Text', 'dor_raboti'),
        'add_new_item' => __('Add New Custom Text', 'dor_raboti'),
        'edit_item' => __('Edit Custom Text', 'dor_raboti'),
        'new_item' => __('New Custom Text', 'dor_raboti'),
        'all_items' => __('Show All Custom Texts', 'dor_raboti'),
        'view_item' => __('View Custom Text', 'dor_raboti'),
        'search_items' => __('Search Custom Texts', 'dor_raboti'),
        'not_found' => __('No Custom Texts found', 'dor_raboti'),
        'not_found_in_trash' => __('No Custom Texts found in Trash', 'dor_raboti'),
        'menu_name' => __('Custom Texts', 'dor_raboti')
    );
    $args = array(
        'public' => false,
        'show_ui' => true,
        'labels' => $labels,
        'supports' => array('title', 'editor')
    );
    register_post_type('custom_text-widget', $args);
}

add_action('init', 'custom_text_register_post_type');


// add necessary content filters
add_filter('ww_content', 'wptexturize');
add_filter('ww_content', 'convert_smilies');
add_filter('ww_content', 'convert_chars');
add_filter('ww_content', 'wpautop');
add_filter('ww_content', 'shortcode_unautop');
add_filter('ww_content', 'do_shortcode', 11);
add_filter('ww_content', array($GLOBALS['wp_embed'], 'run_shortcode'), 8);
add_filter('ww_content', array($GLOBALS['wp_embed'], 'autoembed'), 8);

// only load admin class for non-ajax requests to the admin section
if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {

    require_once CUSTOM_TEXT_PLUGIN_DIR . '/includes/class-admin.php';
    new Custom_Text_Widgets_Admin();
}

