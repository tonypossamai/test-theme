// -----------------------------------------------------------------------------
// Options currently supports two properties, production and target.
//
// Production is a boolean and if true will configure webpack for a production
// build (minify, strip, etc) and will also add a hash to the filename.
//
// Target is a string and will determine what level of polyfills are added. By
// default, a modern build will include polyfills for features used in the code
// for browsers that support modules modules.
//
// To see what explicit polyfills are added to each build, add debug to the
// options for babel.
// -----------------------------------------------------------------------------
export default (options, argv) => {

    // ---------------------------------------------------------------------
    // Lets build the filename of the scripts we are creating
    // ---------------------------------------------------------------------
    let filename = '[name]';

    if(options.production === true){
        filename = filename + '.[chunkhash]';
    }

    // If we are running a modern build, lets change the file extension to mjs
    filename = filename + (options.target === 'modern' ? '.mjs' : '.js');

    // ---------------------------------------------------------------------
    // Begin the config
    // ---------------------------------------------------------------------
    let config = {
        mode: (options.production === true ? 'production' : 'development'),
        output: {
            filename: filename
        },
        module: {
            rules: [
                {
                    enforce: 'pre',
                    test: /\.js$/,
                    exclude: /node_modules/,
                    loader: 'eslint-loader',
                },
            ]
        },
        externals: {
            jquery: 'jQuery',
            $: 'jQuery',
            jQuery: 'jQuery'
        },
        // ---------------------------------------------------------------------
        // Don't output webpack statistics
        // ---------------------------------------------------------------------
        stats: 'errors-only'
    };

    if(options.target === 'legacy') {
        // ---------------------------------------------------------------------
        // Build for legacy browsers
        // ---------------------------------------------------------------------
        config.module.rules.push({
            test: /\.js$/,
            exclude: /node_modules/,
            loader: "babel-loader",
            options: {
                presets: [
                    ["@babel/preset-env", {
                        useBuiltIns: "usage",
                        corejs: 3,
                        targets: {
                            esmodules: false
                        }
                    }]
                ]
            }
        });
    }else {
        // ---------------------------------------------------------------------
        // Build for modern browsers
        // ---------------------------------------------------------------------
        config.module.rules.push({
            test: /\.js$/,
            exclude: /node_modules/,
            loader: "babel-loader",
            options: {
                presets: [
                    ["@babel/preset-env", {
                        useBuiltIns: "usage",
                        corejs: 3,
                        targets: {
                            esmodules: true
                        }
                    }]
                ]
            }
        });
    }

    // ---------------------------------------------------------------------
    // Ship it
    // ---------------------------------------------------------------------
    return config;
};
