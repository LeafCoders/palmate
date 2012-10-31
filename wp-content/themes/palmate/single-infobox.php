<?php while (have_posts()) : the_post(); ?>
<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox marginBoth paddingBoth">
      <header>
        <h1 class="entry-title"><?php the_title(); ?></h1>
      </header>
      <div class="entry-content row-fluid">
        <div class="span6"><?php the_content(); ?></div>
        <div class="span6"><img class="img-polaroid" src="<?php echo get_field( 'infobox_image' ); ?>" alt="infobox" /></div>
      </div>
    </div>
  </div>
</article>
<?php endwhile; ?>