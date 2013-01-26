<header id="banner" class="navbar hidden-phone" role="banner">
  <div class="navbar-inner">
    <div class="container">
      <nav id="nav-main" role="navigation">
        <?php wp_nav_menu( array('theme_location' => 'primary_navigation', 'walker' => new Roots_Navbar_Nav_Walker(), 'menu_class' => 'nav' ) ); ?>
      </nav>
    </div>
  </div>
</header>
