<div class="row-fluid">
  <div class="span12 titlebox">
    <?php if ( get_post_thumbnail_id() > 0 ) : ?>
      <div class="img-container">
        <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="img-rounded" />
        <h1><?php the_title(); ?></h1>
      </div>
    <?php else : ?>
      <h1><?php the_title(); ?></h1>
    <?php endif; ?>
  </div>
</div>
