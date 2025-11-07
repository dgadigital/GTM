<?php /* testimonial_card_slider */ ?> 
<?php
/**
 * Partial: Testimonial Card Slider
 * Uses CPT: testimonial
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
$section_description = get_sub_field('section_description'); // Text
$archive_link  = get_post_type_archive_link('testimonial');
$bottom_btn           = get_sub_field('bottom_button');   
?>

<section
  id="<?= esc_attr($section_id); ?>"
  class="testimonial-card-slider section-<?= esc_attr($section_index); ?> <?= esc_attr($background_color . ' ' . $font_color); ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?= esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container">

    <!-- Row 1: Section Title -->
    <?php if (!empty($section_title)) : ?>
      <div class="section-title text-center <?= $font_color?>">
        <h2><?= esc_html($section_title); ?></h2>
      </div>
    <?php endif; ?>
    <?php if (!empty($section_description)) : ?>
      <div class="section-description text-center <?= $font_color?>">
        <h3><?= esc_html($section_description); ?></h3>
      </div>
    <?php endif; ?>

    <!-- Row 2: Slick Slider -->
     <div class="container">
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
             $title  = get_the_title();
             $permalink  = get_permalink();
             $logo           = get_field('logo');
             $content    = apply_filters('the_content', get_the_content());
         ?>
             <a href="<?= esc_url($permalink); ?>" class="testimonial-card">
               <div class="card-inner text-center">
                 <?php if (!empty($image_id)) : ?>
                   <div class="image-wrapper">
                     <?= wp_get_attachment_image($image_id, 'medium', false, [
                       'style' => 'max-height:111px;object-fit:contain;margin:auto;display:block;',
                       'alt'   => esc_attr(get_the_title()),
                     ]); ?>
                   </div>
                 <?php endif; ?>
   
                 <div class="content">
                   <div class="testimonial"><?= $content?></div>
                   <div class="bottom-card-wrapper">
                        <h3><?= $title?></h3>
                        <?php if (!empty($logo)): ?>
                          <div class="logo-wrapper">
                            <img src="<?= esc_url($logo['url']); ?>" alt="<?= esc_attr($title); ?> Logo">
                          </div>
                        <?php endif; ?>
                   </div>
                   

                 </div>




               </div>
             </a>
         <?php
           endwhile;
           wp_reset_postdata();
         endif;
         ?>
       </div>
     </div>

    <!-- Row 3: Button (Auto archive link) -->
  
      <div class="section-button text-center mt-4">
        <?php if (!empty($bottom_btn)): ?>  
            <a href="<?= $bottom_btn['url']?>" class="btn btn-tertiary"><?= $bottom_btn['title']?></a>    
        <?php endif; ?>
        <a href="<?= esc_url($archive_link); ?>" class="btn btn-primary">
          View All Testimonials
        </a>
      </div>
  

  

  </div>
</section>
