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
   <!--[if IE 7]>
      <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/pluton-ie7.css" />
   <![endif]-->  
      <?php wp_head(); ?>
   </head>
   <body <?php body_class(); ?>>
      <div class="head-infobar">
        <div class="container">
          <div class="header-bar-left">
            <ul class="contact show-destop">
              <li><a href="tel: 0901231234"><span class="icon-phone"></span>0901231234</a></li>
              <li><a href="" class='zalo-chat'><span class="icon-zalo"></span>0901231234</a></li>
            </ul>
          </div>
          <div class="header-bar-right">
            <ul class="social">
              <li class="facebook">
                  <a href="#" target="_blank" rel="alternate" title="facebook.com/"><span class="icon-fa icon-facebook-circled"></span></a>
              </li>
              
              <li class="instagram">
                  <a href="#" target="_blank" rel="alternate" title="#"><span class="icon-fa icon-linkedin-circled"></span></a>
              </li>
              <li class="google-plus">
                  <a href="#" target="_blank" rel="alternate" title="#"><span class="icon-fa icon-gplus-circled"></span></a>
              </li>
            </ul>
            <div class="member-action">
              
              <?php if(is_user_logged_in()) { ?>
              <span>Chào <?php echo wp_get_current_user()->display_name;?>!</span>
              <a href="<?php echo wp_logout_url(); ?>" class="signout">Đăng Xuất</a>
              <a href="<?php echo  home_url( 'member-infomation' ); ?>" class="">Tài khoản</a>
              <?php } else { ?>
              <span>Xin chào!</span>
              <a href="<?php echo home_url( 'member-login' ); ?>" class="signin"><span>Đăng Nhập</span></a>
              <a href="<?php echo wp_registration_url(); ?> " class="register"><span>Đăng Ký</span></a>
              <?php }?>
              
            </div>
          </div>
        </div>
      </div>
      <div class="navbar">
         <div class="navbar-inner">
             <div class="container">
                 <a href="#" class="brand top-logo">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/happy_ship.png" width="120" height="120" alt="Logo" />
                 </a>
                 <a href="tel: 0901231234" class="show-mobile"><span class="icon-phone"></span>0901231234</a>
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
