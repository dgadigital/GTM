// gulp/tasks/checkJsFolder.js
const fs = require("fs");
const path = require("path");
const { themePath } = require("./detectTheme");

// ✅ Define JS source and dist paths
const jsBasePath = path.join(themePath, "assets/js");
const jsSrcPath = path.join(jsBasePath, "src");
const jsDistPath = path.join(jsBasePath, "dist");

// ✅ Ensure `assets/js/src` folder exists
if (!fs.existsSync(jsSrcPath)) {
  fs.mkdirSync(jsSrcPath, { recursive: true });
  console.log("✅ Created JS source folder:", jsSrcPath);
}

// ✅ Ensure `assets/js/dist` folder exists
if (!fs.existsSync(jsDistPath)) {
  fs.mkdirSync(jsDistPath, { recursive: true });
  console.log("✅ Created JS dist folder:", jsDistPath);
}

// ✅ Ensure `main.js` exists inside `src/`
const mainJsPath = path.join(jsSrcPath, "main.js");
if (!fs.existsSync(mainJsPath)) {
  fs.writeFileSync(
    mainJsPath,
    `// Default JS entry file
import 'bootstrap';
import $ from 'jquery';
import 'slick-carousel';

$(document).ready(function () {
  console.log('✅ main.js is loaded and ready!');
});`,
    "utf8"
  );
  console.log("✅ Created JS entry file:", mainJsPath);
}

module.exports = function checkJsFolder() {};
