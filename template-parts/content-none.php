<?php

ob_start();

if (is_search()) {
    // This is search so lets output an appropriate message
    ?><p><?php esc_html_e(
        'Sorry, but nothing matched your search terms. Please try again with some different keywords.',
        'granola'
    ); ?></p><?php
} else {
    // This is a bad page so lets output an appropriate message

    ?><p><?php esc_html_e(
        'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.',
        'granola'
    ); ?></p><?php
}

get_search_form();

$content = ob_get_clean();

echo \Granola\render('assets/components/wysiwyg', [
    'heading' => __('Nothing found', 'granola'),
    'content' => $content
]);
