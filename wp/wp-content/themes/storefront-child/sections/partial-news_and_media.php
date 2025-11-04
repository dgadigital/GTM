<?php /* partial-news_and_media.php */ ?>
<?php
if (empty(get_row_layout())) return;

$section_index = $args['section_index'] ?? 0;

// === ACF Fields ===
$section_id       = get_sub_field('section_id');
$background_color = get_sub_field('background_color'); // e.g. bg-gray-150
$font_color       = get_sub_field('font_color');       // e.g. text-dark
$section_title    = get_sub_field('section_title');    // Text
$podcast_embed    = get_sub_field('podcast_embed');    // oEmbed
$checklist_label  = get_sub_field('checklist_label');  // Text
$checklist_link   = get_sub_field('checklist_link');   // Link
$news_count       = get_sub_field('news_count') ?: 4;
$read_all_text    = get_sub_field('read_all_text') ?: 'Read All News';
$read_all_link    = get_sub_field('read_all_link');    // Link

// === Query CPT: News ===
$news_query = new WP_Query([
  'post_type'      => 'news',
  'posts_per_page' => $news_count,
  'post_status'    => 'publish',
]);
?>

<section 
  id="<?php echo esc_attr($section_id ?: 'section-' . $section_index); ?>"
  class="news-and-media section-<?php echo esc_attr($section_index); ?> <?php echo esc_attr($background_color . ' ' . $font_color); ?>"
>
  <div class="container">
    <?php if (!empty($section_title)): ?>
      <h2 class="section-title text-center"><?php echo esc_html($section_title); ?></h2>
    <?php endif; ?>

    <div class="news-media-flex">
      
      <!-- Left Column -->
      <div class="media-left">
            <?php if (!empty($podcast_embed)): ?>
            <div class="podcast-block">
                <h3 class="subheading">Listen to our Podcast on Spotify</h3>
                <div class="podcast-embed">
                <?php echo $podcast_embed; // raw HTML ?>
                </div>
            </div>
            <?php endif; ?>

        
        
          <div class="checklist-download">
            <a href="<?php echo esc_url($checklist_link['url']); ?>" target="<?php echo esc_attr($checklist_link['target'] ?: '_self'); ?>" class="download-link">
              <span class="checklist-text">Download our free Crisis PR Checklist</span>
              <span class="download-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="96" height="98" viewBox="0 0 96 98" fill="none">
                <rect width="96" height="97.5" fill="url(#pattern0_69_235)"/>
                <defs>
                <pattern id="pattern0_69_235" patternContentUnits="objectBoundingBox" width="1" height="1">
                <use xlink:href="#image0_69_235" transform="matrix(0.0115625 0 0 0.0113846 -0.078125 -0.0717949)"/>
                </pattern>
                <image id="image0_69_235" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                </defs>
                </svg>
            </span>
            </a>
          </div>
        
      </div>

      <!-- Right Column -->
      <div class="media-right">
        <h3 class="subheading">Read our latest PR news</h3>

        <?php if ($news_query->have_posts()): ?>
          <div class="news-list">
            <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
              <a href="<?php the_permalink(); ?>" class="news-item">
                <?php if (has_post_thumbnail()): ?>
                  <div class="news-thumb"><?php the_post_thumbnail('medium_large'); ?></div>
                <?php endif; ?>
                <h4 class="news-title"><?php the_title(); ?></h4>
              </a>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php else: ?>
          <p>No news found.</p>
        <?php endif; ?>

            <?php
            $news_archive_link = get_post_type_archive_link('news');
            if ($news_archive_link):
            ?>
            <div class="read-more">
                <a href="<?php echo esc_url($news_archive_link); ?>" class="btn btn-primary">
                <?php echo esc_html($read_all_text ?: 'Read All News'); ?>
                </a>
            </div>
            <?php endif; ?>

      </div>

    </div>
  </div>
</section>
