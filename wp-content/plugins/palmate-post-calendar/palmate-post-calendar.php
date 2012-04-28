<?php
/*
Plugin Name: palmate-post-calendar
Plugin URI: http://github.com/LeafCoders/palmate
Description: A calendar view that can be put inside a post
Version: 0.1
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( "Can't load this file directly" );
}

class PalmatePostCalendar
{
	function __construct() {
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
	}
	
	function action_admin_init() {
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons', array( $this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
		}
	}

	function filter_mce_button( $buttons ) {
		array_push( $buttons, '|', 'btn_Palmate_InsCal' );
		return $buttons;
	}
	
	function filter_mce_plugin( $plugins ) {
		$plugins['palmateCalendar'] = plugin_dir_url( __FILE__ ) . 'js/editor_plugin.js';
		return $plugins;
	}
}

$calendar = new PalmatePostCalendar();