<?php if (have_posts()) : the_post(); ?>
<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox marginBoth paddingBoth">
      <header>
        <a href="/nyheter"><h1 class="entry-title">Nyheter</h1></a>
      </header>
      <?php echo palmate_get_the_news_content(false); ?>
      <a href="/nyheter">Visa alla nyheter</a>
    </div>
  </div>
</article>
<?php endif; ?>
