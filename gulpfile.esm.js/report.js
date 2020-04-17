'use strict';

import config from '../_development/config/config';
import { src } from 'gulp';
import sizereport from 'gulp-sizereport';

export default function report() {
    return src([config.paths.base.dest + "**/*", "!" + config.paths.base.dest + "timestamp.txt"])
        .pipe(sizereport({
            gzip: true
        }));
};
