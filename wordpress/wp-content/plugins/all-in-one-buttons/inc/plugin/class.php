<?php
if (!class_exists('aiobtnButton')) {

	class aiobtnButton {
    
    /**
     * Constructor
     */
    function __construct() {
      // Add TinyMCE button
      add_action( 'init', array( $this, 'add_button' ) );
    } // end constructor
        
    // Add All In One Buttons button to TinyMCE
    public function add_button() {
      global $pagenow;
      
      // Don't bother doing this stuff if the current user lacks permissions
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;
      
      // Add only in Rich Editor mode
      if ( get_user_option('rich_editing') == 'true' && ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'page-new.php', 'page.php' ) ) ) ) {
        add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_plugin' ) );
        add_filter( 'mce_buttons', array( $this, 'register_button' ) );
      }
    }
    
    // Load the TinyMCE plugin: editor_plugin.js
    public function add_tinymce_plugin($plugin_array) {
      // This plugin file will work the magic of our button
      global $AIO_Buttons_Path;
      $plugin_array["aio_buttons"] = $AIO_Buttons_Path . 'inc/plugin/editor_plugin.js';
      return $plugin_array;
    }
          
    // Register the button
    public function register_button($buttons) {
      // Add a separation before our button, here our button's id is aio_buttons
       array_push($buttons, "|", "aio_buttons");
       return $buttons;
    }
        
	} // end class
  
  $aiobtn_button = new aiobtnButton();
  
}
?>