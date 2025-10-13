// gulp/tasks/generateSectionScss.js
const fs = require("fs");
const path = require("path");

module.exports = function generateSectionScss() {
  const sectionsPath = path.resolve(__dirname, "../../sections");
  const scssSectionsPath = path.resolve(__dirname, "../../assets/scss/sections");

  if (!fs.existsSync(scssSectionsPath)) {
    fs.mkdirSync(scssSectionsPath, { recursive: true });
    console.log(`✅ Created missing folder: ${scssSectionsPath}`);
  }

  // Read all PHP section files
  const sectionFiles = fs.readdirSync(sectionsPath).filter(file => file.endsWith(".php"));

  sectionFiles.forEach(file => {
    const baseName = file.replace("partial-", "").replace(".php", "");
    const scssFile = `_${baseName}.scss`;
    const scssFilePath = path.join(scssSectionsPath, scssFile);

    // Create file only if missing
    if (!fs.existsSync(scssFilePath)) {
      fs.writeFileSync(scssFilePath, `/* Styles for ${baseName} section */\n`);
      console.log(`🆕 Created ${scssFilePath}`);
    }
  });
};
