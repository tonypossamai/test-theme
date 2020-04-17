<?php

$classes = ['cards'];

if (!empty($args['class'])) {
    $classes[] = $args['class'];
}

?><div class="<?php echo implode(' ', $classes); ?>">
    <div class="cards__row">
        <?php foreach ($args['cards'] as $key => $card) { ?>
            <div class="cards__col">
                <?php echo \Granola\render('assets/components/card', $card); ?>
            </div>
        <?php } ?>
    </div>
</div>
