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
      <h1>Månadskalender</h1>
    </div>
    <?php echo do_shortcode('[Calendar rangeMode="month" width="offset2 span8"]'); ?>
  </div>
</div>
</div>
