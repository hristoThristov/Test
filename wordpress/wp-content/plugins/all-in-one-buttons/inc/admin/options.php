<?php
  /**
   * configure your admin page
   */
  $config = array(    
    'menu'=> array('top' => 'aiobtn'),             //sub page to settings page
    'page_title' => 'All In One Buttons',       //The name of this page 
    'capability' => 'edit_themes',         // The capability needed to view the page 
    'option_group' => 'aiobtn_options',       //the name of the option to create in the database
    'id' => 'aiobtn',            // meta box id, unique per page
    'fields' => array(),            // list of fields (can be added by field arrays)
    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );

  /**
   * Initiate your admin page
   */
  $options_panel = new aiobtnAdmin($config);
  $options_panel->OpenTabs_container('');
  $options_panel->SelfPath = plugins_url( 'admin', plugin_basename( dirname( __FILE__ ) ) );

if( isset($_GET['page']) && $_GET['page'] == 'aiobtn' ) {
  
  /**
   * define your admin page tabs listing
   */
  $options_panel->TabsListing(array(
    'links' => array(
    'options_1' =>  __('Getting Started', 'aiobtn'),
    'options_2' =>  __('General Settings', 'aiobtn')
    )
  ));
  
  /**
   * Open admin page 1st tab
   */
  $options_panel->OpenTab('options_1');
  $options_panel->Title(__('Getting Started','aiobtn'));
  $options_panel->addParagraph(__('When you\'re working with new software, we understand that getting started is often the hardest part. That\'s why we\'ve provided an overview of All In One Buttons to help you do just that. If you have any additional questions, please feel free to contact wpgoods.com for support. Thank you!','aiobtn')."<br /><img class='aiobtn-img-guide' src='" . $options_panel->SelfPath . "/images/aio_button_guide.png' alt='" . esc_attr__('All In One Buttons - Getting Started Guide', 'aiobtn') . "' />");
  $options_panel->CloseTab();

  /**
   * Open admin page 2nd tab
   */
  $options_panel->OpenTab('options_2');
  $options_panel->Title(__('General Settings','aiobtn'));
  $options_panel->addText('shortcode_name',array('name'=> __('Shortcode Name','aiobtn'), 'std'=> 'aio_button', 'desc'=> __('You can use this option to rename the WordPress shortcode.','aiobtn')));
  $options_panel->addSelect('default_animation',array('none' => __('None','aiobtn'),'flash' => __('Flash','aiobtn'),'bounce' => __('Bounce','aiobtn'),'pulse' => __('Pulse','aiobtn'),'shake' => __('Shake','aiobtn'),'swing' => __('Swing','aiobtn')),array('name'=> __('Default Animation','aiobtn'), 'std'=> array('none'), 'desc'=> __('You can use this option to change the default animation.','aiobtn')));
  $options_panel->addSelect('default_color',array('black' => __('Black','aiobtn'),'blue' => __('Blue','aiobtn'),'brown' => __('Brown','aiobtn'),'gray' => __('Gray','aiobtn'),'green' => __('Green','aiobtn'),'orange' => __('Orange','aiobtn'),'pink' => __('Pink','aiobtn'),'purple' => __('Purple','aiobtn'),'red' => __('Red','aiobtn'),'yellow' => __('Yellow','aiobtn')),array('name'=> __('Default Color','aiobtn'), 'std'=> array('red'), 'desc'=> __('You can use this option to change the default color.','aiobtn')));
  $options_panel->addSelect('default_size',array('small' => __('Small','aiobtn'),'medium' => __('Medium','aiobtn'),'large' => __('Large','aiobtn')),array('name'=> __('Default Size','aiobtn'), 'std'=> array('small'), 'desc'=> __('You can use this option to change the default size.','aiobtn')));
  $options_panel->addText('default_text',array('name'=> __('Default Text','aiobtn'), 'std'=> 'Download Now', 'desc'=> __('You can use this option to change the default text.','aiobtn')));
  $options_panel->CloseTab();

  //Help tab
  $options_panel->HelpTab(array(
    'id'=>'tab_id',
    'title'=>__('Customer Support','aiobtn'),
    'content'=>'<p>'.__('Thank you for downloading All In One Buttons. I really hope you\'re enjoying the product. Customer support is a top priority for WP Goods. Your enquiries will receive a personal response within 48 hours (2 working days).','aiobtn').'</p><p>'.__('If you need help for any reason, please feel free to contact support through the WP Goods Ticksy support system. Just sign in with your Facebook or Twitter account (or register manually) and give us a shout at','aiobtn').' <a href="http://wpgoods.ticksy.com">http://wpgoods.ticksy.com</a>. '.__('Once again, thank you!','aiobtn').'</p>'
  ));
}
?>