<?php
if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// === ACF Fields ===
$section_title        = get_sub_field('section_title');        // Text
$section_description  = get_sub_field('section_description');  // Textarea
$block_wrapper_title  = get_sub_field('block_wrapper_title');  // Text
$background_color     = get_sub_field('background_color');     // Select (e.g. bg-orange)
$blocks               = get_sub_field('blocks');               // Repeater
$content_source       = get_sub_field('content_source') ?: 'sectors'; // Select (default sectors)
?>

<section class="section-<?php echo esc_attr($section_index); ?> icon-column-section <?php echo esc_attr($background_color); ?>">
  <div class="container">
    <div class="section-header d-flex justify-content-between align-items-start flex-column flex-lg-row">
      <?php if (!empty($section_title)): ?>
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
      <?php endif; ?>

      <?php if (!empty($section_description)): ?>
        <div class="section-description">
          <?php echo wp_kses_post($section_description); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($block_wrapper_title)): ?>
      <h3 class="block-wrapper-title"><?php echo esc_html($block_wrapper_title); ?></h3>
    <?php endif; ?>


    <?php
    // ==========================================================
    // OPTION 1 → Auto pull from CPT "sectors"
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
            <a href="<?php echo esc_url(get_permalink()); ?>" class="icon-block">
            
              <div class="icon-block-inner">
                <?php if (!empty($sector_icon)): ?>
                  <div class="icon-wrapper">
                    <?php echo wp_get_attachment_image($sector_icon, 'medium', false, ['class' => 'icon', 'alt' => esc_attr($sector_title)]); ?>
                  </div>
                <?php endif; ?>

                <div class="block-text-wrapper">
                  <h4 class="block-title"><?php echo esc_html($sector_title); ?></h4>
                  <?php if (!empty($sector_desc)): ?>
                    <div class="block-description"><?php echo wp_kses_post($sector_desc); ?></div>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      <?php endif; ?>

    <?php
    // ==========================================================
    // OPTION 2 → Manual Repeater (forced)
    // ==========================================================
    elseif ($content_source === 'manual' && !empty($blocks)) :
    ?>
      <div class="row icon-blocks">
        <?php foreach ($blocks as $block):
          $icon             = $block['icon']['url'] ?? '';
          $block_title      = $block['block_title'] ?? '';
          $block_description = $block['block_description'] ?? '';
        ?>
          <div class="icon-block">
            <div class="icon-block-inner">
              <?php if (!empty($icon)): ?>
                <div class="icon-wrapper">
                  <img src="<?php echo esc_url($icon); ?>" class="icon" alt="<?php echo esc_attr($block_title ?: 'Icon'); ?>">
                </div>
              <?php endif; ?>

              <div class="block-text-wrapper">
                <?php if (!empty($block_title)): ?>
                  <h4 class="block-title"><?php echo esc_html($block_title); ?></h4>
                <?php endif; ?>
                <?php if (!empty($block_description)): ?>
                  <div class="block-description"><?php echo wp_kses_post($block_description); ?></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
