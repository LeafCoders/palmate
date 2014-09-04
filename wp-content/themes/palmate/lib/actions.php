<?php

/**
 * Add the RSS feed link in the <head> if there's posts
 */
function roots_feed_link() {
  $count = wp_count_posts('post'); if ($count->publish > 0) {
    echo "\n\t<link rel=\"alternate\" type=\"application/rss+xml\" title=\"". get_bloginfo('name') ." Feed\" href=\"". home_url() ."/feed/\">\n";
  }
}

add_action('wp_head', 'roots_feed_link', -2);

/**
 * Add the asynchronous Google Analytics snippet from HTML5 Boilerplate
 * if an ID is defined in config.php
 *
 * @link mathiasbynens.be/notes/async-analytics-snippet
 */
function roots_google_analytics() {
  if (GOOGLE_ANALYTICS_ID) {
    echo "\n\t<script>\n";
    echo "\t\tvar _gaq=[['_setAccount','" . GOOGLE_ANALYTICS_ID . "'],['_trackPageview']];\n";
    echo "\t\t(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];\n";
    echo "\t\tg.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';\n";
    echo "\t\ts.parentNode.insertBefore(g,s)}(document,'script'));\n";
    echo "\t</script>\n";
  }
}

add_action('wp_footer', 'roots_google_analytics');


/**
 * Detect if member is or has logged in
 */
function palmate_detect_member_status() {
  global $palmate_is_member;
  $palmate_is_member = false;
  if (trim(MEMBER_PASSWORD) == false) {
    $palmate_is_member = false;
  } elseif ($_COOKIE["palmate_member"] == MEMBER_PASSWORD) {
    $palmate_is_member = true;
  } elseif ($_POST["member_pwd"] == MEMBER_PASSWORD) {
    unset($_POST['member_pwd']);
    $expire = time()+5*60; // cookie expires after 5 minute
    setcookie("palmate_member", MEMBER_PASSWORD, $expire);
    $palmate_is_member = true;
  }
}

add_action('init', 'palmate_detect_member_status');


/**
 * 
 */
function palmate_pre_save_post( $content ) {
  // Replace all <a href="mailto:...">...</a> with [Email address="..."]
  $pos = strpos( $content, 'mailto:' );
  while ( $pos ) {
    $start = strrpos( substr( $content, 0, $pos ), '<a' );
    $end = strpos( $content, '</a>', $pos ) + 4;
    $email = substr( $content, $pos + 7, strpos( $content, '"', $pos ) - $pos - 7 );
    if ( $pos > 0 ) {
      $content = substr_replace( $content, '[Email address="' . $email . '"]', $start, $end - $start );
    }
    $pos = strpos( 'mailto:', $content );
  }

  // Replace all a@b.c [Email address="a@b.c"]
  $pos = strpos( $content, '@' );
  while ( $pos ) {
    $start = strrpos( substr( $content, 0, $pos ), ' ' ) + 1;
    $end = strpos( $content, ' ', $pos );
    $email = substr( $content, $start, $end - $start );
    if ( $pos > 0 && strpos( $email, '=' ) === FALSE ) {
      $content = substr_replace( $content, '[Email address="' . $email . '"]', $start, $end - $start );
    }
    $pos = strpos( '@', $content );
  }

  return $content;
}

add_filter ( 'content_save_pre', 'palmate_pre_save_post' );
