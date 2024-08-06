import fs from 'node:fs';
import { exec } from 'child_process';
import chokidar from 'chokidar';

const arg = process.argv[2];

if (arg === 'admin') {

    // sync admin.js
    function syncAdminJs() {
        console.log('Syncing admin files...');

        const adminJs = './dist/admin.js';
        if (fs.existsSync(adminJs)) {
            fs.copyFileSync(adminJs, '../plugin/static/admin.js');
        }
    }
    syncAdminJs();
    chokidar.watch('./dist/admin.js').on('all', syncAdminJs)

} else if (arg === 'plugin') {

    console.log('Syncing plugin files...');

    function syncPluginFolder() {

        const from = '../plugin';
        const to = '../wordpress/wp-content/plugins/hyvor-talk';
        const command = `rsync -av --delete "${from}/" "${to}/"`;

        console.log(`Syncing plugin changes at ${new Date().toLocaleString()}`);

        exec(command, (error, stdout, stderr) => {
            if (error) {
              console.error(`Sync error: ${error.message}`);
              return;
            }
        });

    }

    syncPluginFolder();
    chokidar.watch('../plugin', {
        ignored: '.svn',
    }).on('change', syncPluginFolder);


}
