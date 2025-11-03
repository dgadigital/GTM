<?php
/**
 * Storefront Child Theme – Full Custom Frontend
 * Use Storefront only for WooCommerce + backend logic
 */

require_once get_stylesheet_directory() . '/inc/class-wp-bootstrap-navwalker.php';
require_once get_stylesheet_directory() . '/inc/class-custom-walker-nav.php';

// ==========================================================
// 0. Force URLs to match current host (for Docker / BrowserSync)
// ==========================================================
add_filter('stylesheet_directory_uri', function ($uri) {
    if (isset($_SERVER['HTTP_HOST'])) {
        $uri = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/wp-content/themes/storefront-child';
    }
    return $uri;
});

// ==========================================================
// 1. Remove ALL Storefront CSS & JS
// ==========================================================
add_action('wp_enqueue_scripts', function () {
    // Remove parent styles
    wp_dequeue_style('storefront-style');
    wp_dequeue_style('storefront-gutenberg-blocks');
    wp_dequeue_style('storefront-fonts');
    wp_dequeue_style('storefront-icons');

    // Remove parent scripts
    wp_dequeue_script('storefront-navigation');
    wp_dequeue_script('storefront-skip-link-focus-fix');
    wp_dequeue_script('storefront-header-cart');
    wp_dequeue_script('storefront-sticky-header');

    // Optional WooCommerce block styles
    wp_dequeue_style('wc-block-style');
    wp_dequeue_style('wc-blocks-style');
}, 20);

// ==========================================================
// 2. Disable ALL WooCommerce CSS
// ==========================================================
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// ==========================================================
// 3. Enqueue Bootstrap, Slick, and Custom Theme Scripts
// ==========================================================
add_action('wp_enqueue_scripts', function () {
    // Ensure jQuery always loads
    wp_enqueue_script('jquery');

    // Detect correct host for dynamic URL (BrowserSync + Docker safe)
    $theme_uri = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/wp-content/themes/storefront-child';

    // --- Bootstrap ---
    wp_enqueue_style(
        'bootstrap-css',
        $theme_uri . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css',
        [],
        '5.3.8'
    );
    wp_enqueue_script(
        'bootstrap-js',
        $theme_uri . '/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js',
        ['jquery'],
        '5.3.8',
        true
    );

    // --- Slick Carousel ---
    wp_enqueue_style(
        'slick-css',
        $theme_uri . '/assets/vendor/slick-carousel/slick/slick.css',
        ['bootstrap-css'],
        '1.8.1'
    );
    wp_enqueue_style(
        'slick-theme-css',
        $theme_uri . '/assets/vendor/slick-carousel/slick/slick-theme.css',
        ['slick-css'],
        '1.8.1'
    );
    wp_enqueue_script(
        'slick-js',
        $theme_uri . '/assets/vendor/slick-carousel/slick/slick.min.js',
        ['jquery'],
        '1.8.1',
        true
    );

    // --- Main Compiled Theme CSS ---
    $style_path  = get_stylesheet_directory() . '/assets/css/style.min.css';
    $bundle_path = get_stylesheet_directory() . '/assets/js/dist/bundle.min.js';

    if (file_exists($style_path)) {
        wp_enqueue_style(
            'child-style',
            $theme_uri . '/assets/css/style.min.css',
            ['bootstrap-css', 'slick-theme-css'], // ensure order
            filemtime($style_path)
        );
    }

    // --- Child Scripts (compiled JS bundle) ---
    if (file_exists($bundle_path)) {
        wp_enqueue_script(
            'child-scripts',
            $theme_uri . '/assets/js/dist/bundle.min.js',
            ['jquery', 'bootstrap-js', 'slick-js'],
            filemtime($bundle_path),
            true
        );
    }

    // --- Ensure Customizer CSS (inline styles) is last ---
    // The Customizer injects `wp_add_inline_style('storefront-style', ...)`
    // so we hook your CSS before that by using 'customize_preview_init'
    
}, 30);

// ==========================================================
// 3.5 Ensure style.min.css is SECOND TO LAST (before Customizer)
// ==========================================================
add_action('wp_enqueue_scripts', function () {
    // Remove default child style.css that WordPress appends last
    wp_dequeue_style('storefront-child-style');
    wp_deregister_style('storefront-child-style');
}, 50);


// ==========================================================
// 4. Safety net – Force print enqueued JS in footer
// ==========================================================
add_action('wp_footer', function () {
    wp_print_scripts(['bootstrap-js', 'slick-js', 'child-scripts']);
}, 100);

