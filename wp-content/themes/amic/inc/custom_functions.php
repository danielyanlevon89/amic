<?php
function dor_raboti_template_directory_uri(){
    echo get_template_directory_uri();
}

function download_price_list_shortcode_func() {

    ?>
    <section class="bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="download">
                        <div class="download-content text-uppercase"><?php esc_html_e('Price list', 'dor_raboti') ?> </div>
                        <a class="btn btn-md btn-dark btn-shadow" href="<?php echo get_site_url(); ?>/price.pdf" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Download', 'dor_raboti') ?> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php

}
add_shortcode( 'download_price_list_shortcode', 'download_price_list_shortcode_func' );


function get_testimonials_slider_shortcode_func() {
    $testimonials = get_posts( array(
        'category' => 4
    ) );
    $items='';
    if($testimonials){
        foreach ($testimonials as $k=>$testimonial) :
            $testimonial_thumbnail_url='';
            $excerpt_testimonial = substr($testimonial->post_content, 0, 500);
            $short_testimonial_content = substr($excerpt_testimonial, 0, strrpos($excerpt_testimonial, ' '));
            $active_class='';
            if($k==0){
                $active_class='active';
            }
                                        if ( has_post_thumbnail($testimonial) ) {
                                            $testimonial_thumbnail_id = get_post_thumbnail_id($testimonial);
                                            $testimonial_thumbnail_url = wp_get_attachment_url( $testimonial_thumbnail_id );
                                           ?>
                                        <?php }
              $items.= '
                   <div class="item '.$active_class.'">
                   '.wp_strip_all_tags($short_testimonial_content).'
                    <div class="user pull-left"> <img class="pull-left user-photo" src="'.$testimonial_thumbnail_url.'" alt="'.$testimonial->post_title.'">
                                <div class="user-data pull-left">
                                    <h3 class="name-user">'.$testimonial->post_title.'</h3>
                                    <div class="rating fontawesome"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
                                </div>
                            </div>
                </div>
                        
                        
                        ';
              endforeach;
    }

     $testimonials = '<div class="testimonials">
        <div id="testimonials_Carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">'. $items.'</div>
            <div class="testimonial-owl-nav owl-nav pull-right">
                <a class="left carousel-control pull-left" href="#testimonials_Carousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                    <span class="sr-only">'.esc_html('Previous', 'dor_raboti').'</span>
                </a>
                <a class="right carousel-control pull-right" href="#testimonials_Carousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                    <span class="sr-only">'.esc_html('Next', 'dor_raboti').'</span>
                </a>
            </div>
        </div>
    </div>
    <style>
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: 70%;
            margin: auto;
        }
        .carousel-control.right,.carousel-control.left{
            background: none;
        }
    </style>
';

return $testimonials;
}
add_shortcode( 'get_testimonials_slider_shortcode', 'get_testimonials_slider_shortcode_func' );


function dor_raboti_the_breadcrumb(){
    global $post;
    if(!is_home()){
        echo '<li><a href="'.site_url().'">'. esc_html__('Home', 'dor_raboti'). '</a></li> ';
        if(is_single()){ // posts
//            the_category(', ');
            $categories = get_the_category();

            if (!empty($categories)) {
                echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">'
                        . esc_html($categories[0]->name) .
                        '</a>';
            }

            echo " <li>  </li> ";
            echo '<li>';
            the_title();
            echo '</li>';

        }
        elseif (is_page()) { // pages
            if ($post->post_parent ) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) echo $crumb . '<li>  </li> ';
            }
            echo the_title();
            echo " <li>  </li> ";
        }
        elseif (is_category()) { // category
            global $wp_query;
            $obj_cat = $wp_query->get_queried_object();
            $current_cat = $obj_cat->term_id;
            $current_cat = get_category($current_cat);
            $parent_cat = get_category($current_cat->parent);
            if ($current_cat->parent != 0)
                echo(get_category_parents($parent_cat, TRUE, ' <li>  </li> '));
            single_cat_title();
            echo " <li>  </li> ";
        }
        elseif (is_search()) { // search pages
            echo esc_html__('Search results "', 'dor_raboti') . get_search_query() . '"';
            echo " <li>  </li> ";
        }
        elseif (is_tag()) { // tags
            echo single_tag_title('', false);
        }
        elseif (is_day()) { // archive (days)
            echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> <li>  </li> ';
            echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li> <li>  </li> ';
            echo get_the_time('d');
        }
        elseif (is_month()) { // archive (months)
            echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> <li>  </li>';
            echo get_the_time('F');
        }
        elseif (is_year()) { // archive (years)
            echo get_the_time('Y');
        }
        elseif (is_author()) { // authors
            global $author;
            $userdata = get_userdata($author);
            echo '<li>Posted ' . $userdata->display_name . '</li>';
        } elseif (is_404()) { // if page not found
            echo '<li>'. esc_html__('Error 404', 'dor_raboti'). '</li>';
            echo " <li>  </li> ";
        }

        if (get_query_var('paged')) // number of page
            echo ' (' . get_query_var('paged').'- page)';

    } else { // home
        $pageNum=(get_query_var('paged')) ? get_query_var('paged') : 1;
        if($pageNum>1)
            echo '<li><a href="'.site_url().'"></i>'. esc_html__('Home', 'dor_raboti'). '</a></li> <li> </li> <li>'.$pageNum.'- page</li>';
        else
            echo '<li></i>'. esc_html__('Home', 'dor_raboti'). '</li>';
    }
}

