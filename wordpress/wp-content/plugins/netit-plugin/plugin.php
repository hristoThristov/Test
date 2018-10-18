<?php
/*
Plugin Name:    NetIT plugin
Description:    NetIT very very important stuff
Version:        20180515
*/

define("NETIT_PLUGIN_SLUG", plugin_dir_path(__FILE__) . 'admin/main.php');

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'netit_add_action_links' );

function netit_add_action_links ( $links ) {
    $mylinks = [
        '<a href="' . admin_url( 'admin.php?page=netit-plugin/admin/main.php' ) . '">Settings</a>',
    ];

    //return $mylinks;
    return array_merge( $links, $mylinks );
}
/**
 * End filters section
 */

 /**
  * Start actions section
  */

function netit_the_post_action( $post_object ) {
    $uppercase_titles = get_option('netit_settings_title_up');
    $excl_points = get_option('netit_settings_excl_after');

    // modify post object here
    if(!empty($uppercase_titles)) {
        $post_object->post_title = strtoupper($post_object->post_title);
    }

    if(!empty($excl_points)) {
        $post_object->post_title .= " !!!";
    }
    
    // Obsolete
    //$post_object->post_title = strtoupper($post_object->post_title) . " !!!";
}
add_action( 'the_post', 'netit_the_post_action' );

function netit_admin_menu_options() {   
    add_menu_page (
        'NetIT options', // page title 
        'NetIT options title', // menu title
        'manage_options', // capability (permissions)
        NETIT_PLUGIN_SLUG, // slug
        NULL, // callback function
        NULL, // icon URL
        99 // position
    );

    add_submenu_page (
        NETIT_PLUGIN_SLUG, // parent slug
        'NetIT options second', // title
        'NetIT options second title', // menu tile
        'manage_options', // permissions
        plugin_dir_path(__FILE__) . 'admin/edit.php', // slug
        NULL // menu icon
    );
}

function netit_top_page_callback() {
    echo "Top page.";
}

function netit_second_level_callback() {
    echo "Internal page.";
}

add_action('admin_menu', 'netit_admin_menu_options');

function netit_admin_remove_options_page() {
    remove_menu_page('edit-comments.php');
}

add_action('admin_menu', 'netit_admin_remove_options_page', 99);

function netit_settings_init()
{
    // register a new setting for "reading" page
    register_setting('general', 'netit_settings_title_up');
    register_setting('general', 'netit_settings_excl_after');
 
    // register a new section in the "reading" page
    add_settings_section(
        'netit_settings_section',
        'NetIT Settings Section',
        //'netit_settings_section_callback', // callback for custom markup for our custom section
        NULL,
        'general'
    );
 
    // register a new field in the "wporg_settings_section" section, inside the "reading" page
    add_settings_field(
        'netit_settings_title_uppercase',
        'Uppercase titles',
        'netit_settings_field_uppercase_callback',
        'general',
        'netit_settings_section'
    );

    add_settings_field(
        'netit_settings_title_excl',
        'Exclimation points after titles',
        'netit_settings_field_exclimations_callback',
        'general',
        'netit_settings_section'
    );
}

function netit_settings_section_callback() {
    echo '<p>NetIT section intorduction.</p>';
}

function netit_settings_field_uppercase_callback() {
    // get the value of the setting we've registered with register_setting()
    $setting = get_option('netit_settings_title_up');
    // Useful debug!!!
    //var_dump($setting);
    // output the field

    $checked = '';
    if( !empty($setting) ) {
        $checked = "checked";
    }

    ?>
    <input
        type="checkbox"
        name="netit_settings_title_up"
        <?php echo $checked; ?>
        value="1" />
    <?php
}

function netit_settings_field_exclimations_callback() {
        // get the value of the setting we've registered with register_setting()
        $setting = get_option('netit_settings_excl_after');
        // Useful debug!!!
        //var_dump($setting);
        // output the field
    
        $checked = '';
        if( !empty($setting) ) {
            $checked = "checked";
        }
    
        ?>
        <input
            type="checkbox"
            name="netit_settings_excl_after"
            <?php echo $checked; ?>
            value="1" />
        <?php
}
 
/**
 * register netit_settings_init to the admin_init action hook
 */
add_action('admin_init', 'netit_settings_init');

/**
 * Function initializing the shortcodes.
 */
function netit_shortcodes_init() {

    /**
     * Calculator function.
     */
    function calculator_shortcode($atts = [], $content = null)
    {
        /*$content = "<pre>";
        $content .= "The caculator.";
        $now = time();
        $content .= date("d/m/Y - H:i:s", $now);
        $content .= "</pre>";*/

        $content = "<div style='background-color: {$atts['color']}' class='calc-container'>";
        if(!empty($atts['title'])) {
            $content .= "<h2>{$atts['title']}</h2>";
        }
        else {
            $content .= "<h2>Calculator</h2>";
        }
        $content .= "<input type='text' class='calc-output' /><br/>";

        $content .= "<div class='calc-btns'>";
        for($i = 9; $i >= 0; $i--) {
            $content .= "<button value='{$i}' class='calc-btn btn-act btn-num btn-{$i}'>{$i}</button>";
        }

        $content .= "<button value='+' class='calc-btn btn-act btn-op btn-plus'>+</button>";
        $content .= "<button value='-' class='calc-btn btn-act btn-op btn-minus'>-</button>";
        $content .= "<button value='=' class='calc-btn btn-equals'>=</button>";

        $content .= "</div>";

        $content .= "</div>";

 
        // always return
        return $content;
    }
    add_shortcode('netit_calc', 'calculator_shortcode');
}

add_action('init', 'netit_shortcodes_init');

function netit_calc_enqueue_styles() {
    $url = plugins_url();

    // TODO: find better way to get the plugin URL.
    wp_enqueue_style( 'netit-plugin', $url . '/netit-plugin/css/calc.css' );
}

// Hook to wp_enqueue_scripts with my_theme_enqueue_styles function
add_action( 'wp_enqueue_scripts', 'netit_calc_enqueue_styles' );

function netit_calc_enqueue_scripts() {
    $url = plugins_url();

    // TODO: find better way to get the plugin URL.
    wp_enqueue_script( 'netit-plugin', $url . '/netit-plugin/js/calc.js', ['jquery'] );
}

// Hook to wp_enqueue_scripts with my_theme_enqueue_styles function
add_action( 'wp_enqueue_scripts', 'netit_calc_enqueue_scripts' );

function netit_custom_post_type()
{
    register_post_type('grade',
        array(
            'labels'      => array(
                'name'          => __('Grades'),
                'singular_name' => __('Grade'),
            ),
            'public'      => true,
            'has_archive' => true,
        )
    );
}
add_action('init', 'netit_custom_post_type');