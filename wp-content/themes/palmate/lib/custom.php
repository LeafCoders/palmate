<?php

// Custom functions

register_nav_menus(array('desktop_navigation'=>'Meny för desktop'));
register_nav_menus(array('mobile_navigation'=>'Meny för mobil enhet'));

function showAdminMessages()
{
  if ( user_can( 'manage_options' ) && !function_exists( 'register_field_group' ) ) {
    echo '<div id="message" class="updated fade"><p><strong>Advanced Custom Fields måste installeras!</strong></p></div>';
  }
}
add_action( 'admin_notices', 'showAdminMessages' );

/*

function palmate_register_connection_types() {
  if ( function_exists( 'p2p_register_connection_type' ) ) {
    // Connect post to pages
    p2p_register_connection_type( array(
      'name' => 'posts_to_pages',
      'from' => 'post',
      'to' => 'page',
      'admin_box' => 'any' ) );
    
    // Connect sermon to themes
    p2p_register_connection_type( array(
      'name' => 'sermons_to_themes',
      'from' => 'sermon',
      'to' => 'theme',
      'admin_box' => 'any' ) );
  }
}
add_action( 'wp_loaded', 'palmate_register_connection_types' );


function register_cpt_theme() {
    $labels = array( 
        'name' => _x( 'Teman', 'theme' ),
        'singular_name' => _x( 'Tema', 'theme' ),
        'add_new' => _x( 'Skapa nytt', 'theme' ),
        'add_new_item' => _x( 'Skapa nytt tema', 'theme' ),
        'edit_item' => _x( 'Redigera tema', 'theme' ),
        'new_item' => _x( 'Nytt tema', 'theme' ),
        'view_item' => _x( 'Visa tema', 'theme' ),
        'search_items' => _x( 'Sök tema', 'theme' ),
        'not_found' => _x( 'Hittade inga teman', 'theme' ),
        'not_found_in_trash' => _x( 'Hittade inga teman i papperskorgen', 'theme' ),
        'parent_item_colon' => _x( 'Förälder:', 'theme' ),
        'menu_name' => _x( 'Teman', 'theme' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Ett tema kan innehålla flera predikningar',
        'supports' => array( 'title', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => 'teman',
        'can_export' => true,
        'rewrite' => array( 'slug' => 'teman' ),
        'capability_type' => 'post'
    );

    register_post_type( 'theme', $args );
}
add_action( 'init', 'register_cpt_theme' );

function register_cpt_sermon() {
    $labels = array( 
        'name' => _x( 'Predikningar', 'sermon' ),
        'singular_name' => _x( 'Predikan', 'sermon' ),
        'add_new' => _x( 'Skapa ny', 'sermon' ),
        'add_new_item' => _x( 'Skapa ny predikan', 'sermon' ),
        'edit_item' => _x( 'Redigera predikan', 'sermon' ),
        'new_item' => _x( 'Ny predikan', 'sermon' ),
        'view_item' => _x( 'Visa predikan', 'sermon' ),
        'search_items' => _x( 'Sök predikan', 'sermon' ),
        'not_found' => _x( 'Hittade inga predikningar', 'sermon' ),
        'not_found_in_trash' => _x( 'Hittade inga predikningar i papperskorgen', 'sermon' ),
        'parent_item_colon' => _x( 'Tema:', 'sermon' ),
        'menu_name' => _x( 'Predikningar', 'sermon' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'En predikan kan kopplas till ett tema',
        'supports' => array( 'title', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => 'predikningar',
        'can_export' => true,
        'rewrite' => array( 'slug' => 'predikningar', 'with_front' => FALSE ),
        'capability_type' => 'post'
    );

    register_post_type( 'sermon', $args );
}
add_action( 'init', 'register_cpt_sermon' );
*/

/**
 * A cleaner walker for wp_nav_menu() customized for Palmate
 */
class Palmate_Nav_Walker extends Walker_Nav_Menu {
  
  private $first_in_level = FALSE;
  
  function start_lvl(&$output, $depth = 0, $args = array()) {
    if ($depth < 1) {
      $this->first_in_level = TRUE;
      $output .= "\n<ul class=\"dropdown-menu\">\n";
    }
  }

  function end_lvl(&$output, $depth = 0, $args = array()) {
    if ($depth < 1) {
      $this->first_in_level = FALSE;
      $output .= "</ul>\n";
    }
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args);

    if ($item->is_dropdown && ($depth === 0)) {
      $item_html = str_replace('<a', '<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"', $item_html);
    } elseif ($depth === 1) {
      $item_html = str_replace('<a', '<a class="nav-header-palmate" ', $item_html);
    } elseif ($depth === 2) {
      $item_html = str_replace('<a', '<a class="nav-group-palmate" ', $item_html);
    }

    $output .= $item_html;
  }
  
  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    // Remove 'active' class from menues
    unset($element->classes);

    // Only allow dropdown menu at depth 0
    $element->is_dropdown = !empty($children_elements[$element->ID]) && ($depth === 0);
    if ($element->is_dropdown) {
      $element->classes[] = 'dropdown';
    }

    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }
  
}

/**
 * Activate Palmate nav walker
 */
function palmate_nav_menu_args($args = '') {
  if (current_theme_supports('bootstrap-top-navbar')) {
    $roots_nav_menu_args['depth'] = 3;
  }

  $roots_nav_menu_args['walker'] = new Palmate_Nav_Walker();

  return array_merge($args, $roots_nav_menu_args);
}
add_filter('wp_nav_menu_args', 'palmate_nav_menu_args');

/**
 * Remove visual editor for pages. The visual editor does cleanups that removes valid html5 elements
 */
function palmate_page_can_richedit( $can ) {
    global $post;

    if ( 'page' == $post->post_type )
        return false;

    return $can;
}
add_filter( 'user_can_richedit', 'palmate_page_can_richedit' );

/**
 * Remove cleanup filters that rewrites <a> tags. A <a> tag may surround blocks in html5
 * but wpautop rewrites thoose tags to multiple tags.
 */
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

/**
 * the_slug is a missing function in WordPress. Keep it here until WordPress implements it
 */
function the_slug($echo = true){
  $slug = basename(get_permalink());
  if ($echo) echo $slug;
  return $slug;
}
