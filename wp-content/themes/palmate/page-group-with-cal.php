<?php
/*
Template Name: Group with calendar
*/
the_post();

/*get_template_part('templates/page', 'navigation-root');
get_template_part('templates/page', 'navigation');*/
get_template_part('templates/page', 'title');
get_template_part('templates/page', 'content');
get_template_part('templates/calendar', 'span12');
get_template_part('templates/page-loop', 'groupposts');
