/**
 * watch.js — Watches SCSS, JS, and PHP files and triggers BrowserSync reloads
 */
require("dotenv").config();

const gulp = require("gulp");
const browserSync = require("./browserSync");
const path = require("path");
const { themePath } = require("./detectTheme");
const generateSectionScss = require("./generateSectionScss");

// Define theme-specific paths
const themeScss = [
  path.join(themePath, "assets/scss/**/*.scss"),
  "!" + path.join(themePath, "assets/css/**/*.css"), // ⛔ ignore compiled CSS output
];
const themeJs = path.join(themePath, "assets/js/src/**/*.js");

// 🧩 PHP watcher — exclude vendor/node_modules to stop infinite reload loops
const themePhp = [
  path.join(themePath, "**/*.php"),
  "!" + path.join(themePath, "node_modules/**/*"),
  "!" + path.join(themePath, "vendor/**/*"),
  "!" + path.join(themePath, "assets/vendor/**/*"),
  "!" + path.join(themePath, "gulp/**/*"),
  "!" + path.join(themePath, "acf-json/**/*"),
];

function watch() {
  const proxyUrl = process.env.BROWSERSYNC_PROXY || "http://localhost:8000";

  browserSync.init({
    proxy: proxyUrl,
    notify: false,
    open: true,
    injectChanges: true,
    reloadDebounce: 1500, // 🧠 delay reloads slightly to prevent loops in Docker
    reloadDelay: 800, // ✅ add this line
  });

  // 🧩 Watch SCSS → run 'scss' task → inject CSS (no full reload)
  // gulp.watch(themeScss, gulp.series("scss")).on("change", browserSync.stream);
gulp.watch(themeScss, gulp.series("scss"));


  // 🧩 Watch JS → run 'scripts' task → reload browser
  gulp.watch(themeJs, gulp.series("scripts", (done) => {
    console.log("⚡ JS source changed → rebuilding bundle...");
    browserSync.reload();
    done();
  }));

  // 🧩 Watch PHP → reload browser (with delay)
  gulp.watch(themePhp).on("change", (file) => {
    console.log(`🔄 Reloading due to PHP change: ${path.basename(file)}`);
    setTimeout(() => browserSync.reload(), 1200); // wait for Docker write to finish
  });

  // 🆕 Watch /sections folder → auto-generate matching SCSS when new partials are added
  const sectionsPath = path.join(themePath, "sections/*.php");
  gulp.watch(sectionsPath).on("add", (file) => {
    console.log(`🆕 Detected new partial: ${path.basename(file)}`);
    generateSectionScss();
  });
}

module.exports = watch;
