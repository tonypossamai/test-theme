<?php

// The wysiwyg__content wrapper needs to exist around the content as we need to
// apply an overflow hidden to the wysiwyg, and if we applied a width to the top
// level wysiwyg, we would not have full screen width content.

?><div class="wysiwyg">
    <?php if (!empty($args['heading'])) { ?>
        <div class="wysiwyg__heading">
            <?php echo $args['heading']; ?>
        </div>
    <?php } ?>

    <?php if (!empty($args['content'])) { ?>
        <div class="wysiwyg__content">
            <?php echo $args['content']; ?>
        </div>
    <?php } ?>
</div>
