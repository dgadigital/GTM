<?php /* full_width_block_hover */ ?> 
<?php
/**
 * Full Width Block Hover Slider
 * Layout: full_width_block_hover_slider
 */

$section_index = $args['section_index'] ?? 0;
$section_id    = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

$blocks = get_sub_field('blocks');
?>

<?php if ($blocks): ?>
  <section id="<?php echo esc_attr($section_id); ?>" class="fullwidth-block-hover section-<?php echo esc_attr($section_index); ?>">
    <div class="carousel"><!-- no Bootstrap row/cols -->
      <?php foreach ($blocks as $block): 
        $bg    = $block['background_image'];
        $icon  = $block['icon'];
        $title = $block['title'];
        $short = $block['short_text'];
        $long  = $block['long_text'];
        $btn   = $block['button'];
      ?>
        <div class="card">
          <div class="card-image">
            <img src="<?php echo esc_url($bg['url']); ?>" alt="<?php echo esc_html($title); ?>">
          </div>
          <div class="card-content">
            <div class="content-wrap">
                <?php if ($icon): ?>
                  <div class="icon">
                    <?php echo wp_get_attachment_image($icon['ID'], 'thumbnail'); ?>
                  </div>
                <?php endif; ?>
                <h3><?php echo esc_html($title); ?></h3>
                <div class="short"><?php echo esc_html($short); ?></div>
                <div class="long"><?php echo esc_html($long); ?></div>
                <div class="btn-wrapper">
                    <?php if ($btn): ?>
                  <a href="<?php echo esc_url($btn['url']); ?>" class="btn btn-primary" <?php if ($btn['target']) echo 'target="_blank"'; ?>>
                    <?php echo esc_html($btn['title']); ?>
                  </a>
                <?php endif; ?>
                </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div><!-- /.carousel -->
  </section>
<?php endif; ?>
