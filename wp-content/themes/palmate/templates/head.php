<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <meta name="apple-mobile-web-app-capable" content="yes" />

  <script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/modernizr-2.6.2.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/jquery-1.8.1.min.js"><\/script>')</script>
  <script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/swipe.min.js"></script>

  <link href='http://fonts.googleapis.com/css?family=Lato:900' rel='stylesheet' type='text/css' />
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/ryttargardskyrkan.ico" />
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/touch-icon-iphone.png" />
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/img/touch-icon-ipad.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/img/touch-icon-iphone-retina.png" />
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/img/touch-icon-ipad-retina.png" />
  <link rel="apple-touch-startup-image" href="<?php echo get_template_directory_uri(); ?>/assets/img/touch-startup.png" />
  <link rel="apple-touch-startup-image" sizes="640x920" media="(device-width: 320px) and (-webkit-device-pixel-ratio: 2)"
        href="<?php echo get_template_directory_uri(); ?>/assets/img/touch-startup-retina.pmg" />
  <link rel="apple-touch-startup-image" sizes="640x1096" href="<?php echo get_template_directory_uri(); ?>/assets/img/touch-startup-retina-5.png" />

  <?php wp_head(); ?>
</head>