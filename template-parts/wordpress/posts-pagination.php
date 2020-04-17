<?php

the_posts_pagination([
    'prev_text' => __('Previous page', 'granola'),
    'next_text' => __('Next page', 'granola'),
    'before_page_number' => '<span class="screen-reader-text">' . __('Page', 'granola') . ' </span>',
]);
