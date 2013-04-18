<form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url('/'); ?>">
  <div style="margin: 0 auto; width: 290px;">
    <div class="input-append">
      <label class="hide" for="s"><?php _e('Search for:', 'roots'); ?></label>
      <input type="text" value="" name="s" id="s" class="search-query" placeholder="<?php _e('Search', 'roots'); ?> <?php bloginfo(); ?>">
      <input type="submit" id="searchsubmit" value="<?php _e('Search', 'roots'); ?>" class="btn">
    </div>
  </div>
</form>
