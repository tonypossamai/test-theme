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
import wpPot from 'gulp-wp-pot';

// ----------------------------------------
// Task
// ----------------------------------------
export default function pot() {
    let destination = './' + config.wordpress['Text Domain'] + '.pot';

    return src(config.paths.php, {cwd: './'})
        .pipe(plumber())
        .pipe(wpPot({
            domain: config.wordpress['Text Domain'],
            package: config.wordpress['Text Domain']
        }))
        .pipe(dest(destination));
};

