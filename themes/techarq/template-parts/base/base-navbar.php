<header id="site-header" class="js-navbar">
    <div class="container">
        <div class="logo">
            <!-- Your site logo here -->
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/techarq-logo.png' ) ?>" alt="Site Logo">
            </a>
        </div>

        <nav id="site-navigation">
            <?php
            // Display the navigation menu
            wp_nav_menu(array(
                'theme_location' => 'main-menu', // Change this to your registered menu location
                'menu_class'     => 'main-menu',
                'container'      => false,
            ));
            ?>
        </nav>

        <button class="nav-tgl" type="button" aria-label="toggle menu">
            <span aria-hidden="true"></span>
        </button>
    </div>
</header>