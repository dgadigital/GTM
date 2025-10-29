<?php /* testimonial_card_slider */ ?> 
<?php
/**
 * Partial: Testimonial Card Slider
 * Uses CPT: testimonial
 */

$section_title = get_sub_field('section_title'); // Text field from Flexible Content
$archive_link  = get_post_type_archive_link('testimonial'); // Auto-link to CPT archive
?>

<section class="testimonial-card-slider section-<?php echo esc_attr($args['section_index'] ?? 0); ?>">
  <div class="container">

    <!-- Row 1: Section Title -->
    <?php if (!empty($section_title)) : ?>
      <div class="section-title text-center">
        <h2><?php echo esc_html($section_title); ?></h2>
      </div>
    <?php endif; ?>

    <!-- Row 2: Slick Slider -->
    <div class="testimonial-slider">
      <?php
      $testimonials = new WP_Query([
        'post_type'      => 'testimonial',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
      ]);

      if ($testimonials->have_posts()) :
        while ($testimonials->have_posts()) :
          $testimonials->the_post();

          $image_id   = get_post_thumbnail_id();
          $percentage = get_field('percentage'); // ACF number field
          $permalink  = get_permalink();
      ?>
          <div class="testimonial-card">
            <div class="card-inner text-center">
              
              <?php if ($image_id) : ?>
                <div class="image-wrapper">
                  <?php echo wp_get_attachment_image($image_id, 'medium', false, [
                    'style' => 'max-height:111px;object-fit:contain;margin:auto;display:block;',
                    'alt'   => esc_attr(get_the_title()),
                  ]); ?>
                </div>
              <?php endif; ?>

              <div class="content">
                <div class="excerpt">
                  <?php echo esc_html(get_the_excerpt()); ?>
                </div>

                <?php if ($percentage) : ?>
                  <div class="percentage">
                    <?php echo esc_html($percentage); ?>
                  </div>
                <?php endif; ?>

                <a href="<?php echo esc_url($permalink); ?>" class="learn-more">
                  Learn more
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
    <?php if ($archive_link) : ?>
      <div class="section-button text-center mt-4">
        <a href="<?php echo esc_url($archive_link); ?>" class="btn btn-primary">
          View All Testimonials
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>