'use strict';

import config from '../_development/config/config';
import { existsSync, mkdirSync } from 'fs';

export default function create(cb) {
    // Check if the directory does not exist
    if (!existsSync(config.paths.base.dest)) {
        mkdirSync(config.paths.base.dest);
    }

    cb();
};
