const fs = require("fs");
const path = require("path");
const { themePath } = require("./detectTheme");

function checkThemeEnqueue() {
  console.log("\nChecking theme asset enqueues...\n");

  const funcPath = path.join(themePath, "functions.php");
  if (!fs.existsSync(funcPath)) {
    console.error("❌ functions.php not found in theme path.");
    return;
  }

  const content = fs.readFileSync(funcPath, "utf8");
  const checks = [
    { file: "assets/css/style.min.css", label: "style.min.css" },
    { file: "assets/js/dist/bundle.min.js", label: "bundle.min.js" }
  ];

  let allGood = true;

  for (const { file, label } of checks) {
    if (content.includes(file)) {
      console.log(`✅ Enqueued: ${label}`);
    } else {
      console.warn(`⚠️ Missing enqueue for ${label}`);
      allGood = false;
    }
  }

  if (allGood) {
    console.log("\n🎉 All theme assets are properly enqueued.\n");
  } else {
    console.log("\n⚠️ Some theme assets may not be enqueued correctly.\n");
  }
}

checkThemeEnqueue();
