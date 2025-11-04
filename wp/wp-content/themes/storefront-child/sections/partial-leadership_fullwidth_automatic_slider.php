<?php /* leadership_fullwidth_automatic_slider */ ?>
<?php
if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// === Section ID Logic ===
$section_id = get_sub_field('section_id');
if (empty($section_id)) {
  $page_id    = get_the_ID();
  $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === ACF Fields ===
$background_color     = get_sub_field('background_color');  // e.g. bg-orange
$background_image     = get_sub_field('background_image');  // Image array
$font_color           = get_sub_field('font_color');        // e.g. text-white
$section_title        = get_sub_field('section_title');     // Text
$section_description  = get_sub_field('section_description'); // WYSIWYG
$member_wrapper_title = get_sub_field('member_wrapper_title'); // Text
$members              = get_sub_field('members');           // Repeater
?>

<section
  id="<?= esc_attr($section_id); ?>"
  class="leadership-fullwidth-automatic-slider section-<?= esc_attr($section_index); ?> <?= esc_attr($background_color . ' ' . $font_color); ?>"
  <?php if (!empty($background_image)): ?>
    style="background-image:url('<?= esc_url($background_image['url']); ?>');"
  <?php endif; ?>
>
  <div class="container">
    <div class="section-header d-flex justify-content-between align-items-start flex-column flex-lg-row">
      <?php if (!empty($section_title)): ?>
        <h2 class="section-title <?= $font_color?>"><?= esc_html($section_title); ?></h2>
      <?php endif; ?>

      <?php if (!empty($section_description)): ?>
        <div class="section-description <?= $font_color?>">
          <?= wp_kses_post($section_description); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($member_wrapper_title)): ?>
      <h3 class="member-wrapper-title <?= $font_color?>"><?= esc_html($member_wrapper_title); ?></h3>
    <?php endif; ?>
  </div>

  <?php if (!empty($members)): ?>
    <div class="members">
      <?php foreach ($members as $item):
        $member_img         = $item['member']; // Image array
        $member_name        = $item['member_name'];
        $member_position    = $item['member_position'];
        $member_description = $item['member_description'];
      ?>
        <div class="member">
          <div class="member-inner">
            <?php if (!empty($member_img)): ?>
              <div class="image-wrapper">
                <?= wp_get_attachment_image($member_img['ID'], 'full', false, [
                  'class' => 'icon',
                  'alt'   => esc_attr($member_name ?: 'Member')
                ]); ?>
              </div>
            <?php endif; ?>

            <div class="member-text-wrapper">
              <div class="member-text-wrapper-top">
                <?php if (!empty($member_name)): ?>
                  <h4 class="member-name"><?= esc_html($member_name); ?></h4>
                <?php endif; ?>

                <?php if (!empty($member_position)): ?>
                  <div class="member-position"><?= esc_html($member_position); ?></div>
                <?php endif; ?>
              </div>

              <?php if (!empty($member_description)): ?>
                <div class="member-text-wrapper-bottom">
                  <div class="member-description"><?= wp_kses_post($member_description); ?></div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
