<?php
/**
 * Template Name: Flexible Content
*/
get_header();

if (have_posts()) {
    ob_start();

    while (have_posts()) {
        the_post();
        the_content();
    }

    $content = ob_get_clean();

    echo \Granola\render(
        'assets/components/main',
        \Granola\render('assets/components/article', $content)
    );
}

get_footer();
