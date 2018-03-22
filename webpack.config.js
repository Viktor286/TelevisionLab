'use strict';

const webpack = require('webpack');
// const ConcatPlugin = require('webpack-concat-plugin');
const AssetsPlugin = require('assets-webpack-plugin');

console.log('>>>>>>>>>>: '+__dirname);
module.exports = {

    context: __dirname,

    entry: {
        build: './desktop/js/static/app.js'
        // vendors: './desktop/js/static/vendors.js'
    },

    output: {
        path: __dirname + '/desktop/js/',
        filename: '[name].[chunkhash].js'
    },

    watch: false,

    watchOptions: {
        aggregateTimeout: 100
    },

    devtool: 'source-map',

    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            sourceMap: true
        }),
        new webpack.NoEmitOnErrorsPlugin(),
        new AssetsPlugin({
            filename: 'build.js.json',
            path: __dirname + '/desktop/js/manifest/'
        })

    ]

    // console.log('NODE_ENV: ', env.NODE_ENV); // 'local', --env.NODE_ENV=development
    // console.log('Production: ', env.production); // true, --env.production


        // devtool: env.NODE_ENV === 'development' ? "cheap-inline-module-source-map" : "source-map",
        // source-map, cheap-inline-module-source-map, eval



        // watch: env.NODE_ENV === 'development', // watch: true,
        // watchOptions: {
        //     aggregateTimeout: 100
        // }

        // module: {
        //     rules: [
        //         {   //* Babel *// npm install babel-loader babel-cli babel-core babel-preset-env babel-preset-es2015 -DE
        //             test: /\.js$/,
        //             // include: path.join(__dirname, 'src'),
        //             exclude: /(node_modules|bower_components)/,
        //             use: {
        //                 loader: 'babel-loader',
        //                 options: {
        //                     presets: ['env'] // es2015
        //                 }
        //             }
        //         }
        //
        //         // {   // * CSS * // npm install style-loader css-loader -DE
        //         //     test: /\.css$/,
        //         //     use: ExtractTextPlugin.extract({
        //         //         fallback: "style-loader",
        //         //         use: "css-loader"
        //         //     })
        //         // }
        //     ]
        // },

        // plugins: [
        //     new ExtractTextPlugin("bundle.css"),
        // ]


};