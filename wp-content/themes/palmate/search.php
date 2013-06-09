<?php if ( have_posts() ) : ?>
  <article id="searchResult" class="hentry row-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div id="searchBox" class="contentBox paddingBoth">
          <?php echo palmate_search_shortcode(); ?>
        </div>
      </div>
    </div>
    <div class="span12">
      <div class="contentBox paddingBoth">
        <header>
          <h3><small>Sökresultat för</small></h3>
          <h1 class="entry-title">"<?php echo get_search_query(); ?>"</h1>
        </header>
        <div class="entry-content hideHref">
          <?php while ( have_posts() ) : ?>
            <div class="row-fluid">
            <?php for ( $i = 0; $i < 2;) : the_post() ?>
              <?php if ( get_the_title() != "Hem" ) : $i++ ?>
                <div class="span6 paddingBoth">
                  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <h2><?php the_title(); ?></h2>
                    <?php
                      if ( get_post_type() == "personnel") : echo "Personal";
                      elseif ( get_post_type() == "churchleader") : echo "Församlingsledare";
                      elseif ( get_post_type() == "boardleader") : echo "Råd";
                      else : the_excerpt();
                      endif;
                    ?>
                  </a>
                </div>
              <?php endif; ?>
            <?php endfor; ?>
          </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </article>
<?php else : ?>
  <article id="searchResult" class="hentry row-fluid no-results not-found">
    <div class="row-fluid">
      <div class="span12">
        <div id="searchBox" class="contentBox paddingBoth">
          <?php echo palmate_search_shortcode(); ?>
        </div>
      </div>
    </div>
    <div class="span12">
      <div class="contentBox paddingBoth">
        <header>
          <h1 class="entry-title">Hittade inget</h1>
        </header>
        <div class="entry-content">
          <p>Hittade inga sidor med innehållet: <?php echo get_search_query(); ?></p>
        </div>
      </div>
    </div>
  </article>
<?php endif; ?>
