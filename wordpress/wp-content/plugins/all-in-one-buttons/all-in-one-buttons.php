<?php
/*
Plugin Name: All in One Buttons
Description: My own buttons.
Version: 20180622

*/

//global scope constants
define( 'aiobtn_path', plugin_dir_path(__FILE__) );
define( 'AIO_Buttons_Version', '1.3' );
//declare global variables
$AIO_Buttons_Path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
$AIO_Buttons_Data = get_option('aiobtn_options');
$AIO_Buttons_Slug = basename(dirname(__FILE__));
$AIO_Buttons_Class = array('admin','dialog','plugin','shortcode');
//require the classes
foreach($AIO_Buttons_Class as $class) {
	require_once( aiobtn_path . 'inc/'.$class.'/class.php' );
}

class AIOButtons {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'All In One Buttons';
	const slug = 'aiobtn';
	
	/**
	 * Constructor
	 */
	function __construct() {
		//register an activation hook for the plugin
		register_activation_hook( __FILE__, array( $this, 'install' ) );

		//Hook up to the init action
		add_action( 'init', array( $this, 'init' ) );
	}
  
	/**
	 * Runs when the plugin is activated
	 */
	public function install() {
		//save default shortcodes
		if (!get_option('aiobtn_options')) {
			$default = array(
				'shortcode_name' => 'aio_button',
				'default_animation' => 'none',
				'default_color' => 'red',
				'default_size' => 'small',
				'default_text' => __('Download Now','aiobtn')
			);
			update_option('aiobtn_options',$default);
		}
	}
  
	/**
	 * Runs when the plugin is initialized
	 */
	public function init() {
		// Setup localization
		load_plugin_textdomain( 'aiobtn', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
    
		// Load JavaScript and Stylesheets
		$this->register_scripts_and_styles();
    
    // Add action links in Plugins page
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
      
    // Add meta links in Plugins page
    add_filter( 'plugin_row_meta', array( $this, 'meta_links' ), 10, 2 );
    
    add_filter('widget_text', 'do_shortcode'); // Allow shortcode in widgets
    add_filter('comment_text', 'do_shortcode'); // Allow shortcode in comments
    add_filter('the_excerpt', 'do_shortcode'); // Allow shortcode in excerpt
	}
  
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {	
		if ( is_admin() ) {
			if (isset($_GET['page']) && $_GET['page'] == 'aiobtn') {
				$this->load_file( self::slug . '-admin-script', '/js/admin.min.js', true );
			}
		}
	} // end register_scripts_and_styles
	
	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file( $name, $file_path, $is_script = false ) {

		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); //depends on jquery
				wp_enqueue_script( $name );
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

	} // end load_file
  
  // Add action links in Plugins page
  public function action_links( $links ) {
    return array_merge(
      array(
        'settings' => '<a href="' . admin_url('admin.php?page=aiobtn') . '">' . __( 'Settings', 'aiobtn' ) . '</a>'
      ),
      $links
    );
  }
    
  // Add meta links in Plugins page
  public function meta_links( $links, $file ) {
    $plugin = plugin_basename(__FILE__);
    // create link
    if ( $file == $plugin ) {
      return array_merge(
        $links,
        array( '<a href="http://twitter.com/wpgoods">'.__('Twitter', 'aiobtn').'</a>' )
      );
    }
    return $links;
  }
  
} // end class
new AIOButtons();
?>