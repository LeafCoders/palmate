<?php
  $menu_name = the_title('','',false);
  if ( is_nav_menu( $menu_name ) == false ) {
    global $post;
    $post_parents = get_post_ancestors( $post->ID );    
    if ( $post_parents and $post_parents[0] ) {
      $menu_name = get_the_title( $post_parents[0] );
    }
  }
?>

<?php if ( is_nav_menu( $menu_name ) ) : ?>
<header id="banner" class="navbar" role="banner">
  <div class="navbar-inner">
    <div class="container">
      <nav id="nav-main" role="navigation">
        <?php wp_nav_menu( array('menu' => $menu_name, 'fallback_cb' => '', 'walker' => new Roots_Navbar_Nav_Walker(), 'menu_class' => 'nav' ) ); ?>
      </nav>
    </div>
  </div>
</header>
<?php endif; ?>
