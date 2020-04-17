<?php

add_filter('granola/render/assets/components/cards', function (array $args): array {

    // -------------------------------------------------------------------------
    // Loop each of the cards
    // -------------------------------------------------------------------------
    $args['cards'] = array_map(function ($card) {

        if (is_array($card)) {
            // -----------------------------------------------------------------
            // Handle filtering content from Gutenberg block
            // -----------------------------------------------------------------

            $card['media'] = wp_get_attachment_image($card['image']['id'], 'large');
            $card['meta'] = 'Hello | this is dog';
            $card['link'] = 'https://google.com';

            unset($card['image']);
        } elseif ($card instanceof WP_Post) {
            // -----------------------------------------------------------------
            // Handle filtering content from WordPress posts
            // -----------------------------------------------------------------

            $card = [
                'link' => get_the_permalink($card->ID),
                'heading' => get_the_title($card->ID),
                'content' => apply_filters('the_excerpt', get_the_excerpt($card->ID)),
                'media' => get_the_post_thumbnail(get_the_id($card->ID), 'medium'),
                // 'meta' => 'hello'
            ];
            ;
        }

        return $card;
    }, $args['cards']);

    // -------------------------------------------------------------------------
    // Return the content to the render functions
    // -------------------------------------------------------------------------
    return $args;
});
