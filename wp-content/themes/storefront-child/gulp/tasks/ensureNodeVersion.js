const fs = require("fs");

const ensureNodeVersionFile = () => {
    const defaultVersion = "18";
    if (!fs.existsSync(".nvmrc")) {
        fs.writeFileSync(".nvmrc", `${defaultVersion}\n`, "utf8");
        console.log(`Created .nvmrc with default Node.js version: ${defaultVersion}`);
    }
};

module.exports = ensureNodeVersionFile;
