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
    $cal->request( rosette_api_url( 'eventweek' ) );
    echo $cal->output();

    echo '<em>From: ' . rosette_api_url( 'eventweek' ) . '</em>';
  ?>
</div>
</div>
