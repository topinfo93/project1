<!DOCTYPE html>
<html <?php language_attributes(); ?>>
   <head>
   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap-responsive.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/theme.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.cslider.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.bxslider.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/animate.css" />
   <!--[if IE 7]>
      <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/pluton-ie7.css" />
   <![endif]-->  
      <?php wp_head(); ?>
   </head>
   <body <?php body_class(); ?>>
      
      <div class="navbar">
         <div class="navbar-inner">
             <div class="container">
                 <a href="#" class="brand top-logo">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/happy_ship.png" width="120" height="120" alt="Logo" />
                 </a>
                 <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                     <i class="icon-menu"></i>
                 </button>
                 <div class="nav-collapse collapse pull-right">
                  <?php wp_nav_menu( array(
                          'theme_location' => 'main-menu',
                          'container' => false,
                          'menu_id' => 'top-navigation',
                          'menu_class' => 'nav',
                          'depth' => 1
                  )); ?>
                 </div>
                
             </div>
         </div>
     </div>
