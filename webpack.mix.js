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

mix
  .js('resources/js/dashboard/app.js', 'public/js/dashboard')
  .js('resources/js/notes/app.js', 'public/js/notes')
  .js('resources/js/app-tmp.js', 'public/js')
  .extract([
    'vue',
    'element-ui',
    'lodash.get',
    'lodash.debounce',
    'moment',
    'axios',
    'jquery',
    'bootstrap',
  ])
;

mix.sass('resources/sass/app.scss', 'public/css');

mix.js('resources/js/mods/bookmark.js', 'public/js/mods');
mix.js('resources/js/mods/collapse.js', 'public/js/mods');

if (mix.inProduction()) {
  mix.version();
}
