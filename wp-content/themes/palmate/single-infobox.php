<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class() ?> id="post-<?php the_ID(); ?>">
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
    <div class="entry-content">
      <?php
        $img_url = get_field( 'infobox_image' );
        if ( !empty( $img_url ) ) {
          echo '<div class="infobox"><img src="' . $img_url . '" class="img-polaroid" /></div>';
        }
        the_content();
      ?>
    </div>
  </article>
<?php endwhile; ?>