// ==========================================================
// 5. Remove Storefront's default content wrappers
// ==========================================================
add_action('after_setup_theme', function () {
    remove_action('storefront_before_content', 'storefront_before_content');
    remove_action('storefront_after_content', 'storefront_after_content');
    remove_action('storefront_content_top', 'storefront_content_top');
    remove_action('storefront_content_bottom', 'storefront_content_bottom');
});

// ==========================================================
// 6. Save and Load ACF JSON for version control
// ==========================================================
add_filter('acf/settings/save_json', function ($path) {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

// ==========================================================
// 7. Register Primary Navigation Menu
// ==========================================================
add_action('after_setup_theme', function () {
    register_nav_menus([
        'left'    => __('Left Menu', 'storefront-child'),   // Desktop left
        'right'   => __('Right Menu', 'storefront-child'),  // Desktop right
        'primary' => __('Primary Menu', 'storefront-child'), // Mobile
        'footer' => __('Footer Menu', 'storefront-child') // Footer
    ]);
});



// ==========================================================
// 8. Enable menus for all public CPTs
// ==========================================================
add_action('wp_loaded', function () {
    $post_types = get_post_types(['public' => true, '_builtin' => false], 'objects');
    foreach ($post_types as $pt) {
        $pt->show_in_nav_menus = true;
    }
});

// ==========================================================
// 9. Force ACF-created CPTs to have archives + menus
// ==========================================================
add_action('acf/init', function () {
    add_action('wp_loaded', function () {
        $post_types = get_post_types(['public' => true, '_builtin' => false], 'objects');
        foreach ($post_types as $pt) {
            $pt->has_archive = true;
            $pt->show_in_nav_menus = true;
        }
    }, 20);
});

// ==========================================================
// 10. Debug CPT output in admin logs
// ==========================================================
add_action('admin_init', function () {
    $pt = get_post_type_object('case-study');
    if ($pt) {
        error_log('CPT FOUND ✅');
        error_log('has_archive: ' . var_export($pt->has_archive, true));
        error_log('show_in_nav_menus: ' . var_export($pt->show_in_nav_menus, true));
    } else {
        error_log('CPT NOT FOUND ❌');
    }
});
add_action('wp_enqueue_scripts', function() {
    error_log('✅ wp_enqueue_scripts is running for Storefront Child');
});


add_filter('get_custom_logo', function ($html) {
    // Get logo ID
    $custom_logo_id = get_theme_mod('custom_logo');
    if (!$custom_logo_id) return $html;

    // Get stored alt text or fallback to site name
    $alt = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);
    if (empty($alt)) {
        $alt = get_bloginfo('name');
    }

    // Replace or insert the alt attribute
    $html = preg_replace('/alt="[^"]*"/', 'alt="' . esc_attr($alt) . '"', $html);
    return $html;
});

/**
 * Disable the content editor for pages using the "Flexible Content" template.
 * Works for both block editor and classic editor, without affecting other pages.
 */
add_action('load-post.php', 'dga_disable_editor_for_flexible_template');
add_action('load-post-new.php', 'dga_disable_editor_for_flexible_template');

function dga_disable_editor_for_flexible_template() {
    // Get current screen; only proceed on page edit screens
    $screen = get_current_screen();
    if (empty($screen) || $screen->post_type !== 'page') {
        return;
    }

    // Resolve the post ID (existing or new)
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : (isset($_POST['post_ID']) ? (int) $_POST['post_ID'] : 0);
    if (!$post_id) {
        return;
    }

    // Match by the actual template file name, e.g. page-flexible-content.php
    $template_file = get_page_template_slug($post_id);
    if ($template_file !== 'page-flexible-content.php') {
        return;
    }

    // 1) Disable the Block Editor (Gutenberg) for this post.
    add_filter('use_block_editor_for_post', function($use_block, $post) use ($post_id) {
        return ($post && (int) $post->ID === $post_id) ? false : $use_block;
    }, 10, 2);

    // 2) Remove Classic Editor content box for this request only.
    //    (remove_post_type_support is global, so do it late and only for this load.)
    add_action('admin_head', function() {
        remove_post_type_support('page', 'editor');
    });

    // Optional: also hide the editor area via CSS in case another plugin re-adds it.
    add_action('admin_head', function() {
        echo '<style>#postdivrich, #post-body-content { display:none !important; }</style>';
    });
}


