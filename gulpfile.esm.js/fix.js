'use strict';

import gulp from 'gulp';
import { stylesFix } from "./styles";
import { componentsStylesFix } from './componentsStyles';
import { phpFix } from "./php";

export default function fix(cb) {
    stylesFix();
    componentsStylesFix();
    phpFix();

    cb();
}
