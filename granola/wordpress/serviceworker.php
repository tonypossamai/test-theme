<?php

namespace Granola\WordPress;

class ServiceWorker
{
    public static function init(): void
    {
        add_action('admin_init', [__CLASS__, 'register']);
    }

    public static function register(): void
    {
        $source = \Granola\assetPath('general/serviceworker.js');
        $dest = get_home_path() . 'serviceworker.js';

        copy($source, $dest);
    }
}
