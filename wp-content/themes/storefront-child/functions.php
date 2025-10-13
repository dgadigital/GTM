<?php
/**
 * Storefront Child Theme functions
 */

add_action('wp_enqueue_scripts', function() {

    // Enqueue parent theme stylesheet (Storefront)
    wp_enqueue_style(
        'storefront-style',
        get_template_directory_uri() . '/style.css'
    );

    // 🔧 Vendor Styles
    wp_enqueue_style(
        'bootstrap-css',
        get_stylesheet_directory_uri() . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css')
    );

    wp_enqueue_style(
        'slick-css',
        get_stylesheet_directory_uri() . '/assets/vendor/slick-carousel/slick/slick.css',
        [],
        filemtime(get_stylesheet_directory() . '/assets/vendor/slick-carousel/slick/slick.css')
    );

    wp_enqueue_style(
        'slick-theme-css',
        get_stylesheet_directory_uri() . '/assets/vendor/slick-carousel/slick/slick-theme.css',
        ['slick-css'],
        filemtime(get_stylesheet_directory() . '/assets/vendor/slick-carousel/slick/slick-theme.css')
    );

    // 🔧 Vendor Scripts
    wp_enqueue_script(
        'bootstrap-js',
        get_stylesheet_directory_uri() . '/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js'),
        true
    );

    wp_enqueue_script(
        'slick-js',
        get_stylesheet_directory_uri() . '/assets/vendor/slick-carousel/slick/slick.min.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/assets/vendor/slick-carousel/slick/slick.min.js'),
        true
    );

    // ✅ Compiled child theme stylesheet (after vendors)
    wp_enqueue_style(
        'storefront-child-style',
        get_stylesheet_directory_uri() . '/assets/css/style.min.css',
        ['storefront-style', 'bootstrap-css', 'slick-css', 'slick-theme-css'],
        filemtime(get_stylesheet_directory() . '/assets/css/style.min.css')
    );

    // ✅ Compiled child theme JS (after vendors)
    wp_enqueue_script(
        'storefront-child-scripts',
        get_stylesheet_directory_uri() . '/assets/js/dist/bundle.min.js',
        ['jquery', 'bootstrap-js', 'slick-js'],
        filemtime(get_stylesheet_directory() . '/assets/js/dist/bundle.min.js'),
        true
    );
});


// Save ACF field groups as JSON
add_filter('acf/settings/save_json', function ($path) {
    return get_stylesheet_directory() . '/acf-json';
});

// Load ACF field groups from JSON
add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]); // remove default path
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});
