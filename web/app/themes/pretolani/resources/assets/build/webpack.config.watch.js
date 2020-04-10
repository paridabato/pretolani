const url = require('url');
const webpack = require('webpack');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

const config = require('./config');

const target = process.env.DEVURL || config.devUrl;

/**
 * We do this to enable injection over SSL.
 */
if (url.parse(target).protocol === 'https:') {
  process.env.NODE_TLS_REJECT_UNAUTHORIZED = 0;

  config.proxyUrl = config.proxyUrl.replace('http:', 'https:');
}

module.exports = {
  output: {
    pathinfo: true,
    publicPath: config.proxyUrl + config.publicPath,
  },
  cache: false,
  devtool: '#cheap-module-source-map',
  stats: false,
  plugins: [
    new webpack.optimize.OccurrenceOrderPlugin(),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoEmitOnErrorsPlugin(),
    new BrowserSyncPlugin({
      host: config.host,
      port: config.port,
      proxy: target,
      reloadDelay: 1000,
      },
      {
        injectCss: true
      }),
  ],
};
