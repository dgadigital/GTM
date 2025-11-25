// gulp/tasks/generateSectionScss.js
const fs = require("fs");
const path = require("path");
const extractSectionClasses = require("./extractSectionClasses");

module.exports = function generateSectionScss() {
  const sectionsPath = path.resolve(__dirname, "../../sections");
  const scssSectionsPath = path.resolve(__dirname, "../../assets/scss/sections");

  // Ensure SCSS folder exists
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
    const phpFilePath = path.join(sectionsPath, file);

    // Create SCSS file if missing (empty)
    if (!fs.existsSync(scssFilePath)) {
      fs.writeFileSync(scssFilePath, "");
      console.log(`🆕 Created ${scssFilePath}`);
    }

    // Check if SCSS file is empty
    const currentContent = fs.readFileSync(scssFilePath, "utf8").trim();

    if (currentContent.length === 0) {
      const scssOutput = extractSectionClasses(phpFilePath, baseName);
      fs.writeFileSync(scssFilePath, scssOutput);
      console.log(`🎨 Auto-generated SCSS for: ${scssFilePath}`);
    }
  });
};
