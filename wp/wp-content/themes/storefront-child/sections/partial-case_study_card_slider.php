<?php /* case_study_card_slider */ ?> 
<?php
/**
 * Partial: Case Study Card Slider
 * Uses CPT: case-study
 */

if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === Section Styling Fields ===
$background_color = get_sub_field('background_color'); // e.g. bg-white, bg-dark
$font_color       = get_sub_field('font_color');       // e.g. text-white

// === Section Content ===
$section_title = get_sub_field('section_title'); // Text
$archive_link  = get_post_type_archive_link('case-study'); // ✅ changed CPT
?>

<section
  id="<?php echo esc_attr($section_id); ?>"
  class="case-study-card-slider section-<?php echo esc_attr($section_index); ?> <?php echo esc_attr($background_color . ' ' . $font_color); ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?php echo esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container">


    <?php if (!empty($section_title)) : ?>
      <div class="section-title text-center">
        <h2><?php echo esc_html($section_title); ?></h2>
      </div>
    <?php endif; ?>
<?php
// --- Featured Case Study ---
$featured_case = new WP_Query([
  'post_type'      => 'case-study',
  'posts_per_page' => 1,
  'tax_query'      => [
    [
      'taxonomy' => 'case_study_feature',
      'field'    => 'slug',
      'terms'    => 'featured',
    ],
  ],
]);

if ($featured_case->have_posts()) : ?>
  <div class="featured-case-study mb-5">
    <?php while ($featured_case->have_posts()) : $featured_case->the_post(); ?>

      <div class="featured-card d-flex flex-column flex-lg-row align-items-start">

        <!-- Left: Video -->
        <div class="video-col flex-shrink-0 mb-4 mb-lg-0">
          <?php 
$video = get_field('video');

if ($video && !empty($video['url'])): 
    $video_url = $video['url'];
    // Use ACF video thumbnail (poster) if available
    $poster = '';
    if (!empty($video['ID'])) {
        $poster_src = wp_get_attachment_image_src($video['ID'], 'large');
        if ($poster_src) {
            $poster = $poster_src[0];
        }
    }
?>
  <div class="video-wrapper">
    <video controls <?php if ($poster) echo 'poster="' . esc_url($poster) . '"'; ?>>
      <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>
<?php endif; ?>



        </div>

        <!-- Right: Content -->
        <div class="content-col">
          <?php if (has_post_thumbnail()): ?>
  <div class="featured-image mb-3">
    <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
  </div>
<?php endif; ?>
          <?php if ($title = get_field('title')): ?>
            <h3 class="brand-title"><?php echo esc_html($title); ?></h3>
          <?php endif; ?>

          <?php if ($challenge = get_field('challenge')): ?>
            <div class="challenge mb-3">
              <h4>Challenge:</h4>
              <?php echo wp_kses_post($challenge); ?>
            </div>
          <?php endif; ?>

          <?php if ($play = get_field('play')): ?>
            <div class="play mb-3">
              <h4>Play:</h4>
              <?php echo wp_kses_post($play); ?>
            </div>
          <?php endif; ?>

          <?php if ($roi = get_field('roi')): ?>
            <div class="roi mb-3">
              <h4>ROI:</h4>
              <?php echo wp_kses_post($roi); ?>
            </div>
          <?php endif; ?>

          <!-- Stats -->
          <div class="stats d-flex flex-wrap mt-3">
            <?php if ($return = get_field('return_of_investment')): ?>
              <div class="stat-item">
                <span class="value"><?php echo esc_html($return); ?></span>
                <span class="label">Return of Investment</span>
              </div>
            <?php endif; ?>

            <?php if ($media = get_field('media_mentions')): ?>
              <div class="stat-item">
                <span class="value"><?php echo esc_html($media); ?></span>
                <span class="label">Media Mentions</span>
              </div>
            <?php endif; ?>

            <?php if ($crisis = get_field('crisis_response_rate')): ?>
              <div class="stat-item">
                <span class="value"><?php echo esc_html($crisis); ?></span>
                <span class="label">Crisis Response Rate</span>
              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>

    <?php endwhile; wp_reset_postdata(); ?>
  </div>
<?php endif; ?>



    <div class="container">
      <h2 class="text-center">View Other Case Studies</h2>
    </div>
    <div class="case-study-slider">
      <?php
      $case_studies = new WP_Query([
        'post_type'      => 'case-study', // ✅ CPT updated
        'posts_per_page' => -1,
        'post_status'    => 'publish',
      ]);

      if ($case_studies->have_posts()) :
        while ($case_studies->have_posts()) :
          $case_studies->the_post();

          $image_id   = get_post_thumbnail_id();
          $excerpt    = get_the_excerpt();
          $permalink  = get_permalink();
      ?>
          <div class="case-study-card">
            <div class="card-inner text-center">
              <?php if (!empty($image_id)) : ?>
                <div class="image-wrapper">
                  <?php echo wp_get_attachment_image($image_id, 'medium', false, [
                    'style' => 'max-height:180px;object-fit:cover;margin:auto;display:block;border-radius:8px;',
                    'alt'   => esc_attr(get_the_title()),
                  ]); ?>
                </div>
              <?php endif; ?>

              <div class="content">
                <h3 class="case-study-title"><?php echo esc_html(get_the_title()); ?></h3>

                <?php if (!empty($excerpt)) : ?>
                  <div class="excerpt"><?php echo esc_html($excerpt); ?></div>
                <?php endif; ?>

                <a href="<?php echo esc_url($permalink); ?>" class="learn-more">
                  Read More
                </a>
              </div>
            </div>
          </div>
      <?php
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </div>

    <!-- Row 3: Button (Auto archive link) -->
    <?php if (!empty($archive_link)) : ?>
      <div class="section-button text-center mt-4">
        <a href="<?php echo esc_url($archive_link); ?>" class="btn btn-primary">
          View All Case Studies
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>
