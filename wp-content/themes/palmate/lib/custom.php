<?php

// Custom functions

register_nav_menus(array('desktop_navigation'=>'Meny för desktop'));
register_nav_menus(array('mobile_navigation'=>'Meny för mobil enhet'));

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
