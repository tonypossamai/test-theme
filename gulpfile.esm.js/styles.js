'use strict';

import config from '../_development/config/config';
import { taskStyles, taskStylesLint, taskStylesFix } from './task-styles';

function styles() {
    const src = config.paths.base.src + config.paths.styles.src + config.paths.styles.entry;
    const dest = config.paths.base.dest + config.paths.styles.dest;

    return taskStyles(src, dest);
}

function stylesDev() {
    const src = config.paths.base.src + config.paths.styles.src + config.paths.styles.entry;
    const dest = config.paths.base.dest + config.paths.styles.dest;

    return taskStyles(src, dest, false);
}

function stylesLint() {
    const src = config.paths.base.src + config.paths.styles.src + '/**/*.scss';

    return taskStylesLint(src);
}

function stylesFix() {
    const src = config.paths.base.src + config.paths.styles.src + '/**/*.scss';
    const dest = config.paths.base.src + config.paths.styles.src;

    return taskStylesFix(src, dest);
}

export {
    styles,
    stylesDev,
    stylesLint,
    stylesFix
}
