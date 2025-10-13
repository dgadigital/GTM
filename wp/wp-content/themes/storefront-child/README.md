# WordPress Theme Development with Gulp

This setup automates SCSS compilation, JavaScript bundling, file watching, and BrowserSync for live reloading, ensuring an efficient workflow for WordPress theme development.

---

## **📌 Features**
- **Bootstrap & Slick.js (Stored Locally in `assets/vendor/`)**
- **SCSS Compilation (With Minification & Source Maps)**
- **JavaScript Bundling with Webpack (ES6/Babel Support)**
- **Automatic Theme File Generation (`style.css`, `functions.php`, etc.)**
- **File Watching for PHP, SCSS, and JS with BrowserSync**
- **Node.js Version Management (`.nvmrc`)**

---

## **📌 Installation**

### **1️⃣ Ensure You Have Node.js and Yarn Installed**
If you haven’t installed Yarn yet, install it globally:
```
npm install -g yarn
```

### **2️⃣ Download or Copy the Theme Folder to `wp-content/themes/`**
Make sure the theme folder is placed inside the `wp-content/themes/` directory of your WordPress installation.

Example path:
```
C:/laragon/www/my-wordpress/wp-content/themes/my-theme
```

### **3️⃣ Open a Terminal and Navigate to the Theme Folder**
```
cd C:/laragon/www/my-wordpress/wp-content/themes/my-theme
```

### **4️⃣ Install Dependencies**
```
yarn add gulp gulp-sass sass gulp-webpack webpack webpack-stream browser-sync babel-loader node-sass mysql gulp-postcss autoprefixer --dev
yarn add bootstrap slick-carousel
```
✔ This will install all required **Gulp plugins, Webpack, BrowserSync, Babel, Bootstrap, and Slick.js** based on `package.json`.

### **5️⃣ Run the Initial Gulp Setup**
```
yarn gulp
```
✔ This will:
   - ✅ Check the Node.js version and enforce `.nvmrc`
   - ✅ Detect the active theme inside `wp-content/themes/`
   - ✅ Generate missing theme files (`style.css`, `functions.php`, `header.php`, etc.)
   - ✅ Copy Bootstrap & Slick.js to `assets/vendor/`
   - ✅ Compile SCSS to CSS (`assets/scss/ → assets/css/style.min.css`)
   - ✅ Bundle JavaScript (`assets/js/main.js → assets/js/bundle.min.js`)
   - ✅ Start watching files and enable live reloading via BrowserSync

---

## **📌 File Structure**
```
/my-theme
│── assets
│   ├── css
│   │   ├── style.min.css
│   ├── js
│   │   ├── bundle.min.js
│   ├── vendor
│   │   ├── bootstrap
│   │   │   ├── css/bootstrap.min.css
│   │   │   ├── js/bootstrap.bundle.min.js
│   │   ├── slick
│   │   │   ├── slick.min.js
│   │   │   ├── slick.css
│   │   │   ├── slick-theme.css
│   │   │   ├── ajax-loader.gif
│── gulp/tasks
│── gulpfile.js
│── package.json
│── yarn.lock
│── .nvmrc
│── style.css
│── functions.php
│── header.php
│── footer.php
│── index.php
│── single.php
│── page.php
│── sidebar.php
│── 404.php
```

---

## **📌 Gulp Tasks**
| **Command** | **What It Does** |
|------------|-----------------|
| `yarn gulp` | Runs all tasks (SCSS, JS, Watch, BrowserSync) |
| `yarn gulp scss` | Compiles SCSS (`assets/scss/ → assets/css/style.min.css`) |
| `yarn gulp scripts` | Bundles JS (`assets/js/main.js → assets/js/bundle.min.js`) |
| `yarn gulp watch` | Watches SCSS, JS, and PHP for changes |
| `yarn gulp copyVendor` | Copies Bootstrap & Slick.js to `assets/vendor/` |
| `yarn gulp generateThemeFiles` | Ensures required theme files exist |

---

## **📌 Notes**
✔ **The theme must be inside `wp-content/themes/` for Gulp to work properly.**
✔ **`gulpfile.js` ensures missing theme files are created.**
✔ **Bootstrap and Slick.js are placed in `assets/vendor/`.**
✔ **Supports Windows CMD (no need for PowerShell).**

---

🚀 **Now the README is fully based on `gulpfile.js`!**

