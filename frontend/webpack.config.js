const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');

module.exports = {
    mode: "development",

    entry: path.resolve(__dirname, 'src', 'index.jsx'),

    resolve: {
        extensions: [".js", ".jsx", ".css", ".scss", ".sass"],
    },

    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                loader: 'babel-loader'
            },

            {
                test: /\.(png|jpg|jpeg|gif|ico)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            outputPath: 'images',
                            name: '[name]-[sha1:hash:7].[ext]'
                        }
                    }
                ]
            },

            // Loading fonts
            {
                test: /\.(ttf|otf|eot|woff|woff2)$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            outputPath: 'fonts',
                            name: '[name].[ext]'
                        }
                    }
                ]
            },

            // Loading CSS
            {
                test: /\.(css)$/,
                use: [ MiniCssExtractPlugin.loader, 'css-loader']
            },

            // Loading SASS/SCSS
            {
                test: /\.(s[ca]ss)$/,
                use: [ MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader' ]
            }
        ]
    },

    plugins: [
        new HtmlWebpackPlugin({
            title: 'Music Portal',
            template: 'public/index.html'
        }),
        new MiniCssExtractPlugin({
            filename: 'main-[hash:8].css'
        })
    ],

    devServer: {
        open: true,
        historyApiFallback: true
    },

    watch: true
};
