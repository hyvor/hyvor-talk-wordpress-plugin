import Admin from './Admin.svelte';
import './admin.css';

const wrap = document.getElementById('wp-hyvor-talk-admin');


if (wrap) {

    // @ts-ignore
    new Admin({
        target: wrap,
    });

}

