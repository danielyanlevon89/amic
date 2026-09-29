<!-- Site Footer -->

<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="widget widget-image">
                    <h3 class="widget-title"><?= get_bloginfo('name'); ?></h3>
                </div>

                <div class="widget widget-text">
                    <p> <?php echo get_theme_mod('footer_text'); ?> </p>
                </div>

            </div>
            <div class="col-md-4">
                <div class="widget widget-nav-menu">
                    <h3 class="widget-title"><?php esc_html_e('Navigation', 'dor_raboti'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'menu_class' => 'menu',
                        'menu_id' => 'footer-menu',
                        'container' => false
                    ));
                    ?>

                </div>
            </div>
            <div class="col-md-4">
                <div class="widget widget-contact-info">
                    <h3 class="widget-title"><?php esc_html_e('Contact Us', 'dor_raboti'); ?></h3>
                    <ul class="contact-info">
                        <?php if (get_theme_mod('address') != ''): ?>
                            <li><i class="fa fa-map-marker"></i> <?php echo get_theme_mod('address'); ?></li>
                        <?php endif; ?>
                        <?php if (get_theme_mod('first_phone_number') != ''): ?>
                            <li><i class="fa fa-phone"></i> <a
                                        href="tel:<?php echo get_theme_mod('first_phone_number'); ?>"
                                        class="important"><?php echo get_theme_mod('first_phone_number'); ?></a></li>
                        <?php endif; ?>
                        <?php if (get_theme_mod('second_phone_number') != ''): ?>
                            <li><i class="fa fa-phone"></i> <a
                                        href="tel:<?php echo get_theme_mod('second_phone_number'); ?>"><?php echo get_theme_mod('second_phone_number'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (get_theme_mod('email_address') != ''): ?>
                            <li><i class="fa fa-envelope"></i> <a
                                        href="mailto:<?php echo get_theme_mod('email_address'); ?>"><?php echo get_theme_mod('email_address'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
            <!--div class="col-md-3">
                <h3 class="widget-title"><?php esc_html_e('Work Time', 'dor_raboti'); ?></h3>
                <p><?php echo get_theme_mod('work_time_text'); ?></p>
                <?php if (get_theme_mod('work_time_schedule') != ''): ?>
                    <?php echo get_theme_mod('work_time_schedule'); ?>
                <?php endif; ?>
            </div-->
        </div>
    </div>

</footer>

<!-- /Site Footer -->
</div>
<?php //echo do_shortcode('[contacts_form_popup]') ?>

</body>
<?php wp_footer(); ?>
</html>