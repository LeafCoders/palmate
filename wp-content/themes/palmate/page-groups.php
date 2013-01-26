<?php
/*
Template Name: Lista med grupper
*/

the_post();
get_template_part('templates/page', 'group-main');

$mypages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'desc' ) );
foreach( $mypages as $page ) {
  $post = $page;
  setup_postdata( $post );
  get_template_part('templates/page', 'group');
}
