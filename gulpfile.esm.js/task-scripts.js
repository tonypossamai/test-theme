'use strict';

// ----------------------------------------
// Configuration
// ----------------------------------------
import webpackConfig from '../webpack.config.js';

// ----------------------------------------
// Modules
// ----------------------------------------
import gulp from 'gulp';
import plumber from 'gulp-plumber';
import browserSync from 'browser-sync';
import webpack from 'webpack';
import webpackStream from 'webpack-stream';
import named from 'vinyl-named-with-path';
import gulpif from 'gulp-if';

// -----------------------------------------------------------------------------
// Script Closure
// -----------------------------------------------------------------------------
function taskScripts(src, dest, production = true) {
    return gulp.src(src)
        .pipe(gulpif(production !== true, plumber({
            errorHandler: function (err) {
                console.log(err.message);
                this.emit('end');
            }
        })))
        .pipe(named())
        .pipe(webpackStream({
            config: [
                webpackConfig({
                    production: production,
                    target: 'legacy'
                }),
                webpackConfig({
                    production: production,
                    target: 'modern'
                })
            ]
        }, webpack))
        .pipe(gulp.dest(dest))
        .pipe(browserSync.stream());
}

export {
    taskScripts
}
