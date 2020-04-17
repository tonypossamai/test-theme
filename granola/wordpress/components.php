<?php

namespace Granola\WordPress;

class Components
{

    var $blockPath = '';

    public function __construct()
    {
        self::init();

        add_action('acf/update_field_group', [$this, 'updateFieldGroup'], 1);
    }

    public static function init(): void
    {
        add_action('init', [__CLASS__, 'loadBlockFunctions']);
        add_action('acf/init', [__CLASS__, 'addBlocks']);
        add_filter('acf/settings/load_json', [__CLASS__, 'blockFieldGroups']);
    }

    function updateFieldGroup($group): void
    {
        // Check if the field group is assigned to a block, and if the block is
        // in the _src/components folder
        if (!empty($group['location'][0][0]['param']) && $group['location'][0][0]['param'] === 'block') {
            // Pull the actual block name
            $block = str_replace('acf/', '', $group['location'][0][0]['value']);

            // Build a path to the block source code
            $blockPath = \Granola\themePath('_development/components/' . $block);

            // Check the path exists
            if (is_dir($blockPath)) {
                // Set the block we are currently saving
                $this->blockPath = $blockPath;

                // Hook in to the save json method
                add_action('acf/settings/save_json', [$this, 'updateGroupSavePath'], 9999);
            }
        }
    }

    function updateGroupSavePath(): string
    {
        // change the path the block is stored at
        return $this->blockPath;
    }

    public static function blockFieldGroups(array $paths): array
    {
        return array_merge(
            $paths,
            glob(get_stylesheet_directory() . '/assets/components/*')
        );
    }

    public static function addBlocks(): void
    {
        self::require(
            glob(\Granola\themePath('assets/components/*/acf.php'))
        );
    }

    public static function loadBlockFunctions(): void
    {
        self::require(
            glob(\Granola\themePath('assets/components/*/functions.php'))
        );
    }

    private static function require(array $files): void
    {
        foreach ($files as $key => $file) {
            require_once $file;
        }
    }
}
