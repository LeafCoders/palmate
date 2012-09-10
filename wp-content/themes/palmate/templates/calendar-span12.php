<div class="row-fluid">
  <div class="span12 calendarbox well">
    <?php
$response = wp_remote_get( 'http://www.ryttargardskyrkan.se/program/view.php' );
if ( is_wp_error( $response ) ) {
   echo 'Something went wrong!';
} else {
   $cal = json_decode($response[body], true);
   for ( $i = 0; $i < 10; $i++ ) {
     echo '<p><i>' . $cal[date][$i] . ' - </i>';
     echo '<strong>' . $cal[title][$i] . '</strong></p>';
   }
//   print_r( $response[body] );
}
?>    
  </div>
</div>