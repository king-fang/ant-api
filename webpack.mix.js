const mix = require('laravel-mix');
const path = require('path')

function resolve (dir) {
  return path.join(__dirname, dir)
}
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
// mix.browserSync({
//     proxy: 'http://hulu.test',
//     files: [
//         './resources/views/**/*.blade.php',
//         './resources/js/views/*.vue',
//         './resources/js/components/*.vue',
//         './resources/js/*.js',
//         './resources/js/**/*.js'
//     ]
// });

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
          '@': resolve('resources/js')
        }
    }
});
mix.js('resources/js/app.js', 'public/js')
   .less('resources/less/app.less', 'public/css');
