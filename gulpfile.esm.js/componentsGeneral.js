'use strict';

import config from '../_development/config/config';
import gulp from 'gulp';
import plumber from 'gulp-plumber';
import browsersync from 'browser-sync';

export default function componentsGeneral() {
    return gulp.src([config.paths.base.src + config.paths.components.src + config.paths.components.entry + "**/*", "!**/*.scss", "!**/*.js"])
        .pipe(plumber())
        .pipe(gulp.dest(config.paths.base.dest + config.paths.components.dest))
        .pipe(browsersync.stream());
}
