
const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const sourcemaps = require("gulp-sourcemaps");
const rename = require("gulp-rename");
const browserSync = require("./browserSync");
const path = require("path");
const { themePath } = require("./detectTheme");

// Check if we're in production mode
const isProduction = process.env.NODE_ENV === "production";

function scss() {
    return gulp.src(path.join(themePath, "assets/scss/style.scss")) // ✅ Use themePath for flexibility
        .pipe(sourcemaps.init()) // ✅ Add source maps for easier debugging
        .pipe(sass({
            outputStyle: isProduction ? "compressed" : "expanded", // ✅ Minify only in production mode
            includePaths: ["node_modules/bootstrap/scss"] // ✅ Import Bootstrap SCSS
        }).on("error", sass.logError)) // ✅ Prevent Gulp from crashing on SCSS error
        .pipe(postcss([
            autoprefixer({ overrideBrowserslist: ["last 2 versions"] }) // ✅ Add WebKit & other prefixes
        ]))
        .pipe(rename({ suffix: ".min" })) // ✅ Rename output file with .min.css
        .pipe(sourcemaps.write(".")) // ✅ Write source maps
        .pipe(gulp.dest(path.join(themePath, "assets/css"))) // ✅ Now outputs to assets/css/
        .pipe(browserSync.stream()); // ✅ Auto-refresh BrowserSync
}

module.exports = scss;