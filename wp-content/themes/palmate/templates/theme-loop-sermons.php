<?php
  // Find connected sermons to this theme
  $connected = new WP_Query( array(
    'connected_type' => 'sermons_to_themes',
    'connected_items' => get_queried_object(),
    'nopaging' => true,
  ) );
?>

<?php /* Print the rest of the posts with span3 */ ?>
<div class="row-fluid">
  <?php $counter = 0; while ( $connected->have_posts() ) : $connected->the_post(); ?>
    <?php if ( $counter == 4 ) : $counter = 0; ?>
      </div>
      <div class="row-fluid">
    <?php endif; $counter++; ?>
    <?php get_template_part('templates/post', 'span3'); ?>
  <?php endwhile; ?>
</div>

<?php wp_reset_postdata(); // Set $post back to original post ?>
