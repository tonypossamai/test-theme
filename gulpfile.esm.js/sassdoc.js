'use strict';

import config from '../_development/config/config';

import { src } from 'gulp';
import sassdoc from 'sassdoc';

export default function sassDoc() {
    return src(config.paths.base.src + config.paths.styles.src + '**/*.scss')
        .pipe(sassdoc());
};
