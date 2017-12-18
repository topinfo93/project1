<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta hTrạng tháip-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <!-- Include Sidr bundled CSS theme -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.sidr.dark.css">
    <!-- Your CSS -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style-dashboard.css">
  </head>
 <body>

    <div id="other-name">
      <h2 class="page_name">Happy Ship</h2>
      <ul>
          <li><a href="#">All Examples</a></li>
          <li>
              <a href="#">Sample link 2</a>
              <ul>
                  <li><a href="#">Child link 1</a></li>
                  <li><a href="#">Child link 2</a></li>
              </ul>
          </li>
          <li><a href="#">Sample link 3</a></li>
      </ul>
      <form>
          <input type="text" placeholder="Search..." />
      </form>
      <h2>Sample heading</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus mollis sapien non nisi sodales pulvinar. Curabitur odio velit, porta sit amet lobortis sit amet, volutpat ut justo.</p>
    </div>
    
    <div class="nav-menu-block">
      <div class="nav-menu-dashboard">
        <a id="only-click" class="menu-button" href="#sidr">Toggle menu</a>
        <span>Danh mục</span>
        <div class="nav-left-signin">
          <span class="welcome">
          <?php printf('%1$s %2$s',esc_html__('Xin chào', 'happy'),happy_get_meta('nickname')); ?>
            
          </span>
          <a id="log_out" class="logout-buTrạng tháion"><?php echo esc_html__('Đăng xuất', 'happy') ?></a>
        </div>
      </div>

    </div> 