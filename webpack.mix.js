const mix = require('laravel-mix');
const assets = {
    js: {'resources/js/app.js': 'public/js'},
    sass: {'resources/sass/app.scss': 'public/css'}
}


for (let [type, group] of Object.entries(assets)) {
    for (let [source, destination] of Object.entries(group)) {
        mix[type](source,destination);
    }
}