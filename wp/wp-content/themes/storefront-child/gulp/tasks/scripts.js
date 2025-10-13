const gulp = require("gulp");
const webpack = require("webpack-stream");
const path = require("path");
const { themePath } = require("./detectTheme");

function scripts() {
  return gulp
    .src(path.join(themePath, "assets/js/src/main.js")) // ✅ input path
    .pipe(
      webpack({
        mode: "production",
        output: {
          filename: "bundle.min.js",
        },
        module: {
          rules: [
            {
              test: /\.js$/,
              exclude: /node_modules/,
              use: {
                loader: "babel-loader",
                options: { presets: ["@babel/preset-env"] },
              },
            },
          ],
        },
      })
    )
    .pipe(gulp.dest(path.join(themePath, "assets/js/dist"))) // ✅ output path
    .on("end", () => console.log("✅ JavaScript bundled successfully."));
}

module.exports = scripts;
