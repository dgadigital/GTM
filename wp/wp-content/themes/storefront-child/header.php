<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
// ✅ Safety check: ensure menus are registered
$locations = get_nav_menu_locations();
?>

<!-- ==================== DESKTOP NAV ==================== -->
<nav class="navbar navbar-expand-lg sticky-top d-none d-lg-flex">
  <div class="container d-flex align-items-center justify-content-between">

    <!-- LEFT MENU -->
    <div class="navbar-left flex-grow-1 d-flex justify-content-end">
      <?php
      if (isset($locations['left'])) {
        wp_nav_menu([
          'theme_location' => 'left',
          'container'      => false,
          'menu_class'     => 'navbar-nav justify-content-end',
          'fallback_cb'    => false,
          'walker'         => new Custom_Walker_Nav(),
        ]);
      }
      ?>
    </div>

    <!-- CENTER LOGO -->
    <div class="navbar-logo mx-4 text-center">
      
        <?php
        if (function_exists('the_custom_logo') && has_custom_logo()) {
          the_custom_logo();
        } else {
          echo esc_html(get_bloginfo('name'));
        }
        ?>
      
    </div>

    <!-- RIGHT MENU -->
    <div class="navbar-right flex-grow-1 d-flex justify-content-start">
      <?php
      if (isset($locations['right'])) {
        wp_nav_menu([
          'theme_location' => 'right',
          'container'      => false,
          'menu_class'     => 'navbar-nav justify-content-start',
          'fallback_cb'    => false,
          'walker'         => new Custom_Walker_Nav(),
        ]);
      }
      ?>
    </div>

  </div>
</nav>



<!-- ==================== MOBILE NAV ==================== -->
<nav class="navbar navbar-expand-lg sticky-top d-lg-none">
  <div class="container-fluid d-flex flex-column align-items-stretch px-3">

    <!-- Top Row -->
    <div class="d-flex justify-content-center align-items-center w-100 py-2">
      
        <?php
        if (function_exists('the_custom_logo')) {
          the_custom_logo();
        } else {
          echo esc_html(get_bloginfo('name'));
        }
        ?>
      

      <!-- Toggle -->
      <button class="navbar-toggler mobile-burger" type="button"
        data-bs-toggle="collapse" data-bs-target="#mobileNav"
        aria-controls="mobileNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <!-- Collapsible Menu -->
    <div class="collapse navbar-collapse mt-2" id="mobileNav">
      <?php
      if (isset($locations['primary'])) {
        wp_nav_menu([
          'theme_location'  => 'primary',
          'container'       => false,
          'menu_class'      => 'navbar-nav text-center gap-2',
          'fallback_cb'     => false,
          'walker'          => new Custom_Walker_Nav(),
        ]);
      }
      ?>
    </div>

  </div>
</nav>