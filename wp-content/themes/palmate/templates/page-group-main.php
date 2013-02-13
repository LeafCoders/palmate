<div class="row-fluid">
  <div class="span12">
    <div class="contentBox contentGroupHeader marginBoth paddingBoth" style="background-image: url('/assets/img/content/group_<?php the_slug(); ?>.jpg');">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>
</div>
<?php if (mb_strlen(get_the_content()) > 20) : ?>
<div class="row-fluid">
  <div class="span12">
    <div class="contentBox marginMoveUp marginBoth paddingBoth">
      <?php the_content(); ?>
    </div>
  </div>
</div>
<?php endif; ?>