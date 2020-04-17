<?php

// https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Granola\\';

    $len = strlen($prefix);

    // does the class use the namespace prefix?
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // base directory for the namespace prefix
    $baseDir = rtrim(__DIR__, 'core/') . '/';

    // get the relative class name
    $relativeClass = strtolower(substr($class, $len));

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
