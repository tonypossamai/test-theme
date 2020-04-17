'use strict';

// ----------------------------------------
// Configuration
// ----------------------------------------
import config from '../_development/config/config';
import { taskScripts } from './task-scripts';

// ----------------------------------------
// Task
// ----------------------------------------
function scripts() {
    const src = config.paths.base.src + config.paths.scripts.src + config.paths.scripts.entry;
    const dest = config.paths.base.dest + config.paths.scripts.dest;

    return taskScripts(src, dest);
}

function scriptsDev() {
    const src = config.paths.base.src + config.paths.scripts.src + config.paths.scripts.entry;
    const dest = config.paths.base.dest + config.paths.scripts.dest;

    return taskScripts(src, dest, false);
}

export {
    scripts,
    scriptsDev
}
