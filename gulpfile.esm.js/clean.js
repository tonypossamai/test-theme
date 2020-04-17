'use strict';

import config from '../_development/config/config';
import del from 'del'

export default function clean() {
    return del([
        config.paths.base.dest
    ]);
}
