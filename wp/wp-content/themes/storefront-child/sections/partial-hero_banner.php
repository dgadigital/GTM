<?php
/**
 * Hero Banner Section (Final Version - Auto ID, Two Link Buttons)
 * Layout: hero_banner
 */

$section_index      = $args['section_index'] ?? 0;
$section_id         = get_sub_field('section_id');       // Optional manual ID
$intro_line         = get_sub_field('intro_line');       // Text
$headline           = get_sub_field('headline');         // Textarea
$tagline            = get_sub_field('tagline');          // Textarea
$primary_button     = get_sub_field('primary_button');   // Link
$secondary_button   = get_sub_field('secondary_button'); // Link
$bg_image_id        = get_sub_field('background_image'); // Image ID

// === Auto-generate unique ID if not manually set ===
if (empty($section_id)) {
    $page_id    = get_the_ID();
    $section_id = 'page_' . $page_id . '-section_' . $section_index;
}

// === Early return if essential data missing ===
if (empty($headline) && empty($bg_image_id)) return;
?>

<section 
    id="<?php echo esc_attr($section_id); ?>"
    class="hero-banner section-<?php echo esc_attr($section_index); ?>"
>
    <?php if ($bg_image_id): ?>
        <div class="hero-bg">
            <?php echo wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'bg-img']); ?>
            <div class="overlay"></div>
        </div>
    <?php endif; ?>

    <div class="container hero-content">
        <?php if (!empty($intro_line)): ?>
            <span class="hero-intro"><?php echo esc_html($intro_line); ?></span>
        <?php endif; ?>

        <?php if (!empty($headline)): ?>
            <h1 class="hero-title"><?php echo wp_kses_post(nl2br($headline)); ?></h1>
        <?php endif; ?>

        <?php if (!empty($tagline)): ?>
            <p class="hero-tagline"><?php echo esc_html($tagline); ?></p>
        <?php endif; ?>

        <div class="hero-buttons">
            <?php if (!empty($primary_button['url'])): ?>
                <a href="<?php echo esc_url($primary_button['url']); ?>"
                   class="btn btn-primary"
                   <?php echo !empty($primary_button['target']) ? 'target="' . esc_attr($primary_button['target']) . '"' : ''; ?>>
                   <?php echo esc_html($primary_button['title']); ?>
                </a>
            <?php endif; ?>

            <?php if (!empty($secondary_button['url'])): ?>
                <a href="<?php echo esc_url($secondary_button['url']); ?>"
                   class="btn btn-secondary"
                   <?php echo !empty($secondary_button['target']) ? 'target="' . esc_attr($secondary_button['target']) . '"' : ''; ?>>
                   <?php echo esc_html($secondary_button['title']); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
