<?php
/*
Template Name: Lista med grupper
*/

the_post();
get_template_part('templates/page', 'group-main');

$group_id = $post->ID;
$mypages = get_pages(array('child_of' => $group_id, 'sort_column' => 'menu_order', 'sort_order' => 'asc'));
foreach($mypages as $post) {
  // Only show posts that has the page as parent
  if ($post->post_parent == $group_id) {
    setup_postdata($post);

    $page_template = get_post_meta($post->ID, '_wp_page_template', true);
    if ($page_template == 'page-group_with_news.php') {
      get_template_part('templates/page', 'group_with_news');
    } else if ($page_template == 'page-group.php'){
      get_template_part('templates/page', 'group');
    }
  }
}
