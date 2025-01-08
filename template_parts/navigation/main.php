<?php

use WarpHtmx\Walkers\MainMenu;

wp_nav_menu([
    'theme_location'    => 'main',
    'menu_id'           => 'main-menu',
    'menu'              => 'main-menu',
    'container'         => 'nav',
    'container_class'   => apply_filters('warp_theme_main_menu_container_class', warp_get_class('menu.main.container')),
    'walker'            => new MainMenu(),
]);
