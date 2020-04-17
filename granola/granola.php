<?php
// ----------------------------------------------------
// ----------------------------------------------------
// Welcome to the Granola
// ----------------------------------------------------
// ----------------------------------------------------
// The objective is to streamline WordPress theme
// development by including helpers for required tasks
// as well as customising WordPress to be greener.
// Granola isn't like every other starter theme, its
// opinionated whilst being minimal
// ----------------------------------------------------

// ----------------------------------------------------
// Core
// ----------------------------------------------------
require_once 'core/autoload.php';
require_once 'core/paths.php';
require_once 'core/render.php';
require_once 'core/image.php';
require_once 'core/svg.php';

// ----------------------------------------------------
// Load the config file
// ----------------------------------------------------
require_once 'config.php';

// ----------------------------------------------------
// Start it up
// ----------------------------------------------------
\Granola\WordPress\Admin::init();
\Granola\WordPress\Assets::init();
\Granola\WordPress\Cleanup::init();
new \Granola\WordPress\Components;
\Granola\WordPress\Gutenberg::init();
// \Granola\WordPress\Iframes::init();
\Granola\WordPress\Images::init();
\Granola\WordPress\LazyLoad::init();
\Granola\WordPress\Menus::init();
\Granola\WordPress\ServiceWorker::init();
\Granola\WordPress\Settings::init();
\Granola\WordPress\Sidebars::init();
\Granola\WordPress\ServiceWorker::init();
\Granola\WordPress\UploadMimes::init();
\Granola\Plugin\ACF::init();
\Granola\Plugin\GravityForms::init();
\Granola\Plugin\YoastSEO::init();
