<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
  // Show admin bar when logged in
  if (is_user_logged_in()) {
    wp_admin_bar_render();
  }
?>

<?php echo '<!-- Test reload ' . time() . ' -->'; ?>


<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
  <div class="container">
    

    <button class="navbar-toggler" type="button"
      data-bs-toggle="collapse" data-bs-target="#mainNav"
      aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <?php
wp_nav_menu([
    'theme_location'  => 'primary',
    'depth'           => 2,
    'container'       => 'div',
    'container_class' => 'collapse navbar-collapse',
    'container_id'    => 'mainNav',
    'menu_class'      => 'navbar-nav ms-auto mb-2 mb-lg-0',
    'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
    'walker'          => new WP_Bootstrap_Navwalker(),
]);

    ?>
  </div>
</nav>
<div>fghfghfgh</div>

