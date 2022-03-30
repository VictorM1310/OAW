const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = {
  mode: 'development',
  entry: {
    home: path.resolve(__dirname, 'public/assets/js/home.js'),
    news: path.resolve(__dirname, 'public/assets/js/news.js'),
    sidebar: path.resolve(__dirname, 'public/assets/js/sidebar.js'),
    style: path.resolve(__dirname, 'public/assets/css/home.css'),
  },
  output: {
    path: path.resolve(__dirname, 'build'),
    filename: '[name]_[contenthash].js',
    clean: true,
  },
  devServer: {
    static: {
      directory: path.resolve(__dirname, 'build'),
    },
    port: 3000,
    open: true,
    hot: true,
    compress: true,
    historyApiFallback: true,
  },
  optimization: {
    minimize: true,
    minimizer: [
      new UglifyJsPlugin({
        uglifyOptions: {
          compress: {
            dead_code: false,
            drop_console: false,
            unused: false,
          },
          output: {
            comments: false,
          },
        },
      }),
      new CssMinimizerPlugin(),
    ],
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [MiniCssExtractPlugin.loader, 'css-loader'],
      },
    ],
  },
  plugins: [
    new HtmlWebpackPlugin({
      title: 'Home',
      filename: 'home.html',
      template: 'webpack/templates/home.html',
      chunks: ['home', 'sidebar', 'style'],
    }),
    new HtmlWebpackPlugin({
      title: 'News',
      filename: 'news.html',
      template: 'webpack/templates/news.html',
      chunks: ['news', 'sidebar', 'style'],
    }),
    new CopyWebpackPlugin({
      patterns: [
        {
          from: 'public/assets/img',
          to: 'assets/img',
        },
      ],
    }),
    new MiniCssExtractPlugin({
      filename: '[name]_[contenthash].css',
    }),
  ],
};
