<?php
/**
 * Plugin Name: Features Content and Slider
 * Description: Easy to add and display what features your company, product or service offers, using our shortcode OR template code
 * Author: Custom
 * Version: 1.3.3
 * @package WordPress
 * @author WP OnlineSupport
 */

if (!defined('ABSPATH')) {
    exit;
}
if (!defined('FEATURES_PLUGIN_DIR')) {
    define('FEATURES_PLUGIN_DIR', dirname(__FILE__)); // Plugin dir
}

function features_load_textdomain()
{
    load_theme_textdomain('dor_raboti', get_template_directory() . '/lang');
}

add_action('plugins_loaded', 'features_load_textdomain');


/**
 * Register the Widget class
 */
function features_register_widget()
{
    require_once FEATURES_PLUGIN_DIR . '/includes/class-widget.php';
    register_widget('Features_Widget');
}

add_action('widgets_init', 'features_register_widget');


function features_register_post_type()
{
    $labels = array(
        'name' => __('Features', 'dor_raboti'),
        'singular_name' => __('Feature', 'dor_raboti'),
        'add_new' => __('New Feature', 'dor_raboti'),
        'add_new_item' => __('Add New Feature', 'dor_raboti'),
        'edit_item' => __('Edit Feature', 'dor_raboti'),
        'new_item' => __('New Feature', 'dor_raboti'),
        'all_items' => __('Show All Features', 'dor_raboti'),
        'view_item' => __('View Feature', 'dor_raboti'),
        'search_items' => __('Search Features', 'dor_raboti'),
        'not_found' => __('No Features found', 'dor_raboti'),
        'not_found_in_trash' => __('No Features found in Trash', 'dor_raboti'),
        'menu_name' => __('Features', 'dor_raboti')
    );
    $args = array(
        'public' => false,
        'show_ui' => true,
        'labels' => $labels,
        'supports' => array('title')
    );
    register_post_type('features-widget', $args);
}

add_action('init', 'features_register_post_type');


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

    require_once FEATURES_PLUGIN_DIR . '/includes/class-admin.php';
    new
    Features_Widgets_Admin();
}

