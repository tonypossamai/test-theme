'use strict';

import config from '../_development/config/config';
import { src, dest } from 'gulp';
import plumber from 'gulp-plumber';

export default function general() {
    let destination = config.paths.base.dest + config.paths.general.dest;

    return src(config.paths.base.src + config.paths.general.src + '*.*')
        .pipe(plumber())
        .pipe(dest(destination));
}
