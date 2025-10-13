const fs = require("fs");
const path = require("path");
const { themePath } = require("./detectTheme");

function checkVendorEnqueue() {
  const vendorPath = path.join(themePath, "assets/vendor");
  const functionsPhp = path.join(themePath, "functions.php");

  if (!fs.existsSync(vendorPath)) {
    console.error("❌ Vendor folder missing:", vendorPath);
    return;
  }

  if (!fs.existsSync(functionsPhp)) {
    console.error("❌ functions.php not found. Cannot verify enqueues.");
    return;
  }

  const phpContent = fs.readFileSync(functionsPhp, "utf8");
  const vendorFolders = fs.readdirSync(vendorPath);

  console.log("🔍 Checking vendor enqueues...\n");

  vendorFolders.forEach(folder => {
    const folderPath = path.join(vendorPath, folder);

    if (fs.statSync(folderPath).isDirectory()) {
      const vendorFiles = fs.readdirSync(folderPath, { recursive: true })
        .filter(file => /\.(css|js)$/i.test(file)); // Only .css / .js

      vendorFiles.forEach(file => {
        const fileName = path.basename(file);

        if (!phpContent.includes(fileName)) {
          console.error(`⚠️  Not enqueued yet: ${fileName}`);
        } else {
          console.log(`✅ Enqueued: ${fileName}`);
        }
      });
    }
  });
}

module.exports = checkVendorEnqueue;
