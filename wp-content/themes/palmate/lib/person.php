<?php

/**
 * Person post type
 */
function register_cpt_person() {

  // Register the post type
  $labels = array( 
    'name' => _x( 'Personer', 'person' ),
    'singular_name' => _x( 'Person', 'person' ),
    'add_new' => _x( 'Skapa ny', 'person' ),
    'add_new_item' => _x( 'Skapa ny person', 'person' ),
    'edit_item' => _x( 'Redigera person', 'person' ),
    'new_item' => _x( 'Ny person', 'person' ),
    'view_item' => _x( 'Visa person', 'person' ),
    'search_items' => _x( 'Sök person', 'person' ),
    'not_found' => _x( 'Hittade inga personer', 'person' ),
    'not_found_in_trash' => _x( 'Hittade inga personer i papperskorgen', 'person' ),
    'parent_item_colon' => _x( 'Förälder:', 'person' ),
    'menu_name' => _x( 'Personer', 'person' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'En person kan visas i en sida via t.ex. [Person namn="Fredrik Lignell"]',
    'supports' => array( 'title' ),
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => true,
    'has_archive' => false,
    'query_var' => 'person',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'person', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/comment-grey-bubble.png'),
    'capability_type' => 'page'
  );
  register_post_type( 'person', $args );

  if (function_exists( "register_field_group" ) ) {
  	register_field_group(array (
  		'id' => '5083049be407a',
  		'title' => 'Person',
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
  				'instructions' => 'T.ex. "Pastor", "Receptionist" eller "Cellgruppsråd"',
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
  				'instructions' => 'Bild i storleken 130x190',
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
  					'value' => 'person',
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
  				9 => 'featured_image',
  			),
  		),
  		'menu_order' => 0,
  	));
  }
}
add_action( 'init', 'register_cpt_person' );


/**
 * Person shortcode [person namn="" titel="" epost="" tele="" bild=""]
 */
/*
function palmate_person_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'namn' => 'Namn saknas',
    'titel' => '',
    'epost' => '',
    'tele' => '',
    'bild' => 'UnknownPerson.png'
  ), $atts ) );  


  $text = '<div class="person">';
  $text .= '<img src="./assets/' . $bild . '" />';
  $text .= '<p class="person-name">' . $namn . '</p>';
  $text .= '<p class="person-title">' . $titel . '</p>';
  $text .= '<p class="person-mail">' . $epost . '</p>';
  $text .= '<p class="person-tele">' . $tele . '</p>';
  $text .= '</div>';

  return $text;
}
add_shortcode( 'person', 'palmate_person_shortcode' );  
*/
/**
 * Person shortcode [Person namn=""]
 */
function person_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'namn' => ''
  ), $atts ) );  

  $args = array(
    'name' => $namn,
    'post_type' => 'person',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts'=> 1
  );
  $query = new WP_Query($args);
  
  $text = '';
  if ( $query->have_posts() ) {
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
    $text  = '<div class="person clearfix">';
    $text .= '  <img class="img-polaroid" alt="Bild på person" src="' . $imgUrl . '" />';
    $text .= '  <h4>' . get_field( 'name' ) . '</h4>';
    $text .= '  <p><strong>' . get_field( 'description' ) . '</strong></p><br>';

    if ( !empty( $email ) ) {
      $text .= '  <p><i class="icon-envelope"></i>  ' . $email . '</p>';
    }
    $phone = get_field( 'phone' );
    if ( !empty( $phone ) ) {
      $text .= '  <p><i class="icon-th"></i>  ' . $phone . '</p>';
     }
    $text .= '</div>';
  }
  return $text;
}
add_shortcode( 'Person', 'person_shortcode' );  



