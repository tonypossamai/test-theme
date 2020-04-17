<footer class="footer">
    <div class="footer__inner">
        <div class="footer__logo">
            <?php echo \Granola\svg('logo-wholegrain-digital', [
                'title' => get_bloginfo('name'),
                'description' => get_bloginfo('description'),
            ]); ?>
        </div>

        <div class="footer__content">
            <?php wp_nav_menu(array(
                'theme_location' => 'footer',
                'depth' => 2,
                'container' => '',
                'menu_class' => 'footer__menu',
                'fallback_cb' => false,
            )); ?>
        </div>

        <ul class="footer__social">
            <li>
                <a href="#0">
                    Facebook
                </a>
            </li>
            <li>
                <a href="#0">
                    Linked In
                </a>
            </li>
            <li>
                <a href="#0">
                    Twitter
                </a>
            </li>
        </ul>

        <p class="footer__signature">
            <?php echo \Granola\render('template-parts/signature'); ?>
        </p>
    </div>
</footer>
