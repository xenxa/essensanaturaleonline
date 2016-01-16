var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.scripts([
    'jquery-2.1.1.min.js',
    'materialize.min.js',
    'jquery-ui.min.js'
    ],'public/js/vendor.js');
});

/*
elixir(function(mix) {
    mix.styles([
    'materialize.min.css',
    ],'public/css/vendor.css');
});
*/

