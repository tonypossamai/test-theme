<?php

get_header();

echo \Granola\render(
    'assets/components/main',
    \Granola\render('template-parts/content-none')
);

get_footer();
