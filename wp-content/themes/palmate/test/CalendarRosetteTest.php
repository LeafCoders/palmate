<?php
/*
  Run this test with 'php -f CalendarRosetteTest.php' and verify output
*/

require_once( '../lib/calendar-rosette.php' );

class CalendarRosetteTest extends CalendarRosette
{
  function request( $url ) {
    $response  = '{ "week":40,';
    $response .= '  "since":"2012-10-01",';
    $response .= '  "until":"2012-10-07",';
    $response .= '  "days": [';
    $response .= '    {"date":"2012-10-01","dayNumber":1,"events":[]},';
    $response .= '    {"date":"2012-10-02","dayNumber":2,"events":[]},';
    $response .= '    {"date":"2012-10-03","dayNumber":3,"events":[]},';
    $response .= '    {"date":"2012-10-04","dayNumber":4,"events":[]},';
    $response .= '    {"date":"2012-10-05","dayNumber":5,"events":[]},';
    $response .= '    {"date":"2012-10-06","dayNumber":6,"events":[]},';
    $response .= '    {"date":"2012-10-07","dayNumber":7,"events":[';
    $response .= '      {"id":"5071f050e4b005b4e5b3a8ac","title":"Gudstjänst","startTime":"2012-10-07 11:00 Europe/Stockholm","endTime":null,"themeId":null},';
    $response .= '      {"id":"5071f422e4b005b4e5b3a8ad","title":"Test","startTime":"2012-10-07 17:00 Europe/Stockholm","endTime":null,"themeId":null}';
    $response .= '    ]}';
    $response .= '  ]';
    $response .= '}';

    $this->calData = json_decode( $response, true );
	}
}

// Helper methods
date_default_timezone_set( 'Europe/Stockholm' );
function date_i18n( $format, $timestamp ) {
  return 'notimportant';
}

// Do request
$cal = new CalendarRosetteTest();
$cal->request( '' );
$output = $cal->output();

// Test cases
echo 'Weeks:  ' . substr_count( $output, 'cal-week' ) . ', expected 1' . PHP_EOL;
echo 'Days:   ' . substr_count( $output, 'cal-day' ) . ', expected 7' . PHP_EOL;
echo 'Events: ' . substr_count( $output, 'cal-event' ) . ', expected 2' . PHP_EOL;
echo 'Desc:   ' . substr_count( $output, 'cal-desc' ) . ', expected 2' . PHP_EOL;

echo 'Equal <div and </div: ' . ( substr_count( $output, '<div' ) === substr_count( $output, '</div' ) ? 'true' : 'false' ) . PHP_EOL;
echo 'Equal <p and </p: ' . ( substr_count( $output, '<p' ) === substr_count( $output, '</p' ) ? 'true' : 'false' ) . PHP_EOL;
echo 'Equal <small and </small: ' . ( substr_count( $output, '<small' ) === substr_count( $output, '</small' ) ? 'true' : 'false' ) . PHP_EOL;
?>
