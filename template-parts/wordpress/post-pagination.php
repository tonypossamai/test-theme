<?php

$post_type = get_post_type();

the_post_navigation([
    'prev_text' => __('Previous ' . $post_type, 'granola'),
    'next_text' => __('Next ' . $post_type, 'granola'),
]);
