'use strict';

import config from '../_development/config/config';
import { writeFile } from 'fs';
import glob from 'glob';

const newline = '\r\n'; // New line code

export default function componentsScripts(cb) {
    const src = config.paths.base.src + config.paths.components.src + config.paths.components.entry + '**/scripts.js';
    const files = glob.sync(src);
    var content = '';

    if (files.length > 0) {
        const imports = files.map(function (file) {
            return "import '" + file.replace('./_development/components/', './') + "';" + newline;
        });

        content = imports.reduce(function (carry, line) {
            return carry + line;
        });
    }

    writeFile(
        config.paths.base.src + config.paths.components.src + '_components.js', // File to write to
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