function add_mce_markup( $initArray ) {
    $ext = 'i[id|name|class|style]';
    if ( isset( $initArray['extended_valid_elements'] ) ) {
        $initArray['extended_valid_elements'] .= ',' . $ext;
    } else {
        $initArray['extended_valid_elements'] = $ext;
    }
    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'add_mce_markup' );


function right_sidebar_contacts_shortcode_func() {

    ?>
    <aside class="sidebar sidebar-right col-md-3">
        <div class="widget">
            <h3 class="widget-title small-margin text-uppercase"><?php esc_html_e('Our Address', 'dor_raboti') ?></h3>
            <ul class="contact-info">
    <?php if(get_theme_mod('address') != ''):?>
                <li><i class="fa fa-map-marker"></i> <?php echo get_theme_mod('address'); ?></li>
    <?php endif; ?>
    <?php if(get_theme_mod('first_phone_number') != ''):?>
                <li><i class="fa fa-phone"></i> <a href="tel:<?php echo get_theme_mod('first_phone_number'); ?>" class="important"><?php echo get_theme_mod('first_phone_number'); ?></a></li>
    <?php endif; ?>
    <?php if(get_theme_mod('second_phone_number') != ''):?>
                <li><i class="fa fa-mobile-phone"></i> <a href="tel:<?php echo get_theme_mod('second_phone_number'); ?>"><?php echo get_theme_mod('second_phone_number'); ?></a></li>
    <?php endif; ?>
    <?php if(get_theme_mod('email_address') != ''):?>
                <li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo get_theme_mod('email_address'); ?>"><?php echo get_theme_mod('email_address'); ?></a></li>
    <?php endif; ?>
            </ul>
        </div>
    </aside>
    <?php

}
add_shortcode( 'right_sidebar_contacts', 'right_sidebar_contacts_shortcode_func' );


function wp_upload_bits_check_if_exist( $file ) {
    $upload = wp_upload_dir(  );
    $filename = sanitize_file_name( $file['name'] );
    $new_file = $upload['path'] . "/".$filename;
    if(file_exists($new_file)){
        return false;
    }
return $file;
}
add_filter( 'wp_upload_bits', 'wp_upload_bits_check_if_exist' );


function contacts_table_shortcode_func() {
    $contacts_table='
    <table class="info-table">
        <tbody>
        <tr class="info-table-row">
            <th class="info-table-icon"><i class="fa fa-long-arrow-right"></i></th>
            <td class="info-table-content">'.get_bloginfo( 'name' ).'</td>
        </tr>
        <tr class="info-table-row">
            <th class="info-table-icon"><i class="fa fa-map-marker"></i></th>
            <td class="info-table-content">'.get_theme_mod('address').'</td>
        </tr>
        <tr class="info-table-row">
            <th class="info-table-icon"><i class="fa fa-phone"></i></th>
            <td class="info-table-content">'.get_theme_mod('first_phone_number').'</td>
        </tr>
        <tr class="info-table-row">
            <th class="info-table-icon"><i class="fa fa-envelope"></i></th>
            <td class="info-table-content">'.get_theme_mod('email_address').'</td>
        </tr>
        <tr class="info-table-row">
            <th class="info-table-icon"><i class="fa fa-globe"></i></th>
            <td class="info-table-content"><strong><a href="'.get_site_url().'" target="_blank">'.get_site_url().'</a></strong></td>
        </tr>
        </tbody>
    </table>
   ';
    return $contacts_table;

}
add_shortcode( 'contacts_table', 'contacts_table_shortcode_func' );

//fix wp_redirect header error
function callback($buffer) {
    // You can modify $buffer here, and then return the updated code
    return $buffer;
}
function buffer_start() { ob_start("callback"); }
function buffer_end() { ob_end_flush(); }
add_action('init', 'buffer_start');
add_action('wp_footer', 'buffer_end');
















