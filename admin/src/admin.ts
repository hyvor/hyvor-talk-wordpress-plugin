import Admin from './Admin.svelte';

const wrap = document.getElementById('wp-hyvor-talk-admin');


if (wrap) {

    // @ts-ignore
    new Admin({
        target: wrap,
    });

}

console.log(wrap)
