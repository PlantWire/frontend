const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/sass/errors.scss', 'public/css');
mix.js('resources/fontawesome/js/all.js', 'fontawesome/js/all.js')
    .sass('resources/fontawesome/scss/fontawesome.scss', 'fontawesome/scss/fontawesome.scss');
mix.styles([
    'resources/fontawesome/css/all.css'
], 'fontawesome/css/all.css');
