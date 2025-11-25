const semver = require("semver");

// Required version
const required = ">=18";

// Current version
const current = process.version.replace("v", "");

if (!semver.satisfies(current, required)) {
  console.error("\n❌ ERROR: Wrong Node version detected.\n");
  console.error(`Current: v${current}`);
  console.error("Required: Node 18 or higher\n");
  console.error("👉 FIX: Run the following command:\n");
  console.error("   nvm use 18\n");
  process.exit(1);
}
