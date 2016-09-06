var elixir = require('laravel-elixir')

var paths = {
  js: [],
  css: [],
}

elixir(function (mix) {
  mix.sass('app.sass', './resources/assets/tmp')
  paths.css.push('./resources/assets/tmp/app.css')

  mix.browserify('app.js', './resources/assets/tmp/app.js')
  paths.js.push('./resources/assets/tmp/app.js')

  mix.copy('./node_modules/font-awesome/fonts/**', 'public/fonts')

  mix.scripts(paths.js, './public/js/app.js', './')
  mix.styles(paths.css, './public/css/app.css', './')
})