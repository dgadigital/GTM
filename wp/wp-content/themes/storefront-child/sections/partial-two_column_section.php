<?php
/**
 * Two Column Section
 * Fields:
 * - background_image (Image ID)
 * - section_title (Text)
 * - section_description (Text)
 * - left_content (WYSIWYG)
 * - form_content (WYSIWYG)
 * - reverse_columns (True/False)
 */

$background_image   = get_sub_field('background_image')['url']; // Image ID
$section_title      = get_sub_field('section_title'); // Text
$section_description = get_sub_field('section_description'); // Text
$left_content       = get_sub_field('left_content'); // WYSIWYG
$form_content       = get_sub_field('form_content'); // WYSIWYG
$reverse_columns    = get_sub_field('reverse_columns'); // True/False

if (empty($section_title) && empty($left_content) && empty($form_content)) return;

$section_index = $args['section_index'] ?? 0;
$section_id = get_sub_field('section_id');

$reverse_class = $reverse_columns ? 'reverse' : '';
?>

<section class="two-column-section two-column-section-form section-<?php echo esc_attr($section_index); ?> <?php echo esc_attr($reverse_class); ?>" <?php echo $section_id ? 'id="' . esc_attr($section_id) . '"' : ''; ?> <?php echo $background_image ? 'style="background-image: url(\'' . esc_url($background_image) . '\');"' : ''; ?>>
    <div class="container">
        <?php if ($section_title): ?>
          <h2><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>
        <?php if ($section_description): ?>
          <div class="description"><?php echo esc_html($section_description); ?></div>
        <?php endif; ?>
    </div>

  <div class="container">
    <div class="content-wrapper">      
      <div class="text-col">
        <?php if ($left_content): ?>
          <div class="content"><?php echo wp_kses_post($left_content); ?></div>
        <?php endif; ?>
      </div>

      <div class="form-col">
        <?php if ($form_content): ?>
          <div class="form-wrapper">
            <?php echo wp_kses_post($form_content); ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>
