<?php

namespace Granola\WordPress;

class Menus
{
    public static function init(): void
    {
        add_action('after_setup_theme', [__CLASS__, 'menus']);
    }

    public static function menus(): void
    {
        global $GRANOLA_MENUS;

        if (is_array($GRANOLA_MENUS)) {
            register_nav_menus($GRANOLA_MENUS);
        }
    }
}
