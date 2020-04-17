<?php

// This file will be autoloaded by granola in /granola/plugins/acf.
// You dont need to worry about the timing with hooks as this is run on
// acf/init. The documentation for creating a block with acf can be found at the
// following link:
//
// https://www.advancedcustomfields.com/resources/acf_register_block_type/
//
// For this file to load, it must be prefixed with block-. This is because the
// glob looks for acf-blocks/block-*.php.
//
// It is important that this file remain free from html and is merely a
// mechanism for
// - Registering a block
// - Retrieving and processing fields in to the required format
// - calling \Granola\render with a partial that will output the markup

acf_register_block_type([
    // Name in code, alphabetical only
    'name' => 'cards',

    // Name for Interface
    'title' =>  'Cards',

    // Short description
    'description' => 'cards block',

    // common | formatting | layout | widgets | embed
    'category' => 'layout',

    // https://developer.wordpress.org/resource/dashicons/
    // 'icon' => 'dashicons-layout',

    // An array of post types that this block will be available for
    // 'post_types' => ['post', 'page'],

    // When the block is clicked on, the block is replaced with the fields
    'mode' => 'auto',

    // The default block alignment.
    // 'left', 'center', 'right', 'wide', 'full'
    'align' => '',

    // What options do we want this block to support.
    'supports' => [
        // Align can be an array of options, or a boolean
        // 'align' => ['left', 'right', 'full'],
        'align' => ['wide', 'full'],
    ],

    // Handle rendering the block
    'render_callback' => function ($block) {

        $args = \Granola\WordPress\Gutenberg::classes(get_fields(), $block);

        echo \Granola\render('assets/components/cards', $args);
    }
]);
