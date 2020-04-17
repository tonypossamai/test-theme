<div class="g-card">
    <?php if (!empty($args['heading'])) { ?>
        <div class="g-card__heading">
            <?php if (!empty($args['link'])) { ?>
                <a href="<?php echo $args['link']; ?>">
            <?php } ?>

            <?php echo $args['heading']; ?>

            <?php if (!empty($args['link'])) { ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (!empty($args['meta'])) { ?>
        <div class="g-card__meta">
            <?php echo $args['meta']; ?>
        </div>
    <?php } ?>

    <?php if (!empty($args['content'])) { ?>
        <div class="g-card__content">
            <?php echo $args['content']; ?>
        </div>
    <?php } ?>

    <?php if (!empty($args['media'])) { ?>
        <div class="g-card__media img-fit">
            <?php echo $args['media']; ?>
        </div>
    <?php } ?>
</div>
