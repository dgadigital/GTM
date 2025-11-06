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
$content_source    = get_sub_field('content_source');
?>

<section
  class="grid-section section-<?= esc_attr($section_index); ?> <?= esc_attr($background_color . ' ' . $font_color); ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?= esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container">
    <?php if (!empty($section_title)): ?>
      <h2 class="section-title <?= $font_color?>"><?= esc_html($section_title); ?></h2>
    <?php endif; ?>

    <?php if (!empty($section_desc)): ?>
      <div class="section-description <?= $font_color?>"><?= esc_html($section_desc); ?></div>
    <?php endif; ?>
  </div>

<?php
// Debug (optional)
echo '<!-- content_source: ' . esc_html($content_source) . ' -->';

// === If source is Manual (use repeater)
if ($content_source === 'manual' && !empty($grid_items)): ?>
  <div class="grid">
    <?php foreach ($grid_items as $item):
      $title          = $item['title'] ?? '';
      $size           = $item['size'] ?? '';
      $video          = $item['video'] ?? '';
      $image_fallback = $item['image_fallback']['url'] ?? '';
      $logo           = $item['logo']['url'] ?? '';
      $post_url       = $item['post_url'] ?? '#';
    ?>
      <a href="<?= esc_url($post_url); ?>" class="item <?= esc_attr($size); ?>">
        <?php if (!empty($video)): ?>
          <video class="bg-video" muted preload="auto" loop playsinline>
            <source src="<?= esc_url($video['url']); ?>" type="video/mp4">
          </video>
        <?php elseif (!empty($image_fallback)): ?>
          <img class="bg-video bg-img-fallback" src="<?= esc_url($image_fallback); ?>" alt="<?= esc_attr($title); ?>">
        <?php endif; ?>

        <div class="overlay">
          <?php if (!empty($logo)): ?>
            <div class="logo-wrapper">
              <img src="<?= esc_url($logo); ?>" alt="<?= esc_attr($title); ?> Logo">
            </div>
          <?php endif; ?>
          <?php if (!empty($title)): ?>
            <h3><?= esc_html($title); ?></h3>
          <?php endif; ?>
        </div>
      </a>
    <?php endforeach; ?>
  </div>

<?php
// === If source is Testimonial CPT
else:?>
  <?php
$testimonial_query = new WP_Query([
  'post_type'      => 'testimonial',
  'posts_per_page' => 9,
  'post_status'    => 'publish',
    'orderby' => 'date',
  'order'   => 'ASC',

]);

if ($testimonial_query->have_posts()): ?>
  <div class="grid">
    <?php while ($testimonial_query->have_posts()): $testimonial_query->the_post();
      $title          = get_the_title();
      $video          = get_field('video');
      $image_fallback = get_field('image_fallback');
      $logo           = get_field('logo');
      $size           = get_field('size');
      $permalink      = get_permalink();
    ?>
      <a href="<?= esc_url($permalink); ?>" class="item <?= esc_attr($size); ?>">
        <?php if (!empty($video)): ?>
          <video class="bg-video" muted preload="auto" loop playsinline>
            <source src="<?= esc_url($video['url']); ?>" type="video/mp4">
          </video>
        <?php elseif (!empty($image_fallback)): ?>
          <img class="bg-video bg-img-fallback" src="<?= esc_url($image_fallback['url']); ?>" alt="<?= esc_attr($title); ?>">
        <?php endif; ?>

        <div class="overlay">
          <?php if (!empty($logo)): ?>
            <div class="logo-wrapper">
              <img src="<?= esc_url($logo['url']); ?>" alt="<?= esc_attr($title); ?> Logo">
            </div>
          <?php endif; ?>
          <h3><?= esc_html($title); ?></h3>
        </div>
      </a>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
<?php endif; ?>


<?php endif; ?>


  <div class="container btn-wrapper">
    <a href="/" class="btn btn-primary">View All Testimonial</a>
  </div>
</section>
