<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="height=device-height,
                      width=device-width, initial-scale=1.0,
                      minimum-scale=1.0, maximum-scale=1.0,
                      user-scalable=no, target-densitydpi=device-dpi">
    <?php wp_head(); ?>
    <?php
    $meta_key=get_theme_mod('default_meta_key');
    $meta_desc=get_theme_mod('default_meta_desc');
    $white_logo=get_option('white_logo_image');

        if(isset($post) && isset($post->ID)){
            $custom_meta_tags = get_post_meta($post->ID, 'custom_meta_tags', true);
            $custom_meta_tags_arr = explode("[--1--]", $custom_meta_tags);
            if($custom_meta_tags_arr && is_array($custom_meta_tags_arr)){
                ($custom_meta_tags_arr[0])?$meta_key=$custom_meta_tags_arr[0]:'';
                ($custom_meta_tags_arr[1])?$meta_desc=$custom_meta_tags_arr[1]:'';
            }
        }



        $titleInBackground='';
        $headerStyles='';
        $headerClass='classic';
        $term = get_queried_object();
        $background = get_term_meta($term->term_id, 'custom_background', true) ?: get_post_meta($post->ID, 'custom_background', true);
        $show_background = get_term_meta($term->term_id, 'show_background', true) ?: get_post_meta($post->ID, 'show_background', true);

        $custom_page_title = $term->name?:get_post_meta($post->ID, 'custom_page_title', true);


        if ($show_background && !empty($background['url'])) {
            $headerClass='white';
            $headerStyles = '
                style="
                height: 350px;
                background:url('.esc_url($background['url']).') no-repeat center / cover
                "
            ';
            $titleInBackground = "<div class='container title_in_background'><h1>".esc_html($custom_page_title)."</h1><p>".esc_html($term->category_description)."</p></div>";
        }
     ?>
    <meta name="description" content="<?php echo $meta_desc; ?>">
    <meta name="keywords" content="<?php echo $meta_key; ?>">

</head>
<body <?php body_class(); ?> data-gr-c-s-loaded="true">
<div class="ghost-nav-wrap empty site-navigation"></div>
<div class="site">
    <!-- Site Header -->
    <header <?=$headerStyles;?> class="site-header <?=$headerClass?> relative style-4">
        <div class="container">
            <div class="header-wrap clearfix">
                <div class="logo pull-left">
                        <?php
                        if ($headerClass == 'classic') {
                            the_custom_logo();
                        } else {
                            echo '<a href="/" class="custom-logo-link" rel="home">
                                        <img  src="'.$white_logo.'" class="custom-logo" alt="AMIC" decoding="async">
                                    </a>';
                        }
                        ?>
                </div>

                    <!-- Site navigation -->
                <nav class="site-navigation pull-right">
                    <div class="mobile-wrap">
                        <!-- Main menu -->
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary-menu',
                            'menu_class' => 'main-menu',
                            'menu_id' => 'main-menu',
                            'walker' => new WPDocs_Walker_Nav_Menu()
                        ));
                        ?>
                        <!-- /Main menu -->
                    </div>
                    <!-- Mobile navigation toggle -->
                    <button class="burger pull-right"><span class="burger-top"></span> <span
                                class="burger-middle"></span> <span class="burger-bottom"></span></button>
                    <!-- /Mobile navigation toggle -->
                </nav>
                <!-- /Site navigation -->
            </div>
        </div>
        <!-- /container -->
        <?=$titleInBackground;?>
    </header>
    <!-- /Site Header -->