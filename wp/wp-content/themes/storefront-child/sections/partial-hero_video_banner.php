<?php
/**
 * Hero Video Banner
 * Layout: hero_video_banner
 */

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === Section Styling Fields ===
$background_color = (string) get_sub_field('background_color');
$background_image = get_sub_field('background_image');
$background_video = get_sub_field('background_video');
$font_color       = (string) get_sub_field('font_color');

// Normalize video value
if (is_array($background_video) && !empty($background_video['url'])) {
  $background_video = $background_video['url'];
}

// Safely get image URL
$bg_image_url = '';
if (is_array($background_image) && !empty($background_image['url'])) {
  $bg_image_url = $background_image['url'];
}

// === Section Content Fields ===
$intro_line     = get_sub_field('intro_line');
$headline       = get_sub_field('headline');
$tagline        = get_sub_field('tagline');
$primary_button = get_sub_field('primary_button');
$has_button     = is_array($primary_button) && !empty($primary_button['url']);

// === Early exit if empty ===
if (
  empty($headline)
  && empty($tagline)
  && empty($intro_line)
  && !$has_button
  && empty($background_video)
  && empty($bg_image_url)
) return;

// === Build class list ===
$section_classes = trim('hero-video-banner section-' . $section_index . ' ' . $background_color . ' ' . $font_color);
?>
<section id="<?= esc_attr($section_id); ?>" class="<?= esc_attr($section_classes); ?>">

  <!-- Background video or image -->
  <?php if (!empty($background_video)) : ?>
    <video class="hero-bg-video" autoplay muted loop playsinline>
      <source src="<?= esc_url($background_video); ?>" type="video/mp4">
    </video>
  <?php elseif (!empty($bg_image_url)) : ?>
    <img class="hero-bg-video bg-img-fallback" src="<?= esc_url($bg_image_url); ?>" alt="Hero Background">
  <?php endif; ?>

  <div class="container hero-content">
    <div class="row align-items-center hero-content-wrapper">
      <div class="text-column col-lg-6 col-md-12 col-12">
        <?php if (!empty($intro_line)) : ?>
          <h1 class="hero-intro"><?= esc_html($intro_line); ?></h1>
        <?php endif; ?>

        <?php if (!empty($headline)) : ?>
          <span class="hero-title"><?= wp_kses_post($headline); ?></span>
        <?php endif; ?>

        <?php if (!empty($tagline)) : ?>
          <p class="hero-tagline"><?= esc_html($tagline); ?></p>
        <?php endif; ?>

        <?php if ($has_button) : ?>
          <div class="btn-wrapper">
            <a href="<?= esc_url($primary_button['url']); ?>"
              class="btn btn-primary"
              <?php if (!empty($primary_button['target'])) echo 'target="' . esc_attr($primary_button['target']) . '"'; ?>>
              <?= esc_html($primary_button['title']); ?>
            </a>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-lg-6 col-md-12 col-12 video-control text-center">
        <button class="video-toggle" type="button" aria-label="Toggle video">
          <svg class="icon-play" xmlns="http://www.w3.org/2000/svg" width="44" height="72" viewBox="0 0 44 72" fill="none">
            <path d="M43.5 35.5071L0 71.0141V0L43.5 35.5071Z" fill="white" />
          </svg>
          <svg class="icon-pause" xmlns="http://www.w3.org/2000/svg" width="44" height="72" viewBox="0 0 44 72" fill="none">
            <rect x="0" width="14" height="72" fill="white" />
            <rect x="30" width="14" height="72" fill="white" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</section>
