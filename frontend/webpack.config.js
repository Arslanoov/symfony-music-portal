const HtmlWebpackPlugin = require('html-webpack-plugin');
const path = require('path');

module.exports = {
    mode: "development",

    entry: path.resolve(__dirname, 'src', 'index.js'),

    plugins: [
        new HtmlWebpackPlugin({
            title: 'Music Portal',
            template: 'public/index.html'
        })
    ],
};
