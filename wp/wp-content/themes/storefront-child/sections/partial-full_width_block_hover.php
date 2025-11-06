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
$background_color = get_sub_field('background_color'); // e.g. bg-white, bg-dark
$background_image = get_sub_field('background_image'); // Image (optional)
$font_color       = get_sub_field('font_color');       // e.g. text-dark, text-light

// === Section Content ===
$section_title       = get_sub_field('section_title');
$section_description = get_sub_field('section_description');
$rows                = get_sub_field('rows') ?: 2;
$source              = get_sub_field('source');
$blocks              = get_sub_field('blocks');
?>

<section
  id="<?= esc_attr($section_id); ?>"
  class="fullwidth-block-hover section-<?= esc_attr($section_index); ?> <?= esc_attr($background_color . ' ' . $font_color); ?> <?= (!empty($section_title) || !empty($section_description)) ? 'section-padding' : ''; ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?= esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>

  <?php if (!empty($section_title) || !empty($section_description)) : ?>
    <div class="container">
      <div class="section-text-wrapper text-center">
        <?php if (!empty($section_title)) : ?>
          <h2 class="section-title <?= esc_attr($font_color); ?>"><?= esc_html($section_title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($section_description)) : ?>
          <div class="section-description <?= esc_attr($font_color); ?>"><?= wp_kses_post($section_description); ?></div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>


  <?php
  // ===================================================
  // === SOURCE: POST TYPE (Services)
  // ===================================================
  if ($source === 'post_type' || empty($source)) :

    $query = new WP_Query([
      'post_type'      => 'services',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
    ]);

    if ($query->have_posts()) : ?>
      <div class="carousel" data-rows="<?= esc_attr($rows); ?>">
        <?php while ($query->have_posts()) : $query->the_post();
          $bg    = get_field('background_image');
          $icon  = get_field('icon');
          $title = get_the_title();
          $short = get_field('short_ext');
          $long  = get_field('long_text');
          $link  = get_permalink();
        ?>
          <a href="<?= esc_url($link); ?>" class="card">
            <?php if (!empty($bg)) : ?>
              <div class="card-image">
                <img src="<?= esc_url($bg['url']); ?>" alt="<?= esc_attr($title); ?>">
              </div>
            <?php endif; ?>

            <div class="card-content">
              <div class="content-wrap">
                <?php if (!empty($icon)) : ?>
                  <div class="icon">
                    <img width="69" height="66" src="<?= esc_url($icon['url']); ?>" alt="<?= esc_attr($title); ?> icon">
                  </div>
                <?php endif; ?>

                <h3 class="section-title text-white"><?= esc_html($title); ?></h3>

                <?php if (!empty($short)) : ?>
                  <div class="short section-description text-white"><?= esc_html($short); ?></div>
                <?php endif; ?>

                <?php if (!empty($long)) : ?>
                  <div class="long"><?= esc_html($long); ?></div>
                <?php endif; ?>

                <div class="btn-wrapper">
                  <span class="btn btn-primary">Learn More</span>
                </div>
              </div>
            </div>
          </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div><!-- /.carousel -->
    <?php endif; ?>


  <?php
  // ===================================================
  // === SOURCE: MANUAL BLOCKS
  // ===================================================
  elseif ($source === 'manual' && !empty($blocks)) : ?>
    <div class="carousel" data-rows="<?= esc_attr($rows); ?>">
      <?php foreach ($blocks as $block) :
        $bg        = $block['background_image'];
        $icon      = $block['icon'];
        $title     = $block['title'];
        $short     = $block['short_text'];
        $long      = $block['long_text'];
        $btn       = $block['button'];
        $page_link = $block['page_link']['url'] ?? ($btn['url'] ?? '#');
      ?>
        <a href="<?= esc_url($page_link); ?>" class="card">
          <?php if (!empty($bg)) : ?>
            <div class="card-image">
              <img src="<?= esc_url($bg['url']); ?>" alt="<?= esc_attr($title); ?>">
            </div>
          <?php endif; ?>

          <div class="card-content">
            <div class="content-wrap">
              <?php if (!empty($icon)) : ?>
                <div class="icon">
                  <?= wp_get_attachment_image($icon['ID'], 'thumbnail', false, ['alt' => esc_attr($title)]); ?>
                </div>
              <?php endif; ?>

              <?php if (!empty($title)) : ?>
                <h3 class="section-title <?= esc_attr($font_color); ?>"><?= esc_html($title); ?></h3>
              <?php endif; ?>

              <?php if (!empty($short)) : ?>
                <div class="short section-description <?= esc_attr($font_color); ?>"><?= esc_html($short); ?></div>
              <?php endif; ?>

              <?php if (!empty($long)) : ?>
                <div class="long"><?= esc_html($long); ?></div>
              <?php endif; ?>

              <?php if (!empty($btn)) : ?>
                <div class="btn-wrapper">
                  <span class="btn btn-primary"><?= esc_html($btn['title']); ?></span>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div><!-- /.carousel -->
  <?php endif; ?>

</section>
