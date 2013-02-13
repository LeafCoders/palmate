<article class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox marginBoth paddingBoth">
      <header>
        <a href="/nyheter"><h1 class="entry-title">Nyheter</h1></a>
      </header>
      <?php
      while (have_posts()) :
        the_post();
        echo palmate_get_the_news_content(false);
      endwhile;
      $big = 999999999;
      echo paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
      ));
      ?>
    </div>
  </div>
</article>
