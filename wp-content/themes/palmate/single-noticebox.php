<?php while (have_posts()) : the_post(); ?>
<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox paddingBoth">
      <header>
        <h1 class="entry-title"><?php the_title(); ?></h1>
      </header>
      <div class="entry-content row-fluid">
        <div class="span7"><?php the_content(); ?></div>
        <div class="span5 paddingLeft"><img class="img-polaroid" src="<?php echo get_field( 'noticebox_image' ); ?>" alt="notis"></div>
      </div>
    </div>
  </div>
</article>
<?php endwhile; ?>