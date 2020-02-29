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

mix.js('resources/assets/js/app.js', 'public/js');

//mix.extract();

//mix.config.fileLoaderDirs.fonts = 'assets/fonts';


// mix.copy('public/fonts/vendor/_element-ui@2.13.0@element-ui/lib/theme-chalk/element-icons.ttf', 'public/fonts/element-icons.ttf');
// mix.copy('public/fonts/vendor/_element-ui@2.13.0@element-ui/lib/theme-chalk/element-icons.woff', 'public/fonts/element-icons.woff');

