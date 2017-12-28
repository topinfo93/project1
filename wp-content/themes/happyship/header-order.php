<!DOCTYPE html>
<html <?php language_attributes(); ?>>
   <head>
   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap-responsive.css" />
   <!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/style.css" /> -->
   <!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/theme.css" /> -->
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.cslider.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/jquery.bxslider.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/animate.css" />
   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets_backend/css/style-dashboard.css" />
   <!--[if IE 7]>
      <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/pluton-ie7.css" />
   <![endif]-->  
      <?php wp_head(); ?>
   </head>
   <body <?php body_class(); ?>>
      <div class="nav-menu-block">
         <div class="nav-menu-dashboard">
           <div class="nav-left-signin">
             <span class="welcome">Xin chào <?php echo wp_get_current_user()->display_name;?>!</span>
             <a id="log_out" class="logout-button" href="<?php echo wp_logout_url(); ?>">Đăng xuất</a>
           </div>
         </div>

       </div> 