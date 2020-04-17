'use strict';

// Config
import config from '../_development/config/config';

// Core
import gulp from 'gulp';
import browsersync from 'browser-sync';

// General
import general from './general';
import assetManifest from './assetManifest';
import wordpressStylesheet from './wordpressStylesheet';
import pot from './pot';

// Assets
import fonts from './fonts';
import images from './images';
import svg from './svg';
import { stylesDev, stylesLint } from './styles';
import { scriptsDev } from './scripts';

// Components
import componentsGeneral from './componentsGeneral';
import { componentsStyles, componentsStylesLint } from './componentsStyles';
import componentsScripts from './componentsScripts';

// Admin
import report from './report';

export default function watch(cb) {
    // Styles
    gulp.watch(
        config.paths.base.src + config.paths.styles.src + '**/*',
        gulp.parallel(
            gulp.series(
                stylesDev,
                assetManifest
            ),
            stylesLint,
            componentsStylesLint
        )
    );

    // Scripts
    gulp.watch(
        config.paths.base.src + config.paths.scripts.src + '**/*',
        gulp.series(
            scriptsDev,
            assetManifest
        )
    );

    // General
    gulp.watch(
        config.paths.general.src + '**/*',
        { cwd: config.paths.base.src },
        general
    );

    // Images
    gulp.watch(
        config.paths.base.src + config.paths.images.src + '**/*',
        gulp.series(
            images,
            assetManifest
        )
    );

    // Fonts
    gulp.watch(
        config.paths.base.src + config.paths.fonts.src + '**/*',
        gulp.series(
            fonts,
            assetManifest
        )
    );

    // SVGs
    gulp.watch(
        config.paths.base.src + config.paths.images.src + '**/*.svg',
        gulp.series(
            svg,
            assetManifest
        )
    );

    // PHP Files
    gulp.watch(
        config.paths.php,
        gulp.parallel(wordpressStylesheet, function () {
            browsersync.reload();
        })
    );

    // Components PHP
    gulp.watch(
        [
            config.paths.base.src + config.paths.components.src + '**/*',
            '!**/*.scss',
            '!**/*.js'
        ],
        gulp.series(
            componentsGeneral,
            assetManifest
        )
    );

    // Components Styles
    gulp.watch(
        [
            config.paths.base.src + config.paths.components.src + '**/*.scss',
            '!' + config.paths.base.src + config.paths.components.src + '*.scss'
        ],
        gulp.parallel(
            gulp.series(
                componentsStyles,
                stylesDev,
                assetManifest
            ),
            stylesLint,
            componentsStylesLint
        )
    );

    // Components Scripts
    gulp.watch(
        [
            config.paths.base.src + config.paths.components.src + '**/*.js',
            '!' + config.paths.base.src + config.paths.components.src + '*.js'
        ],
        gulp.series(
            componentsScripts,
            scriptsDev,
            assetManifest
        )
    );
}
