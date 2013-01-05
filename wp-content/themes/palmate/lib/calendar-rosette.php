<?php

class CalendarRosette
{
  protected $calData = null;

  function request( $url ) {
    $this->calData = null;

    $response = wp_remote_get( $url );
    if ( !is_wp_error( $response ) ) {
//      $this->calData = json_decode( $response[body], true );
			$text = str_replace( 'week":01', 'week":1', $response[body]);
			$text = str_replace( 'week":02', 'week":2', $text);
			$text = str_replace( 'week":03', 'week":3', $text);
			$text = str_replace( 'week":04', 'week":4', $text);
			$text = str_replace( 'week":05', 'week":5', $text);
			$text = str_replace( 'week":06', 'week":6', $text);
			$text = str_replace( 'week":07', 'week":7', $text);
			$text = str_replace( 'week":08', 'week":8', $text);
			$text = str_replace( 'week":09', 'week":9', $text);
			$this->calData = json_decode( $text, true );
    }
	}

  function output() {
    $output = '';
    if ( !empty( $this->calData ) ) {
      self::week( $output, $this->calData );
    }
    return $output;
  }

  function outputHeader() {
    if ( !empty( $this->calData ) ) {
			return '<div class="cal-week">Vecka ' . $this->calData[week] . ', ' . self::eventYear( $this->calData ) . '<small>' . self::eventMonths( $this->calData ) . '</small></div>';
    }
    return '<div></div>';
  }

  function outputEmpty( $year, $week ) {
    return '<div data-year="' . $year . '" data-months="..." data-week="' . $week . '"><table><tbody><tr><td></td></tr></tbody></table></div>';
  }

/* ------ Data functions ------------------------------------------------------ */

  protected function eventYear( $week ) {
    $dateTime = new DateTime( $week[since] );
		$dateTime->modify( '+3 days' );  /* Forth day sets the week number */
    return date_i18n( 'Y', $dateTime->getTimeStamp() );
  }

  protected function eventMonth( $date ) {
    $dateTime = new DateTime( $date );
    return date_i18n( 'F', $dateTime->getTimeStamp() );
  }

  protected function eventMonths( $week ) {
    $monthSince = self::eventMonth( $week[since] );
    $monthUntil = self::eventMonth( $week[until] );
    return $monthSince . ( $monthSince != $monthUntil ? ', ' . $monthUntil : '' );
  }
  
  protected function eventWeekDay( $day ) {
    $dateTime = new DateTime( substr( $day[date], 0, 10 ) );
    return date_i18n( 'D', $dateTime->getTimeStamp() );
  }

  protected function eventDay( $day ) {
    return ltrim( substr( $day[date], 8, 2 ), '0' );
  }

  protected function eventTime( $event ) {
    return substr( $event[startTime], 11, 5 );
  }

  protected function eventTitle( $event ) {
    return $event[title];
  }

/* ------ Format functions ---------------------------------------------------- */

  protected function week( &$output, $week ) {
    $output .= '<div data-year="' . self::eventYear( $week ) . '" data-months="' . self::eventMonths( $week ) . '" data-week="' . $week[week] . '"><table><tbody>';

    // Iterate through all days
    foreach ( $week[days] as $day ) {
      self::day( $output, $day );
    }

    $output .= '</tbody></table></div>';
  }

  protected function day( &$output, $day ) {
    // Iterate through all events
		$rows = 0;
		$eventsOutput = '';
    foreach ( $day[events] as $event ) {
      $rows += self::event( $eventsOutput, $event );
    }
		$rows = max( $rows, 1 );

    $sunday = ( $day[dayNumber] == 7 ) ? ' cal-sunday' : '';

    $output .= '<tr><td colspan="3" class="cal-divider"></td></tr>';
    $output .= '<tr>';
		$output .= '<td rowspan="' . $rows . '" class="cal-date' . $sunday . '">';
    $output .= '<div>' . self::eventDay( $day ) . '<p>' . self::eventWeekDay( $day ) . '</p></div>';
    $output .= '</td>';
    $output .= $eventsOutput;
		$output .= '</tr>';
  }

  protected function event( &$output, $event ) {
    $description = $event[description];

    if ( !empty( $output ) ) {
			$output .= '<tr>';
		}
    $output .= '<td class="cal-time">' . self::eventTime( $event ) . '</td><td class="cal-event">' . self::eventTitle( $event ) . '</td></tr>';
    if ( !empty( $description ) ) {
      $output .= '<tr><td></td><td class="cal-desc">' . $description . '</td></tr>';
			return 2;
    }
		return 1;
  }
}

?>
