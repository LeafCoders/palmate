<div class="span3 blogbox well">
  <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php roots_entry_meta(); ?>
    </header>
    <div class="entry-content">
      <?php the_excerpt(); ?>
    </div>
  </article>
</div>