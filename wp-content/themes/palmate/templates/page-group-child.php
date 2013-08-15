<?php
if ( $post->post_parent ) {
  $group_title = get_the_title($post->post_parent);
  $group_href = '<a href="' . get_permalink($post->post_parent) . '">Tillbaka till ' . $group_title . '</a>';
  $group_title .= ' - ';
}
?>

<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox paddingBoth">
      <header>
        <a href="<?php echo get_permalink(); ?>"><h1 class="entry-title"><?php echo $group_title; the_title(); ?></h1></a>
      </header>
      <div class="entry-content"><?php the_content(); ?></div>
      <div><?php echo $group_href; ?></div>
    </div>
  </div>
</article>
