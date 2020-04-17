<?php

$siteManifest = \Granola\assetContent('general/site.webmanifest', 'json');

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <link rel="manifest" href="<?php echo \Granola\assetURL('general/site.webmanifest'); ?>">
    <meta name="theme-color" content="<?php echo esc_attr($siteManifest['theme_color']); ?>"/>

    <?php wp_head(); ?>
</head>

<header>
    <h1>THIS IS THE HEADER</h1>
</header>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <?php echo \Granola\render('assets/components/skip-link'); ?>
    <?php echo \Granola\render('assets/components/headerhorizontal'); ?>
