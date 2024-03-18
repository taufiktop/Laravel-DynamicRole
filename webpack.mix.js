const mix = require("laravel-mix");
const path = require("path");
const purgecss = require("@fullhuman/postcss-purgecss");
const tailwindcss = require("tailwindcss");
const cssImport = require('postcss-import');

mix
  .js("resources/js/app.js", "public/js")
  .postCss("resources/css/app.css", "public/css")
  .options({
    postCss: [
      cssImport(),
      tailwindcss("tailwind.config.js"),
      ...(mix.inProduction() ? [
        purgecss({
          content: ['./resources/views/**/*.blade.php', './resources/js/**/*.vue'],
          defaultExtractor: content => content.match(/[\w-/:.]+(?<!:)/g) || [],
          whitelistPatternsChildren: [/nprogress/],
        })
      ] : []),
    ],
  })
  .webpackConfig({
    output: mix.inProduction() && process.env.MIX_PUBLIC_PATH ? {
      chunkFilename: 'js/[name].js?id=[chunkhash]',
      publicPath: '/' + process.env.MIX_PUBLIC_PATH + '/'
    } : {
      chunkFilename: 'js/[name].js?id=[chunkhash]',
    },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '@': path.resolve('resources/js'),
      },
    },
  })
  .version()
  .sourceMaps()