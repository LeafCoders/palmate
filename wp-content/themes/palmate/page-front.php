<?php
/*
Template Name: Front page
*/
the_post(); ?>

<div class="row-fluid">
  <div id="main" class="span8 contentbox" role="main">
    <div class="page-header">
      <h1>Just nu <small>i Ryttargårdskyrkan</small></h1>
    </div>
    <div class="row-fluid">
      <a class="span6 maximg" href="#">
        <img class="img-polaroid" src="../assets/img/infobox1.png" alt="">
      </a>
      <a class="maximg span6" href="#">
        <img class="img-polaroid" src="../assets/img/infobox2.png" alt="">
      </a>
    </div>
    <div class="row-fluid">
      <a class="span6 maximg" href="#">
        <img class="img-polaroid" src="../assets/img/infobox3.png" alt="">
      </a>
      <a class="maximg span6" href="#">
        <img class="img-polaroid" src="../assets/img/infobox4.png" alt="">
      </a>
    </div>
  
    <?php the_content(); ?>
  </div>
  <?php get_template_part('templates/calendar', 'span4'); ?>
</div>

