const fs = require('fs');

// Load and parse the JSON file
const jsonData = require('../../design.json');

// Extract the `html` section
const htmlData = jsonData.generate;

// Define the parent class


// Function to generate CSS
function generateCSS(parent, styles) {
    let css = '';
  
    for (const [element, classes] of Object.entries(styles)) {
      if (typeof classes === 'object') {
        // Check if "container" is defined for this element
        if ('container' in classes) {
          css += `${parent} ${element} {\n  @apply ${classes.container};\n}\n\n`;
          // Remove "container" and recursively process remaining keys
          const { container, ...rest } = classes;
          css += generateCSS(`${parent} ${element}`, rest);
        } else {
          if(classes == '') continue;
          // No "container", recursively process nested styles
          css += generateCSS(`${parent} ${element}`, classes);
        }
      } else {
        if(classes == '') continue;
        // Generate CSS for simple key-value pairs
        css += `${parent} ${element} {\n  @apply ${classes};\n}\n\n`;
      }
    }
  
    return css;
  }
  
let cssOutput = '@layer components {';  
for (const [key, value] of Object.entries(htmlData)) {
    cssOutput += generateCSS(`.html-${key}`, value)
}
cssOutput += '}';
// Generate the CSS


// Write the CSS to a file
fs.writeFileSync('./assets/css/parts/generated.css', cssOutput, 'utf8');

console.log('CSS has been generated and saved to ./assets/css/parts/generated.css');
