<?php

/**
 * Обработваща функция за добавяне на стиловете в темата.
 */
function twfi_child_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    // Adds the CSS from the parent theme.
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

    // adds the CSS from the child theme.
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

// Hook to wp_enqueue_scripts with twfi_child_enqueue_styles function
add_action( 'wp_enqueue_scripts', 'twfi_child_enqueue_styles' );

// Custom Function to change the favicon of the site.
function twfi_child_favicon_link() {
    echo '<link rel="shortcut icon" type="image/x-icon" href="' . get_stylesheet_directory_uri() . '/favicon.ico" />' . "\n";
}

// Hook to wp_head for the cahnge if the favicon
add_action( 'wp_head', 'twfi_child_favicon_link' );

// Добавяне на външен изпълним файл.
require_once( get_stylesheet_directory() . '/foo.class.php' );

// Проверка за вече съществуваща twentyfifteen_test функция, в случай че има още дъщерни теми.
if ( ! function_exists( 'twentyfifteen_test' ) ) {
    // Дефиниция на наша обработваща функция
    function twentyfifteen_test () {
        echo "<div style='position: absolute; top: 0; left: 0; z-index: 999;'>";
        $date = strtotime("+1 day");
        var_dump(date("d/M/Y - H:i:s", $date));

        $foo = new Foo();
        $foo->bar();
        echo "</div>";
    }
}

// Извикване на нашата обработваща функция.
twentyfifteen_test();