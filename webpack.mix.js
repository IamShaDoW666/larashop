const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .alias({
        '@': 'resources/js',
    });

mix.options({
    hmrOptions: {
        host: 'localhost',
        port: 8080
    }
})

if (mix.inProduction()) {
    mix.version();
}
