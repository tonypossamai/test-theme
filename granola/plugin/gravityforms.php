<?php

namespace Granola\Plugin;

class GravityForms
{
    public static function init(): void
    {
        add_filter('gform_confirmation_anchor', '__return_false');
        add_filter('gform_progressbar_start_at_zero', '__return_true');
        add_filter('gform_init_scripts_footer', '__return_true');
        add_filter('gform_enable_field_label_visibility_settings', '__return_true');

        add_filter('gform_ajax_spinner_url', [__CLASS__, 'spinnerURL'], 10);
        add_action('gform_enqueue_scripts', [__CLASS__, 'dequeueStylesheets'], 11);
        add_filter('gform_get_form_filter', [__CLASS__, 'removeInlineStyle'], 10);
    }

    // ----------------------------------------------------
    // Gravity likes to output a lot of CSS
    // We don't like that...
    // ----------------------------------------------------
    public static function dequeueStylesheets(): void
    {
        // ----------------------------------------------------
        // Check if we are not on the administration screen and
        // if we are not viewing a gravity forms demo screen
        // ----------------------------------------------------
        if (!is_admin() && !array_key_exists('gf_page', $_GET)) {
            wp_dequeue_style('gforms_reset_css');
            wp_dequeue_style('gforms_datepicker_css');
            wp_dequeue_style('gforms_formsmain_css');
            wp_dequeue_style('gforms_ready_class_css');
            wp_dequeue_style('gforms_browsers_css');
        }
    }

    // ----------------------------------------------------
    // Gravity forms likes to output style tags directly
    // in the markup, most annoyingly when using the list
    // field type. This will search gravity output and remove
    // any inline style tags
    // ----------------------------------------------------
    public static function removeInlineStyle(string $form_string): string
    {
        return preg_replace(
            '/<\s*style.+?<\s*\/\s*style.*?>/si',
            ' ',
            $form_string
        );
    }

    public static function spinnerURL(): string
    {
        return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
    }
}
