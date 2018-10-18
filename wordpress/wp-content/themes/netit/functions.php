<?php

/**
 * 
 */
function netit_enqueue_styles() {
    wp_enqueue_style( 'netit-theme', get_template_directory_uri() . '/style.css' );
}

// Hook to wp_enqueue_scripts with my_theme_enqueue_styles function
add_action( 'wp_enqueue_scripts', 'netit_enqueue_styles' );

function print_numbers_skip_ten($num) {
    for($i = 0; $i < $num; $i+= 10) {
        echo $i . ", ";
    }
}

/* Registers custom defined menus for tis theme. */
register_nav_menus( [
        'netit_top' => __( 'Netit Primary Menu', 'netit' ),
        'netit_bot' => __( 'Netit Secondary Menu', 'netit' ),
    ]
);