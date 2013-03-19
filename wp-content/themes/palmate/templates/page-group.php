<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox marginBoth paddingBoth">
      <header>
        <a href="<?php echo get_permalink(); ?>"><h1 class="entry-title"><?php the_title(); ?></h1></a>
      </header>
      <div class="entry-content"><?php the_content(); ?></div>
    </div>
  </div>
</article>
