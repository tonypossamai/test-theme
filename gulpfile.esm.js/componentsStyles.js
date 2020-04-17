'use strict';

import config from '../_development/config/config';
import { taskStyles, taskStylesLint, taskStylesFix } from './task-styles';
import { writeFile } from 'fs';
import glob from 'glob';

const newline = '\r\n'; // New line code

function componentsStyles(cb) {
    const src = config.paths.base.src + config.paths.components.src + '[^_]**/styles.scss';
    const files = glob.sync(src);
    var content = '';

    if (files.length > 0) {
        const imports = files.map(function (file) {
            return "@import '" + file.replace('./_development/components/', './') + "';" + newline;
        });

        content = imports.reduce(function (carry, line) {
            return carry + line;
        });
    }

    writeFile(
        config.paths.base.src + config.paths.components.src + '_components.scss', // File to write to
        content, // Contents of file
        {}, // Options for the file
        function (err) { // Callback
            if (err) {
                throw err;
            }
        }
    );

    cb();
}

function componentsStylesLint() {
    const src = config.paths.base.src + config.paths.components.src + '**/*.scss';

    return taskStylesLint(src);
}

function componentsStylesFix() {
    const src = config.paths.base.src + config.paths.components.src + '**/*.scss';
    const dest = config.paths.base.src + config.paths.components.src

    return taskStylesFix(src, dest);
}

export {
    componentsStyles,
    componentsStylesLint,
    componentsStylesFix
}
