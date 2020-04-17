<?php

namespace Granola\WordPress;

class Gutenberg
{
    public static function init(): void
    {
        add_action('after_setup_theme', [__CLASS__, 'gutenbergSupport']);
    }

    public static function classes($args, array $block): array
    {
        if (!is_array($args)) {
            return [];
        }

        if (!empty($block['align'])) {
            $args['class'] = 'align' . $block['align'];
        }

        return $args;
    }

    public static function gutenbergSupport(): void
    {
        // Some blocks such as the image or video block have the possibility to define a “wide” or “full” alignment
        // 'align-wide' support adds the corresponding classname to the block’s wrapper ( .alignwide or .alignfull )
        add_theme_support('align-wide');

        // By default, the color palette offered to blocks,
        // allows the user to select a custom color from a color picker field.
        // Let's disable it by default.
        add_theme_support('disable-custom-colors');
        add_theme_support('editor-color-palette');
        add_theme_support('disable-custom-font-sizes');
    }
}
