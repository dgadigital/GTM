<?php /* leadership_fullwidth_automatic_slider */ ?>
<?php
if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// ACF fields
$background_color       = get_sub_field('background_color'); // e.g. 'bg-orange'
$section_title          = get_sub_field('section_title'); // Text
$section_description    = get_sub_field('section_description'); // WYSIWYG
$member_wrapper_title   = get_sub_field('member_wrapper_title'); // Text
$members                = get_sub_field('members'); // Repeater
?>

<section class="section-<?php echo esc_attr($section_index); ?> leadership-fullwidth-automatic-slider <?php echo esc_attr($background_color); ?>">
  <div class="container">

    <div class="section-header d-flex justify-content-between align-items-start flex-column flex-lg-row">
      <?php if (!empty($section_title)): ?>
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
      <?php endif; ?>

      <?php if (!empty($section_description)): ?>
        <div class="section-description">
          <?php echo wp_kses_post($section_description); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($member_wrapper_title)): ?>
      <h3 class="member-wrapper-title"><?php echo esc_html($member_wrapper_title); ?></h3>
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
                  <?php echo wp_get_attachment_image($member_img['ID'], 'full', false, [
                    'class' => 'icon',
                    'alt'   => esc_attr($member_name ?: 'Member')
                  ]); ?>
                </div>
              <?php endif; ?>

              <div class="member-text-wrapper">
                <div class="member-text-wrapper-top">
                    <?php if (!empty($member_name)): ?>
                      <h4 class="member-name"><?php echo esc_html($member_name); ?></h4>
                    <?php endif; ?>
    
                    <?php if (!empty($member_position)): ?>
                      <div class="member-position"><?php echo esc_html($member_position); ?></div>
                    <?php endif; ?>
                </div>  
                <div class="member-text-wrapper-bottom">
                    <?php if (!empty($member_description)): ?>
                      <div class="member-description"><?php echo wp_kses_post($member_description); ?></div>
                    <?php endif; ?>
                </div>  
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  
</section>
