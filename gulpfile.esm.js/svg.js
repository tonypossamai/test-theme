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

export default function svg() {
    return src(config.paths.base.src + config.paths.svg.src + '**/*.svg')
        .pipe(plumber())
        .pipe(imagemin(
            [
                imagemin.svgo(config.plugins.imagemin.svgdeep)
            ], {
                verbose: false,
                silent: true
            })
        )
        .pipe(dest(config.paths.base.dest + config.paths.svg.dest));
};
