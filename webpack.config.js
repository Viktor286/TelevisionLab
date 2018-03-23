'use strict';

const webpack = require('webpack');
// const ConcatPlugin = require('webpack-concat-plugin');
const AssetsPlugin = require('assets-webpack-plugin');

const mode = process.env.NODE_ENV;

mode === 'production' ? console.log('production >>>>>>>>>>: '+__dirname) : null;

let moduleDevRules = {
    rules: [
        {
            enforce: "pre",
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
                loader: 'eslint-loader',
                options: {
                    // this will edit source files
                    // fix: true
                }
            }
        },
        {
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
                loader: 'babel-loader',
                options: {
                    presets: ['es2015'] // es2015, env
                }
            }
        }
    ],
};

let pluginDevRules = [

];


let moduleProductionRules = {
    rules: [
        {
            test: /\.js$/,
            exclude: /(node_modules|bower_components)/,
            use: {
                loader: 'babel-loader',
                options: {
                    presets: ['es2015'] // es2015, env
                }
            }
        }
    ],
};

let pluginProductionRules = [
    new webpack.optimize.UglifyJsPlugin({
        sourceMap: true
    }),
    new webpack.NoEmitOnErrorsPlugin(),
    new AssetsPlugin({
        filename: 'build.js.json',
        path: __dirname + '/desktop/js/manifest/'
    })

];



module.exports = {

    context: __dirname,

    entry: {
        build: './desktop/js/static/app.js'
    },

    output: {
        path: __dirname + '/desktop/js/',
        filename: mode === 'production' ? '[name].[chunkhash].js' : '[name].js',
    },

    watch: mode !== 'production',

    watchOptions: {
        aggregateTimeout: 100
    },

    devtool: mode === 'production' ? "source-map" : false,

    plugins: mode === 'production' ? pluginProductionRules : pluginDevRules,

    module: mode === 'production' ? moduleProductionRules : moduleDevRules

};