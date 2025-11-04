<?php /* two_column_section */ ?>
<?php
/**
 * Two Column Section with Form
 */

if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === Section Styling Fields ===
$background_color     = get_sub_field('background_color') ?: '';
$background_image     = get_sub_field('background_image');
$font_color           = get_sub_field('font_color') ?: '';

// === Section Content ===
$section_title        = get_sub_field('section_title');
$section_description  = get_sub_field('section_description');
$left_content         = get_sub_field('left_content');
$form_content         = get_sub_field('form_content');
$reverse_columns      = get_sub_field('reverse_columns');

$reverse_class = $reverse_columns ? 'reverse' : '';
?>

<section
  id="<?= esc_attr($section_id); ?>"
  class="two-column-section section-<?= esc_attr($section_index); ?> <?= esc_attr(trim($background_color . ' ' . $font_color . ' ' . $reverse_class)); ?>"
  <?php if (!empty($background_image['url'])): ?>
    style="background-image:url('<?= esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container">
    <?php if (!empty($section_title)): ?>
      <h2 class="section-title <?= $font_color?>"><?= esc_html($section_title); ?></h2>
    <?php endif; ?>

    <?php if (!empty($section_description)): ?>
      <div class="section-description <?= $font_color?>"><?= esc_html($section_description); ?></div>
    <?php endif; ?>
  </div>

  <div class="container">
    <div class="content-wrapper d-flex flex-column flex-lg-row <?= esc_attr($reverse_class); ?>">
      
      <div class="text-col">
        <?php if (!empty($left_content)): ?>
          <div class="content"><?= wp_kses_post($left_content); ?></div>
        <?php endif; ?>
      </div>

<div class="form-col">
  <?php if (!empty($form_content)): ?>
    <div class="form-wrapper">
      <?= do_shortcode($form_content); ?>
    </div>
  <?php endif; ?>
</div>


    </div>
  </div>
</section>
