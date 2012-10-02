<?php
/*
  Run this test with 'php -f testCalendar.php' and verify output
*/

require_once( '../lib/calendar.php' );

class PalmateCalendarTest extends PalmateCalendar
{
  function request( $url ) {
    $response = '{ "week": 39, "months": [9], "events": [';
    $response .= ' "1": [ "title": "Hej hopp", "StartTime": "10:00" ]';
    $response .= '] }';

    $this->calData = json_decode( $response, true );
	}
}

// Helper methods
date_default_timezone_set( 'Europe/Stockholm' );
function date_i18n( $format, $timestamp ) {
  return 'notimportant';
}

// Do request
$cal = new PalmateCalendarTest();
$cal->request( '' );
$output = $cal->output();

// Test cases
echo 'Weeks:  ' . substr_count( $output, 'cal-week' ) . ', expected 3' . PHP_EOL;
echo 'Days:   ' . substr_count( $output, 'cal-day' ) . ', expected 7' . PHP_EOL;
echo 'Events: ' . substr_count( $output, 'cal-event' ) . ', expected 10' . PHP_EOL;
echo 'Desc:   ' . substr_count( $output, 'cal-desc' ) . ', expected 9' . PHP_EOL;

echo 'Equal <div and </div: ' . ( substr_count( $output, '<div' ) === substr_count( $output, '</div' ) ? 'true' : 'false' ) . PHP_EOL;
echo 'Equal <p and </p: ' . ( substr_count( $output, '<p' ) === substr_count( $output, '</p' ) ? 'true' : 'false' ) . PHP_EOL;
echo 'Equal <small and </small: ' . ( substr_count( $output, '<small' ) === substr_count( $output, '</small' ) ? 'true' : 'false' ) . PHP_EOL;
?>
