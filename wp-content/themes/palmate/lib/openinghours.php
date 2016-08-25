<?php

/**
 * Opening hours post type
 */
function register_cpt_openinghour() {

  // Register the post type
  $labels = array( 
    'name' => _x( 'Öppettider', 'openinghour' ),
    'singular_name' => _x( 'Öppettid', 'openinghour' ),
    'add_new' => _x( 'Skapa ny', 'openinghour' ),
    'add_new_item' => _x( 'Skapa ny öppettid', 'openinghour' ),
    'edit_item' => _x( 'Redigera öppettid', 'openinghour' ),
    'new_item' => _x( 'Ny öppettid', 'openinghour' ),
    'view_item' => _x( 'Visa öppettid', 'openinghour' ),
    'search_items' => _x( 'Sök öppettid', 'openinghour' ),
    'not_found' => _x( 'Hittade inga öppettider', 'openinghour' ),
    'not_found_in_trash' => _x( 'Hittade inga öppettider i papperskorgen', 'openinghour' ),
    'parent_item_colon' => _x( 'Förälder:', 'openinghour' ),
    'menu_name' => _x( 'Öppettider', 'openinghour' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'En öppettid innehåller öppettider för olika dagar',
    'supports' => array( 'title' ),
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'publicly_queryable' => false,
    'exclude_from_search' => true,
    'has_archive' => false,
    'query_var' => 'openinghour',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'oppettid', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-image.gif'),
    'capability_type' => 'openinghour'
  );
  register_post_type( 'openinghour', $args );

  global $wp_roles;
  $wp_roles->add_cap( 'administrator', 'edit_openinghour' );
  $wp_roles->add_cap( 'administrator', 'edit_openinghours' );
  $wp_roles->add_cap( 'administrator', 'edit_others_openinghours' );
  $wp_roles->add_cap( 'administrator', 'delete_openinghour' );
  $wp_roles->add_cap( 'administrator', 'publish_openinghours' );

  // Add special fields for openinghour settings
  if (function_exists("register_field_group")) {
    register_field_group(array (
      'id' => 'acf_oppettid',
      'title' => 'Öppettid',
      'fields' => array (
        array (
          'key' => 'field_57bdf0021ece1',
          'label' => 'Dag 1',
          'name' => 'day_1',
          'type' => 'text',
          'default_value' => 'Mån-Fre',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57bdf0ae1ece2',
          'label' => 'Tider 1',
          'name' => 'times_1',
          'type' => 'text',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57bdf0d21ece4',
          'label' => 'Dag 2',
          'name' => 'day_2',
          'type' => 'text',
          'default_value' => 'Lör',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57bdf0f41ece7',
          'label' => 'Tider 2',
          'name' => 'times_2',
          'type' => 'text',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57bdf0e71ece5',
          'label' => 'Dag 3',
          'name' => 'day_3',
          'type' => 'text',
          'default_value' => 'Sön',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57bdf0f31ece6',
          'label' => 'Tider 3',
          'name' => 'times_3',
          'type' => 'text',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
        array (
          'key' => 'field_57bdf1171ece8',
          'label' => 'Tillfällig information',
          'name' => 'temporary_information',
          'type' => 'text',
          'instructions' => 'Texten kommer att visas med röd färg för att indikera att texten är tillfällig',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'formatting' => 'none',
          'maxlength' => '',
        ),
      ),
      'location' => array (
        array (
          array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'openinghour',
            'order_no' => 0,
            'group_no' => 0,
          ),
        ),
      ),
      'options' => array (
        'position' => 'normal',
        'layout' => 'no_box',
        'hide_on_screen' => array (
          0 => 'the_content',
          1 => 'excerpt',
          2 => 'custom_fields',
          3 => 'discussion',
          4 => 'comments',
          5 => 'revisions',
          6 => 'slug',
          7 => 'author',
          8 => 'format',
          9 => 'featured_image'
        ),
      ),
      'menu_order' => 0,
    ));
  }
}
add_action( 'init', 'register_cpt_openinghour' );


/**
 * Opening hours shortcode [OpeningHours titles="office,cafe", showtitles="true"]
 */
function palmate_openinghours_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'titles' => '',
    'showtitles' => 'true'
  ), $atts ) );

  $args = array(
    'post_type' => 'openinghour',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts' => 1
  );
  $openinghours_query = null;
  $openinghours_query = new WP_Query($args);

  $temporary_content = '';
  $row_content = '';

  while ($openinghours_query->have_posts()) {
    $openinghours_query->the_post();
    $title = the_title( '', '', false );

    if ( stripos( $titles, $title ) === false ) {
      continue;
    }

    $temporary_information = get_field( 'temporary_information' );
    $times1 = get_field( 'times_1' );
    $times2 = get_field( 'times_2' );
    $times3 = get_field( 'times_3' );

    if ( !empty( $temporary_information ) ) {
      $temporary_content .= '<p style="color: red">' . $temporary_information . '</p>';
    }

    $col1 = '';
    $col2 = '';
    if ( !empty( $times1 ) ) {
      $col1 .= get_field( 'day_1' );
      $col2 .= $times1;
    }
    if ( !empty( $times2 ) ) {
      $col1 .= '<br>' . get_field( 'day_2' );
      $col2 .= '<br>' . $times2;
    }
    if ( !empty( $times3 ) ) {
      $col1 .= '<br>' . get_field( 'day_3' );
      $col2 .= '<br>' . $times3;
    }
    if ( $showtitles == 'true' ) {
      $row_content .= '<tr><td colspan="3"><b>' . $title . '</b></td><tr>';
    }
    $row_content .= '<tr><td>' . $col1 . '</td><td>&nbsp;&nbsp;&nbsp;</td><td>' . $col2 . '</td></tr>';
  }
  wp_reset_query();
  return $temporary_content . '<table><tbody>' . $row_content . '</tbody></table>';
}

add_shortcode( 'OpeningHours', 'palmate_openinghours_shortcode' );
