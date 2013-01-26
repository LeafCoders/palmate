<?php if ( have_posts() ) : ?>
  <article id="searchResult" class="hentry row-fluid">
    <div class="span12">
      <div class="contentBox marginBoth paddingBoth">
        <header>
          <h1 class="entry-title"><small>Sökresultat för: </small><br> <?php echo get_search_query(); ?></h1>
        </header>
        <div class="entry-content">
  <?php while ( have_posts() ) : the_post(); ?>
          <h2><?php the_title(); ?></h2>
          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_excerpt("Läs mer..."); ?></a>
  <?php endwhile; ?>
        </div>
      </div>
    </div>
  </article>
<?php else : ?>
  <article id="searchResult" class="hentry row-fluid no-results not-found">
    <div class="span12">
      <div class="contentBox marginBoth paddingBoth">
        <header>
          <h1 class="entry-title">Hittade inget</h1>
        </header>
        <div class="entry-content">
          <p>Hittade inga sidor med innehållet: <?php echo get_search_query(); ?></p>
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </article>
<?php endif; ?>
