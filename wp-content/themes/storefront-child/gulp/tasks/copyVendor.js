const gulp = require("gulp");
const path = require("path");
const { themePath } = require("./detectTheme");

// Define destination folder
const vendorPath = path.join(themePath, "assets/vendor");

function copyVendor() {
    return gulp.src([
        // Bootstrap: Only JS & CSS (No SCSS, No ESM, No Maps)
        "node_modules/bootstrap/dist/js/bootstrap.bundle.min.js",
        "node_modules/bootstrap/dist/css/bootstrap.min.css",

        // Slick.js: Only JS, CSS, Theme CSS, and Loader GIF
        "node_modules/slick-carousel/slick/slick.min.js",
        "node_modules/slick-carousel/slick/slick.css",
        "node_modules/slick-carousel/slick/slick-theme.css",
        "node_modules/slick-carousel/slick/ajax-loader.gif" // ✅ Now included
    ], { base: "node_modules" })
    .pipe(gulp.dest(vendorPath)) // ✅ Copy only selected files
    .on("end", () => console.log("✅ Bootstrap & Slick.js copied to assets/vendor/"));
}

module.exports = copyVendor;
