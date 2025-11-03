<?php
/**
 * Logo Slider Section
 * Layout: logo_slider
 */

if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === ACF Fields ===
$logos             = get_sub_field('logos');            // Repeater
$rows              = get_sub_field('rows') ?: 1;        // Default 1
$background_color  = get_sub_field('background_color'); // e.g. bg-white, bg-dark
$background_image  = get_sub_field('background_image'); // Image
$font_color        = get_sub_field('font_color');       // e.g. text-white
?>

<section
  id="<?php echo esc_attr($section_id); ?>"
  class="logo-slider section-<?php echo esc_attr($section_index); ?> <?php echo esc_attr($background_color . ' ' . $font_color); ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?php echo esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container">
    <?php if (!empty($logos)): ?>
      <div class="logoslider" data-rows="<?php echo esc_attr($rows); ?>">
        <?php foreach ($logos as $logo):
          $logo_img = $logo['logo_image'];
          if (empty($logo_img)) continue;
        ?>
          <div class="logo-slide">
            <?php echo wp_get_attachment_image($logo_img['ID'], 'medium', false, [
              'alt' => esc_attr(get_post_meta($logo_img['ID'], '_wp_attachment_image_alt', true) ?: 'Logo')
            ]); ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
