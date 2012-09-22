<div class="span4 calendarbox">
  <?php 
    $cal = new PalmateCalendar();
    $cal->request( 'http://www.ryttargardskyrkan.se/program/view.php' );
    echo $cal->output();
  ?>
</div>