const gulp = require("gulp");

/**
 * Default Gulp Task
 * 
 * - `copyVendor` → Copies Bootstrap & Slick.js from `node_modules` to the theme folder.
 * - `scss` → Compiles SCSS files into CSS.
 * - `scripts` → Bundles JavaScript using Webpack.
 * - `watch` → Monitors theme files for changes (SCSS, JS, PHP).
 * - `dbWatch` → Checks for WordPress database changes (new posts, comments, settings).
 *
 * Running `gulp` in the terminal will execute all of these tasks automatically.
 */
gulp.task("default", gulp.series(
    "copyVendor", 
    gulp.parallel("scss", "scripts", "watch", "dbWatch")
));
