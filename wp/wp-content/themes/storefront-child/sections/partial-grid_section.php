<?php
/* grid_section */
$section_title = get_sub_field('section_title');
$section_desc  = get_sub_field('section_description');
$grid_items    = get_sub_field('grid_items');
?>

<section class="grid-section section-<?php echo esc_attr($args['section_index'] ?? 0); ?>">
  <div class="container">
    <?php if ($section_title): ?><h2><?php echo esc_html($section_title); ?></h2><?php endif; ?>
    <?php if ($section_desc): ?><div class="description"><?php echo esc_html($section_desc); ?></div><?php endif; ?>
  </div>

  <div class="grid">
    <?php foreach ($grid_items as $item):
      $title = $item['title'];
      $size  = $item['size'];
      $video = $item['video'];
      $logo  = $item['logo']['url'];
      
    ?>
    <div class="item <?php echo esc_attr($size); ?>">
      <?php if ($video): ?>
        <video class="bg-video" muted preload="auto">
          <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
        </video>
      <?php endif; ?>
      

      <div class="overlay">
        <?php if ($logo): ?>
          <div class="logo-wrapper">
            <img src="<?php echo ($logo); ?>" alt="<?php echo esc_attr($title); ?> Logo">
          </div>
        <?php endif; ?>

        <?php if ($title): ?>
          <h3><?php echo esc_html($title); ?></h3>
          <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="container btn-wrapper">
    <a href="/" class="btn btn-primary">View All Case Studies</a>
  </div>
</section>
