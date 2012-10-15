<!--<div class="span4 calendarbox">-->
  <?php 
    $cal = new CalendarOldFormat();
    $cal->request( 'http://www.ryttargardskyrkan.se/program/view.php' );
    echo $cal->output();
  ?>
<!--</div>-->