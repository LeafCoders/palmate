<?php

/**
 * Latest blog post shortcode [LatestBlogPost]
 */
function palmate_latestBlogPost_shortcode( $atts ) {
  $response = wp_remote_get( 'http://www.ryttargardskyrkan.se/blogg-post2.php' );
  $text = '<div style="max-height: 250px; overflow: hidden;">';
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
function generate_palmate_calendar( $year, $week, $width ) {
  $cal = new CalendarRosette();
  if (empty($week)) {
    $cal->request( rosette_api_url( 'eventweek' ) );
  } else {
    $cal->request( rosette_api_url( 'eventweek/' . $year . '-W' . $week ) );
  }

  $output  = '<div id="calendar" class="row-fluid">';
  $output .= '  <div class="pagination-centered">';
  $output .= '    <div class="btn-group pagination-centered">';
  $output .= '      <button onclick="loadCalendar(\'' . $year . '\', \'' . ($week-1) . '\')" class="btn"><i class="icon-arrow-left"></i></button>';
  $output .= '      <button onclick="loadCalendar(\'' . $year . '\', \'' . date('W') . '\')" class="btn">Aktuell vecka</button>';
  $output .= '      <button onclick="loadCalendar(\'' . $year . '\', \'' . ($week+1) . '\')" class="btn"><i class="icon-arrow-right"></i></button>';
  $output .= '    </div>';
  $output .= '  </div><br>';
  $output .= '  <div class="' . $width . '">';
  $output .= $cal->output();
  $output .= '  </div>';
  $output .= '</div>';
  
  return $output;
}

function calendar_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'year' => date("Y"),
    'week' => date("W"),
    'width' => 'span12'
  ), $atts ) );

  return generate_palmate_calendar( $year, $week, $width );
}
add_shortcode( 'Calendar', 'calendar_shortcode' );

function palmate_ajax_loadCalendar() {
	$year = $_POST['year'];
	$week = $_POST['week'];
  echo generate_palmate_calendar( $year, $week, 'span12' );
	die(); // this is required to return a proper result
}
add_action('wp_ajax_loadCalendar', 'palmate_ajax_loadCalendar');
add_action('wp_ajax_nopriv_loadCalendar', 'palmate_ajax_loadCalendar');

/**
 * Insert one image that is only visible on a phone [ImageOnlyPhone imgurl="content-img-temp.png"]
 */
function imageOnlyPhone_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'imgurl' => 'content-img-temp.png'
  ), $atts ) );

  $output  = '<div class="row-fluid marginBottom visible-phone">';
  $output .= '  <div class="span12"><figure><img class="img-polaroid imgCenter" src="/assets/img/content/' . $imgurl . '" /></figure></div>';
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
    $output .= '  <div class="span12"><figure><img class="img-polaroid imgCenter" src="/assets/img/content/' . $imgUrl . '" /></figure></div>';
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

/**
 * Download file [FileDownload text='' filename="" icon="icon-file"]
 */
function palmate_fileDownload_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'text' => '',
    'filename' => '',
    'icon' => 'icon-file'
  ), $atts ) );

  return '<a class="fileDownload" href="/assets/' . $filename . '"><i class="' . $icon . '"></i> ' . $text . '</a>';
}
add_shortcode( 'FileDownload', 'palmate_fileDownload_shortcode' );

