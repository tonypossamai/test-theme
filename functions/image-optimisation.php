<?php

add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment, $size) {
    // Lets return early if we are in the admin area
    if (is_admin()) {
        return $attr;
    }

    // For an education on responsive images, check this link
    // https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images

    // If $size is an array, width and height were passed
    // and not a defined image size
    if (is_array($size)) {
        $attr['sizes'] = $size[0] . 'px';
    } else {
        // Get the current content block. It's also possible to get the entire
        // render stack if you have a block in a block and want to test for that.
        $current_partial = \Granola\currentPartial();

        // Check if the current block is the test block
        // if ($current_partial['partial'] === 'template-parts/components/guides') {
        //     if($current_partial['args']['presentation'] === 'list'){
        //         $attr['sizes'] = '(max-width: 1023px) 100vw, 555px';
        //     }else {
        //         $attr['sizes'] = '(max-width: 1023px) 100vw, 364px';
        //     }
        // }elseif ($current_partial['partial'] === 'template-parts/flexible-content/instagram') {
        //     $attr['sizes'] = '(max-width: 1023px) 50vw, 17vw';
        // }
    }

    return $attr;
}, 25, 3);
