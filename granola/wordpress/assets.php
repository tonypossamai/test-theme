<?php

namespace Granola\WordPress;

class Assets
{
    public static function init(): void
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'assetsLoad']);
        add_filter('wp_default_scripts', [__CLASS__, 'removejQueryMigrate']);
        add_action('wp_default_scripts', [__CLASS__, 'movejQueryToFooter']);
        add_action('wp_head', [__CLASS__, 'javascriptDetection'], 0);
        add_filter('style_loader_src', [__CLASS__, 'removeVer'], 10, 2);
        add_filter('script_loader_src', [__CLASS__, 'removeVer'], 10, 2);
        add_filter('script_loader_tag', [__CLASS__, 'module'], 10, 3);
        add_action('enqueue_block_editor_assets', [__CLASS__, 'adminStyles']);
    }

    public static function adminStyles(): void
    {
        wp_enqueue_style('granola-gutenberg', \Granola\assetURL('styles/gutenberg.css', true), []);
    }

    public static function removeVer(string $src): string
    {
        if (strpos($src, '?ver=')) {
            $src = remove_query_arg('ver', $src);
        }

        return $src;
    }

    public static function assetsLoad(): void
    {
        // ------------------------------------------
        // If we are on the admin screen we dont need
        // to load the custom scripts and styles
        // ------------------------------------------
        if (is_admin()) {
            wp_enqueue_style('granola-stylesheet', get_stylesheet_uri());
            return;
        }

        // ------------------------------------------
        // Enqueue Granola CSS
        // ------------------------------------------
        wp_enqueue_style('granola-styles', \Granola\assetURL('styles/styles.css', true), []);

        // ------------------------------------------
        // Build our script dependencies
        // ------------------------------------------
        $script_dependencies = [];

        if (defined('JQUERY_REQUIRED') && JQUERY_REQUIRED === true) {
            $script_dependencies[] = 'jquery';
        }

        // ------------------------------------------
        // Load our javascript files and their dependencies
        // ------------------------------------------
        wp_register_script('granola-scripts', \Granola\assetURL('scripts/scripts.mjs', true), $script_dependencies, '', true);

        // ------------------------------------------
        // Just in case we need pass PHP variables to JS
        // We should wrap this in a constant so we can
        // turn this on and off
        // ------------------------------------------
        wp_localize_script('granola-scripts', 'params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'home_url' => home_url(),
        ));

        /* Enqueue comment-reply script if needed */
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        wp_register_script('granola-scripts-legacy', \Granola\assetURL('scripts/legacy.js', true), ['granola-scripts'], '', true);

        wp_enqueue_script('granola-scripts-legacy');
    }

    public static function removejQueryMigrate(&$scripts): void
    {
        if (is_admin()===false && GRANOLA_REMOVE_JQUERY_MIGRATE === true) {
            $scripts->remove('jquery');
            $scripts->add('jquery', false, array('jquery-core'), '1.12.4');
        }
    }

    // ------------------------------------------
    // Move jQuery to footer but put it in the
    // the header if needed
    // https://wordpress.stackexchange.com/questions/173601/enqueue-core-jquery-in-the-footer/240612#240612
    // ------------------------------------------
    // So this is pretty clever. We move jQuery to
    // the footer by default. If nothing requires
    // it be loaded in the header, it will stay in
    // the footer. But if a plugin requires it in
    // the header, it will be magically moved :)
    // ------------------------------------------
    public static function movejQueryToFooter($wp_scripts): void
    {
        if (is_admin()===false && GRANOLA_JQUERY_IN_FOOTER === true) {
            $wp_scripts->add_data('jquery', 'group', 1);
            $wp_scripts->add_data('jquery-core', 'group', 1);
        }
    }

    // ------------------------------------------
    // Handles JavaScript detection.
    // Adds a `js` class to the root `<html>` element when JavaScript is detected.
    // Needs to be added in the header to avoid FOUC.
    // ------------------------------------------
    public static function javascriptDetection(): void
    {
        echo "<script>(function(html){html.className = ".
        "html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
    }

    public static function module(string $tag, string $handle, string $src): string
    {
        $search = "type='text/javascript'";

        // Check if we are working with the main scripts file
        if (strpos($src, 'assets/scripts/scripts') !== false) {
            // Lets add the module attribute to the modern script file
            if (strpos($src, '.mjs') !== false) {
                return str_replace($search, "type='module'", $tag);
            }

            // Lets add the nomodule attribute to the legacy script file
            if (strpos($src, '.js') !== false) {
                return str_replace($search, 'nomodule async defer', $tag);
            }
        }

        if (strpos($src, 'assets/scripts/legacy') !== false) {
            // Lets add the module attribute to the modern script file
            if (strpos($src, '.mjs') !== false) {
                return str_replace($search, "type='module'", $tag);
            }

            // Lets add the nomodule attribute to the legacy script file
            if (strpos($src, '.js') !== false) {
                return str_replace($search, 'nomodule async defer', $tag);
            }
        }

        return $tag;
    }
}
