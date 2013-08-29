<?php if (have_posts()) : the_post(); ?>
<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span10 offset1">
    <div class="contentBox paddingBoth">
      <header>
        <a href="/nyheter"><h1 class="entry-title">Nyheter</h1></a>
      </header>
      <?php echo palmate_get_the_news_content(); ?>
      <a href="/nyheter">Visa alla nyheter</a>
    </div>
  </div>
</article>
<?php endif; ?>
