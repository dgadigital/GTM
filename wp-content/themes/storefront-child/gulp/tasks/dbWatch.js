const browserSync = require("browser-sync").create();
const axios = require("axios");

const WP_BASE = "http://localhost:8000"; // ✅ match your WP container URL

let lastPostID = null;
let lastCommentID = null;
let lastSettingsHash = null;

async function checkForUpdates() {
  try {
    const posts = await axios.get(`${WP_BASE}/wp-json/wp/v2/posts?per_page=1`);
    if (posts.data.length) {
      const latestPostID = posts.data[0].id;
      if (lastPostID && latestPostID !== lastPostID) {
        console.log("📝 New post detected → reload");
        browserSync.reload();
      }
      lastPostID = latestPostID;
    }
  } catch (e) {
    console.error("❌ Error checking posts:", e.code);
  }

  try {
    const comments = await axios.get(`${WP_BASE}/wp-json/wp/v2/comments?per_page=1`);
    if (comments.data.length) {
      const latestCommentID = comments.data[0].id;
      if (lastCommentID && latestCommentID !== lastCommentID) {
        console.log("💬 New comment detected → reload");
        browserSync.reload();
      }
      lastCommentID = latestCommentID;
    }
  } catch (e) {
    console.error("❌ Error checking comments:", e.code);
  }

  try {
    const settings = await axios.get(`${WP_BASE}/wp-json/wp/v2/settings`);
    const hash = Buffer.from(JSON.stringify(settings.data)).toString("base64");
    if (lastSettingsHash && hash !== lastSettingsHash) {
      console.log("⚙️ Settings changed → reload");
      browserSync.reload();
    }
    lastSettingsHash = hash;
  } catch (e) {
    console.error("❌ Error checking settings:", e.code);
  }
}

setInterval(checkForUpdates, 5000);

module.exports = function dbWatch() {
  console.log("📡 Monitoring WordPress database changes...");
};
