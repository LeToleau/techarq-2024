const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = {
  mode: 'development', // Default to development, can be overridden by --mode production
  entry: {
    general: './src/styles.scss', // Main entry point
    bundle: './assets/scss/index.scss', // Additional entry point
    main: './assets/js/index.js', // New JavaScript entry point
  },
  output: {
    filename: '[name].min.js', // Change filename to include '.min.js'
    path: path.resolve(__dirname, 'assets/dist'),
    publicPath: '/assets/dist/',
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          'sass-loader',
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].min.css',
    }),
  ],
  optimization: {
    minimizer: [
      new TerserPlugin({
        extractComments: false,
        terserOptions: {
          compress: {
            drop_console: true,
          },
        },
      }),
    ],
  },
};
