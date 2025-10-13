/**
 * detectTheme.js — Cross-platform WordPress theme detection for Gulp
 */

const fs = require("fs");
const path = require("path");

// Normalize Windows backslashes to forward slashes for matching
const currentPath = process.cwd().replace(/\\/g, "/");

// Expected structure: should be inside "wp-content/themes/(theme_folder)/"
if (!currentPath.includes("wp-content/themes/")) {
  console.error("❌ ERROR: This is not a WordPress theme directory.");
  process.exit(1);
}

// Extract the theme path & name
const themePath = process.cwd();
const themeName = path.basename(themePath);

// Validate presence of style.css
const styleCssPath = path.join(themePath, "style.css");
if (!fs.existsSync(styleCssPath)) {
  console.error("❌ ERROR: Missing style.css. This is not a valid WordPress theme.");
  process.exit(1);
}

// Optional sanity check: make sure style.css has a "Theme Name:" header
const styleContent = fs.readFileSync(styleCssPath, "utf8");
if (!/Theme\s+Name\s*:/i.test(styleContent)) {
  console.error("❌ ERROR: style.css missing 'Theme Name:' header.");
  process.exit(1);
}

console.log(`✅ Detected WordPress theme: ${themeName}`);
module.exports = { themeName, themePath };
