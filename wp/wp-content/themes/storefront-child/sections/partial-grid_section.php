<?php
/* grid_section */

// === Section Index ===
$section_index = $args['section_index'] ?? 0;

// === Section Styling Fields ===
$background_color = get_sub_field('background_color'); // e.g. 'bg-white'
$background_image = get_sub_field('background_image'); // Image
$font_color       = get_sub_field('font_color');       // e.g. 'text-dark'

// === Section Content Fields ===
$section_title = get_sub_field('section_title');
$section_desc  = get_sub_field('section_description');
$grid_items    = get_sub_field('grid_items');
?>

<section
  class="grid-section section-<?php echo esc_attr($section_index); ?> <?php echo esc_attr($background_color . ' ' . $font_color); ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?php echo esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container">
    <?php if (!empty($section_title)): ?>
      <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
    <?php endif; ?>

    <?php if (!empty($section_desc)): ?>
      <div class="section-description"><?php echo esc_html($section_desc); ?></div>
    <?php endif; ?>
  </div>

  <?php if (!empty($grid_items)): ?>
    <div class="grid">
      <?php foreach ($grid_items as $item):
        $title          = $item['title'] ?? '';
        $size           = $item['size'] ?? '';
        $video          = $item['video'] ?? '';
        $image_fallback = $item['image_fallback']['url'] ?? '';
        $logo           = $item['logo']['url'] ?? '';
        $post_url       = $item['post_url'] ?? '#';
      ?>
        <a href="<?php echo esc_url($post_url); ?>" class="item <?php echo esc_attr($size); ?>">
          <?php if (!empty($video)): ?>
            <video class="bg-video" muted preload="auto" autoplay loop playsinline>
              <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
            </video>
          <?php elseif (!empty($image_fallback)): ?>
            <img class="bg-video bg-img-fallback" src="<?php echo esc_url($image_fallback); ?>" alt="<?php echo esc_attr($title); ?>">
          <?php endif; ?>

          <div class="overlay">
            <?php if (!empty($logo)): ?>
              <div class="logo-wrapper">
                <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($title); ?> Logo">
              </div>
            <?php endif; ?>

            <?php if (!empty($title)): ?>
              <h3><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="container btn-wrapper">
    <a href="/" class="btn btn-primary">View All Case Studies</a>
  </div>
</section>
