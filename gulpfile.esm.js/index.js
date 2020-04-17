'use strict';

import gulp from 'gulp';
import env from 'gulp-env';
import browsersync from './browserSync';
import buildTask from './build';
import buildDevTask from './build-dev';
import watchTask from './watch';
import clean from "./clean";
import report from "./report";
import fonts from "./fonts";
import images from "./images";
import fix from "./fix";
import { php, phpFix } from "./php";
import svg from "./svg";
import { styles, stylesDev, stylesLint, stylesFix } from "./styles";
import { scripts, scriptsDev } from "./scripts";
import pot from "./pot";
import wordpressStylesheet from "./wordpressStylesheet";
import { componentsStyles, componentsStylesFix } from './componentsStyles';
import componentsScripts from './componentsScripts';


const watch = gulp.series(buildDevTask, gulp.parallel(browsersync, watchTask));
const build = buildTask;

const taskName = process.argv[2];

if (taskName === 'watch') {
    // Load environment variables
    env(".env.js");
}

export {
    build,
    watch,
    clean,
    report,
    fonts,
    images,
    svg,
    styles,
    stylesDev,
    stylesLint,
    stylesFix,
    scripts,
    scriptsDev,
    pot,
    php,
    phpFix,
    wordpressStylesheet,
    componentsStyles,
    componentsStylesFix,
    componentsScripts,
    fix
}

export default build;
