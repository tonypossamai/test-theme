<?php

namespace Granola\WordPress;

class Admin
{
    public static function init(): void
    {
        add_filter('get_user_option_admin_color', [__CLASS__, 'adminColor']);
    }

    public static function adminColor()
    {
        $env = \Granola\resolve('.env.js');

        if (file_exists($env)) {
            return 'light';
        }
    }
}
