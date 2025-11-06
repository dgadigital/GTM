</main>

<footer class="">
    <div class="container top-row">
        <div class="logo-wrapper">            
            <?php
            if (function_exists('the_custom_logo') && has_custom_logo()) {
                the_custom_logo();
            } else {
                echo esc_html(get_bloginfo('name'));
            }
            ?>
        </div>

        <div class="footer-menu-wrapper">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer',
                'container'      => false
            ]);
            ?>
        </div>
    </div>

    <div class="container mid-row">
        <div class="row mid-row-wrapper">
            <?php
            // === Optional: Use ACF repeater if you want to manage office details ===
            if (have_rows('footer_addresses', 'option')) :
                foreach (get_field('footer_addresses', 'option') as $address) :
                    $location = $address['location_title'] ?? '';
                    $phone    = $address['phone'] ?? '';
                    $details  = $address['address'] ?? '';
                    ?>
                    <div class="address-column">
                        <?php if ($location): ?>
                            <div class="location-title"><?php echo esc_html($location); ?></div>
                        <?php endif; ?>
                        <div class="address-wrapper">
                            <?php if ($phone): ?>
                                <div class="phone detail-icon"><?php echo esc_html($phone); ?></div>
                            <?php endif; ?>
                            <?php if ($details): ?>
                                <div class="address detail-icon"><?php echo wp_kses_post($details); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="social-icons-column">
                <?php if (have_rows('social_media', 'option')) : ?>
                    <div class="social-icons-wrapper">
                        <?php while (have_rows('social_media', 'option')) : the_row(); 
                            $url  = get_sub_field('url');
                            $icon = get_sub_field('icon_class');
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                <i class="fab <?php echo esc_attr($icon); ?>"></i>
                            </a>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

<div class="bottom-row">
    <div class="container bottom-row-wrapper">
        <div class="copyright-wrapper">
            Copyright © 2025 Good Talent Media. All Rights Reserved. 
            <a href="">Privacy Policy</a> | 
            <a href="">Terms & Conditions</a> | 
            <a href="">Sitemap</a>
        </div>

        <div class="osoac-logo-wrapper">
            <img src="/wp-content/uploads/2025/11/official-supporter-of-australian-creators.png" alt="Official supporter of Australian creators logo">
        </div>
    </div>
</div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
