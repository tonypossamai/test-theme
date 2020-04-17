<?php

namespace Granola\Plugin;

class ACF
{
    public static function init(): void
    {
        add_action('acf/init', [__CLASS__, 'optionPages']);
        add_action('acf/init', [__CLASS__, 'googleAPIKey']);
        add_filter('the_content', [__CLASS__, 'renderFlex'], 1);
        add_filter('acf/load_field/name=background_color', [__CLASS__, 'loadColorFieldChoices']);

        // Handles disabling Gutenberg on flexible content template
        add_filter('gutenberg_can_edit_post_type', [__CLASS__, 'disable_gutenberg'], 10, 2);
        add_filter('use_block_editor_for_post_type', [__CLASS__, 'disable_gutenberg'], 10, 2);
    }

    public static function optionPages(): void
    {
        global $GRANOLA_ACF_OPTIONS_PAGES;

        // ----------------------------------------------------
        // If ACF Exists, lets create all the options pages
        // that have been configured
        // ----------------------------------------------------
        if (function_exists('acf_add_options_page') && isset($GRANOLA_ACF_OPTIONS_PAGES)) {
            if (is_array($GRANOLA_ACF_OPTIONS_PAGES) && !empty($GRANOLA_ACF_OPTIONS_PAGES)) {
                // ----------------------------------------------------
                // Add a default options page to nest everything under
                // ----------------------------------------------------
                acf_add_options_page();

                // ----------------------------------------------------
                // Loop through the pages configured and create them
                // ----------------------------------------------------
                foreach ($GRANOLA_ACF_OPTIONS_PAGES as $key => $page) {
                    acf_add_options_sub_page($page);
                }
            }
        }
    }

    // ----------------------------------------------------
    // Configure ACF with our Google API key
    // ----------------------------------------------------
    public static function googleAPIKey(): void
    {
        if (defined('GRANOLA_GOOGLE_API_KEY') && GRANOLA_GOOGLE_API_KEY != '') {
            acf_update_setting('google_api_key', GRANOLA_GOOGLE_API_KEY);
        }
    }

    public static function renderFlex(string $content): string
    {
        if (self::isFlexibleContentTemplate(get_the_id())) {
            if (!post_password_required()) {
                $content = \Granola\render(
                    'assets/components/flexiblecontent',
                    get_field('flexible_content')
                );
            } else {
                $content = \Granola\render('assets/components/wysiwyg', [
                    'content' => $content
                ]);
            }

            // Disable autop to address extra tags around whitespace
            // Inside the if statement, we generate the content to be returned
            // before we remove the wpautop filter so we don't get p tags for
            // whitespace. If we performed the function call on the return
            // statement, we would have to remove the filter, then add it back
            // in when generating each of the content blocks.
            remove_filter('the_content', 'wpautop');
        }

        return $content;
    }

    /**
     * Determine if the template being loaded is build with flexible content
     * @param int|null $post_id
     * @return boolean
     */
    public static function isFlexibleContentTemplate($post_id = null): bool
    {
        if ($post_id === null) {
            $post_id = get_the_id();
        }

        return get_page_template_slug($post_id) === 'page-templates/flexible-content.php';
    }


    public static function loadColorFieldChoices(array $field): array
    {
        global $GRANOLA_COLORS;

        $field['choices'] = $GRANOLA_COLORS;

        return $field;
    }

    public static function disable_gutenberg(bool $can_edit, string $post_type): bool
    {
        if (!(is_admin() && !empty($_GET['post']))) {
            return $can_edit;
        }

        if (self::disable_editor($_GET['post'])) {
            $can_edit = false;
        }

        return $can_edit;
    }

    public static function disable_editor($id = false): bool
    {
        $excluded_templates = [
            'page-templates/flexible-content.php',
        ];

        if (empty($id)) {
            return false;
        }

        $id = intval($id);
        $template = get_page_template_slug($id);

        return in_array($template, $excluded_templates);
    }
}
