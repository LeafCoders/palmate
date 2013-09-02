<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox paddingBoth">
      <header>
        <a href="<?php echo get_permalink(); ?>"><h1 class="entry-title"><?php the_title(); ?></h1></a>
      </header>
      <div class="row-fluid">
        <div class="span7 paddingRight entry-content">
          <?php the_content(); ?>
        </div>
        <div class="span1"></div>
        <div class="span4 paddingLeft">
          <h2>Nyheter</h2>
          <?php echo palmate_get_newsgroup_contents(the_slug(false)); ?>
        </div>
      </div>
    </div>
  </div>
</article>
