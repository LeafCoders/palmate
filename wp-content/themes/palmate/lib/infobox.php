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
    'description' => 'En infobox har en egen sida eller länkas mot en annan sida',
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
          'instructions' => 'Ange bild att visa i infoboxen. Storleken ska vara ca 600x300 pixlar.',
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


function generateInfoboxes( $generator ) {
    $args = array(
      'post_type' => 'infobox',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'caller_get_posts'=> 1
    );
    $query = new WP_Query($args);

    if ( $query->have_posts() ) {
      $counter = 0;
      $generator->elementBefore();
      while ( $query->have_posts() ) {
        $query->the_post();
        if ( $generator->verifyEndDate() ) {
          $generator->elementInfobox( $counter );
          $counter++;
        }
      }
      $generator->elementAfter( $counter );
    }
    // Restore global post data stomped by the_post()
    wp_reset_query();
   
    return $generator->output();
}

class PalmateInfobox
{
  protected $html = '';

  function elementBefore() {
    $this->html = '<ul>';
  }

  function elementInfobox( $counter ) {
    $this->html .= '<li>infobox</li>';
  }

  function elementAfter( $counter ) {
    $this->html .= '</ul>';
  }
  
  function output() {
    return $this->html;
  }

  function verifyEndDate() {
    $endDate = get_field( 'infobox_enddate' );
    $secondsBetween = strtotime( $endDate ) - time();
    if ( $secondsBetween < 0 ) {
      // Move to trash if end date has been passed
      wp_update_post(array('ID' => get_the_ID(), 'post_status' => 'trash'));
      return false;
    }
    return true;
  }

  function infoboxHtml( $class ) {
    $link = get_field( 'infobox_link' );
    if ( empty( $link ) ) {
      $link = get_permalink(get_the_ID());
    }

    $imgUrl = get_field( 'infobox_image' );
    $textOverlay = '';
    if ( empty( $imgUrl ) ) {
      $imgUrl = '../assets/img/infobox.png';
      $textOverlay = '<h2>' . the_title('','',false) . '</h2>';
    }

    $html =  '<a class="' . $class . '" href="' . $link . '">';
//    $html .=   '<div>';
    $html .=     '<img src="' . $imgUrl . '" class="img-polaroid" alt="' . the_title('','',false) . '"/>' . $textOverlay;
//    $html .=   '</div>';
    $html .= '</a>';
    return $html;
  }
}

class PalmateInfoboxCarousel extends PalmateInfobox
{
  private $outBig = '';
  private $outGrid = '';
  
  function elementBefore() {
    $this->outBig =  '<div id="infoboxBigCarousel" class="carousel slide">';
    $this->outBig .=   '<div class="carousel-inner">';

    $this->outGrid =  '<div id="infoboxGridCarousel" class="carousel slide hidden-phone">';
    $this->outGrid .=   '<div class="carousel-inner">';
  }

  function elementInfobox( $counter ) {
    $active = ( $counter === 0 ) ? ' active' : '';

    // Element for Big carousel
    self::startBig( $active );
    $this->outBig .= parent::infoboxHtml( 'infobox infoboxBig' );
    self::endBig();

    // Element for Grid carousel
    if ( $counter % 2 === 0 ) {
      if ( $counter > 0 ) {
        self::endGridRow();
      }
      if ( $counter % 4 === 0 ) {
        if ( $counter > 0 ) {
          self::endGrid();
        }
        self::startGrid( $active );
      }
      self::startGridRow();
    }
    $this->outGrid .= parent::infoboxHtml( 'infobox infoboxSmall span6' );
  }

  function elementAfter( $counter ) {
    // End Big carousel
    $this->outBig .= '</div>';
    $this->outBig .= '</div>';

    // Fill out rows until even rows
    self::endGridRow();
    if ( $counter % 4 < 2 ) {
      self::startGridRow();
      self::endGridRow();
    }
    self::endGrid();

    // End Grid carousel
    $this->outGrid .= '</div></div>';
  }

  function startBig( $active ) {
    $this->outBig .= '<div class="item' . $active . '">';
    $this->outBig .=   '<div class="heightContainer">';
    $this->outBig .=     '<div class="infoboxHeight50p"></div>';
    $this->outBig .=     '<div class="heightItem">';
  }

  function endBig() {
    $this->outBig .= '</div></div></div>';
  }

  function startGrid( $active ) {
    $this->outGrid .= '<div class="item infoboxGrid' . $active . '">';
  }

  function startGridRow() {
    $this->outGrid .= '<div class="row-fluid">';
    $this->outGrid .=   '<div class="heightContainer">';
    $this->outGrid .=      '<div class="infoboxHeight25p"></div>';
    $this->outGrid .=      '<div class="heightItem">';
  }

  function endGridRow() {
    $this->outGrid .= '</div></div></div>';
  }

  function endGrid() {
    $this->outGrid .= '</div>';
  }

  function output() {
    // Surround Big and Grid carousel with a row
    $htmlTot  = '<div class="row-fluid infoboxContent">';
    $htmlTot .=    '<div class="span6">' . $this->outBig . '</div>';
    $htmlTot .=    '<div class="span6">' . $this->outGrid . '</div>';
    $htmlTot .= '</div>';

    // Start sliding carousels
    $htmlTot .= '<script type="text/javascript">$(window).load(function() { $(\'#infoboxBigCarousel\').carousel( { interval: 4000 } ); $(\'#infoboxGridCarousel\').carousel( { interval: 6000 } ); })</script>';
    return $htmlTot;
  }
}

/**
 * Info box shortcode [infobox]
 */
function palmate_infobox_shortcode( $atts ) {
  return generateInfoboxes(new PalmateInfoboxCarousel());
}
add_shortcode( 'infobox', 'palmate_infobox_shortcode' );  
