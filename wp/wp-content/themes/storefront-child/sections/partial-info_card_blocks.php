<?php /* info_card_blocks */ ?> 

<?php
/**
 * Info Card Blocks Section
 */

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === Section Styling Fields ===
$background_color = get_sub_field('background_color'); // Select (bg-*)
$background_image = get_sub_field('background_image'); // Image array
$font_color       = get_sub_field('font_color');       // Select (text-*)

// === Section Content Fields ===
$title       = get_sub_field('title');
$description = get_sub_field('description');
$blocks      = get_sub_field('blocks'); // Repeater
$button      = get_sub_field('button');

// === Early exit if all empty ===
if (empty($title) && empty($description) && empty($blocks) && empty($button) && empty($background_image)) return;
?>

<section
  id="<?= esc_attr($section_id); ?>"
  class="info-card-blocks section-<?= esc_attr($section_index); ?> <?= esc_attr($background_color . ' ' . $font_color); ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?= esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container info-card-content-wrapper">

    <?php if (!empty($title) || !empty($description)): ?>
      <div class="info-card-header">
        <?php if (!empty($title)): ?>
          <h2 class="section-title <?= $font_color?>"><?= ($title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($description)): ?>
          <div class="section-description <?= $font_color?>"><?= wp_kses_post($description); ?></div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($blocks)): ?>
      <div class="info-card-grid">
        <?php foreach ($blocks as $block):
          $image   = $block['image']['url'] ?? '';
          $heading = $block['heading'] ?? '';
          $text    = $block['text'] ?? '';
        ?>
          <div class="info-card">
            <?php if (!empty($image)): ?>
              <div class="info-card-image">
                <img src="<?= esc_url($image); ?>" alt="<?= esc_attr($heading); ?>">
              </div>
            <?php endif; ?>

            <div class="info-card-content">
              <?php if (!empty($heading)): ?>
                <h3 class="fs-50"><?= ($heading); ?></h3>
              <?php endif; ?>
              <?php if (!empty($text)): ?>
                <p><?= ($text); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($button)):
      $btn_url    = $button['url'] ?? '';
      $btn_title  = $button['title'] ?? '';
      $btn_target = $button['target'] ?? '_self';
    ?>
      <div class="info-card-button">
        <a href="<?= esc_url($btn_url); ?>" class="btn btn-tertiary" target="<?= esc_attr($btn_target); ?>">
          <?= ($btn_title); ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>
