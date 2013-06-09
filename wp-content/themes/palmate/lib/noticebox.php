<?php

/**
 * Notice box post type
 */
function register_cpt_noticebox() {

  // Register the post type
  $labels = array( 
    'name' => _x( 'Notisboxar', 'noticebox' ),
    'singular_name' => _x( 'Notisbox', 'noticebox' ),
    'add_new' => _x( 'Skapa ny', 'noticebox' ),
    'add_new_item' => _x( 'Skapa ny notisbox', 'noticebox' ),
    'edit_item' => _x( 'Redigera notisbox', 'noticebox' ),
    'new_item' => _x( 'Ny notisbox', 'noticebox' ),
    'view_item' => _x( 'Visa notisbox', 'noticebox' ),
    'search_items' => _x( 'Sök notisbox', 'noticebox' ),
    'not_found' => _x( 'Hittade inga notisboxar', 'noticebox' ),
    'not_found_in_trash' => _x( 'Hittade inga notisboxar i papperskorgen', 'noticebox' ),
    'parent_item_colon' => _x( 'Förälder:', 'noticebox' ),
    'menu_name' => _x( 'Notisboxar', 'noticebox' ),
  );

  $args = array( 
    'labels' => $labels,
    'hierarchical' => false,
    'description' => 'En notisbox har en egen sida eller länkas mot en annan sida',
    'supports' => array( 'title', 'editor', 'thumbnail' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => false,
    'query_var' => 'noticebox',
    'can_export' => true,
    'rewrite' => array( 'slug' => 'notis', 'with_front' => FALSE ),
    'menu_icon' => admin_url( '/images/media-button-image.gif'),
    'capability_type' => 'noticebox'
  );
  register_post_type( 'noticebox', $args );

  global $wp_roles;
  $wp_roles->add_cap( 'administrator', 'edit_noticebox' );
  $wp_roles->add_cap( 'administrator', 'edit_noticeboxs' );
  $wp_roles->add_cap( 'administrator', 'delete_noticebox' );
  $wp_roles->add_cap( 'administrator', 'publish_noticeboxs' );

  // Add special fields for Noticebox settings
  if (function_exists( "register_field_group" ) ) {
    register_field_group( array(
      'id' => '5053a3598e93e',
      'title' => 'Inställningar för notisboxen',
      'fields' => 
      array (
        0 => 
        array (
          'key' => 'field_5057889f06efc',
          'label' => 'Bild',
          'name' => 'noticebox_image',
          'type' => 'image',
          'instructions' => 'Ange bild att visa i notisboxen. Storleken ska vara 940x400 pixlar.',
          'required' => '0',
          'save_format' => 'url',
          'preview_size' => 'medium',
          'order_no' => '0',
        ),
        1 => 
        array (
          'key' => 'field_505786e9d26d5',
          'label' => 'Slutdatum',
          'name' => 'noticebox_enddate',
          'type' => 'date_picker',
          'instructions' => 'Ange ett datum då notisboxen ska sluta att visas.',
          'required' => '1',
          'date_format' => 'yymmdd',
          'display_format' => 'yy-mm-dd',
          'order_no' => '1',
        ),
        2 => 
        array (
          'key' => 'field_50538ab1443fd',
          'label' => 'Länk',
          'name' => 'noticebox_link',
          'type' => 'text',
          'instructions' => 'Ange en länk till den sida som du vill ska visas då användaren trycker på notisboxen. Lämna den tom ifall du vill att texten i denna post ska visas istället.',
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
            'value' => 'noticebox',
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
add_action( 'init', 'register_cpt_noticebox' );


function generateNoticeboxes( $generator ) {
    $args = array(
      'post_type' => 'noticebox',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'caller_get_posts'=> 1
    );
    $query = new WP_Query($args);

    $titles = array();
    if ( $query->have_posts() ) {
      if ( $query->found_posts > 1 ) {
        $generator->elementsBefore();
        while ( $query->have_posts() ) {
          $query->the_post();
          if ( $generator->verifyEndDate() ) {
            $generator->elementNoticebox( count($titles) );
            array_push( $titles, the_title('','',false) );
          }
        }
        $generator->elementsAfter( $titles );
      } else {
        $query->the_post();
        array_push( $titles, the_title('','',false) );
        $generator->singleElementNoticebox();
      }
    }
    // Restore global post data stomped by the_post()
    wp_reset_query();

    if ( count($titles) > 0 ) {
      return $generator->output();
    } else {
      return "";
    }
}

class PalmateNoticebox
{
  protected $html = '';

  function elementsBefore() {
    $this->html = '<ul>';
  }

  function elementNoticebox( $counter ) {
    $this->html .= '<li>noticebox</li>';
  }

  function singleElementNoticebox() {
  }

  function elementsAfter( $titles ) {
    $this->html .= '</ul>';
  }
  
  function output() {
    return $this->html;
  }

  function verifyEndDate() {
    $endDate = get_field( 'noticebox_enddate' );
    $secondsBetween = strtotime( $endDate ) - time();
    if ( $secondsBetween < -24*60*60 ) {
      // Move to trash if end date has been passed
      wp_update_post(array('ID' => get_the_ID(), 'post_status' => 'trash'));
      return false;
    }
    return true;
  }

  function noticeboxHtml( $class ) {
    $link = get_field( 'noticebox_link' );
    if ( empty( $link ) ) {
      $link = get_permalink(get_the_ID());
    }

    $imgUrl = get_field( 'noticebox_image' );
    $textOverlay = '';
    if ( empty( $imgUrl ) ) {
      $imgUrl = '../assets/img/noticebox.png';
//      $textOverlay = '<h2>' . the_title('','',false) . '</h2>';
    }

    $html =  '<a class="' . $class . '" href="' . $link . '">';
    $html .= '  <img src="' . $imgUrl . '" alt="' . the_title('','',false) . '"/>' . $textOverlay;
    $html .= '</a>';
    return $html;
  }
}

class PalmateNoticeboxCarousel extends PalmateNoticebox
{
  private $outBig = '';
  private $outGrid = '';
  
  function elementsBefore() {
    $this->outBig =  '<div id="noticeboxBigCarousel" class="carousel slide">';
    $this->outBig .=   '<div class="carousel-inner">';

    $this->outGrid =  '<div id="noticeboxGridCarousel" class="carousel slide hidden-phone">';
    $this->outGrid .=   '<div class="carousel-inner">';
  }

  function elementNoticebox( $counter ) {
    $active = ( $counter === 0 ) ? ' active' : '';

    // Element for Big carousel
    self::startBig( $active );
    $this->outBig .= parent::noticeboxHtml( 'noticebox noticeboxBig' );
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
    $this->outGrid .= parent::noticeboxHtml( 'noticebox noticeboxSmall span6' );
  }

  function elementsAfter( $titles ) {
    // End Big carousel
    $this->outBig .= '</div>';
    $this->outBig .= '</div>';

    // Fill out rows until even rows
    self::endGridRow();
    if ( count($titles) % 4 < 2 ) {
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
    $this->outBig .=     '<div class="noticeboxHeight50p"></div>';
    $this->outBig .=     '<div class="heightItem">';
  }

  function endBig() {
    $this->outBig .= '</div></div></div>';
  }

  function startGrid( $active ) {
    $this->outGrid .= '<div class="item noticeboxGrid' . $active . '">';
  }

  function startGridRow() {
    $this->outGrid .= '<div class="row-fluid">';
    $this->outGrid .=   '<div class="heightContainer">';
    $this->outGrid .=      '<div class="noticeboxHeight25p"></div>';
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
    $htmlTot  = '<div class="row-fluid noticeboxContent">';
    $htmlTot .=    '<div class="span6">' . $this->outBig . '</div>';
    $htmlTot .=    '<div class="span6">' . $this->outGrid . '</div>';
    $htmlTot .= '</div>';

    // Start sliding carousels
    $htmlTot .= '<script type="text/javascript">$(window).load(function() { $(\'#noticeboxBigCarousel\').carousel( { interval: 4000 } ); $(\'#noticeboxGridCarousel\').carousel( { interval: 6000 } ); })</script>';
    return $htmlTot;
  }
}

class PalmateNoticeboxSwipe extends PalmateNoticebox
{
  private $out = '';

  function elementsBefore() {
    $this->out .= '<div class="row-fluid">';
    $this->out .= '  <div class="span12">';
    $this->out .= '    <div class="noticeboxClickHere"><div></div></div>';
    $this->out .= '    <div class="contentBox" style="padding-bottom: 0px;">';
    $this->out .= '      <div id="noticeboxSwipe" class="swipe">';
    $this->out .= '        <div class="swipe-wrap">';
  }

  function elementNoticebox( $counter ) {
    $this->out .= '<div>' . parent::noticeboxHtml( 'noticebox' ) . '</div>';
  }

  function singleElementNoticebox() {
    $this->out .= '<div class="row-fluid">';
    $this->out .= '  <div class="span12">';
    $this->out .= '    <div class="contentBox" style="padding-bottom: 0px;">';
    $this->out .= '<div>' . parent::noticeboxHtml( 'noticebox' ) . '</div>';
    $this->out .= '    </div>';
    $this->out .= '  </div>';
    $this->out .= '</div>';
  }

  function elementsAfter( $titles ) {
    $this->out .= '        </div>';
    $this->out .= '      </div>';
    $this->out .= '    </div>';
    $this->out .= '  </div>';
    $this->out .= '</div>';
    $this->out .= '<div class="row-fluid">';
    $this->out .= '  <div class="span12">';
    $this->out .= '    <div class="noticeboxNav">';
    $this->out .= '      <ul>';

    // Add bullets for each noticebox. Set first one to class="on"
    $onClass = ' class="on"';
    foreach ( $titles as $id => $title) {
      $this->out .= '<li><a' . $onClass . ' href="#" onclick="noticeboxSwipe.slide(' . $id . ');noticeboxSwipe.auto(0);return false;">' . $title . '</a></li>';
      $onClass = '';
    }

    $this->out .= '      </ul>';
    $this->out .= '    </div>';
    $this->out .= '  </div>';
    $this->out .= '</div>';
    $this->out .= '<script type="text/javascript">var noticeboxSwipe = new Swipe(document.getElementById("noticeboxSwipe"), { auto: 12000, callback: function(pos, e) { var i = bullets.length; while (i--) { bullets[i].className = " "; } bullets[pos].className = "on";} }), bullets = $(".noticeboxNav > ul > li > a");</script>';
  }

  function output() {
    return $this->out;
  }
}

/**
 * Notice box shortcode [noticebox]
 */
function palmate_noticebox_shortcode() {
  return generateNoticeboxes(new PalmateNoticeboxSwipe());
}
add_shortcode( 'noticebox', 'palmate_noticebox_shortcode' );  
