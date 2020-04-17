<header class="header">
    <div class="header__inner">
        <a class="header__logo" href="<?php echo esc_url(home_url('/')); ?>">
            <?php echo \Granola\svg('logo-wholegrain-digital', [
                'title' => get_bloginfo('name'),
                'description' => get_bloginfo('description'),
            ]); ?>
        </a>

        <?php if (has_nav_menu('header')) : ?>
            <nav class="header__navigation">
                <?php
                // it's better to have burger menu inside 'nav' tag
                // Read more: http://www.a11ymatters.com/pattern/mobile-nav/
                echo \Granola\render('assets/components/burger/index', [
                    'class' => 'header__burger js-header-burger',
                    'aria-label' => __('Menu', 'granola'),
                    'aria-controls' => 'main-menu',
                    'aria-expanded' => 'false',
                ]);
                ?>

                <?php wp_nav_menu([
                    'theme_location' => 'header',
                    'depth' => 0,
                    'container' => '',
                    'menu_class' => 'header__menu',
                    'menu_id' => 'main-menu', // don't delete it, needed for 'aria-controls' in burger button.
                    'fallback_cb' => false,
                ]); ?>
            </nav>
        <?php endif; ?>
    </div>
</header>
