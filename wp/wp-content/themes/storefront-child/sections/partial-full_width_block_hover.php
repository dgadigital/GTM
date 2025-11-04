<?php /* full_width_block_hover */ ?> 
<?php
/**
 * Full Width Block Hover Slider
 * Layout: full_width_block_hover_slider
 */

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section' . $section_index;
}

// === Section Styling Fields ===
$background_color = get_sub_field('background_color'); // Select (e.g. bg-white, bg-dark)
$background_image = get_sub_field('background_image'); // Image (optional override)
$font_color       = get_sub_field('font_color');       // Select (e.g. text-dark, text-light)

// === Section Content ===
$blocks = get_sub_field('blocks');
?>

<?php if (!empty($blocks)): ?>
  <section
    id="<?= esc_attr($section_id); ?>"
    class="fullwidth-block-hover section-<?= esc_attr($section_index); ?> <?= ($background_color . ' ' . $font_color); ?>"
    <?php if (!empty($background_image)): ?>
      style="background-image:url('<?= esc_url($background_image['url']); ?>');"
    <?php endif; ?>
  >
    <div class="carousel"><!-- no Bootstrap row/cols -->
      <?php foreach ($blocks as $block): 
        $bg    = $block['background_image'];
        $icon  = $block['icon'];
        $title = $block['title'];
        $short = $block['short_text'];
        $long  = $block['long_text'];
        $btn   = $block['button'];
        $page_link   = $block['page_link']?$block['page_link']['url']:'';
        
      ?>
        <a href="<?= $page_link?>" class="card">
          
          <div class="card-image">
            <?php if (!empty($bg)): ?>
              <img src="<?= esc_url($bg['url']); ?>" alt="<?= esc_attr($title); ?>">
            <?php endif; ?>
          </div>

          <div class="card-content">
            <div class="content-wrap">
              <?php if (!empty($icon)): ?>
                <div class="icon">
                  <?= wp_get_attachment_image($icon['ID'], 'thumbnail', false, ['alt' => esc_attr($title)]); ?>
                </div>
              <?php endif; ?>

              <?php if (!empty($title)): ?>
                <h3 class="section-title <?= $font_color?>"><?= esc_html($title); ?></h3>
              <?php endif; ?>

              <?php if (!empty($short)): ?>
                <div class="short section-description <?= $font_color?>"><?= esc_html($short); ?></div>
              <?php endif; ?>

              <?php if (!empty($long)): ?>
                <div class="long"><?= esc_html($long); ?></div>
              <?php endif; ?>

              <?php if (!empty($btn)): ?>
                <div class="btn-wrapper <?= $font_color?>">
                  <a href="<?= esc_url($btn['url']); ?>" class="btn btn-primary" <?php if (!empty($btn['target'])) echo 'target="_blank"'; ?>>
                    <?= esc_html($btn['title']); ?>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div><!-- /.carousel -->
  </section>
<?php endif; ?>
