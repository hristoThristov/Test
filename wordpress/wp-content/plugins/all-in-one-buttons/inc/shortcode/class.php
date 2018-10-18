<?php
if (!class_exists('aiobtnShortcode')) {

	class aiobtnShortcode {
  
    function __construct() {
      global $AIO_Buttons_Data;
      
      // Register the WordPress shortcode
      if (is_array($AIO_Buttons_Data) && array_key_exists('shortcode_name',$AIO_Buttons_Data)) {
        add_shortcode($AIO_Buttons_Data['shortcode_name'], array( $this, 'shortcode'));
      } else {
        add_shortcode('aio_button', array( $this, 'shortcode'));
      }

    }
  
		public function shortcode($atts) {
			global $AIO_Buttons_Data, $AIO_Buttons_Path;
			
			if(is_array($AIO_Buttons_Data) && array_key_exists('default_animation',$AIO_Buttons_Data)) {
				$default_animation = $AIO_Buttons_Data['default_animation'];
			} else {
				$default_animation = 'flash';
			}
			
			if(is_array($AIO_Buttons_Data) && array_key_exists('default_color',$AIO_Buttons_Data)) {
				$default_color = $AIO_Buttons_Data['default_color'];
			} else {
				$default_color = 'red';
			}
			
			if(is_array($AIO_Buttons_Data) && array_key_exists('default_size',$AIO_Buttons_Data)) {
				$default_size = $AIO_Buttons_Data['default_size'];
			} else {
				$default_size = 'small';
			}
			
			if(is_array($AIO_Buttons_Data) && array_key_exists('default_text',$AIO_Buttons_Data)) {
				$default_text = $AIO_Buttons_Data['default_text'];
			} else {
				$default_text = __( 'Download Now', 'aiobtn' );
			}
			
			// Extract the attributes
			extract(shortcode_atts(array(
				'align' => 'none',
				'color' => $default_color,
				'icon' => 'none',
				'url' => '#',
				'animation' => $default_animation,
				'size' => $default_size,
				'target' => '_self',
				'relationship' => 'dofollow',
				'text' => $default_text
				), $atts));

      wp_enqueue_style( 'aiobtn-style', $AIO_Buttons_Path . '/css/display.css', array(), AIO_Buttons_Version );
				
			// You can now access the attribute values		
      $align_array = array('none','left','right','center');
      if (sizeof($align_array) == 0 || !in_array($align, $align_array)) { $align = 'none'; } 
    
      $animation_array = array('flash','shake','bounce','swing','pulse','none');
      if (sizeof($animation_array) == 0 || !in_array($animation, $animation_array)) { $animation = $default_animation; }
      
      $color_array = array('yellow','red','blue','black','brown','orange','green','purple','gray','pink');
      if (sizeof($color_array) == 0 || !in_array($color, $color_array)) { $color = $default_color; }
			
      $size_array = array('small','medium','large');
      if (sizeof($size_array) == 0 || !in_array($size, $size_array)) { $size = $default_size; }
			
			if($target == 'blank' || $target == '_blank') { $target = 'target="_blank" '; } else { $target = ''; }
      
      $relationship_array = array('dofollow','nofollow','prefetch','noreferrer','author','bookmark','help','search','tag','next','prev','license','alternate');
      if (sizeof($relationship_array) == 0 || !in_array($relationship, $relationship_array)) { $relationship = 'dofollow'; }
			
      if($icon == 'none') { $icon = ''; } else {
        $social_array = array('pinterest','dropbox','google-plus','jolicloud','yahoo','blogger','picasa','amazon','tumblr','wordpress','instapaper','evernote','xing','zootool','dribbble','deviantart','read-it-later','linked-in','forrst','pinboard','behance','github','youtube','skitch','foursquare','quora','badoo','spotify','stumbleupon','readability','facebook','twitter','instagram','posterous-spaces','vimeo','flickr','last-fm','rss','skype','e-mail','vine','myspace','goodreads','apple','windows','yelp','playstation','xbox','android','ios','wikipedia','pocket','steam','souncloud','slideshare','netflix','paypal','google-drive','linux-foundation','ebay');
        if(!in_array($icon, $social_array)) {
          wp_enqueue_style( 'aiobtn-glyphicons', $AIO_Buttons_Path . '/css/glyphicons.css', array(), AIO_Buttons_Version );
          if($size == 'small') {
            $icon = '<i class="glyphicons glyphicons-'.$icon.'"></i>'; 
          } elseif($size == 'medium') {
            $icon = '<i class="glyphicons glyphicons-'.$icon.' x2"></i>'; 
          } else {
            $icon = '<i class="glyphicons glyphicons-'.$icon.' x3"></i>'; 
          }
        } else {
          wp_enqueue_style( 'aiobtn-glyphicons-social', $AIO_Buttons_Path . '/css/glyphicons-social.css', array(), AIO_Buttons_Version );
          if($size == 'small') {
            $icon = '<i class="social social-'.$icon.'"></i>';
          } elseif($size == 'medium') {
            $icon = '<i class="social social-'.$icon.' x2"></i>';
          } else {
            $icon = '<i class="social social-'.$icon.' x3"></i>';
          }
        }
      }
      
      if($align == 'none'){ $align = 'aio-button'; } else { $align = 'aio-button-'.$align; }
      if($animation == 'none'){ $animation = '';  } else { $animation = 'aio-'.$animation; }
      $color = 'aio-'.$color;
      if($size == 'small'){ $size = ''; } else { $size = '-'.$size; }
      if($relationship == 'dofollow'){ $relationship = ''; } else { $relationship = ' rel="'.$relationship.'"'; }
      
      if($animation) {
        return '<div class="'.$align.'"><div class="'.$animation.'"><a '.$target.'href="'.$url.'" class="'.$color.''.$size.'" title="'.$text.'"'.$relationship.'>'.$icon.$text.'</a></div></div>';
      } else {
        return '<div class="'.$align.'"><a '.$target.'href="'.$url.'" class="'.$color.''.$size.'" title="'.$text.'"'.$relationship.'>'.$icon.$text.'</a></div>';
      }

		}
    
	} // end class
  
  $aiobtn_shortcode = new aiobtnShortcode();
  
}
?>