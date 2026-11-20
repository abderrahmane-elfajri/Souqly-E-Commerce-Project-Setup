import fs from 'fs';
import path from 'path';

const buildDir = path.resolve('public/build/assets');
const cssDestDir = path.resolve('public/css');
const jsDestDir = path.resolve('public/js');

if (!fs.existsSync(cssDestDir)) fs.mkdirSync(cssDestDir, { recursive: true });
if (!fs.existsSync(jsDestDir)) fs.mkdirSync(jsDestDir, { recursive: true });

if (fs.existsSync(buildDir)) {
    const files = fs.readdirSync(buildDir);
    for (const file of files) {
        if (file.endsWith('.css') && file.startsWith('app-')) {
            fs.copyFileSync(path.join(buildDir, file), path.join(cssDestDir, 'app.css'));
            console.log(`Copied ${file} -> public/css/app.css`);
        }
        if (file.endsWith('.js') && file.startsWith('app-')) {
            fs.copyFileSync(path.join(buildDir, file), path.join(jsDestDir, 'app.js'));
            console.log(`Copied ${file} -> public/js/app.js`);
        }
    }
}
