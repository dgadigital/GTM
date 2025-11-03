<?php
/**
 * Logo Slider Section
 * Layout: logo_slider
 */

$section_index      = $args['section_index'] ?? 0;
$section_id         = get_sub_field('section_id'); // optional manual ACF field

// ✅ Auto-generate fallback ID
if (empty($section_id)) {
    $page_id    = get_the_ID();
    $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// ✅ ACF fields
$logos            = get_sub_field('logos');
$background_color = get_sub_field('background_color') ?: 'light';
$rows             = get_sub_field('rows') ?: 1;
?>

<section id="<?php echo esc_attr($section_id); ?>" class="logo-slider section-<?php echo esc_attr($section_index); ?> <?php echo ($background_color); ?>">
  <div class="container">
    <?php if ($logos): ?>
      <div class="logoslider" data-rows="<?php echo esc_attr($rows); ?>">
        <?php foreach ($logos as $logo): 
          $logo_img = $logo['logo_image'];
        ?>
          <div class="logo-slide">
            <?php echo wp_get_attachment_image($logo_img['ID'], 'medium'); ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>