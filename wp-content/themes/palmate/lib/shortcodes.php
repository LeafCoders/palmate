<?php

/**
 * Latest blog post shortcode [LatestBlogPost]
 */
function palmate_latestBlogPost_shortcode( $atts ) {
  $response = wp_remote_get( 'http://www.ryttargardskyrkan.se/blogg-post2.php' );
  $text = '<div style="max-height: 300px; overflow: hidden;">';
  if ( !is_wp_error( $response ) ) {
    $text .= utf8_encode( $response[body] );
  } else {
    $text .= 'Kunde inte hitta bloggen.';
  }
  $text .= '</div>';
  $text .= '<a href="http://blogg.ryttargardskyrkan.se/"><div><span class="readMore"></span></div><br></a>';

  return $text;
}
add_shortcode( 'LatestBlogPost', 'palmate_latestBlogPost_shortcode' );

/**
 * Calendar [Calendar width="span12"]
 */
function calendar_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'width' => 'span12'
  ), $atts ) );

  $cal = new CalendarOldFormat();
  $cal->request( 'http://www.ryttargardskyrkan.se/program/view.php' );

  //$cal = new CalendarRosette();
  //$cal->request( 'http://localhost:8888/assets/img/eventweek-3.json' );

  $output  = '<div class="row-fluid">';
  $output .= '  <div class="' . $width . '">';
  $output .= $cal->output();
  $output .= '  </div>';
  $output .= '</div>';
  return $output;
}
add_shortcode( 'Calendar', 'calendar_shortcode' );


/**
 * Insert one image that is only visible on a phone [ImageOnlyPhone imgurl="content-img-temp.png"]
 */
function imageOnlyPhone_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'imgurl' => 'content-img-temp.png'
  ), $atts ) );

  $output  = '<div class="row-fluid marginBottom visible-phone">';
  $output .= '  <div class="span12"><figure><img class="img-polaroid imgCenter" src="/assets/img/' . $imgurl . '" /></figure></div>';
  $output .= '</div>';
  return $output;
}
add_shortcode( 'ImageOnlyPhone', 'imageOnlyPhone_shortcode' );

/**
 * Insert image in a column [ImageColumn span="span4" imgurls="content-img-temp.png" side="right"]
 */
function imageColumn_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'span' => 'span4',
    'imgurls' => 'content-img-temp.png',
    'side' => 'right'
  ), $atts ) );

  if ( $side == 'right' ) {
    $span .= ' hidden-phone';
  }

  $hiddenClass = '';
  $output = '<div class="' . $span . '">';
  foreach ( explode(',', $imgurls) as $imgUrl ) {
    $output .= '<div class="row-fluid marginBottom' . $hiddenClass . '">';
    $output .= '  <div class="span12"><figure><img class="img-polaroid imgCenter" src="/assets/img/' . $imgUrl . '" /></figure></div>';
    $output .= '</div>';

    // Set hidden after first item
    if ( $side == 'left' ) {
      $hiddenClass = ' hidden-phone';
    }
  }
  $output .= '</div>';
  return $output;
}
add_shortcode( 'ImageColumn', 'imageColumn_shortcode' );

/**
 * Age and time box [AgeAndTime age="", time=""]
 */
function palmate_ageAndTime_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'age' => '',
    'time' => ''
  ), $atts ) );

  $text = '<div class="ageAndTime"><span><i class="icon-user"></i> ' . $age . '<span class="dividerVert"></span><i class="icon-time"></i> ' . $time . '</span></div>';
  return $text;
}
add_shortcode( 'AgeAndTime', 'palmate_ageAndTime_shortcode' );

