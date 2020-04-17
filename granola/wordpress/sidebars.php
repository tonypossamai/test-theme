<?php

namespace Granola\WordPress;

class Sidebars
{
    public static function init(): void
    {
        add_action('widgets_init', [__CLASS__, 'register']);
    }

    public static function register(): void
    {
        global $GRANOLA_SIDEBARS;

        if (is_array($GRANOLA_SIDEBARS)) {
            foreach ($GRANOLA_SIDEBARS as $key => $sidebar) {
                register_sidebar($sidebar);
            }
        }
    }
}
