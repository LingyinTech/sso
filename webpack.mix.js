const mix = require('laravel-mix');

require('dotenv').config();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/static/js')
    .js('resources/js/index/sign.js', 'public/static/js/index')
    .js('resources/js/index/redirect.js', 'public/static/js/index')
    .js('resources/js/developer/index.js', 'public/static/js/developer')
    .sass('resources/sass/app.scss', 'public/static/css')
    .sass('resources/sass/index.scss', 'public/static/css')
    .sass('resources/sass/developer.scss', 'public/static/css')
    .copyDirectory('resources/images', 'public/static/images')
;
