const fs = require('fs');

try {
  // Read individual CSS files
  const baseCSS = fs.readFileSync('./assets/css/parts/base.css', 'utf8');
  const componentsCSS = fs.readFileSync('./assets/css/parts/components.css', 'utf8');
  const generatedCSS = fs.readFileSync('./assets/css/parts/generated.css', 'utf8');

  // Concatenate all the files
  const finalCSS = baseCSS + '\n' + componentsCSS + '\n' + generatedCSS;

  // Write the concatenated CSS to a new file
  fs.writeFileSync('./assets/css/tailwind.css', finalCSS, 'utf8');

  console.log('CSS files successfully concatenated and written to output.css');
} catch (error) {
  console.error('Error reading or writing files:', error);
}
