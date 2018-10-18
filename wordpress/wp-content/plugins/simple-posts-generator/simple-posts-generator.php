<?php
/**
 * Plugin Name: Simple Posts Generator
 * Plugin URI: https://wordpress.org/plugins/simple-posts-generator/
 * Description: A simple User and Post generator for testers and developers
 * Version: 1.3.1
 * Author: Earl Evan Amante
 * Author URI: https://github.com/earlamante/
 * License: GPL2
 */
	/**
	 * Common fix for adding menu page in plugins
	 */
	include(ABSPATH . "wp-includes/pluggable.php"); 
	
	Class W3B_post_generator {
		var $plugin_name = 'Simple Post Generator';
		var $menu_title = 'Simple Post Generator';
		var $menu_slug	= 'simple-post-generator';

		var $statuses = array(
				'',
				'updated',
				'error'
			);

		var $status;
		var $page_link;
		var $author_id;
		var $msg;

		public function __construct() {
			$this->author_id = $this->get_author_id();

			$this->init();
			$this->process_requests();
		}

		public function init() {
			add_action( 'admin_menu', array($this, 'admin_menu') );

			$this->page_link = '?page=' . $this->menu_slug;
		}

		public function get_author_id() {
			$users = get_users( array( 'search' => 'post_generator@w3bkit.com' ) );

			if(!$users)
				$user_id = wp_create_user('__Post_Generator__', time(), 'post_generator@w3bkit.com');
			else
				$user_id = $users[0]->data->ID;
			
			return $user_id;
		}

		public function process_requests() {
			if( !empty($_POST['generate_posts']) ) {
				$this->generate_posts($_POST);
			}
		}

		public function generate_posts($data=array()) {
			if(!$data) return FALSE;
			extract($data);

			for($y=0; $y<$generate_post_qty ;$y++) {
				$post_data = array(
					'post_title' 		=> str_replace('{{i}}', ($y+1), $generate_post_title),
					'post_content'		=> $generate_post_title,
					'post_status'		=> 'publish',
					'post_type'			=> $generate_post_type,
					'post_author'		=> $this->author_id
				);
				if( !@wp_insert_post( $post_data ) ) {
					$this->msg = 'There was an error in creating the post';
					break;
				}
			}

			if(!$this->msg) {
				$this->status = 1;
				$this->msg = 'Posts Generated. <a href="edit.php?post_type='. $generate_post_type .'">View Generated Posts</a>';
			}
		}

		public function admin_menu() {
			add_submenu_page(
				'tools.php',
				$this->plugin_name,
				$this->menu_title,
				'manage_options',
				$this->menu_slug,
				array($this, 'print_page')
			);
		}

		public function print_page() {
			echo $this->get_template('main_container');
		}

		public function get_template($template_file='') {
			if( file_exists( dirname( __FILE__ ) . '/views/' . $template_file . '.php' ) ) {
				ob_start();
				include( dirname( __FILE__ ) . '/views/' . $template_file . '.php' );
				return ob_get_clean();
			}
			return FALSE;
		}

		public function get_link($links = array()) {
			if($links) {
				$link = $this->page_link;
				foreach( $links as $key => $val ) {
					$link .= '&' . $key . '=' . $val;
				}
				return $link;
			}
			return FALSE;
		}

		public function get_msg() {

			return $this->msg? '<div id="message" class="'. $this->statuses[$this->status] .' notice notice-success is-dismissible below-h2"><p>'.$this->msg.'</p></div>':'';
		}
	}

	$w3b_post_generator = new W3B_post_generator;
?>