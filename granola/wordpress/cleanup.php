<?php

namespace Granola\WordPress;

class Cleanup
{
    public static function init(): void
    {
        add_filter('emoji_svg_url', '__return_false');

        add_action('init', [__CLASS__,'headCleanup']);
        add_action('init', [__CLASS__,'disableEmoji']); // filter to remove TinyMCE emojis
        add_filter('tiny_mce_plugins', [__CLASS__, 'disableEmojiTinyMCE']); // filter to remove TinyMCE emojis
        remove_filter('the_content', [__CLASS__, 'convertSmilies'], 20); // Dont convert :) to an image
        add_action('wp_footer', [__CLASS__, 'noEmbed']);

        // ---------------------------------------------------------------------
        // Legacy
        // Flag for removal
        // ---------------------------------------------------------------------
        add_filter('wp_head', [__CLASS__,'removeWPWidgetRecentCommentsStyle'], 1);
        add_action('wp_head', [__CLASS__,'removeRecentCommentsStyle'], 1);
        add_filter('galleryStyle', [__CLASS__,'galleryStyle']);
    }

    public static function noEmbed(): void
    {
        wp_deregister_script('wp-embed');
    }

    //Let's clean the mess.
    public static function headCleanup(): void
    {
        // Remove EditURI link
        remove_action('wp_head', 'rsd_link');

        // Remove Windows live writer
        remove_action('wp_head', 'wlwmanifest_link');

        // Remove index link
        remove_action('wp_head', 'index_rel_link');

        // Remove previous link
        remove_action('wp_head', 'parent_post_rel_link', 10, 0);

        // Remove start link
        remove_action('wp_head', 'start_post_rel_link', 10, 0);

        // Remove links for adjacent posts
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

        // Remove WP version
        remove_action('wp_head', 'wp_generator');
    }

    // Remove injected CSS for recent comments widget
    public static function removeWPWidgetRecentCommentsStyle(): void
    {
        if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {
            remove_filter('wp_head', 'wp_widget_recent_comments_style');
        }
    }

    // Remove injected CSS from recent comments widget
    public static function removeRecentCommentsStyle(): void
    {
        global $wp_widget_factory;
        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action('wp_head', [
                $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
                'recent_comments_style'
            ]);
        }
    }

    // Remove injected CSS from gallery
    public static function galleryStyle(string $css): string
    {
        return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
    }

    public static function disableEmoji(): void
    {

        // all actions related to emojis
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
    }

    public static function disableEmojiTinyMCE($plugins): array
    {
        if (is_array($plugins)) {
            return array_diff($plugins, ['wpemoji']);
        } else {
            return [];
        }
    }
}
