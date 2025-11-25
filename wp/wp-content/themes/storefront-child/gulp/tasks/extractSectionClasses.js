// gulp/tasks/extractSectionClasses.js
const fs = require("fs");

/**
 * Extract static classes from a PHP section file and produce nested SCSS.
 * Reusable for ALL sections.
 *
 * Logic:
 *  - Strip PHP tags
 *  - Find first <section> with a class attribute
 *  - Use the first static class as the root (e.g. .Accordion-section)
 *  - Walk inner HTML and build a simple tree of nested classNames
 *  - Ignore dynamic PHP classes and generic layout classes like "container"
 *  - Output nested SCSS matching DOM hierarchy
 */
module.exports = function extractSectionClasses(phpFilePath, baseName) {
  const php = fs.readFileSync(phpFilePath, "utf8");

  // Remove PHP blocks for easier parsing
  const noPhp = php.replace(/<\?php[\s\S]*?\?>/g, "");

  // Find first <section ... class="...">
  const sectionMatch = noPhp.match(
    /<section[^>]*class=["']([^"']+)["'][^>]*>/i
  );

  if (!sectionMatch) {
    return `/* Styles for ${baseName} section */\n`;
  }

  // Get static classes from the section tag (ignore anything weird)
  const sectionClasses = sectionMatch[1]
    .split(/\s+/)
    .filter((cls) => cls && !cls.includes("<?"));

  const rootClass = sectionClasses[0];

  if (!rootClass) {
    return `/* Styles for ${baseName} section */\n`;
  }

  // Extract only the content INSIDE the <section>...</section>
  const sectionStartIndex = noPhp.indexOf(sectionMatch[0]);
  const afterSectionOpen = sectionStartIndex + sectionMatch[0].length;
  const rest = noPhp.slice(afterSectionOpen);

  const sectionCloseIndex = rest.search(/<\/section\s*>/i);
  const sectionInnerHtml =
    sectionCloseIndex !== -1 ? rest.slice(0, sectionCloseIndex) : rest;

  // Build a simple tree of class-based nodes from the inner HTML
  const rootNode = { className: rootClass, children: [] };

  buildClassTree(sectionInnerHtml, rootNode);

  // Render SCSS from the tree
  const scss = renderScss(rootNode, 0);

  return `/* Styles for ${baseName} section */\n\n${scss}`;
};

/**
 * Build a tree of class names based on tag nesting.
 * We only care about the FIRST class on each element, and we ignore:
 *  - "container"
 *  - anything containing PHP
 */
function buildClassTree(html, rootNode) {
  const tagRegex = /<\/?([a-zA-Z0-9]+)([^>]*)>/g;
  const stack = [
    {
      tag: "section",
      node: rootNode,
    },
  ];

  let match;
  while ((match = tagRegex.exec(html)) !== null) {
    const full = match[0];
    const tagName = match[1].toLowerCase();
    const attrs = match[2] || "";

    const isClosing = full.startsWith("</");

    if (isClosing) {
      // Pop stack on closing tag
      if (stack.length > 1) {
        stack.pop();
      }
      continue;
    }

    // Opening tag
    const classMatch = attrs.match(/class=["']([^"']+)["']/i);
    let firstClass = null;

    if (classMatch) {
      const classes = classMatch[1]
        .split(/\s+/)
        .filter((cls) => cls && !cls.includes("<?"));

      if (classes.length > 0) {
        firstClass = classes[0];
      }
    }

    // Decide which node this element belongs to
    const parentNode = stack[stack.length - 1].node;

    // Ignore generic layout helpers
    const ignoreClasses = ["container"];

    let currentNode = parentNode;

    if (firstClass && !ignoreClasses.includes(firstClass)) {
      // Reuse existing child node if same class already exists under this parent
      let childNode = parentNode.children.find(
        (c) => c.className === firstClass
      );

      if (!childNode) {
        childNode = { className: firstClass, children: [] };
        parentNode.children.push(childNode);
      }

      currentNode = childNode;
    }

    // Push element onto stack, with reference to the node it maps to
    stack.push({ tag: tagName, node: currentNode });
  }
}

/**
 * Render the tree as nested SCSS.
 */
function renderScss(node, depth) {
  const indent = "  ".repeat(depth);
  let output = "";

  // Root node has no parent selector prefixing
  if (depth === 0) {
    output += `.${node.className} {\n`;
  } else {
    output += `${indent}.${node.className} {\n`;
  }

  node.children.forEach((child) => {
    output += renderScss(child, depth + 1);
  });

  output += `${indent}}\n`;

  return output;
}
