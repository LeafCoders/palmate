<?php
/*
Template Name: Lista med grupper
*/

the_post();
get_template_part('templates/page', 'group');

$mypages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'desc' ) );
foreach( $mypages as $page ) {
  $post = $page;
  setup_postdata( $post );
  get_template_part('templates/page', 'group');
}

/*
$content = $page->post_content;
$content = apply_filters( 'the_content', $content );

echo '  <!-- ' . $post->post_title . ' -->';
echo '  <article id="' . $post->post_name . '" class="hentry row-fluid">';
echo '    <div class="span12">';
echo '      <div class="contentBox marginBoth paddingBoth">';
echo '        <header>';
echo '          <h1 class="entry-title">' . $post->post_title . '</h1>';
echo '        </header>';
echo '        <div class="entry-content">' . apply_filters( 'the_content', $post->post_content ) . '</div>';
echo '      </div>';
echo '    </div>';
echo '  </article>';


$mypages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'desc' ) );
foreach( $mypages as $page ) {		
  $content = $page->post_content;
  $content = apply_filters( 'the_content', $content );

	echo '  <!-- ' . $page->post_title . ' -->';
	echo '  <article id="' . $page->post_name . '" class="hentry row-fluid">';
	echo '    <div class="span12">';
	echo '      <div class="contentBox marginBoth paddingBoth">';
	echo '        <header>';
	echo '          <h1 class="entry-title">' . $page->post_title . '</h1>';
	echo '        </header>';
	echo '        <div class="entry-content">' . $content . '</div>';
	echo '      </div>';
	echo '    </div>';
	echo '  </article>';
}
*/
