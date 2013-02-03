<?php

/**
 * Latest blog post shortcode [LatestBlogPost]
 */
function palmate_latestBlogPost_shortcode( $atts ) {
  $response = wp_remote_get( 'http://backend.ryttargardskyrkan.se/blogg-post2.php' );
  $text = '<div style="max-height: 300px; overflow: hidden;">';
  if ( !is_wp_error( $response ) ) {
    $text .= utf8_encode( $response[body] );
  } else {
    $text .= 'Kunde inte hitta bloggen.';
  }
  $text .= '</div>';
  $text .= '<a href="http://blogg.ryttargardskyrkan.se/"><p>Mer på bloggen<span class="readMore"></span></p></a>';

  return $text;
}
add_shortcode( 'LatestBlogPost', 'palmate_latestBlogPost_shortcode' );


class WeekStepper
{
  protected $date = null;
  function __construct( $year, $week ) {
    $this->date = new DateTime("1970-01-01 00:00:00");
    $this->date->setISODate( $year, $week );
    $this->date->modify("+3 days");
  }
  function prevWeek() { $this->date->modify("-7 days");	}
  function nextWeek() { $this->date->modify("+7 days");	}
  function year() { return (int)$this->date->format("Y"); }
  function week() { return (int)$this->date->format("W"); }
}

/**
 * Calendar [Calendar width="span12"]
 */
function generate_palmate_calendar( $cal, $year, $week, $width, $pages ) {
  $output  = '<div id="calendar" class="row-fluid">';
  $output .= '  <div class="' . $width . ' cal-container">';
  $output .= '    <button id="calPrevWeekBtn" onclick="window.myCalSwipe.prev(); updatePalmateCalButtons(window.myCalSwipe.getPos(), ' . $pages . ');" class="btn cal-week-prev"><i class="icon-arrow-left"></i></button>';
  $output .= '    <button id="calNextWeekBtn" onclick="window.myCalSwipe.next(); updatePalmateCalButtons(window.myCalSwipe.getPos(), ' . $pages . ');" class="btn cal-week-next"><i class="icon-arrow-right"></i></button>';
  $output .= $cal->outputHeader();
  $output .= '    <div id="myCalSwipe" style="margin:0 auto" class="swipe">';
  $output .= '      <div class="swipe-wrap">';

  $ws = new WeekStepper( $year, $week );
  $ws->prevWeek();
  for ($i = 0; $i < $pages; $i++) {
    if ($i == 1) {
      $output .= '<div>' . $cal->outputFull( $ws->year(), $ws->week() ) . '</div>';
    } else {
      $output .= '<div>' . $cal->outputEmpty( $ws->year(), $ws->week() ) . '</div>';
    }
    $ws->nextWeek();
  }

  $output .= '      </div>';
  $output .= '    </div>';
  $output .= '  </div>';
  $output .= '</div>';

  $output .= '<script>var elem = document.getElementById("myCalSwipe"); window.myCalSwipe = new Swipe(elem, {startSlide: 0, continuous: false, callback: swipeCalendarCallback});window.myCalSwipe.slide(1);</script>';

  return $output;
}

function generate_palmate_calendar_request( $year, $week ) {
  $cal = new CalendarRosette();

  $fromOldCalendar = true;
  if ( $fromOldCalendar ) {
    if (empty($week)) {
      $cal->request( 'http://backend.ryttargardskyrkan.se/program/palmate.php' );
    } else {
      $cal->request( 'http://backend.ryttargardskyrkan.se/program/palmate.php?year=' . $year . '&week=' . $week );
    }
  }
  else {
    if (empty($week)) {
      $cal->request( rosette_api_url( 'eventweek' ) );
    } else if (strlen($week) < 2) {
      $cal->request( rosette_api_url( 'eventweek/' . $year . '-W0' . $week ) );
    } else {
      $cal->request( rosette_api_url( 'eventweek/' . $year . '-W' . $week ) );
    }
  }
  return $cal;
}

function palmate_calendar_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'year' => date("Y"),
    'week' => date("W"),
    'width' => 'span12',
    'pages' => '5'
  ), $atts ) );

  $cal = generate_palmate_calendar_request( $year, $week );
  return generate_palmate_calendar( $cal, $year, $week, $width, $pages );
}
add_shortcode( 'Calendar', 'palmate_calendar_shortcode' );

function palmate_ajax_loadCalendar() {
  $year = $_POST['year'];
  $week = $_POST['week'];
  $cal = generate_palmate_calendar_request( $year, $week );
  echo generate_palmate_calendar( $cal, $year, $week, 'span12' );
  die(); // this is required to return a proper result
}
add_action('wp_ajax_loadCalendar', 'palmate_ajax_loadCalendar');
add_action('wp_ajax_nopriv_loadCalendar', 'palmate_ajax_loadCalendar');

function palmate_ajax_loadCalendarWeek() {
  $year = $_POST['year'];
  $week = $_POST['week'];
  $cal = generate_palmate_calendar_request( $year, $week );
  echo $cal->output();
  die(); // this is required to return a proper result
}
add_action('wp_ajax_loadCalendarWeek', 'palmate_ajax_loadCalendarWeek');
add_action('wp_ajax_nopriv_loadCalendarWeek', 'palmate_ajax_loadCalendarWeek');


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
 * Download file [FileDownload text="" filename="" icon="icon-file"]
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


/**
 * Generate a list with rows of <dl></dl> [List][/List]
 * Each line inside the list must have one of the following formats:
 *   <p>Title|Content</p>
 *   <p>Title|Content|Link</p>
 */
function palmate_list_shortcode( $atts, $content ) {
  $content = strip_tags($content, '<p><img><b><i><ul><ol><li>');
  $text = '';
  $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $content, $matches);
  for ($i = 0; $i < $count; ++$i) {
    $row = strip_tags($matches[0][$i], '<img><b><i><ul><ol><li>');
    $items = explode('|', $row);
    $itemcount = count($items);
    if ($itemcount > 1) {
      if ($itemcount > 2) {
        $part  = '<div class="hideHref"><a href="' . $items[2] . '">';
        $part .= '<dl class="dl-horizontal"><dt>' . $items[0] . '</dt><dd class="readMore">' . $items[1] . '</dd></dl>';
        $part .= '</a></div>';
        $text .= $part;
      } else {
        $text .= '<dl class="dl-horizontal"><dt>' . $items[0] . '</dt><dd>' . $items[1] . '</dd></dl>';
      }
    }
  }
  return $text;
}
add_shortcode( 'List', 'palmate_list_shortcode' );

