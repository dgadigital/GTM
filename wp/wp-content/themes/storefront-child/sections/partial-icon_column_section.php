<?php
if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// ACF fields
$section_title       = get_sub_field('section_title'); // Text
$section_description = get_sub_field('section_description'); // Textarea
$block_wrapper_title = get_sub_field('block_wrapper_title'); // Text
$blocks              = get_sub_field('blocks'); // Repeater
$background_color = get_sub_field('background_color'); // e.g. 'bg-orange'

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

    <?php if (!empty($blocks)): ?>
      <div class="row icon-blocks">
        <?php foreach ($blocks as $block): 
          $icon = $block['icon']['url']; // Image ID
          $block_title = $block['block_title']; // Text
          $block_description = $block['block_description']; // Textarea
        ?>
          <div class="icon-block">
            <div class="icon-block-inner">
              <?php if (!empty($icon)): ?>
                <div class="icon-wrapper">
                    <img src="<?= $icon?>" class="icon" alt="<?= $block_title ?? 'Icon' ?>">   
                </div>
              <?php endif; ?>
                <div class="block-text-wrapper">
                    <?php if (!empty($block_title)): ?>
                        <h4 class="block-title"><?php echo ($block_title); ?></h4>
                    <?php endif; ?>
                    <?php if (!empty($block_description)): ?>
                        <div class="block-description"><?php echo ($block_description); ?></div>
                    <?php endif; ?>
                </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
