<?php

class CalendarRosette
{
  protected $calData = null;

  function request( $url ) {
    $this->calData = null;

    $response = wp_remote_get( $url );
    if ( !is_wp_error( $response ) ) {
      $this->calData = json_decode( $response[body], true );
    }
	}

  function output() {
    $output = '';
    if ( !empty( $this->calData ) ) {
      // Week and month header
      self::week( $output, $this->calData );
    }
    return $output;
  }

/* ------ Data functions ------------------------------------------------------ */

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
    $output .= '<div class="cal-week">';
    $output .= '<p>Vecka ' . $week[week] . '<small>' . self::eventMonths( $week ) . '</small></p>';

    // Iterate through all days
    foreach ( $week[days] as $day ) {
      self::day( $output, $day );
    }

    $output .= '</div>';
  }

  protected function day( &$output, $day ) {
    $sunday = ( $day[dayNumber] == 7 ) ? ' cal-sunday' : '';

    $output .= '<div class="cal-day">';
    $output .= '<div class="cal-date' . $sunday . '">' . self::eventDay( $day ) . '<p>' . self::eventWeekDay( $day ) . '</p></div>';

    // Iterate through all events
    foreach ( $day[events] as $event ) {
      self::event( $output, $event );
    }

    $output .= '</div>';
  }

  protected function event( &$output, $event ) {
    $description = 'todo';
    
    $output .= '<div class="cal-event"><p>' . self::eventTime( $event ) . '</p>' . self::eventTitle( $event ) . '</div>';
    if ( !empty( $description ) ) {
      $output .= '<div class="cal-desc">' . $description . '</div>';
    }
  }
}

?>
