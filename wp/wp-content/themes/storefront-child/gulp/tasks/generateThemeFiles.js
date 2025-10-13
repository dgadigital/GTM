const fs = require("fs");
const path = require("path");
const { themePath, themeName } = require("./detectTheme");

// ---------------------------------------------
// 📂 1️⃣ Define required theme files (WordPress core)
// ---------------------------------------------
const themeFiles = {
  "style.css": `/*
Theme Name: ${themeName}
Theme URI: http://example.com/
Author: Your Name
Description: A WordPress theme.
Version: 1.0
License: GPLv2 or later
Text Domain: ${themeName.toLowerCase().replace(/\s+/g, "-")}
*/`,
  "functions.php": `<?php
function ${themeName.toLowerCase().replace(/\s+/g, "_")}_enqueue_assets() {
    // Enqueue parent theme stylesheet (Storefront)
    wp_enqueue_style('storefront-style', get_template_directory_uri() . '/style.css');

    // Enqueue compiled child theme stylesheet
    wp_enqueue_style(
        'storefront-child-style',
        get_stylesheet_directory_uri() . '/assets/css/style.min.css',
        ['storefront-style'],
        filemtime(get_stylesheet_directory() . '/assets/css/style.min.css')
    );

    // Enqueue compiled JS bundle
    wp_enqueue_script(
        'storefront-child-scripts',
        get_stylesheet_directory_uri() . '/assets/js/dist/bundle.min.js',
        ['jquery'],
        filemtime(get_stylesheet_directory() . '/assets/js/dist/bundle.min.js'),
        true
    );
}
add_action('wp_enqueue_scripts', '${themeName.toLowerCase().replace(/\s+/g, "_")}_enqueue_assets');
?>`,
  "header.php": `<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <h1><?php bloginfo("name"); ?></h1>
    <nav>
        <?php wp_nav_menu(array("theme_location" => "primary")); ?>
    </nav>
</header>`,
  "footer.php": `<?php wp_footer(); ?>
<footer>
    <p>&copy; <?php echo date("Y"); ?> <?php bloginfo("name"); ?>. All rights reserved.</p>
</footer>
</body>
</html>`,
  "index.php": `<?php get_header(); ?>
<main>
    <h2>Welcome to ${themeName}</h2>
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <article>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php the_excerpt(); ?>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>`,
  "single.php": `<?php get_header(); ?>
<main>
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <article>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>`,
  "page.php": `<?php get_header(); ?>
<main>
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
        <article>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </article>
    <?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>`,
  "sidebar.php": `<aside>
    <?php if (is_active_sidebar("sidebar-1")): ?>
        <?php dynamic_sidebar("sidebar-1"); ?>
    <?php endif; ?>
</aside>`,
  "404.php": `<?php get_header(); ?>
<main>
    <h1>Page Not Found (404)</h1>
    <p>Sorry, the page you are looking for does not exist.</p>
    <a href="<?php echo home_url(); ?>">Go back home</a>
</main>
<?php get_footer(); ?>`
};

// ---------------------------------------------
// 🎨 2️⃣ Add automatic SCSS generation
// ---------------------------------------------
const scssBaseDir = path.join(themePath, "assets/scss");
const styleScssPath = path.join(scssBaseDir, "style.scss");
const mainScssPath = path.join(scssBaseDir, "main.scss");

const styleScssContent = `
// 🔧 Abstracts (functions, mixins, variables)
@use 'abstracts/functions';
@use 'abstracts/mixins';
@use 'abstracts/variables';

// 🔧 Base styles
@use 'base/reset';
@use 'base/globals';
@use 'base/typography';

// 🔧 Layout
@use 'layout/header';
@use 'layout/footer';

// 🔧 Components
@use 'components/buttons';
@use 'components/cards';
@use 'components/forms';
`;

const mainScssContent = `@use 'style';\n`;

// ---------------------------------------------
// ⚙️ 3️⃣ Write missing files
// ---------------------------------------------
function generateThemeFiles() {
  // Create WP core files if missing
  Object.entries(themeFiles).forEach(([file, content]) => {
    const filePath = path.join(themePath, file);
    if (!fs.existsSync(filePath)) {
      fs.writeFileSync(filePath, content, "utf8");
      console.log(`✅ Created missing ${file}`);
    }
  });

  // Ensure SCSS folder structure exists
  if (!fs.existsSync(scssBaseDir)) {
    fs.mkdirSync(scssBaseDir, { recursive: true });
    console.log(`✅ Created missing folder: ${scssBaseDir}`);
  }

  // Create style.scss (if missing)
  if (!fs.existsSync(styleScssPath)) {
    fs.writeFileSync(styleScssPath, styleScssContent.trim() + "\n");
    console.log(`🎨 Created: ${styleScssPath}`);
  }

  // Create main.scss (if missing)
  if (!fs.existsSync(mainScssPath)) {
    fs.writeFileSync(mainScssPath, mainScssContent);
    console.log(`🎨 Created: ${mainScssPath}`);
  }
}

module.exports = generateThemeFiles;
