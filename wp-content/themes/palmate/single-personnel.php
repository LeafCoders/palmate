<?php if (have_posts()) : the_post(); ?>
<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox paddingBoth">
      <br>
      <?php echo palmate_get_personnel_text(); ?>
      <a href="/forsamlingen/personal">Visa all personal</a>
    </div>
  </div>
</article>
<?php endif; ?>
