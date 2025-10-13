// ✅ Step 1: Ensure correct Node.js version is used
const path = require("path");
const TASKS_PATH = path.resolve(__dirname, "gulp", "tasks"); // ✅ cross-platform absolute path

const ensureNodeVersionFile = require(path.join(TASKS_PATH, "ensureNodeVersion"));
ensureNodeVersionFile(); // Automatically creates `.nvmrc` if missing

// ✅ Step 2: Detect the active WordPress theme folder
const { themeName, themePath } = require(path.join(TASKS_PATH, "detectTheme"));

// ✅ Step 3: Import Gulp and individual tasks
const gulp = require("gulp");

// ✅ Step 4: Run folder checks BEFORE tasks load
const checkScssFolder = require(path.join(TASKS_PATH, "checkScssFolder"));
checkScssFolder();

const checkJsFolder = require(path.join(TASKS_PATH, "checkJsFolder"));
checkJsFolder();

const generateSectionScss = require(path.join(TASKS_PATH, "generateSectionScss"));
generateSectionScss();

// 📌 Task: Copies Bootstrap & Slick.js from `node_modules/` to `assets/vendor/`
const copyVendor = require(path.join(TASKS_PATH, "copyVendor"));

const checkVendorEnqueue = require(path.join(TASKS_PATH, "checkVendorEnqueue"));
checkVendorEnqueue();



// 📌 Task: Compiles SCSS to minified CSS (`assets/scss/ → assets/css/style.min.css`)
const scss = require(path.join(TASKS_PATH, "scss"));

// 📌 Task: Bundles theme JavaScript (`assets/js/main.js → assets/js/bundle.min.js`)
const scripts = require(path.join(TASKS_PATH, "scripts"));

// 📌 Task: Watches for file changes in SCSS, JS, and PHP, then reloads BrowserSync
const watch = require(path.join(TASKS_PATH, "watch"));

// 📌 Task: Monitors WordPress database changes and reloads BrowserSync
// const dbWatch = require(path.join(TASKS_PATH, "dbWatch"));

// ✅ Register individual Gulp tasks
gulp.task("copyVendor", copyVendor);
gulp.task("scss", scss);
gulp.task("scripts", scripts);
gulp.task("watch", watch);
// gulp.task("dbWatch", dbWatch);

// ✅ Default task: Runs all necessary tasks in sequence
gulp.task(
  "default",
  gulp.series(
    "copyVendor",
    gulp.parallel("scss", "scripts", "watch")
  )
);