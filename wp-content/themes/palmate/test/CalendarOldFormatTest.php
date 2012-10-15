<?php
/*
  Run this test with 'php -f CalendarOldFormatTest.php' and verify output
*/

require_once( '../lib/calendar-old-format.php' );

class CalendarOldFormatTest extends CalendarOldFormat
{
  function request( $url ) {
    $response = '{';
    $response .= '"date": ["2012-09-21","2012-09-22","2012-09-23","2012-09-23","2012-09-25","2012-09-28","2012-09-30","2012-09-30","2012-09-30","2012-10-05"],';
    $response .= '"timeStart": ["20:00:00","19:00:00","11:00:00","13:30:00","14:00:00","19:30:00","11:00:00","14:00:00","16:00:00","20:00:00"],';
    $response .= '"title": ["Ekumenisk b\u00f6n- och lovs\u00e5ngsm\u00e4ssa i Domkyrkan","Lovs\u00e5ngskv\u00e4ll","Gudstj\u00e4nst","Steg in i f\u00f6rsamlingen","Bibeln i Fokus","20plush\u00e4ng","Gudstj\u00e4nst","Seminarium","Gemensam tr\u00e4ff p\u00e5 svenska och arabiska","V\u00e4xtv\u00e4rk"],';
    $response .= '"tema": ["","","Som Fadern har s\u00e4nt mig, s\u00e5 s\u00e4nder jag er. Joh.20:21","","","Gemenskap f\u00f6r unga vuxna","","F\u00e4rgresan \u0096 att anpassa sig till en ny kultur","","Om att g\u00e5 fr\u00e5n barnatro till vuxentro"],';
    $response .= '"info": ["","Clas V\u00e5rdstedt med band, Fredrik Lignell","Predikan: Owe Anb\u00e4cken","F\u00f6r dig som \u00e4r nyfiken p\u00e5 medlemskap\r\nAnm\u00e4lan senast 20 sept till Eleonore Gustafsson","Fredrik Lignell","","Predikan: Lars M\u00f6rling.\r\nKyrklunch efter gudstj\u00e4nsten. Anm\u00e4lan till exp senast den 23 sept.","Margareta M\u00f6rling","G\u00e4st: Rita Elmounayer fr\u00e5n kristna\r\narabiska TV-stationen Sat7","En f\u00f6rest\u00e4llning av Carl-Henric Jaktlund & Michael Johnson\r\nOBS i Pingstkyrkan"]';
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
$cal = new CalendarOldFormatTest();
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
