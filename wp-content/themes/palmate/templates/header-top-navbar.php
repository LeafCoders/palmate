<header id="banner" role="banner">
  <div class="header-image">
    <a href="/">
      <br class="hidden-phone">
      <div class="row-fluid">
        <div class="span12">
          <img src="<?php get_template_directory_uri() ?>/assets/img/header-logo.png">
        </div>
      </div>
      <br class="hidden-phone">
    </a>
  </div>
  <div id="mobileMenuToggle" class="visible-phone" onclick="$('#mobileMenu').toggle();">Meny</div>
  <div id="mobileMenu">
    <nav onclick="$('#mobileMenu').toggle(false);">
      <div class="mobileMenuHeader">
        <a href="/#">
          <img src="<?php get_template_directory_uri() ?>/assets/img/header-logo.png">
        </a>
      </div>
      <?php wp_nav_menu(array('theme_location' => 'mobile_navigation', 'menu_class' => 'mobileNav')); ?>
    </nav>
  </div>
  <div class="navbar hidden-phone">
    <div class="navbar-inner">
      <nav id="nav-main" class="nav" role="navigation">
        <?php wp_nav_menu(array('theme_location' => 'desktop_navigation', 'menu_class' => 'nav')); ?>
      </nav>
    </div>
  </div>
</header>
