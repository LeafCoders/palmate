<?php
/*
Template Name: Rosette Calendar
*/
the_post();
?>

<div class="row-fluid">
<div class="span12 paddingBoth">
  <div id="kalender" class="contentBox">
    <div class="paddingBoth">
      <h1>Kalender</h1>
      <p>Denna kalender visar veckor för ca 3 månader framåt. På framsidan visas bara fyra veckor.</p>
    </div>
    <?php echo do_shortcode('[Calendar width="offset2 span8" pages="16"]'); ?>
  </div>
</div>
</div>
