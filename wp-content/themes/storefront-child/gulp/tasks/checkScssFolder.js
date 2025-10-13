const fs = require("fs");
const path = require("path");
const { themePath } = require("./detectTheme");

const scssPath = path.join(themePath, "assets/scss");

// Define SCSS subfolders and the files they should contain
const subfolders = {
    "abstracts": ["_variables.scss", "_mixins.scss", "_functions.scss"],
    "base": ["_globals.scss", "_reset.scss", "_typography.scss"],
    "components": ["_buttons.scss", "_forms.scss", "_cards.scss"],
    "layout": ["_header.scss", "_footer.scss"],
    "pages": ["_home.scss"],
    "sections": ["_banner.scss"]
};

// Create the main SCSS folder if it doesn't exist
if (!fs.existsSync(scssPath)) {
    fs.mkdirSync(scssPath, { recursive: true });
    console.log("✅ SCSS folder created:", scssPath);
}

// Loop through each subfolder and create it if it doesn't exist
Object.entries(subfolders).forEach(([folder, files]) => {
    const folderPath = path.join(scssPath, folder);

    if (!fs.existsSync(folderPath)) {
        fs.mkdirSync(folderPath);
        console.log(`✅ Created SCSS subfolder: ${folderPath}`);
    }

    // Create default SCSS files inside each subfolder if they don't exist
    files.forEach(file => {
        const filePath = path.join(folderPath, file);
        if (!fs.existsSync(filePath)) {
            fs.writeFileSync(filePath, "", "utf8"); // Creates an empty SCSS file
            console.log(`✅ Created SCSS file: ${filePath}`);
        }
    });
});

// Create the main SCSS entry files if they don't exist
const mainScssFiles = {
    "style.scss": "@use 'abstracts/variables';\n@use 'base/globals';\n@use 'layout/header';\n@use 'layout/footer';\n",
    "main.scss": "@use 'style';"
};

Object.entries(mainScssFiles).forEach(([file, content]) => {
    const filePath = path.join(scssPath, file);
    if (!fs.existsSync(filePath)) {
        fs.writeFileSync(filePath, content, "utf8");
        console.log(`✅ Created SCSS file: ${filePath}`);
    }
});

// Export the function so it can be used in Gulp
module.exports = function checkScssFolder() {};
