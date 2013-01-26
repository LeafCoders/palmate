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
    'exclude_from_search' => true,
    'has_archive' => false,
    'query_var' => 'personnel',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'personnel', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-other.gif'),
    'capability_type' => 'page'
  );
  register_post_type( 'personnel', $args );

  if (function_exists( "register_field_group" ) ) {
  	register_field_group(array (
  		'id' => '5083049be407a',
  		'title' => 'Personal',
  		'fields' => 
  		array (
  			0 => 
  			array (
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
  			1 => 
  			array (
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
  			2 => 
  			array (
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
  			3 => 
  			array (
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
  			4 => 
  			array (
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
  		'location' => 
  		array (
  			'rules' => 
  			array (
  				0 => 
  				array (
  					'param' => 'post_type',
  					'operator' => '==',
  					'value' => 'personnel',
  					'order_no' => '0',
  				),
  			),
  			'allorany' => 'all',
  		),
  		'options' => 
  		array (
  			'position' => 'normal',
  			'layout' => 'no_box',
  			'hide_on_screen' => 
  			array (
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
  $query = new WP_Query($args);

  $text = '';
  while ( $query->have_posts() ) {
    $query->the_post();

    $imgUrl = get_field( 'image' );
    if ( empty( $imgUrl ) ) {
      $imgUrl = '/assets/img/person_unknown.png';
    }

    // Add unvisible text in email address to trick the boots
    $email = get_field( 'email' );
    if ( strpos( $email, '@ryttargardskyrkan.se' ) != false ) {
      $email = str_replace( '@ryttargardskyrkan.se', '<i style="display: none;">.felaktig</i>@ryttargardskyrkan.se', get_field( 'email' ) );
    }
    $text .= '<div class="row-fluid marginBottom">';
    $text .= '  <div class="span3">';
    $text .= '    <img style="max-width: 100px;" class="img-polaroid imgCenter" alt="Bild på person" src="' . $imgUrl . '" />';
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
    $text .= '<div class="dividerHor marginBottom visible-phone"></div>';
  }
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
    'exclude_from_search' => true,
    'has_archive' => false,
    'query_var' => 'churchleader',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'churchleader', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-other.gif'),
    'capability_type' => 'page'
  );
  register_post_type( 'churchleader', $args );

  if (function_exists( "register_field_group" ) ) {
  	register_field_group(array (
  		'id' => '508304907abe4',
  		'title' => 'Församlingsledare',
  		'fields' => 
  		array (
  			0 => 
  			array (
  				'label' => 'Namn',
  				'name' => 'name',
  				'type' => 'text',
  				'instructions' => 'Församlingsledarens förnamn och efternamn. Samma som anges i titelraden.',
  				'required' => '1',
  				'default_value' => '',
  				'formatting' => 'none',
  				'key' => 'field_508304815b9c7',
  				'order_no' => '0',
  			),
  			1 => 
  			array (
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
  		'location' => 
  		array (
  			'rules' => 
  			array (
  				0 => 
  				array (
  					'param' => 'post_type',
  					'operator' => '==',
  					'value' => 'churchleader',
  					'order_no' => '0',
  				),
  			),
  			'allorany' => 'all',
  		),
  		'options' => 
  		array (
  			'position' => 'normal',
  			'layout' => 'no_box',
  			'hide_on_screen' => 
  			array (
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
  $query = new WP_Query($args);

  $text = '';
  while ( $query->have_posts() ) {
    $query->the_post();

    $imgUrl = get_field( 'image' );
    if ( empty( $imgUrl ) ) {
      $imgUrl = '/assets/img/person_unknown.png';
    }

    $text .= '<div class="row-fluid marginBottom">';
    $text .= '  <div class="span3">';
    $text .= '    <img style="max-width: 100px;" class="img-polaroid imgCenter" alt="Bild på person" src="' . $imgUrl . '" />';
    $text .= '  </div>';
    $text .= '  <div class="span9">';
    $text .= '    <h3>' . get_field( 'name' ) . '</h3>';
    $text .= '  </div>';
    $text .= '</div>';
    $text .= '<div class="dividerHor marginBottom visible-phone"></div>';
  }
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
    'view_item' => _x( 'Visa rådsordförandena', 'boardleader' ),
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
    'exclude_from_search' => true,
    'has_archive' => false,
    'query_var' => 'boardleader',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'boardleader', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-other.gif'),
    'capability_type' => 'page'
  );
  register_post_type( 'boardleader', $args );

  if (function_exists( "register_field_group" ) ) {
  	register_field_group(array (
  		'id' => '5083049abe407',
  		'title' => 'Rådsordförande',
  		'fields' => 
  		array (
  			0 => 
  			array (
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
  			1 => 
  			array (
  				'label' => 'Bild',
  				'name' => 'image',
  				'type' => 'image',
  				'instructions' => 'Bild i storleken 100x150',
  				'required' => '0',
  				'save_format' => 'url',
  				'preview_size' => 'full',
  				'key' => 'field_508304839cc8b',
  				'order_no' => '1',
  			),
  		),
  		'location' => 
  		array (
  			'rules' => 
  			array (
  				0 => 
  				array (
  					'param' => 'post_type',
  					'operator' => '==',
  					'value' => 'boardleader',
  					'order_no' => '0',
  				),
  			),
  			'allorany' => 'all',
  		),
  		'options' => 
  		array (
  			'position' => 'normal',
  			'layout' => 'no_box',
  			'hide_on_screen' => 
  			array (
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
  $query = new WP_Query($args);

  $text = '';
  while ( $query->have_posts() ) {
    $query->the_post();

    $imgUrl = get_field( 'image' );
    if ( empty( $imgUrl ) ) {
      $imgUrl = '/assets/img/person_unknown.png';
    }

    $text .= '<div class="row-fluid marginBottom">';
    $text .= '  <div class="span3">';
    $text .= '    <img style="max-width: 100px;" class="img-polaroid imgCenter" alt="Bild på person" src="' . $imgUrl . '" />';
    $text .= '  </div>';
    $text .= '  <div class="span9">';
    $text .= '    <h3>' . the_title( '', '', false ) . '</h3>';
    $text .= '    <p>' . get_field( 'name' ) . '</p>';
    $text .= '  </div>';
    $text .= '</div>';
    $text .= '<div class="dividerHor marginBottom visible-phone"></div>';
  }
  return $text;
}
add_shortcode( 'Rådsordföranden', 'palmate_boardleader_shortcode' );  
