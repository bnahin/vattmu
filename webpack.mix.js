let mix = require('laravel-mix')

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

mix.js([
  'resources/assets/js/app.js',
  'public/js/backend.js',
  'public/js/frontend.js'
], 'public/js/app.js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .scripts([
    'public/adminlte/plugins/fastclick/fastclick.js',
    'public/adminlte/plugins/icheck/icheck.js',
    'public/adminlte/plugins/jquery-slimscroll/jquery.slimscroll.js',
    'public/adminlte/plugins/select2/js/select2.js'
  ], 'public/js/plugins.js')
  .styles([
    'public/adminlte/plugins/iCheck/all.css',
    'public/adminlte/plugins/select2/css/select2.css'
  ], 'public/css/plugins.css')
  .disableNotifications()

if (mix.inProduction()) {
  mix.version()
}
