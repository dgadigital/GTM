<?php /* info_card_blocks */ ?> 

<?php
/**
 * Info Card Blocks Section
 */

$section_id     = get_sub_field('section_id');
$title          = get_sub_field('title');
$description    = get_sub_field('description');
$blocks         = get_sub_field('blocks'); // Repeater: image, heading, text
$button         = get_sub_field('button');
$background_img = get_sub_field('background_image')['url'];
$section_index  = $args['section_index'] ?? 0;

if (empty($title) && empty($description) && empty($blocks) && empty($button) && empty($background_img)) {
  return;
}
?>

<section class="info-card-blocks section-<?php echo esc_attr($section_index); ?>"
  <?php if ($section_id) echo 'id="' . esc_attr($section_id) . '"'; ?>
  <?php if ($background_img) : ?>
    style="background-image:url('<?php echo ($background_img)?>');"
  <?php endif; ?>>

  <div class="container info-card-content-wrapper">

    <?php if ($title || $description) : ?>
      <div class="info-card-header">
        <?php if ($title) : ?><h2 class="section-title"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <?php if ($description) : ?><div class="section-description"><?php echo wp_kses_post($description); ?></div><?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($blocks) : ?>
      <div class="info-card-grid">
        <?php foreach ($blocks as $block) :
          $image   = $block['image'] ?$block['image']['url']: '';
          $heading = $block['heading'] ?? '';
          $text    = $block['text'] ?? '';
        ?>
          <div class="info-card">
            
            <?php if ($image) : ?>
              <div class="info-card-image">
                <img src="<?php echo ($image)?>" alt="">
              </div>
            <?php endif; ?>

            <div class="info-card-content">
              <?php if ($heading) : ?><h3 class="fs-50"><?php echo ($heading); ?></h3><?php endif; ?>
              <?php if ($text) : ?><p><?php echo ($text); ?></p><?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($button) :
      $btn_url = $button['url'] ?? '';
      $btn_title = $button['title'] ?? '';
      $btn_target = $button['target'] ?? '_self';
    ?>
      <div class="info-card-button">
        <a href="<?php echo esc_url($btn_url); ?>" class="btn btn-tertiary" target="<?php echo esc_attr($btn_target); ?>">
          <?php echo esc_html($btn_title); ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>
