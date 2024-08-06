import fs from 'node:fs';

fs.watch('./dist', () => {

    // sync to ../plugin
    fs.copyFileSync('./dist/admin.js', '../plugin/admin.js');

});
