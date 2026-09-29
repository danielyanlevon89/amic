<?php


require get_template_directory() . '/inc/custom_functions.php';
require get_template_directory() . '/inc/custom_classess.php';
function dor_raboti_scripts()
{

    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');

    wp_register_style('Font_Awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
    wp_enqueue_style('Font_Awesome');
    wp_enqueue_style('components', get_template_directory_uri() . '/css/components.css');
    wp_enqueue_style('font-roboto', 'https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700');
    wp_enqueue_style('font-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700');
    wp_enqueue_style('font-pt-sans', 'https://fonts.googleapis.com/css?family=PT+Sans:400,600,700');
    wp_enqueue_style('Montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:400,600,700');
    wp_enqueue_style('style-css', get_stylesheet_uri(),array(), '5.4.2');


    wp_enqueue_script('jquery-min', get_template_directory_uri() . '/js/jquery.min.js');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js');
    wp_enqueue_script('doubletaptogo', get_template_directory_uri() . '/js/doubletaptogo.js');
    wp_enqueue_script('functions', get_template_directory_uri() . '/js/functions.js');
    wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.min.js');
    wp_enqueue_script('waypoints', get_template_directory_uri() . '/js/jquery.waypoints.min.js');
    wp_enqueue_script('html5shiv', 'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js');
    wp_enqueue_script('respond', 'https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js');
    wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
    wp_script_add_data('respond', 'conditional', 'lt IE 9');
}

add_action('wp_enqueue_scripts', 'dor_raboti_scripts');

function dor_raboti_setup()
{

    load_theme_textdomain('dor_raboti', get_template_directory() . '/lang');


    add_theme_support('title-tag');

    add_theme_support('custom-logo', array(
        'height' => 50,
        'width' => 199,
        'flex-height' => true
    ));

    add_theme_support('post-thumbnails');

    set_post_thumbnail_size(730, 446);

    add_image_size('dor_raboti-recent-post', 80, 80, true);

    add_theme_support('html5', array(
        'search_form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ));

    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'gallery'
    ));


    if (function_exists('register_nav_menus')) {
        register_nav_menus(
            array(
                'primary-menu' => esc_html__('Primary menu', 'dor_raboti'),
                'footer-menu' => esc_html__('Footer menu', 'dor_raboti')
            )
        );
    }
}

add_action('after_setup_theme', 'dor_raboti_setup');


function dor_raboti_customize_register($wp_customize)
{

    $wp_customize->add_setting('address', array(
        'default' => esc_html__('Company Address', 'dor_raboti'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('first_phone_number', array(
        'default' => esc_html__('First Phone Number', 'dor_raboti'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('second_phone_number', array(
        'default' => esc_html__('Second Phone Number', 'dor_raboti'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('email_address', array(
        'default' => esc_html__('Email Address', 'dor_raboti'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('white_logo_image', array(
            'default' => 'image.jpg',
            'capability' => 'edit_theme_options',
            'type' => 'option',
    ));

    $wp_customize->add_section('company_details', array(
        'title' => esc_html__('Company Details Settings', 'dor_raboti'),
        'priority' => 30,
    ));


    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo', array(
            'label' => esc_html__('white Logo', 'dor_raboti'),
            'section' => 'company_details',
            'settings' => 'white_logo_image',
    )));
    $wp_customize->add_control(
        'address',
        array(
            'label' => esc_html__('Company Address In Footer', 'dor_raboti'),
            'section' => 'company_details',
            'settings' => 'address',
            'type' => 'text',
        ));

    $wp_customize->add_control(
        'first_phone_number',
        array(
            'label' => esc_html__('Company First Phone Number In Footer', 'dor_raboti'),
            'section' => 'company_details',
            'settings' => 'first_phone_number',
            'type' => 'text',
        ));

    $wp_customize->add_control(
        'second_phone_number',
        array(
            'label' => esc_html__('Company Second Phone Number In Footer', 'dor_raboti'),
            'section' => 'company_details',
            'settings' => 'second_phone_number',
            'type' => 'text',
        ));

    $wp_customize->add_control(
        'email_address',
        array(
            'label' => esc_html__('Company Email Address In Footer', 'dor_raboti'),
            'section' => 'company_details',
            'settings' => 'email_address',
            'type' => 'email',
        ));


    $wp_customize->add_setting('footer_text', array(
        'default' => esc_html__('Footer Text', 'dor_raboti'),
        'transport' => 'refresh',
    ));



    $wp_customize->add_section('footer_setting', array(
        'title' => esc_html__('Footer Text', 'dor_raboti'),
        'priority' => 31,
    ));
    $wp_customize->add_control(
        'footer_text',
        array(
            'label' => esc_html__('Footer settings', 'dor_raboti'),
            'section' => 'footer_setting',
            'settings' => 'footer_text',
            'type' => 'textarea',
        ));





    $wp_customize->add_setting('work_time_text', array(
        'default' => esc_html__('Work Time Text', 'dor_raboti'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('work_time_schedule', array(
        'default' => esc_html__('Work Time Schedule', 'dor_raboti'),
        'transport' => 'refresh',
    ));

    $wp_customize->add_section('work_time', array(
        'title' => esc_html__('Work Time', 'dor_raboti'),
        'priority' => 31,
    ));
    $wp_customize->add_control(
        'work_time_text',
        array(
            'label' => esc_html__('Work Time Text', 'dor_raboti'),
            'section' => 'work_time',
            'settings' => 'work_time_text',
            'type' => 'textarea',
        ));
    $wp_customize->add_control(
        'work_time_schedule',
        array(
            'label' => esc_html__('Work Time Schedule', 'dor_raboti'),
            'section' => 'work_time',
            'settings' => 'work_time_schedule',
            'type' => 'textarea',
        ));


    $wp_customize->add_setting('default_meta_key', array(
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('default_meta_desc', array(
        'transport' => 'refresh',
    ));

    $wp_customize->add_section('default_seo_meta_tags', array(
        'title' => esc_html__('SEO Meta Tags', 'dor_raboti'),
        'priority' => 31,
    ));
    $wp_customize->add_control(
        'default_meta_key',
        array(
            'label' => esc_html__('Default Meta Key', 'dor_raboti'),
            'section' => 'default_seo_meta_tags',
            'settings' => 'default_meta_key',
            'type' => 'textarea',
        ));
    $wp_customize->add_control(
        'default_meta_desc',
        array(
            'label' => esc_html__('Default Meta Description', 'dor_raboti'),
            'section' => 'default_seo_meta_tags',
            'settings' => 'default_meta_desc',
            'type' => 'textarea',
        ));

}

add_action('customize_register', 'dor_raboti_customize_register');


/**
 * Add a sidebar.
 */
function dor_raboti_widgets_init()
{
    if (function_exists('register_sidebar')) {
        register_sidebar(array(
            'name' => esc_html__('Home Page Sidebar', 'dor_raboti'),
            'id' => 'home-page-sidebar',
            'description' => esc_html__('Widgets in this area will be shown main wrapper.', 'dor_raboti'),
            'before_widget' => '<div id="%1$s" class="sidebar_wrap %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="side_bar_heading"><h6>',
            'after_title' => '</h6></div>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Page Right Sidebar', 'dor_raboti'),
            'id' => 'page-right-sidebar',
            'before_widget' => '<aside class="sidebar sidebar-right col-md-3">',
            'before_title' => '',
            'after_title' => '',
            'after_widget' => ' </aside>'
        ));
        register_sidebar(array(
            'name' => esc_html__('Page Sidebar', 'dor_raboti'),
            'id' => 'page-sidebar',
            'before_widget' => '<div id="%1$s" class="sidebar_wrap %2$s">',
            'before_title' => '<div class="side_bar_heading"><h6>',
            'after_title' => '</h6></div>',
            'after_widget' => '</div>'
        ));
    }
}

add_action('widgets_init', 'dor_raboti_widgets_init');


if (!function_exists('easingslider_display_image_slide1')) {
    function easingslider_display_image_slide1($slide, $slider)
    {

        ?>
        <?php if (!empty($slide->link) && 'none' != $slide->link) : ?><a href="<?php echo esc_attr($slide->linkUrl); ?>" target="<?php echo esc_attr($slide->linkTargetBlank); ?>"><?php endif; ?>
        <?php if (true === $slider->lazy_loading) : ?>
        <img src="<?php echo esc_attr(easingslider_get_placeholder_pixel()); ?>"
             data-src="<?php echo esc_attr($slide->url); ?>" alt="<?php echo strip_tags(esc_attr($slide->alt)); ?>"
             title="<?php echo strip_tags($slide->title); ?>" class="easingslider-image easingslider-lazy"/>
    <?php else : ?>
        <img src="<?php echo esc_attr($slide->url); ?>" alt="<?php echo strip_tags(esc_attr($slide->alt)); ?>"
             title="<?php echo strip_tags($slide->title); ?>" class="easingslider-image"/>
    <?php endif; ?>
        <?php if (!empty($slide->link) && 'none' != $slide->link) : ?></a><?php endif; ?>

        <div class="tp-parallax-wrap"
             style="position: absolute; left: 200px; top: 242px; ">
            <div class="tp-loop-wrap" style="position:absolute;">
                <div class="tp-mask-wrap" style="position: absolute;  height: auto; width: auto;">
                    <div class="tp-caption text-uppercase rev-title"
                         style="font-size: 48px; font-weight: 400; visibility: inherit;  line-height: 57px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1;">
                        <?php echo $slide->title; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp-parallax-wrap"
             style="position: absolute; left: 200px; top: 302px;">
            <div class="tp-loop-wrap" style="position:absolute;">
                <div class="tp-mask-wrap" style="position: absolute;  height: auto; width: auto;">
                    <div class="tp-caption"
                         style="font-size: 16px; font-family: &quot;PT Sans&quot;, sans-serif; visibility: inherit;  line-height: 23px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1;">
                        <?php echo $slide->alt; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp-parallax-wrap"
             style="position: absolute;  left: 200px; top: 390px; ">
            <div class="tp-loop-wrap" style="position:absolute;">
                <div class="tp-mask-wrap" style="position: absolute;  height: auto; width: auto;">
                    <div class="tp-caption tp-resizeme"
                         style="visibility: inherit;  line-height: 23px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 14px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1;">
                        <p class="btn btn-wide" data-toggle="modal" data-target="#contact_us_form"
                           style=" line-height: 23px; border-width: 0px; margin: 0px; padding: 9px 34px; letter-spacing: 0px; font-weight: 400; font-size: 14px;">
                            <?php esc_html_e('Leave message', 'dor_raboti')?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    add_action('easingslider_display_image_slide1', 'easingslider_display_image_slide1', 10, 2);
}

add_filter('easingslider_before_display_slide', function ($slide, $slider) {

    remove_action('easingslider_display_image_slide', 'easingslider_display_image_slide', 10, 2);
    do_action("easingslider_display_image_slide1", $slide, $slider);
}, 10, 2);


function get_active_shortcodes_widget()
{
    register_widget('Get_Active_Shortcodes_Widget');
}

add_action('widgets_init', 'get_active_shortcodes_widget');


add_filter('posts_search', function ($search, \WP_Query $q) {
    if (!is_admin() && empty($search) && $q->is_search() && $q->is_main_query())
        $search .= " AND 0=1 ";
    return $search;
}, 10, 2);

add_filter( 'widget_text', 'do_shortcode' );



function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );


