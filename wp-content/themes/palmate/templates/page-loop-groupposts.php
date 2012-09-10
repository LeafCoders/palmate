<?php
  // Find connected posts to this page
  $connected = new WP_Query( array(
    'connected_type' => 'posts_to_pages',
    'connected_items' => get_queried_object(),
    'nopaging' => true,
  ) );
?>

<?php /* Print one post with span12 */ ?>
<?php if ( $connected->have_posts() ) : $connected->the_post(); ?>
  <div class="row-fluid">
    <?php get_template_part('templates/post', 'span12'); ?>
  </div>
<?php endif; ?>

<?php /* Print two posts with span6 */ ?>
<?php if ( $connected->have_posts() ) : $connected->the_post(); ?>
  <div class="row-fluid">
    <?php get_template_part('templates/post', 'span6'); ?>
    <?php if ( $connected->have_posts() ) : $connected->the_post(); ?>
      <?php get_template_part('templates/post', 'span6'); ?>
    <?php endif; ?>
  </div>
<?php endif; ?>

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
