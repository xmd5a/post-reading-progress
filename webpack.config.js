const path = require('path');
const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const extractPlugin = new ExtractTextPlugin({
    filename: './[name]/css/bundle.css'
});

module.exports = {
    context: path.resolve(__dirname, 'src'),
    entry: {
        public: './public/app.js',
        admin: './admin/app.js'
    },
    output: {
        path: path.resolve(__dirname),
        filename: './[name]/js/bundle.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                include: /src/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['env']
                    }
                }
            }
            ,
            {
                test: /\.scss$/,
                include: [path.resolve(__dirname, 'src', 'public', 'scss'), path.resolve(__dirname, 'src', 'admin', 'scss')],
                use: extractPlugin.extract({
                    use: [
                        {
                            loader: 'css-loader',
                            options: {
                                sourceMap: true
                            }
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                            }
                        }
                    ]
                })
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin(['public', 'admin']),
        extractPlugin
    ],
    devServer: {
        stats: 'errors-only',
        open: true,
        port: 3000,
        compress: true
    }
}