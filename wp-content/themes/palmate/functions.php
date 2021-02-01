<?php

if (!defined('WP_DEBUG')) {
  die('Direct access forbidden.');
}


function palmate_wp_enqueue_scripts() {
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action( 'wp_enqueue_scripts', 'palmate_wp_enqueue_scripts' );


// Block Patterns
require get_stylesheet_directory() . '/inc/block-patterns.php';
