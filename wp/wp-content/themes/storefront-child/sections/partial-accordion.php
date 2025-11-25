<?php
/**
 * Accordion Layout
 */

// ============================
// ACF FIELDS
// ============================
$section_id     = get_sub_field('section_id');              // Text
$bg_color       = get_sub_field('background_color');        // Select
$title          = get_sub_field('title');                   // Text
$faqs           = get_sub_field('faqs');                    // Repeater (array)
// ============================

// Early return if no FAQs
if (empty($faqs)) return;

$section_index  = $args['section_index'] ?? 0;

$final_id = $section_id ? $section_id : 'section-' . $section_index;

$bg_class = $bg_color ? esc_attr($bg_color) : '';
?>

<section id="<?php echo esc_attr($final_id); ?>" class="Accordion-section <?php echo $bg_class; ?> section-<?php echo esc_attr($section_index); ?>" id="<?php echo esc_attr($final_id); ?>">
  <div class="container">

    <?php if ($title): ?>
      <h2 class="section-title section-title-small">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <div class="faq-container">

      <?php foreach ($faqs as $index => $faq): 
        $question = $faq['question'];   // Text
        $answer   = $faq['answer'];     // WYSIWYG or textarea

        if (empty($question) && empty($answer)) continue;

        // First FAQ should be open
        $is_open = $index === 0 ? ' open' : '';
        $show_content = $index === 0 ? ' show' : '';
      ?>

      <div class="faq-item">
        <!-- //check -->
        <div class="faq-header<?php echo $is_open; ?>">
          <?php echo esc_html($question); ?>
        </div>

        <div class="faq-content<?php echo $show_content; ?>">
          <div class="faq-inner">
            <?php echo wp_kses_post($answer); ?>
          </div>
        </div>
      </div>

      <?php endforeach; ?>

    </div>

  </div>
</section>
