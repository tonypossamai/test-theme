'use strict';

import config from '../_development/config/config';
import gulp from 'gulp';
import plumber from 'gulp-plumber';
import browsersync from 'browser-sync';
import sass from 'gulp-sass';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import cssnano from 'cssnano';
import stylelint from 'gulp-stylelint';
import sourcemaps from 'gulp-sourcemaps';
import atImport from 'postcss-import';
import rename from 'gulp-rename';
import gulpif from 'gulp-if';

function taskStyles(src, dest, production = true) {
    const timestamp = Math.floor(Date.now() / 1000);

    return gulp.src(src)
        .pipe(gulpif(production !== true, plumber({
            errorHandler: function (err) {
                console.log(err.message);
                this.emit('end');
            }
        }), sourcemaps.init()))
        .pipe(sass({
            includePaths: config.paths.includePaths,
        }))
        .pipe(postcss([
            atImport(),
            autoprefixer(),
            cssnano()
        ]))
        .pipe(gulpif(production === true, rename({
            suffix: '.' + timestamp
        })))
        .pipe(gulpif(production !== true, sourcemaps.write('./')))
        .pipe(gulp.dest(dest))
        .pipe(browsersync.stream());
}

function taskStylesLint(src) {
    return gulp.src(src)
        .pipe(plumber())
        .pipe(stylelint(config.plugins.stylelint));
}

function taskStylesFix(src, dest) {
    config.plugins.stylelint.fix = true;

    return gulp.src(src)
        .pipe(plumber())
        .pipe(stylelint(config.plugins.stylelint))
        .pipe(gulp.dest(dest));
}

export {
    taskStyles,
    taskStylesLint,
    taskStylesFix
}
