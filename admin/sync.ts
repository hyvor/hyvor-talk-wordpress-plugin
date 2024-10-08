import { exec } from 'child_process';
import chokidar from 'chokidar';

const arg = process.argv[2];

function copyDir(src: string, dest: string) {

    const command = `rsync -av --delete "${src}/" "${dest}/"`;

    exec(command, (error, stdout, stderr) => {
        if (error) {
          console.error(`Sync error: ${error.message}`);
          return;
        }
    });

}

function syncPluginFolder() {
    console.log(`Syncing plugin changes`);
    copyDir('../plugin', '../wordpress/wp-content/plugins/hyvor-talk');
}

if (arg === 'admin') {

    // sync admin.js
    function syncAdminJs() {
        console.log('Syncing admin files...');
        copyDir('./dist', '../plugin/static/admin');
        setTimeout(syncPluginFolder, 1000);
    }
    syncAdminJs();
    chokidar.watch('./dist/admin.js').on('all', syncAdminJs)

} else if (arg === 'plugin') {

    console.log('Syncing plugin files...');

    syncPluginFolder();
    chokidar.watch('../plugin', {
        ignored: '.svn',
    }).on('change', syncPluginFolder);


}
