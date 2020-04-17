<?php

namespace Granola\WordPress;

class LazyLoad
{
    public static function init(): void
    {
        // There is currently a fallback in place for when javascript is dissabled of adding an image in a noscript tag
        // https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/
        // https://jhtechservices.com/changing-your-image-markup-in-wordpress/

        add_filter('wp_get_attachment_image_attributes', [__CLASS__, 'changeAttachmentImageMarkup'], 10);
        add_filter('the_content', [__CLASS__, 'addImgLazyMarkup'], 15);
    }


    public static function changeAttachmentImageMarkup(array $attributes): array
    {
        if (is_admin()) {
            return $attributes;
        }

        if (GRANOLA_LAZY_LOAD === true) {
            if (isset($attributes['src'])) {
                // Alias the source as we need it later
                $src = $attributes['src'];

                // Move the src to data-src
                $attributes['data-src'] = $src;

                // Overwrite the src attribute with a placeholder
                $attributes['src'] = defined('GRANOLA_LAZY_LOAD_PLACEHOLDER') ? GRANOLA_LAZY_LOAD_PLACEHOLDER : '';
                ;

                if ($attributes['src'] === '') {
                    // Strip dimensions from the src url
                    $clean_src = preg_replace("/-\d+[Xx]\d+\./", ".", $src);

                    // get the image id by url
                    if ($id = self::getImageIDByURL($clean_src)) {
                        // get the lazy thumbnail url
                        $placeholder_thumb = wp_get_attachment_image_src($id, 'lazy');

                        $attributes['src'] = $placeholder_thumb[0];
                    }
                }
            }

            if (isset($attributes['srcset'])) {
                // Move the src-set to data-srcset
                $attributes['data-srcset'] = $attributes['srcset'];

                unset($attributes['srcset']);
            }

            $attributes['class'] .= ' ' . GRANOLA_LAZY_LOAD_CLASS;
        }

        return $attributes;
    }

    public static function addImgLazyMarkup(string $the_content): string
    {
        if (is_admin() || $the_content == "") {
            return $the_content;
        }

        if (GRANOLA_LAZY_LOAD === true) {
            $the_content = preg_replace_callback('/<img[^>]*>/', [__CLASS__, 'convertImage'], $the_content);
        }

        return $the_content;
    }

    public static function convertImage(array $match): string
    {
        $attributes = self::getImgAttributes($match[0]);
        $output = '';

        // This converts any assets that come through the_content and haven't been
        // converted yet
        if (array_key_exists('class', $attributes) === false || strpos($attributes['class'], GRANOLA_LAZY_LOAD_CLASS) === false) {
            $attributes = self::changeAttachmentImageMarkup($attributes);
        }

        // Only add fallbacks if the lazyload class has been set
        if (array_key_exists('class', $attributes) && strpos($attributes['class'], GRANOLA_LAZY_LOAD_CLASS)) {
            $output = self::createImg($attributes);
            $output .= '<noscript>' . self::createImg(self::resetSrcAttributes($attributes)) . '</noscript>';
        } else {
            $output = self::createImg(resetSrcAttributes($attributes));
        }

        return $output;
    }

    public static function resetSrcAttributes(array $attributes): array
    {
        if (array_key_exists('data-src', $attributes)) {
            $attributes['src'] = $attributes['data-src'];
            unset($attributes['data-src']);
        }

        if (array_key_exists('data-srcset', $attributes)) {
            $attributes['srcset'] = $attributes['data-srcset'];
            unset($attributes['data-srcset']);
        }

        return $attributes;
    }

    public static function createImg(array $attribute_array): string
    {
        $attributes = '';
        foreach ($attribute_array as $attribute => $value) {
            $attributes .= $attribute . '="' . $value . '" ';
        }

        // Removes the extra space after the last attribute
        return '<img ' . trim($attributes) . '>';
    }

    public static function getImgAttributes(string $image_node): array
    {
        if (function_exists("mb_convert_encoding")) {
            $image_node = mb_convert_encoding($image_node, 'HTML-ENTITIES', 'UTF-8');
        }

        $dom = new DOMDocument();
        @$dom->loadHTML($image_node);
        $image = $dom->getElementsByTagName('img')->item(0);
        $attributes = array();
        foreach ($image->attributes as $attr) {
            $attributes[$attr->nodeName] = $attr->nodeValue;
        }

        return $attributes;
    }

    // This is a rather expensive public static function to perform on every page load. If there
    // is no page caching, server-side or otherwise, it is recommended to avoid this
    public static function getImageIDByURL(string $image_url): string
    {
        global $wpdb;

        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));

        if (is_array($attachment) && !empty($attachment)) {
            return $attachment[0];
        }

        return '';
    }
}
