<?php

/**
 * Personnel post type
 */
function register_cpt_personnel() {

  // Register the post type
  $labels = array( 
    'name' => _x( 'Personal', 'personnel' ),
    'singular_name' => _x( 'Personal', 'personnel' ),
    'add_new' => _x( 'Skapa ny', 'personnel' ),
    'add_new_item' => _x( 'Skapa ny personal', 'personnel' ),
    'edit_item' => _x( 'Redigera personal', 'personnel' ),
    'new_item' => _x( 'Ny personal', 'personnel' ),
    'view_item' => _x( 'Visa personal', 'personnel' ),
    'search_items' => _x( 'Sök personal', 'personnel' ),
    'not_found' => _x( 'Hittade ingen personal', 'personnel' ),
    'not_found_in_trash' => _x( 'Hittade ingen personal i papperskorgen', 'personnel' ),
    'parent_item_colon' => _x( 'Förälder:', 'personnel' ),
    'menu_name' => _x( 'Personal', 'personnel' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'Info om all personal kan visas i en sida via taggen [Personal]',
    'supports' => array( 'title' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => false,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => false,
    'query_var' => 'personnel',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'personal', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-other.gif'),
    'capability_type' => 'personnel'
  );
  register_post_type( 'personnel', $args );

  global $wp_roles;
  $wp_roles->add_cap( 'administrator', 'edit_personnel' );
  $wp_roles->add_cap( 'administrator', 'edit_personnels' );
  $wp_roles->add_cap( 'administrator', 'edit_others_personnels' );
  $wp_roles->add_cap( 'administrator', 'delete_personnel' );
  $wp_roles->add_cap( 'administrator', 'publish_personnels' );

  if (function_exists( "register_field_group" ) ) {
    register_field_group(array (
      'id' => '5083049be407a',
      'title' => 'Personal',
      'fields' => array (
        0 => array (
          'label' => 'Namn',
          'name' => 'name',
          'type' => 'text',
          'instructions' => 'Personens förnamn och efternamn. Samma som anges i titelraden.',
          'required' => '1',
          'default_value' => '',
          'formatting' => 'none',
          'key' => 'field_50830489c715b',
          'order_no' => '0',
        ),
        1 => array (
          'label' => 'E-post',
          'name' => 'email',
          'type' => 'text',
          'instructions' => 'E-postadress till personen',
          'required' => '0',
          'default_value' => '',
          'formatting' => 'none',
          'key' => 'field_50830489c8302',
          'order_no' => '1',
        ),
        2 => array (
          'label' => 'Telefonnummer',
          'name' => 'phone',
          'type' => 'text',
          'instructions' => 'Telefonnummer till personen',
          'required' => '0',
          'default_value' => '',
          'formatting' => 'none',
          'key' => 'field_50830489c783d',
          'order_no' => '2',
        ),
        3 => array (
          'label' => 'Beskrivning',
          'name' => 'description',
          'type' => 'text',
          'instructions' => 'T.ex. "Pastor" eller "Receptionist"',
          'required' => '0',
          'default_value' => '',
          'formatting' => 'none',
          'key' => 'field_50830489c870c',
          'order_no' => '3',
        ),
        4 => array (
          'label' => 'Bild',
          'name' => 'image',
          'type' => 'image',
          'instructions' => 'Bild i storleken 100x150',
          'required' => '0',
          'save_format' => 'url',
          'preview_size' => 'full',
          'key' => 'field_50830489cc8b3',
          'order_no' => '4',
        ),
      ),
      'location' => array (
        'rules' => array (
          0 => array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'personnel',
            'order_no' => '0',
          ),
        ),
        'allorany' => 'all',
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
add_action( 'init', 'register_cpt_personnel' );

function palmate_get_personnel_text() {
  $text = '';
  $imgUrl = get_field( 'image' );
  if ( empty( $imgUrl ) ) {
    $imgUrl = get_template_directory_uri() . '/assets/img/person_unknown.png';
  }

  // Add unvisible text in email address to trick the boots
  $email = get_field( 'email' );
  if ( strpos( $email, EMAIL_DOMAIN ) != false ) {
    $email = str_replace( EMAIL_DOMAIN, '<i style="display: none;">.felaktig</i>' . EMAIL_DOMAIN, get_field( 'email' ) );
  }
  $text .= '<div class="row-fluid marginBottom">';
  $text .= '  <div class="span3">';
  $text .= '    <img style="max-width: 100px;" class="img-polaroid imgCenter" alt="Bild på person" src="' . $imgUrl . '" >';
  $text .= '  </div>';
  $text .= '  <div class="span9">';
  $text .= '    <h3>' . get_field( 'name' ) . '</h3>';
  $text .= '    <p><strong>' . get_field( 'description' ) . '</strong></p>';

  if ( !empty( $email ) ) {
    $text .= '    <p>E-post:  ' . $email . '</p>';
  }
  $phone = get_field( 'phone' );
  if ( !empty( $phone ) ) {
    $text .= '    <p>Tel:  ' . $phone . '</p>';
   }
  $text .= '  </div>';
  $text .= '</div>';
  return $text;
}

/**
 * Personnel shortcode [Personal]
 */
function palmate_personnel_shortcode( $atts ) {
  $args = array(
    'post_type' => 'personnel',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts'=> 1
  );
  $personnel_query = null;
  $personnel_query = new WP_Query($args);

  $text = '';
  while ( $personnel_query->have_posts() ) {
    $personnel_query->the_post();
    $text .= palmate_get_personnel_text();
    $text .= '<div class="dividerHor marginBottom visible-phone"></div>';
  }
  wp_reset_query();
  return $text;
}
add_shortcode( 'Personal', 'palmate_personnel_shortcode' );  


/**
 * Church leader post type
 */
function register_cpt_churchleader() {

  // Register the post type
  $labels = array( 
    'name' => _x( 'Församlingsledare', 'churchleader' ),
    'singular_name' => _x( 'Församlingsledare', 'churchleader' ),
    'add_new' => _x( 'Skapa ny', 'churchleader' ),
    'add_new_item' => _x( 'Skapa ny församlingsledare', 'churchleader' ),
    'edit_item' => _x( 'Redigera församlingsledare', 'churchleader' ),
    'new_item' => _x( 'Ny församlingsledare', 'churchleader' ),
    'view_item' => _x( 'Visa församlingsledarna', 'churchleader' ),
    'search_items' => _x( 'Sök församlingsledare', 'churchleader' ),
    'not_found' => _x( 'Hittade ingen församlingsledare', 'churchleader' ),
    'not_found_in_trash' => _x( 'Hittade ingen församlingsledare i papperskorgen', 'churchleader' ),
    'parent_item_colon' => _x( 'Förälder:', 'churchleader' ),
    'menu_name' => _x( 'Församl.ledare', 'churchleader' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'Info om alla församlingsledare kan visas i en sida via taggen [Församlingsledare]',
    'supports' => array( 'title' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => false,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => false,
    'query_var' => 'churchleader',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'forsamlingsledare', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-other.gif'),
    'capability_type' => 'churchleader'
  );
  register_post_type( 'churchleader', $args );

  global $wp_roles;
  $wp_roles->add_cap( 'administrator', 'edit_churchleader' );
  $wp_roles->add_cap( 'administrator', 'edit_churchleaders' );
  $wp_roles->add_cap( 'administrator', 'edit_others_churchleaders' );
  $wp_roles->add_cap( 'administrator', 'delete_churchleader' );
  $wp_roles->add_cap( 'administrator', 'publish_churchleaders' );

  if (function_exists( "register_field_group" ) ) {
    register_field_group(array (
      'id' => '508304907abe4',
      'title' => 'Församlingsledare',
      'fields' => array (
        0 => array (
          'label' => 'Titel',
          'name' => 'description',
          'type' => 'text',
          'instructions' => 'Om fältet utelämnas visas texten "Församlingsledare".',
          'required' => '0',
          'default_value' => 'Församlingsledare',
          'formatting' => 'none',
          'key' => 'field_5088830149c748',
          'order_no' => '0',
        ),
        1 => array (
          'label' => 'Bild',
          'name' => 'image',
          'type' => 'image',
          'instructions' => 'Bild i storleken 100x150',
          'required' => '0',
          'save_format' => 'url',
          'preview_size' => 'full',
          'key' => 'field_50830488b39cc',
          'order_no' => '4',
        ),
      ),
      'location' => array (
        'rules' => array (
          0 => array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'churchleader',
            'order_no' => '0',
          ),
        ),
        'allorany' => 'all',
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
add_action( 'init', 'register_cpt_churchleader' );

function palmate_get_churchleader_text() {
  $text = '';
  $imgUrl = get_field( 'image' );
  if ( empty( $imgUrl ) ) {
    $imgUrl = get_template_directory_uri() . '/assets/img/person_unknown.png';
  }
  $description = get_field( 'description' );
  if ( empty( $description ) ) {
    $description = 'Församlingsledare';
  }

  $text .= '<div class="row-fluid marginBottom">';
  $text .= '  <div class="span3">';
  $text .= '    <img style="max-width: 100px;" class="img-polaroid imgCenter" alt="Bild på person" src="' . $imgUrl . '" >';
  $text .= '  </div>';
  $text .= '  <div class="span9">';
  $text .= '    <h3>' . the_title( '', '', false ) . '</h3>';
  $text .= '    <p><strong>' . $description . '</strong></p>';
  $text .= '  </div>';
  $text .= '</div>';
  return $text;
}

/**
 * Church leader shortcode [Församlingsledare]
 */
function palmate_churchleader_shortcode( $atts ) {
  $args = array(
    'post_type' => 'churchleader',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts'=> 1
  );
  $churchleader_query = null;
  $churchleader_query = new WP_Query($args);

  $text = '';
  while ( $churchleader_query->have_posts() ) {
    $churchleader_query->the_post();
    $text .= palmate_get_churchleader_text();
    $text .= '<div class="dividerHor marginBottom visible-phone"></div>';
  }
  wp_reset_query();
  return $text;
}
add_shortcode( 'Församlingsledare', 'palmate_churchleader_shortcode' );  


/**
 * Board leader post type
 */
function register_cpt_boardleader() {

  // Register the post type
  $labels = array( 
    'name' => _x( 'Rådsordförande', 'boardleader' ),
    'singular_name' => _x( 'Rådsordförande', 'boardleader' ),
    'add_new' => _x( 'Skapa ny', 'boardleader' ),
    'add_new_item' => _x( 'Skapa ny rådsordförande', 'boardleader' ),
    'edit_item' => _x( 'Redigera rådsordförande', 'boardleader' ),
    'new_item' => _x( 'Ny rådsordförande', 'boardleader' ),
    'view_item' => _x( 'Visa rådsordförande', 'boardleader' ),
    'search_items' => _x( 'Sök rådsordförande', 'boardleader' ),
    'not_found' => _x( 'Hittade ingen rådsordförande', 'boardleader' ),
    'not_found_in_trash' => _x( 'Hittade ingen rådsordförande i papperskorgen', 'boardleader' ),
    'parent_item_colon' => _x( 'Förälder:', 'boardleader' ),
    'menu_name' => _x( 'Rådsordf.', 'boardleader' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'Info om alla rådsordföranden kan visas i en sida via taggen [Rådsordföranden]',
    'supports' => array( 'title' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => false,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => false,
    'query_var' => 'boardleader',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'radsordforande', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-other.gif'),
    'capability_type' => 'boardleader'
  );
  register_post_type( 'boardleader', $args );

  global $wp_roles;
  $wp_roles->add_cap( 'administrator', 'edit_boardleader' );
  $wp_roles->add_cap( 'administrator', 'edit_boardleaders' );
  $wp_roles->add_cap( 'administrator', 'edit_others_boardleaders' );
  $wp_roles->add_cap( 'administrator', 'delete_boardleader' );
  $wp_roles->add_cap( 'administrator', 'publish_boardleaders' );

  if (function_exists( "register_field_group" ) ) {
    register_field_group(array (
      'id' => '5083049abe407',
      'title' => 'Rådsordförande',
      'fields' => array (
        0 => array (
          'label' => 'Namn',
          'name' => 'name',
          'type' => 'text',
          'instructions' => 'Rådsordförarens förnamn och efternamn. Ange rådets namn i titelraden.',
          'required' => '1',
          'default_value' => '',
          'formatting' => 'none',
          'key' => 'field_5083048b9c715',
          'order_no' => '0',
        ),
        1 => array (
          'label' => 'E-post',
          'name' => 'email',
          'type' => 'text',
          'instructions' => 'E-postadress till rådet',
          'required' => '0',
          'default_value' => '',
          'formatting' => 'none',
          'key' => 'field_50848c0937843',
          'order_no' => '1',
        ),
        2 => array (
          'label' => 'Bild',
          'name' => 'image',
          'type' => 'image',
          'instructions' => 'Bild i storleken 100x150',
          'required' => '0',
          'save_format' => 'url',
          'preview_size' => 'full',
          'key' => 'field_508304839cc8b',
          'order_no' => '2',
        ),
      ),
      'location' => array (
        'rules' => array (
          0 => array (
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'boardleader',
            'order_no' => '0',
          ),
        ),
        'allorany' => 'all',
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
add_action( 'init', 'register_cpt_boardleader' );

function palmate_get_boardleader_text() {
  $text = '';
  $imgUrl = get_field( 'image' );
  if ( empty( $imgUrl ) ) {
    $imgUrl = get_template_directory_uri() . '/assets/img/person_unknown.png';
  }
  $email = get_field( 'email' );
  if ( strpos( $email, EMAIL_DOMAIN ) != false ) {
    $email = str_replace( EMAIL_DOMAIN, '<i style="display: none;">.felaktig</i>' . EMAIL_DOMAIN, get_field( 'email' ) );
  }

  $text .= '<div class="row-fluid marginBottom">';
  $text .= '  <div class="span3">';
  $text .= '    <img style="max-width: 100px;" class="img-polaroid imgCenter" alt="Bild på person" src="' . $imgUrl . '" >';
  $text .= '  </div>';
  $text .= '  <div class="span9">';
  $text .= '    <h3>' . the_title( '', '', false ) . '</h3>';
  $text .= '    <p>' . get_field( 'name' ) . ' (Ordförande)</p>';
  if ( !empty( $email ) ) {
    $text .= '    <p>E-post:  ' . $email . '</p>';
  }
  $text .= '  </div>';
  $text .= '</div>';
  return $text;
}

/**
 * Board leader shortcode [Rådsordföranden]
 */
function palmate_boardleader_shortcode( $atts ) {
  $args = array(
    'post_type' => 'boardleader',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts' => 1
  );
  $boardleader_query = null;
  $boardleader_query = new WP_Query($args);

  $text = '';
  while ( $boardleader_query->have_posts() ) {
    $boardleader_query->the_post();
    $text .= palmate_get_boardleader_text();
    $text .= '<div class="dividerHor marginBottom visible-phone"></div>';
  }
  wp_reset_query();
  return $text;
}
add_shortcode( 'Rådsordföranden', 'palmate_boardleader_shortcode' );  
