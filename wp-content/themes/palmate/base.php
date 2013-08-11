<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->
  <div id="content">
    <?php get_template_part('templates/header-top-navbar'); ?>

    <div id="wrap" class="container-fluid marginBoth" role="document">
      <?php include roots_template_path(); ?>
      <?php get_template_part('templates/footer'); ?>
    </div>
  </div>

</body>
</html>