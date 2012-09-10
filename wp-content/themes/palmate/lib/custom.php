<?php

// Custom functions

function showAdminMessages()
{
  if ( user_can( 'manage_options' ) && !function_exists( 'p2p_register_connection_type' ) ) {
    echo '<div id="message" class="updated fade"><p><strong>Posts 2 Posts måste installeras!</strong></p></div>';
  }
}
add_action( 'admin_notices', 'showAdminMessages' );

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



/**
 * A cleaner walker for wp_nav_menu() customized for Palmate
 */
class Palmate_Nav_Walker extends Roots_Nav_Walker {
  
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
    global $wp_query;
    $indent = ($depth) ? str_repeat("\t", $depth) : '';
    $use_dropdown = $args->has_children && $depth < 1;
    $is_header = $depth == 1;
    $is_group = $depth >= 2;

    $slug = sanitize_title($item->title);
    $id = 'menu-' . $slug;

    $class_names = $value = '';
    $li_attributes = '';
    $classes = empty($item->classes) ? array() : (array) $item->classes;

    if ($use_dropdown) {
      $classes = array_filter($classes, array(&$this, 'check_current'));
      $classes[]      = 'dropdown';
      $li_attributes .= ' data-dropdown="dropdown"';
    }
    else {
      // Remove all classes and espacially the 'active' class
      unset($classes);
    }

    if ($custom_classes = get_post_meta($item->ID, '_menu_item_classes', true)) {
      foreach ($custom_classes as $custom_class) {
        $classes[] = $custom_class;
      }
    }

    $class_names = join(' ', apply_filters(array('nav_menu_css_class'), array_filter($classes), $item, $args));
    $class_names = $class_names ? ' class="' . $id . ' ' . esc_attr($class_names) . '"' : ' class="' . $id . '"';

    // Add divider before a header
    if ($is_header) {
      if ($this->first_in_level) {
        $this->first_in_level = FALSE;
      }
      else {
        $output .= $indent . '<li class="divider"></li>';
      }
    }
    $output .= $indent . '<li' . $class_names . '>';

    $attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
    $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
    $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
    $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url       ) .'"' : '';
    if ($use_dropdown) {
      $attributes .= ' class="dropdown-toggle" data-toggle="dropdown" data-target="#"';
    }
    else if ($is_header) {
      $attributes .= ' class="nav-header-palmate"';
    }
    else if ($is_group) {
      $attributes .= ' class="nav-group-palmate"';
    }

    $item_output  = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
//    $item_output .= $use_dropdown ? ' <b class="caret"></b>' : '';
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}

/**
 * Replace various active menu class names with "active"
 */
function roots_wp_nav_menu_objects($items, $args) {
	foreach ( (array) $items as $key => $menu_item ) {
    $menu_item->classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', (array)$menu_item->classes);
    $menu_item->classes = array_unique($menu_item->classes);
  }
  return $items;
}
add_filter('wp_nav_menu_objects', 'roots_wp_nav_menu_objects');

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
