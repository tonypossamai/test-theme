<?php

$args = wp_parse_args($args, [
    'heading'   => '',
    'key'       => 0,
    'link'      => null,
    'atts'      => null,
    'el'        => null
]);

if ($args['heading'] !== "") {
    // Create a default value for the heading index
    $element = 'h1';

    // Start the output
    $output = esc_html($args['heading']);

    // Wrap the output in a link if one is provided
    if ($args['link'] !== null) {
        $output = '<a href="' . esc_url($args['link']) . '">' . $output . '</a>';
    }

    // Work out if we need to use a different heading
    if (!is_null($args['el'])) {
        $element = $args['el'];
    } elseif ($args['key'] > 0) {
        $element = 'h2';
    }

    // Protecting ourselves from anything nasty
    $element = esc_html($element);

    // Generate attributes if there are any
    if (is_array($args['atts'])) {
        // Create an array
        $atts = [];

        // Loop through each of the attributes
        foreach ($args['atts'] as $key => $value) {
            // Turn the index in to a string and store in the array
            $atts[] = esc_attr($key) . '="' . esc_attr($value) . '"';
        }

        // Implode the array to make our attributes
        $atts = implode(' ', $atts);

        // Create the heading markup
        $output = "<$element $atts>" . $output . "</$element>";
    } else {
        // Create the heading markup
        $output = "<$element>" . $output . "</$element>";
    }

    // Ship it
    echo $output;
}
