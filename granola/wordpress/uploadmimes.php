<?php

namespace Granola\WordPress;

class UploadMimes
{
    public static function init(): void
    {
        add_filter('upload_mimes', [__CLASS__, 'extend']);
    }

    public static function extend(array $mime_types = []): array
    {
        global $GRANOLA_MIME_TYPES;

        if (is_array($GRANOLA_MIME_TYPES)) {
            foreach ($GRANOLA_MIME_TYPES as $key => $value) {
                $mime_types[$key] = $value;
            }
        }

        return $mime_types;
    }
}
