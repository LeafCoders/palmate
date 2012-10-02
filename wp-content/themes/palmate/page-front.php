<?php
/*
Template Name: Front page
*/
the_post(); ?>

<?php echo palmate_infobox_shortcode( '' ); ?>
<div class="row-fluid">
  <div id="main" class="span8 contentbox" role="main">
    <?php the_content(); ?>
  </div>
  <?php get_template_part('templates/calendar', 'span4'); ?>
</div>

