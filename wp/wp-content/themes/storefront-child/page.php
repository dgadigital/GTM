<?php
/**
 * Default Page Template (Child Theme)
 */

get_header(); // ✅ Correct function
?>



  <?php
    // === Global Hero Banner ===
    get_template_part('sections/partial', 'hero_banner');
  ?>

  <?php
    // === Flexible Content Template ===
    // this loads page-flexible-content.php from the same theme
    get_template_part('page', 'flexible-content');
  ?>



<?php get_footer(); ?>
