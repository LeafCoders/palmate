<?php

/**
 * Info box post type
 */
function register_cpt_infobox() {

  // Register the post type
  $labels = array( 
    'name' => _x( 'Infoboxar', 'infobox' ),
    'singular_name' => _x( 'Infobox', 'infobox' ),
    'add_new' => _x( 'Skapa ny', 'infobox' ),
    'add_new_item' => _x( 'Skapa ny infobox', 'infobox' ),
    'edit_item' => _x( 'Redigera infobox', 'infobox' ),
    'new_item' => _x( 'Ny infobox', 'infobox' ),
    'view_item' => _x( 'Visa infobox', 'infobox' ),
    'search_items' => _x( 'Sök infobox', 'infobox' ),
    'not_found' => _x( 'Hittade inga infoboxar', 'infobox' ),
    'not_found_in_trash' => _x( 'Hittade inga infoboxar i papperskorgen', 'infobox' ),
    'parent_item_colon' => _x( 'Förälder:', 'infobox' ),
    'menu_name' => _x( 'Infoboxar', 'infobox' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'En infobox ha en egen sida eller länkas mot en annan sida',
    'supports' => array( 'title', 'editor', 'thumbnail' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => false,
    'query_var' => 'infobox',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'infobox', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-image.gif'),
    'capability_type' => 'page'
  );
  register_post_type( 'infobox', $args );

  // Add special fields for Infobox settings
  if (function_exists( "register_field_group" ) ) {
    register_field_group( array(
      'id' => '5053a3598e93e',
      'title' => 'Inställningar Infobox',
      'fields' => 
      array (
        0 => 
        array (
          'key' => 'field_5057889f06efc',
          'label' => 'Bild',
          'name' => 'infobox_image',
          'type' => 'image',
          'instructions' => 'Ange bild att visa i infoboxen. Storleken ska vara ca 300x180 pixlar.',
          'required' => '0',
          'save_format' => 'url',
          'preview_size' => 'medium',
          'order_no' => '0',
        ),
        1 => 
        array (
          'key' => 'field_505786e9d26d5',
          'label' => 'Slutdatum',
          'name' => 'infobox_enddate',
          'type' => 'date_picker',
          'instructions' => 'Ange ett datum då infoboxen ska sluta att visas.',
          'required' => '1',
          'date_format' => 'yymmdd',
          'display_format' => 'yy-mm-dd',
          'order_no' => '1',
        ),
        2 => 
        array (
          'key' => 'field_50538ab1443fd',
          'label' => 'Länk',
          'name' => 'infobox_link',
          'type' => 'text',
          'instructions' => 'Ange en länk till en sida om du vill att den sidan ska visas då användaren trycker på infoboxen. Lämna den tom ifall du vill att denna post ska visas.',
          'required' => '0',
          'default_value' => '',
          'formatting' => 'html',
          'order_no' => '0',
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
            'value' => 'infobox',
            'order_no' => '0',
          ),
        ),
        'allorany' => 'all',
      ),
      'options' => 
      array (
        'position' => 'side',
        'layout' => 'default',
        'hide_on_screen' => 
        array (
          0 => 'excerpt',
          1 => 'custom_fields',
          2 => 'discussion',
          3 => 'comments',
          4 => 'slug',
          5 => 'format',
          6 => 'featured_image'
        ),
      ),
      'menu_order' => 0,
    ));
  }
}
add_action( 'init', 'register_cpt_infobox' );


/**
 * Info box shortcode [infobox]
 */
function palmate_infobox_shortcode( $atts ) {
  $text = '<div class="page-header">';
  $text .= '  <h1>På gång <small>just nu</small></h1>';
  $text .= '</div>';
  
  $args = array(
    'post_type' => 'infobox',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts'=> 1
  );

  $my_query = null;
  $my_query = new WP_Query($args);
  if ( $my_query->have_posts() ) {
    $counter = 0;
    while ( $my_query->have_posts() ) {
      $my_query->the_post();

      // Test if infobox should be removed
      $end_date = get_field( 'infobox_enddate' );
      $secondsbetween = strtotime( $end_date ) - time();
      if ( $secondsbetween < 0 ) {
        // Move to trash if end date has been passed
        wp_update_post(array('ID' => get_the_ID(), 'post_status' => 'trash'));
        continue;
      }

      // Add new row each second infobox
      if ( $counter % 2 === 0 ) {
        if ( $counter > 0 ) {
          $text .= '</div>';
        }
        $text .= '<div class="row-fluid">';
      }
      
      // Get link to use
      $link = get_field( 'infobox_link' );
      if ( empty( $link ) ) {
        $link = get_permalink(get_the_ID());
      }
      
      // Get image to use
      $img_url = get_field( 'infobox_image' );
      $text_overlay = '';
      if ( empty( $img_url ) ) {
        $img_url = '../assets/img/infobox.png';
        $text_overlay = '    <h2>' . the_title('','',false) . '</h2>';
      }

      $text .= '  <a class="span6 infobox" href="' . $link . '">';
      $text .= '  <div>';
      $text .= '    <img src="' . $img_url . '" class="img-polaroid" alt="' . the_title('','',false) . '"/>';
      $text .= $text_overlay;
      $text .= '  </div>';
      $text .= '  </a>';
      $counter++;
    }
    if ( $counter > 0 ) {
      $text .= '</div>';
    }
  }
  wp_reset_query();  // Restore global post data stomped by the_post().

  return $text;
}
add_shortcode( 'infobox', 'palmate_infobox_shortcode' );  
