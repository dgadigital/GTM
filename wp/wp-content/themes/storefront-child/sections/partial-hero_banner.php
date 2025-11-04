<?php
/**
 * Hero Banner Section
 * Layout: hero_banner
 */

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === Section Styling Fields ===
$background_color = get_sub_field('background_color'); // Select (e.g. bg-white, bg-dark)
$background_image = get_sub_field('background_image'); // Image (array)
$font_color       = get_sub_field('font_color');       // Select (e.g. text-white, text-dark)

// === Section Content Fields ===
$intro_line       = get_sub_field('intro_line');
$headline         = get_sub_field('headline');
$tagline          = get_sub_field('tagline');
$primary_button   = get_sub_field('primary_button');
$secondary_button = get_sub_field('secondary_button');

// === Early return if essential data missing ===
if (empty($headline) && empty($background_image)) return;
?>

<section
  id="<?= esc_attr($section_id); ?>"
  class="hero-banner section-<?= esc_attr($section_index); ?> <?= esc_attr($background_color . ' ' . $font_color); ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?= esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container hero-content">
    <?php if (!empty($intro_line)): ?>
      <span class="hero-intro"><?= esc_html($intro_line); ?></span>
    <?php endif; ?>

    <div class="hero-content-center">
      <?php if (!empty($headline)): ?>
        <h1 class="hero-title"><?= wp_kses_post($headline); ?></h1>
      <?php endif; ?>

      <?php if (!empty($tagline)): ?>
        <div class="hero-tagline"><?= esc_html($tagline); ?></div>
      <?php endif; ?>

      <div class="hero-buttons">
        <?php if (!empty($primary_button['url'])): ?>
          <a href="<?= esc_url($primary_button['url']); ?>"
             class="btn btn-primary"
             <?php if (!empty($primary_button['target'])) echo 'target="' . esc_attr($primary_button['target']) . '"'; ?>>
             <?= esc_html($primary_button['title']); ?>
          </a>
        <?php endif; ?>

        <?php if (!empty($secondary_button['url'])): ?>
          <a href="<?= esc_url($secondary_button['url']); ?>"
             class="btn btn-secondary"
             <?php if (!empty($secondary_button['target'])) echo 'target="' . esc_attr($secondary_button['target']) . '"'; ?>>
             <?= esc_html($secondary_button['title']); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
