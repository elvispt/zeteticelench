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

mix.js('resources/js/dashboard/app.js', 'public/js/dashboard');
mix.js('resources/js/notes/app.js', 'public/js/notes');
mix.extract();

// global css
mix.sass('resources/sass/app.scss', 'public/css');

/**
 * This file contains no logic. It is set here to force laravel-mix to put
 * vendor and manifest on the root of public/js. If not done it would store
 * on the last mix.js('', path) path set.
 */
mix.js('resources/js/null.js', 'public/js')

if (mix.inProduction()) {
  mix.version('/js');
}
