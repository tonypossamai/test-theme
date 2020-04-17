'use strict';

// ----------------------------------------
// Configuration
// ----------------------------------------
import config from '../_development/config/config';

// ----------------------------------------
// Modules
// ----------------------------------------
import { src, dest } from 'gulp';
import plumber from 'gulp-plumber';
import imagemin from 'gulp-imagemin';

// ----------------------------------------
// Task
// ----------------------------------------
export default function images() {
    let destination = config.paths.base.dest + config.paths.images.dest;

    return src(config.paths.base.src + config.paths.images.src + '**/*')
        .pipe(plumber())
        .pipe(imagemin([
            imagemin.gifsicle(config.plugins.imagemin.gif),
            imagemin.mozjpeg(config.plugins.imagemin.jpg),
            imagemin.optipng(config.plugins.imagemin.png),
            imagemin.svgo(config.plugins.imagemin.svg)
        ], {
            verbose: false,
            silent: true
        }))
        .pipe(dest(destination));
};
