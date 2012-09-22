<?php

class PalmateCalendar
{
  protected $calData = null;
  private $event = null;
  private $counter = 0;

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
      $this->counter = 0;
      $this->event = new DateTime( $this->calData[date][$this->counter] );
      while ( $this->event != null ) {
        self::month( $output );
      }
    }
    return $output;
  }

  protected function nextEvent() {
    $this->counter++;
    if ( $this->counter < 10 ) {
      $this->event = new DateTime( $this->calData[date][$this->counter] );
    } else {
      $this->event = null;
    }
  }

  protected function equalFormat( $format, $value ) {
    return ( $this->event != null ) && ( $this->event->format( $format ) == $value );  
  }
  
  protected function eventMonth() {
    return date_i18n( 'F', $this->event->getTimeStamp() );
  }
  
  protected function eventWeekDay() {
    return date_i18n( 'D', $this->event->getTimeStamp() );
  }

  protected function eventDay() {
    return $this->event->format( 'j' );
  }

  protected function eventTime() {
    return substr( $this->calData[timeStart][$this->counter], 0, 5 );
  }

  protected function eventTitle() {
    return $this->calData[title][$this->counter];
  }

  protected function eventDescription() {
    $desc = $this->calData[info][$this->counter];
    if ( !empty( $desc ) ) {
      $desc .= '<br>';
    }
    $desc .= $this->calData[tema][$this->counter];
    return $desc;
  }

  protected function month( &$output ) {
    $startMonth = $this->event->format( 'm' );
    do {
      self::week( $output );
    } while ( self::equalFormat( 'm', $startMonth ) );
  }

  protected function week( &$output ) {
    $output .= '<div class="cal-week">';

    $startWeek = $this->event->format( 'W' );
    $output .= '<p>Vecka ' . $startWeek . '<small>' . self::eventMonth() . '</small></p>';
    do {
      self::day( $output, $i );
    } while ( self::equalFormat( 'W', $startWeek ) );

    $output .= '</div>';
  }

  protected function day( &$output ) {
    $sunday = ( $this->event->format( 'w' ) == 0 ) ? ' cal-sunday' : '';

    $output .= '<div class="cal-day">';
    $output .= '<div class="cal-date' . $sunday . '">' . self::eventDay() . '<p>' . self::eventWeekDay() . '</p></div>';

    $startDay = $this->event->format( 'D' );
    do {
      self::event( $output );
    } while ( self::equalFormat( 'D', $startDay ) );

    $output .= '</div>';
  }

  protected function event( &$output ) {
    $description = self::eventDescription();
    $output .= '<div class="cal-event"><p>' . self::eventTime() . '</p>' . self::eventTitle() . '</div>';
    if ( !empty( $description ) ) {
      $output .= '<div class="cal-desc">' . $description . '</div>';
    }
    self::nextEvent();
  }
}

?>
