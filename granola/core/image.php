<?php

namespace Granola;

/**
 * Return and possibly output an image from the assets directory
 * @param string $name
 * @param array $args
 * @return string
 */
function image(string $name, array $args = []): string
{
    $image = '';

    $args = wp_parse_args($args, [
        'name'   => $name,
        'alt'    => '',
        'class'  => '',
    ]);

    if ($image_url = \Granola\imageURL($args['name'])) {
        $attributes = [
            'src' => esc_url($image_url),
            'alt' => esc_attr($args['alt'])
        ];

        if ($attributes['alt'] == "") {
            $attributes['role'] = 'presentation';
        }

        if ($args['class'] !== "") {
            $attributes['class'] = esc_attr($args['class']);
        }

        $attributes_string = '';

        foreach ($attributes as $key => $value) {
            $attributes_string .= $key . '="' . $value . '" ';
        }

        $image = '<img ' . trim($attributes_string) . '>';
    }

    return $image;
}


/**
 * Build the URL for the image
 * @param string $name
 * @return string
 */
function imageURL(string $name): string
{
    return \Granola\assetURL('images/' . $name);
}
