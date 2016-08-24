<?php

/**
 * Calendar [Calendar rangemode="week" width="span12"]
 */
function generate_palmate_calendar( $rangeMode, $width, $requestUrl ) {
  $output  = '<div id="palmateCalendar" class="row-fluid">';
  $output .= '  <div class="' . $width . ' cal-container">';
  $output .= '    <button onclick="palmateCalendar.showPrev();" class="btn cal-btn-prev"><i class="icon-arrow-left"></i></button>';
  $output .= '    <button onclick="palmateCalendar.showNext();" class="btn cal-btn-next"><i class="icon-arrow-right"></i></button>';
  $output .= '    <div class="cal-header">&nbsp;<small>&nbsp;</small></div>';
  $output .= '    <div class="cal-content">';
  $output .= '      <div style="min-height: 650px;"></div>';
  $output .= '    </div>';
  $output .= '  </div>';
  $output .= '</div>';

  $output .= '<script>var palmateCalendar = PalmateCalendar("' . $rangeMode . '", "#palmateCalendar", "' . $requestUrl . '"); palmateCalendar.init();</script>';

  return $output;
}

function palmate_calendar_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'rangemode' => 'week',
    'width' => 'span12',
    'requesturl' => rosette_api_url( 'public/calendar' )
  ), $atts ) );

  return generate_palmate_calendar( $rangemode, $width, $requesturl );
}
add_shortcode( 'Calendar', 'palmate_calendar_shortcode' );


/**
 * Insert one image that is only visible on a phone [ImageOnlyPhone imgurl="content-img-temp.png"]
 */
function imageOnlyPhone_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'imgurl' => 'content-img-temp.png'
  ), $atts ) );

  $output  = '<div class="row-fluid marginBottom visible-phone">';
  $output .= '  <div class="span12"><figure><img class="img-polaroid imgCenter" src="/assets/img/content/' . $imgurl . '" alt="Bild"></figure></div>';
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
    $output .= '  <div class="span12"><figure><img class="img-polaroid imgCenter" src="/assets/img/content/' . $imgUrl . '" alt="Bild"></figure></div>';
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
 * Insert image in a row [ImageRow imgurls="content-img-temp.png" span="span4"]
 */
function imageRow_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'span' => 'span4',
    'imgurls' => 'content-img-temp.png',
  ), $atts ) );

  $output = '<div class="row-fluid">';
  foreach ( explode(',', $imgurls) as $imgUrl ) {
    $output .= '  <div class="' . $span . ' marginBottom paddingBoth"><figure><img class="img-polaroid imgCenter" src="/assets/img/content/' . $imgUrl . '" alt="Bild"></figure></div>';
  }
  $output .= '</div>';
  return $output;
}
add_shortcode( 'ImageRow', 'imageRow_shortcode' );

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

  return '<a class="fileDownload" href="/assets/' . $filename . '" target="_blank"><i class="' . $icon . '"></i> ' . $text . '</a>';
}
add_shortcode( 'FileDownload', 'palmate_fileDownload_shortcode' );

/**
 * [FileList order="ASC" mimetype="application/pdf"]
 */
function palmate_fileList_shortcode( $attr ) {
	$post = get_post();

	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'post_date ID',
		'mimetype'   => 'application/pdf',
		'id'         => $post ? $post->ID : 0
	), $attr, 'palmate_filelist' );

	$id = intval( $atts['id'] );

	$attachments = get_children( array(
		'post_parent' => $id,
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => $atts['mimetype'],
		'order' => $atts['order'],
    'orderby' => $atts['orderby']
	) );

	if ( empty( $attachments ) ) {
		return '';
	}

  $output .= "<div>";

	foreach ( $attachments as $id => $attachment ) {
		$attachment_url = wp_get_attachment_url( $id );

		$output .= "<a class='fileDownload' style='width: 100%;' href='" . $attachment_url . "' target='_blank'>";
    $output .= "<h5>" . $attachment->post_title . "</h5>";
		$output .= "<div class='paddingLeft'>" . $attachment->post_excerpt . "</div>";
		$output .= "<div class='paddingLeft'>" . $attachment->post_content . "</div>";
    $output .= "</a><br>";
	}

  $output .= "</div>";
  return $output;
}
add_shortcode( 'FileList', 'palmate_fileList_shortcode' );


/**
 * Generate a list with rows of <dl></dl> [List][/List]
 * Each line inside the list must have one of the following formats:
 *   <p>Title|Content</p>
 *   <p>Title|Content|Link</p>
 */
function palmate_list_shortcode( $atts, $content ) {
  $content = strip_tags($content, '<p><img><b><i><ul><ol><li><a>');
  $text = '';
  $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $content, $matches);
  for ($i = 0; $i < $count; ++$i) {
    $row = strip_tags($matches[0][$i], '<img><b><i><ul><ol><li><a>');
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

/**
 * Inserts a search box
 */
function palmate_search_shortcode() {
  ob_start();
  get_search_form();
  $searchform = ob_get_contents();
  ob_end_clean();
  return $searchform;
}
add_shortcode( 'Search', 'palmate_search_shortcode' );

/**
 * Hash an email
 */
function palmate_email_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'address' => ''
  ), $atts ) );

  return palmate_email_hash( $address );
}
add_shortcode( 'Email', 'palmate_email_shortcode' );
