'use strict';

import gulp from 'gulp';
import clean from './clean';
import create from './create';
import report from './report';
import fonts from './fonts';
import images from './images';
import general from './general';
import svg from './svg';
import { styles } from './styles';
import { scripts } from './scripts';
import pot from './pot';
import assetManifest from './assetManifest';
import wordpressStylesheet from './wordpressStylesheet';

// ACF Blocks
import componentsGeneral from './componentsGeneral';
import { componentsStyles } from './componentsStyles';
import componentsScripts from './componentsScripts';

export default gulp.series(
    clean,
    create,
    gulp.parallel(
        componentsGeneral,
        componentsStyles,
        componentsScripts
    ),
    gulp.parallel(
        fonts,
        general,
        images,
        svg,
        pot,
        wordpressStylesheet,
        styles,
        scripts,
    ),
    gulp.parallel(
        assetManifest,
        report
    )
);
