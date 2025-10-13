/**
 * watch.js — Watches SCSS, JS, and PHP files and triggers BrowserSync reloads
 */
require("dotenv").config();

const gulp = require("gulp");
const browserSync = require("browser-sync").create();
const path = require("path");
const { themePath } = require("./detectTheme");
const generateSectionScss = require("./generateSectionScss");

// Define theme-specific paths
const themeScss = [
  path.join(themePath, "assets/scss/**/*.scss"),
  "!" + path.join(themePath, "assets/css/**/*.css"), // ⛔ ignore compiled CSS output
];
const themeJs = path.join(themePath, "assets/js/src/**/*.js");


const themePhp = path.join(themePath, "**/*.php");

function watch() {
  const proxyUrl = process.env.BROWSERSYNC_PROXY || "http://localhost:8000";

  browserSync.init({
    proxy: proxyUrl,
    notify: false,
    open: true,
    injectChanges: true,
  });

  // 🧩 Watch SCSS → run 'scss' task → inject CSS (no full reload)
  gulp.watch(themeScss, gulp.series("scss")).on("change", browserSync.stream);

  // 🧩 Watch JS → run 'scripts' task → reload browser
  gulp.watch(themeJs, gulp.series("scripts", (done) => {
    console.log("⚡ JS source changed → rebuilding bundle...");
    browserSync.reload();
    done();
  }));

  // 🧩 Watch PHP → reload browser only (with small delay to prevent rapid reloads)
  gulp.watch(themePhp).on("change", (file) => {
    console.log(`🔄 Reloading due to PHP change: ${path.basename(file)}`);
    setTimeout(() => browserSync.reload(), 300);
  });

  // 🆕 Watch /sections folder → auto-generate matching SCSS when new partials are added
  const sectionsPath = path.join(themePath, "sections/*.php");
  gulp.watch(sectionsPath).on("add", (file) => {
    console.log(`🆕 Detected new partial: ${path.basename(file)}`);
    generateSectionScss();
  });
}

module.exports = watch;
