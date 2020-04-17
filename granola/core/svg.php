<?php

namespace Granola;

/**
 * Return and possibly output the content of an SVG file in the assets directory
 * @param string $name
 * @param array $args
 * @return string
 */
function svg(string $name, array $args = []): string
{
    $svg = '';

    // Merge attributes
    $args = wp_parse_args($args, [
        'name'          => $name,
        'wrapped'       => false,
        'title'         => '',
        'description'   => '',
        'keepcolors'    => false,
    ]);

    // get the path to the SVG
    $svg_path = \Granola\svgPath($args['name']);

    if (file_exists($svg_path)) {
        $unique_id = uniqid();

        // How to edit an SVG in PHP
        // https://stackoverflow.com/questions/41264017/php-svg-editing
        // https://stackoverflow.com/questions/18758101/domdocument-add-attribute-to-root-tag

        // Create a new instance of DOMDocument
        $doc = new \DOMDocument;

        // Load in the SVG
        $doc->loadXML(file_get_contents($svg_path));

        // set a role attribute on the SVG element
        $doc->documentElement->setAttribute('role', 'img');

        if ($args['keepcolors']) {
            $doc->documentElement->setAttribute('class', 'svg--keepcolors');
        }

        // Is there a title
        if ($args['title'] !== "") {
            $labelled = [];
            $labelled[] = 'title-' . $unique_id;

            // Add a title
            $title = $doc->createElement('title', $args['title']);
            $title->setAttribute('id', 'title-' . $unique_id);

            // Append it to the SVG
            $doc->firstChild->appendChild($title);

            // Is there a description
            if ($args['description'] !== "") {
                $labelled[] = 'description-' . $unique_id;

                // Add a description
                $description = $doc->createElement('description', $args['description']);
                $description->setAttribute('id', 'description-' . $unique_id);

                // Append it to the SVG
                $doc->firstChild->appendChild($description);
            }

            // Add the attributes to the SVG
            $doc->documentElement->setAttribute('aria-labelledby', implode(' ', $labelled));
        } else {
            $doc->documentElement->setAttribute('aria-hidden', 'true');
        }

        // output the svg markup and strip the xml doctype declaration
        // https://stackoverflow.com/questions/5706086/php-domdocument-output-without-xml-version-1-0-encoding-utf-8/17362447
        $svg = $doc->saveXML($doc->documentElement);

        if ($args['wrapped'] === true) {
            $svg = '<span class="svg-asset svg-asset--' . esc_attr($args['name']) . '">' . $svg . '</span>';
        }
    }

    return $svg;
}

/**
 * Build the path to the SVG asset in the theme
 * @param string $name
 * @return string
 */
function svgPath(string $name): string
{
    return \Granola\assetPath('svgs/' . $name . '.svg');
}
