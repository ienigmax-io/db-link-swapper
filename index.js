/**
 * Usage: node index.js <source> <dest> <oldDomain> <newDomain>
 * <source> - The source file to read from.
 * <dest> - The destination file to write to.
 * <oldDomain> - The domain to replace.
 * <newDomain> - The domain to replace with.
 * author: @iEnigmaX
 * version: 1.0
 */


const fs = require('fs');
const readline = require('readline');
const path = require('path');

const die = (msg) => {
    console.error(msg);
    process.exit(1);
}

const resourcePath = path.join(__dirname, 'resources');
const exportPath = path.join(__dirname, 'exports');

if (process.argv.length < 6) die('Usage: node index.js <source> <dest> <oldDomain> <newDomain>')

const source = resourcePath + '/' + process.argv[2];
const dest = exportPath + '/' + process.argv[3];
const oldDomain = process.argv[4];
const newDomain = process.argv[5];

console.log({source, dest, oldDomain, newDomain})

const readStream = fs.createReadStream(source);
const writeStream = fs.createWriteStream(dest);

const rl = readline.createInterface({
    input: readStream,
    output: writeStream,
    terminal: false
});

rl.on('line', function(line) {
    let newLine = line.replace(new RegExp(oldDomain, 'g'), newDomain);
    writeStream.write(newLine + '\n');
});

rl.on('close', function() {
    console.log('Domain replacement completed.');
});
