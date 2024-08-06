import fs from 'node:fs';

// sync admin.js
function syncAdminJs() {
    fs.copyFileSync('./dist/admin.js', '../plugin/static/admin.js');
}
syncAdminJs();
fs.watch('./dist', syncAdminJs);
