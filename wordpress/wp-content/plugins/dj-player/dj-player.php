<?php
/*
Plugin Name: DJ Player
Description: Fully responsive music player with tracklist.
Version: 1.0
Author: WebArea | Vera Nedvyzhenko
*/


// Admin Scripts & Styles
function djpr_admin_scripts(){
	wp_enqueue_style('djpr_admin_styles', plugins_url('css/admin-style.css', __FILE__));
	wp_enqueue_style('djpr_admin_iris', plugins_url('css/iris.min.css', __FILE__));

	if( is_admin() ) { 
		$djpr_custom_color = get_option('djpr_options')['main_color'];
        wp_enqueue_style('wp-color-picker'); 
        wp_enqueue_script( 'djpr_admin_color', plugins_url( 'js/iris-admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
		wp_localize_script( 'djpr_admin_color', 'djpr_custom_color', $djpr_custom_color);
    }

	wp_enqueue_script('djpr_admin_script', plugins_url('js/admin-js.js', __FILE__));
}
add_action('admin_enqueue_scripts', 'djpr_admin_scripts');

// Scripts & Styles
function djpr_scripts(){
	wp_enqueue_style('djpr_font', '//fonts.googleapis.com/css?family=Open+Sans:400,600,700');
	wp_enqueue_style('djpr_customfont', plugins_url('css/djpr-font.css', __FILE__));
	wp_enqueue_style('djpr_slider', plugins_url('css/dj_slider.css', __FILE__));
	wp_enqueue_style('djpr_styles', plugins_url('css/style.css', __FILE__));

	$djpr_custom_color = get_option('djpr_options')['main_color'];
	if($djpr_custom_color != ''){
		$custom_css = '
			.djpr-player-container .djpr-cover{
				background: '.$djpr_custom_color.';
			}

			.djrp-list .djpr-list-song .djpr-playpause i{
				color: '.$djpr_custom_color.';
			}

			.djrp-list .djpr-list-song:hover .title,
			.djrp-list .djpr-list-song.active .title{
				color: '.$djpr_custom_color.';
			}

			.slimScrollBar{
				background: '.$djpr_custom_color.' !important;
			}
		';
	}
	wp_add_inline_style('djpr_styles', $custom_css);

	wp_enqueue_script('jquery', false, array('jquery'));
	wp_enqueue_script('jquery-ui-core', false, array('jquery'));
	wp_enqueue_script('jquery-ui-slider', false, array('jquery'));

	wp_enqueue_script('djpr_element_queries_sensor', plugins_url('js/ResizeSensor.js', __FILE__), array('jquery'), false, true);
	wp_enqueue_script('djpr_element_queries', plugins_url('js/ElementQueries.js', __FILE__), array('jquery'), false, true);
	wp_enqueue_script('djpr_slimscroll', plugins_url('js/jquery.slimscroll.js', __FILE__), array('jquery'), false, true);
	wp_enqueue_script('djpr_scripts', plugins_url('js/scripts.js', __FILE__), array('jquery'), false, true);
}
add_action('login_enqueue_scripts', 'djpr_scripts');
add_action( 'wp_enqueue_scripts', 'djpr_scripts' );

define( 'DJPR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'DJPR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Songs Post Type
function jdpr_post_type(){
	$labels = [
	'name' => 'DJ Player',
	'singular_name' => 'Song',
	'add_new' => 'Add Song',
	'add_new_item' => 'Add Song',
	'edit_item' => 'Edit Song',
	'search_items' => 'Search',
	'not_found' => 'No songs found',
	'not_found_in_trash' => 'No songs found',
	'all_items' => 'All Songs'
	];

	$args = [
	'labels' => $labels,
	'show_ui' => true,
	'menu_position' => 100,
	'supports' => ['title'],
	'menu_icon' => 'dashicons-format-audio',
	'has_archive' => 'djsong',
	'capability_type' => 'post',
	// 'taxonomies' => array('djsongs_categories'),
	'public' => true
	];

	register_post_type('djsong', $args);
}
add_action('init', 'jdpr_post_type');

// Add Categories
function djsongs_taxonomy() { 
	register_taxonomy(  
		'djsongs_categories',
		'djsong',
		array(  
			'hierarchical' => true,  
			'label' => 'Categories',
			'query_var' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'rewrite' => array(
				'slug' => 'djsong',
				'with_front' => false
				)
			)  
		);  
}  
// add_action( 'init', 'djsongs_taxonomy');

// Add option page
function djpr_submenu_page(){
	add_submenu_page(
		"edit.php?post_type=djsong",
		"Settings",
		"General Settings",
		"manage_options",
		"djpr_main_settings",
		"djpr_main_settings_function"
	);
}

add_action('admin_menu', 'djpr_submenu_page', 105 );

function djpr_main_settings_function(){
	?>
		<h1>DJ Player Settings</h1>
		<div class="djpr-settings-container">
			<form action="options.php" method="POST">
				<?php
					settings_fields( 'djpr_option_group' );
					do_settings_sections( 'djpr_settings_page' );
					submit_button();
				?>
			</form>
		</div>
	<?php
}

function djpr_register_settings() {
	register_setting( 'djpr_option_group', 'djpr_options');
	add_settings_section( 'djpr_general_settings', 'General Settings', '', 'djpr_settings_page' ); 
	add_settings_field('djpr_download', 'Enable download button', 'djpr_download_fill', 'djpr_settings_page', 'djpr_general_settings' );
	add_settings_field('djpr_main_color', 'Player Main Color', 'djpr_main_color_fill', 'djpr_settings_page', 'djpr_general_settings' );
	add_settings_field('djpr_shortcode', 'Player Shortcode', 'djpr_shortcode_fill', 'djpr_settings_page', 'djpr_general_settings' );
}
add_action('admin_init', 'djpr_register_settings');

function djpr_main_color_fill() {
	$val = get_option('djpr_options');
	$val = $val['main_color'];
	?>
	<input type="text" id="djpr_colorpicker" name="djpr_options[main_color]" value="<?php echo esc_attr( $val ) ?>" />
	<?php
}

function djpr_download_fill() {
	$val = get_option('djpr_options')['djpr_download'];
	?>
	<input type="checkbox" name="djpr_options[djpr_download]" value="1"<?php checked( 1 == $val ); ?> />
	<?php
}

function djpr_shortcode_fill() {
	echo '[djpr-player]';
}

// Add Meta Box
function djsongs_meta_box() {
	add_meta_box(
		'djsong_file_metabox',
		'Song File',
		'djsong_file_metabox_func',
		'djsong',
		'normal',
		'high'
		);
}
add_action('add_meta_boxes', 'djsongs_meta_box');

function djsong_file_metabox_func($object){
	wp_nonce_field(basename(__FILE__), "upload_djsong-nonce");

	$song_upload_id = esc_attr(get_post_meta($object->ID, 'upload_djsong_file', true ));
	$song_upload_link = esc_attr(get_post_meta($object->ID, 'upload_djsong_external', true ));

	$djpr_link_type_onload = 'style="display: none;"';
	$djpr_link_type_onload_file = 'style="display: block;"';
	$djpr_checkbox_check = '';
	if($song_upload_link != ''){
		$djpr_checkbox_check = 'checked="checked"';
		$djpr_link_type_onload = 'style="display: block;"';
		$djpr_link_type_onload_file = 'style="display: none;"';
	}

	$html .= '<div class="djpr_checkbox"><input '. $djpr_checkbox_check .' id="djpr_external" type="checkbox"><label for="djpr_external">External Link</label></div>';

	$html .= '<input '. $djpr_link_type_onload .' id="upload_djsong_external" type="text" name="upload_djsong_external" placeholder="https://www.example.com/example.mp3" value="'. $song_upload_link .'">';

	$html .= '<div class="djpr-medialink" '. $djpr_link_type_onload_file .'>';
	$html .= '<input id="upload_djsong" type="hidden" name="upload_djsong" value="' . $song_upload_id . '" />';
	if($song_upload_id == ''){
		$html .= '<input class="button-secondary" id="upload_djsong_button" type="button" value="Upload File" />';
	}else{
		$html .= '<div class="djpr_fileinfo"><div class="djpr_fileinfo_cont"><p><b>File URL:</b> '. wp_get_attachment_url($song_upload_id) .'</p><p><b>File Name:</b> '. get_the_title($song_upload_id) .'</p><p><b>File Size:</b> '. size_format(filesize(get_attached_file($song_upload_id)), 0) .'</p><div class="djpr_fileclose">Delete file</div></div></div>';
	}
	$html .= '</div>';

	echo $html;
}

function djpr_save_meta_fields( $post_id ) {
	if (!isset($_POST["upload_djsong-nonce"]) || !wp_verify_nonce($_POST["upload_djsong-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    if(isset($_POST["upload_djsong"])){
    	$upload_djsong = sanitize_text_field($_POST["upload_djsong"]);
    	update_post_meta($post_id, "upload_djsong_file", $upload_djsong);
    }

    if(isset($_POST["upload_djsong_external"])){
    	$upload_djsong_external = sanitize_text_field($_POST["upload_djsong_external"]);
    	update_post_meta($post_id, "upload_djsong_external", $upload_djsong_external);
    }
}
add_action('save_post', 'djpr_save_meta_fields' );
add_action('new_to_publish', 'djpr_save_meta_fields' );

// Add Shortcode
function djpr_shortcode(){
	ob_start();
	require_once(DJPR_PLUGIN_PATH . 'front-player.php');
	$djpr_content .= ob_get_clean();
	return $djpr_content;
}

add_shortcode('djpr-player', 'djpr_shortcode');

?>