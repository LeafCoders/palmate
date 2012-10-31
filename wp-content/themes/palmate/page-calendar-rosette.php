<?php
/*
Template Name: Rosette Calendar
*/
the_post();
?>

<div class="row-fluid">
<div class="span12 paddingBoth">
  <?php 
    $cal = new CalendarRosette();
//    $cal->request( rosette_api_url( 'eventweek' ) );
    $cal->request( 'http://localhost:8888/assets/img/eventweek-3.json' );
    echo $cal->output();

    echo '<em>From: ' . rosette_api_url( 'eventweek' ) . '</em>';
  ?>
</div>
</div>
