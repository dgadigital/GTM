<?php
/**
 * Storefront Child Theme – Full Custom Frontend
 * Use Storefront only for WooCommerce + backend logic
 */

require_once get_stylesheet_directory() . '/inc/class-wp-bootstrap-navwalker.php';
// ==========================================================
// 1. Remove ALL Storefront CSS & JS
// ==========================================================
add_action('wp_enqueue_scripts', function() {

    // Dequeue all Storefront parent styles
    wp_dequeue_style('storefront-style');                
    wp_dequeue_style('storefront-gutenberg-blocks');     
    wp_dequeue_style('storefront-fonts');                
    wp_dequeue_style('storefront-icons');                

    // Dequeue all Storefront scripts
    wp_dequeue_script('storefront-navigation');          
    wp_dequeue_script('storefront-skip-link-focus-fix'); 
    wp_dequeue_script('storefront-header-cart');         
    wp_dequeue_script('storefront-sticky-header');       

    // Remove WooCommerce block styles (optional)
    wp_dequeue_style('wc-block-style');                  
    wp_dequeue_style('wc-blocks-style');                 
}, 100); // Run late so it overrides the parent

// ==========================================================
// 2. Disable ALL WooCommerce CSS (you’ll use your own)
// ==========================================================
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// ==========================================================
// 3. Enqueue your custom CSS & JS (Bootstrap + Slick + Your theme)
// ==========================================================
add_action('wp_enqueue_scripts', function() {

    // Bootstrap
    wp_enqueue_style(
        'bootstrap-css',
        get_stylesheet_directory_uri() . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css',
        [],
        '5.3.8'
    );

    wp_enqueue_script(
        'bootstrap-js',
        get_stylesheet_directory_uri() . '/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js',
        ['jquery'],
        '5.3.8',
        true
    );

    // Slick Carousel (optional)
    wp_enqueue_style(
        'slick-css',
        get_stylesheet_directory_uri() . '/assets/vendor/slick-carousel/slick/slick.css',
        [],
        null
    );
    wp_enqueue_script(
        'slick-js',
        get_stylesheet_directory_uri() . '/assets/vendor/slick-carousel/slick/slick.min.js',
        ['jquery'],
        null,
        true
    );

    // Your compiled child theme CSS & JS
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/assets/css/style.min.css',
        ['bootstrap-css'],
        filemtime(get_stylesheet_directory() . '/assets/css/style.min.css')
    );
    wp_enqueue_script(
        'child-scripts',
        get_stylesheet_directory_uri() . '/assets/js/dist/bundle.min.js',
        ['jquery', 'bootstrap-js'],
        filemtime(get_stylesheet_directory() . '/assets/js/dist/bundle.min.js'),
        true
    );
}, 110);

// ==========================================================
// 4. Remove Storefront's default content wrappers
// ==========================================================
add_action('after_setup_theme', function() {
    remove_action('storefront_before_content', 'storefront_before_content');
    remove_action('storefront_after_content', 'storefront_after_content');
    remove_action('storefront_content_top', 'storefront_content_top');
    remove_action('storefront_content_bottom', 'storefront_content_bottom');
});

// ==========================================================
// 5. Save and load ACF JSON (for version control)
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
// 6. Register Primary Navigation Menu
// ==========================================================
add_action('after_setup_theme', function() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'storefront-child'),
    ]);
});

// ==========================================================
// 7. Load Bootstrap Navwalker
// ==========================================================


/**
 * Automatically enable "Show in nav menus" for all public custom post types (after all are registered)
 */
add_action('wp_loaded', function() {
    $post_types = get_post_types([
        'public' => true,
        '_builtin' => false
    ], 'objects');

    foreach ($post_types as $pt) {
        if (!$pt->show_in_nav_menus) {
            $pt->show_in_nav_menus = true;
        }
    }
});

/**
 * Force all ACF-created post types to have archives and show in nav menus
 */
add_action('acf/init', function() {
    add_action('wp_loaded', function() {
        $post_types = get_post_types([
            'public'   => true,
            '_builtin' => false,
        ], 'objects');

        foreach ($post_types as $pt) {
            $pt->has_archive = true;
            $pt->show_in_nav_menus = true;
        }
    }, 20);
});


add_action('admin_init', function() {
    $pt = get_post_type_object('case-study');
    if ($pt) {
        error_log('CPT FOUND ✅');
        error_log('has_archive: ' . var_export($pt->has_archive, true));
        error_log('show_in_nav_menus: ' . var_export($pt->show_in_nav_menus, true));
    } else {
        error_log('CPT NOT FOUND ❌');
    }
});
