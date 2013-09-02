<?php
/*
Template Name: Medlemssida
*/

global $palmate_is_member;

if ($palmate_is_member == true) :
  the_post();
  get_template_part('templates/page', 'group');
else :
  get_template_part('templates/page', 'login');
endif;
