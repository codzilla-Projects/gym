<?php gym_user_login_check_redirect('trainee'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php wp_title() ?></title>
  <meta content="<?= get_bloginfo('description'); ?>" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= SH_URL; ?>favicon.png" rel="icon">
  <link href="<?= SH_URL; ?>favicon.png" rel="apple-touch-icon">
      <!-- Favicon -->
  <link rel="shortcut icon" href="<?= get_option('sh_favicon_img'); ?>" type="image/x-icon" />
  <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
 <?php wp_head(); ?>
</head>
<body class="sb-nav-fixed">
  <?php 
      $pages = get_pages(array(
          'meta_key' => '_wp_page_template',
          'meta_value' => 'page-templates/dashboard-index.php'
      ));
        foreach ($pages as $page) {
            $trainee_dashboard = get_page_link($page->ID);
        }
      $pages = get_pages(array(
          'meta_key' => '_wp_page_template',
          'meta_value' => 'page-templates/trainee-schedule.php'
      ));
        foreach ($pages as $page) {
            $trainee_schedule = get_page_link($page->ID);
        }
      $pages = get_pages(array(
          'meta_key' => '_wp_page_template',
          'meta_value' => 'page-templates/my-attendance.php'
      ));
        foreach ($pages as $page) {
            $attendance = get_page_link($page->ID);
        }

   ?>
  <header id="layoutSidenav_nav">         
        <div id="layoutSidenav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                      <a href="<?php echo $trainee_dashboard?>" class="main-logo"> 
                         <img class="img-fluid" src="<?php echo get_option('sh_logo_img') ?>" alt ="Pull It Gym" >
                      </a>
                        <?php 
                        
                          $ml_edit_profile         = get_option('ml_edit_profile');
                          $ml_feeds                = get_option('ml_feeds'); ?>
                        <ul class="main-menu">
                          <li>
                            <a href="<?php echo $trainee_dashboard ?>">
                                 <img class="img-fluid" src="<?php echo SH_URL . "assets/svg/myplan.svg" ?>" alt ="Pull It Gym" >
                                 <span>My Plan</span>                                   
                            </a>
                          </li>
                          <li>
                            <a href="<?php echo get_the_permalink($ml_feeds) ?>">
                                 <img class="img-fluid" src="<?php echo SH_URL . "assets/svg/feeds.svg" ?>" alt ="Pull It Gym" >
                                 <span>Feeds</span>                                   
                            </a>
                          </li>
                         <li>
                            <a href="<?php echo $attendance ?>" >                                    
                                 <img class="img-fluid" src="<?php echo SH_URL . "assets/images/attendance.png" ?>" alt ="Pull It Gym" >
                                 <span>Attendance</span>                                  
                            </a>
                          </li>                          
                         <li>
                            <a href="<?php echo $trainee_schedule ?>" >                                    
                                 <img class="img-fluid" src="<?php echo SH_URL . "assets/svg/calendar.svg" ?>" alt ="Pull It Gym" >
                                 <span>Schedule</span>                                    
                                 
                            </a>
                          </li>                          
                          <li>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#barcodeModal">                                    
                                 <img class="img-fluid" src="<?php echo SH_URL . "assets/images/qr-code1.png" ?>" alt ="Pull It Gym" >
                                 <span>My Code</span>                                    
                                 
                            </a>
                          </li>
                      </ul>                                
                    <div class="profile-nav">
                      <a href="javascript:void(0)" id="menu-profile-toggle">
                          <?php         
                             $current_user     = wp_get_current_user();
                             $uid = $current_user->data->ID;
                             $profile_picture  = get_user_meta(get_current_user_id() ,"pullit_profile_pic" ,true);
                            if(empty($profile_picture)): ?>
                            <img class="img-fluid" src="<?php echo SH_URL ."assets/images/user.png" ;?>" alt ="Pull It Gym" >
                            <?php else :?>
                            <img class="img-fluid" src="<?php echo $profile_picture ?>" alt ="Pull It Gym" >
                         <?php endif ;?>
                      </a>
                        <ul class="profile-ul">
                            <li>
                              <a href="<?php echo get_the_permalink($ml_edit_profile) ;?>">
                                   <i class="cmsmasters-icon-user-3"></i>
                                   <span>Profile</span>                                   
                              </a>
                            </li>                                
                            <li>
                              <a href="<?php echo wp_logout_url()?>">
                                   <i class="cmsmasters-icon-power-1"></i>
                                   <span>Logout</span>                                   
                              </a>
                            </li>                                
                        </ul>
                    </div>
                </div>
            </nav>
        </div><!-- /layoutSidenav_nav -->
  </header>
  <section class="body-content-wrapper">

