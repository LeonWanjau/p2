const autoprefixer = require('autoprefixer');
const path = require('path');
var webpack = require("webpack");

module.exports = [{
  entry: {
    //login_page: ['./resources/js/project/authentication/login_page.js']
    //create_account_page:['./resources/js/project/authentication/create_account_page.js']
    //verify_email_page:['./resources/js/project/authentication/verify_email_page.js']
    //home_page:['./resources/js/project/general/home_page.js']
    //send_password_reset_link_page:['./resources/js/project/authentication/send_password_reset_link_page.js']
    //reset_password_page:['./resources/js/project/authentication/reset_password_page.js']
    //password_reset_status_page:['./resources/js/project/authentication/password_reset_status_page.js']
    //users_page:['./resources/js/project/users/users_page.js']
    //general_component:['./resources/js/project/components/blade_components/general.js']
    //view_users_page:['./resources/js/project/users/view_users_page.js']
    //fonts:['./resources/js/project/fonts/fonts.js']
    scheduler:['./resources/js/project/components/scheduler/scheduler.js']
    
  },
  output: {
    // This is necessary for webpack to compile
    // But we never use style-bundle.js
    filename: '[name].js',
    //path: path.resolve(__dirname, 'dist'),
    /*Authentication*/
    //path: path.resolve(__dirname, 'public/js/project/authentication')
    /*General component*/
    //path: path.resolve(__dirname, 'public/js/project/general')
    /*Users pages*/
    //path: path.resolve(__dirname, 'public/js/project/users')
    /*Fonts*/
    //path: path.resolve(__dirname, 'public/js/project/fonts')
    /*Scheduler*/
    path: path.resolve(__dirname, 'public/js/project/scheduler')
  },
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          /*
          {
            loader: 'file-loader',
            options: {
              outputPath: '../public/css',
              name: '[name].css',
            },
          },
          */
          { loader: 'style-loader' },
          /* { loader: 'extract-loader' },*/
          { loader: 'css-loader' },
          {
            loader: 'postcss-loader',
            options: {
              plugins: () => [autoprefixer()]
            }
          },
          {
            loader: 'sass-loader',
            options: {
              includePaths: ['./node_modules']
            }
          },
        ]
      },

      {
        test: /\.js$/,
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env'],
            }
          },

        ]
      },

      {
        test: /\.(svg|eot|woff|ttf|svg|woff2)$/,
        use: [
            {
                loader: 'file-loader',
                options: {
                    outputPath:"../../../fonts/webfonts",
                    name: "[name].[ext]",
                    publicPath:"/is_p2/public/fonts/webfonts"
                }
            }
        ]
    },

    {
      test: /\.(gif|png)$/,
      use: [
          {
              loader: 'file-loader',
              options: {
                  outputPath:"../../../images",
                  name: "[name].[ext]",
                  publicPath:"/is_p2/public/images"
              }
          }
      ]
  },
    ]
  },

  plugins:[
    new webpack.ProvidePlugin({
      'utils': 'utils'
    })
  ],

  mode: 'development',
}];