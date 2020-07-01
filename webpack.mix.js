const mix = require('laravel-mix');
const tailwind = require('tailwindcss');

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

mix.js('resources/assets/scripts/app.js', 'public/js');

mix.sass('resources/assets/styles/app.scss', 'public/css').options({
    processCssUrls: false,
    postCss: [tailwind('resources/assets/styles/tailwind.config.js')],
});
