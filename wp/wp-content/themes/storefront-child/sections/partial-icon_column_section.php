<?php
if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === ACF Fields ===
$section_title        = get_sub_field('section_title');        // Text
$section_description  = get_sub_field('section_description');  // WYSIWYG
$block_wrapper_title  = get_sub_field('block_wrapper_title');  // Text
$background_color     = get_sub_field('background_color');     // Select (bg-*)
$font_color           = get_sub_field('font_color');           // Select (text-*)
$blocks               = get_sub_field('blocks');               // Repeater
$content_source       = get_sub_field('content_source') ?: 'sectors'; // Select (default)
?>

<section
  id="<?= esc_attr($section_id); ?>"
  class="icon-column-section section-<?= esc_attr($section_index); ?> <?= esc_attr($background_color . ' ' . $font_color); ?>"
>
  <div class="container">
    <div class="section-header d-flex justify-content-between align-items-start flex-column flex-lg-row">
      <?php if (!empty($section_title)): ?>
        <h2 class="section-title <?= $font_color?>"><?= esc_html($section_title); ?></h2>
      <?php endif; ?>

      <?php if (!empty($section_description)): ?>
        <div class="section-description <?= $font_color?>">
          <?= wp_kses_post($section_description); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($block_wrapper_title)): ?>
      <h3 class="block-wrapper-title <?= $font_color?>"><?= esc_html($block_wrapper_title); ?></h3>
    <?php endif; ?>

    <?php
    // ==========================================================
    // OPTION 1 → Auto pull from CPT "sector"
    // OPTION 2 → Manual Repeater fallback
    // ==========================================================
    if ($content_source === 'sectors') :

      $sectors = new WP_Query([
        'post_type'      => 'sector',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
      ]);

      if ($sectors->have_posts()) :
    ?>
        <div class="row icon-blocks">
          <?php while ($sectors->have_posts()) : $sectors->the_post();
            $sector_icon  = get_field('sector_icon'); // Image ID
            $sector_title = get_the_title();
            $sector_desc  = get_field('sector_description') ?: get_the_excerpt();
          ?>
            <a href="<?= esc_url(get_permalink()); ?>" class="icon-block">
              <div class="icon-block-inner">
                <?php if (!empty($sector_icon)): ?>
                  <div class="icon-wrapper">
                    <?= wp_get_attachment_image($sector_icon, 'medium', false, ['class' => 'icon', 'alt' => esc_attr($sector_title)]); ?>
                  </div>
                <?php endif; ?>

                <div class="block-text-wrapper">
                  <h4 class="block-title"><?= esc_html($sector_title); ?></h4>
                  <?php if (!empty($sector_desc)): ?>
                    <div class="block-description"><?= wp_kses_post($sector_desc); ?></div>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      <?php endif; ?>

    <?php elseif ($content_source === 'manual' && !empty($blocks)) : ?>
      <div class="row icon-blocks">
        <?php foreach ($blocks as $block):
          $icon              = $block['icon']['url'] ?? '';
          $block_title       = $block['block_title'] ?? '';
          $block_description = $block['block_description'] ?? '';
        ?>
          <div class="icon-block">
            <div class="icon-block-inner">
              <?php if (!empty($icon)): ?>
                <div class="icon-wrapper">
                  <img src="<?= esc_url($icon); ?>" class="icon" alt="<?= esc_attr($block_title ?: 'Icon'); ?>">
                </div>
              <?php endif; ?>

              <div class="block-text-wrapper">
                <?php if (!empty($block_title)): ?>
                  <h4 class="block-title"><?= esc_html($block_title); ?></h4>
                <?php endif; ?>
                <?php if (!empty($block_description)): ?>
                  <div class="block-description"><?= wp_kses_post($block_description); ?></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
