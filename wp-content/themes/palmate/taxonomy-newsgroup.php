<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span10 offset1">
    <div class="contentBox marginBoth paddingBoth">
      <header>
        <h1 class="entry-title">Nyheter - <?php echo get_queried_object()->name; ?></h1>
      </header>
      <?php
      while (have_posts()) : the_post();
        echo palmate_get_the_news_content();
      endwhile;
      ?>
      <a href="/nyheter">Visa alla nyheter</a>
    </div>
  </div>
</article>
