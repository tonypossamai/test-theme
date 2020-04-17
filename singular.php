<?php

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();

        echo \Granola\render(
            'assets/components/main',
            \Granola\render(
                'assets/components/article',
                \Granola\render('assets/components/wysiwyg', [
                    'heading' => get_the_title(),
                    'content' => apply_filters('the_content', get_the_content())
                ])
            )
        );
    }

    // echo \Granola\render('template-parts/wordpress/paged-post');
    // echo \Granola\render('template-parts/wordpress/post-pagination');
} else {
    echo \Granola\render(
        'assets/components/main',
        \Granola\render('template-parts/content-none')
    );
}

get_footer();
