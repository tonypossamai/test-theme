'use strict';

import config from '../_development/config/config';
import { src, dest } from 'gulp';
import phpcs from 'gulp-phpcs';
import phpcbf from 'gulp-phpcbf';

function php() {
    return src(config.paths.php)
    	// Compares all PHP files with PSR-2
    	.pipe(phpcs({
            bin: 'vendor/bin/phpcs',
            standard: 'PSR2',
            severity: 5,
            warningSeverity: 1
        }))
        // Log all problems that was found
        .pipe(phpcs.reporter('log'))
}

function phpFix() {
    return src(config.paths.php)
        // Updates all code to follow PSR-2
        .pipe(phpcbf({
            bin: 'vendor/bin/phpcbf',
            standard: 'PSR2',
            warningSeverity: 0
        }))
        // Outputs all files
        .pipe(dest('./'))
}

export {
    php,
    phpFix
}

export default php;
