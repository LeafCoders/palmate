<?php
/*
Template Name: Lista med grupper
*/

the_post();
get_template_part('templates/page', 'group-main');

$mypages = get_pages(array('child_of' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'asc'));
foreach($mypages as $page) {
  $post = $page;
  setup_postdata($post);

  $page_template = get_post_meta($post->ID, '_wp_page_template', true);
  if ($page_template == 'page-group_with_news.php') {
    get_template_part('templates/page', 'group_with_news');
  } else {
    get_template_part('templates/page', 'group');
  }
}
