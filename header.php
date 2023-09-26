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
<body <?php body_class(); ?>>
  <header id="header">
    <div class="container">
      <div class="general-menu">
            <div class="row align-items-center">
                <div class="col-md-3 col-12">
                    <div class="main-logo">
                        <a href="<?php echo home_url("/"); ?>" class="main-logo"> 
                           <img class="img-fluid" src="<?php echo get_option('sh_logo_img') ?>" alt ="Pull It Gym" >
                        </a>
                    </div><!-- /main-logo -->                    
                </div><!-- /cols -->
                <div class="col-md-9 col-12">
                    <div class="menu-main">
                               <?php 
                      $args = array(
                        'theme_location' => 'main_menu',
                        'container'      =>  false,
                        'menu_class'     =>   'main-ul'               
                        );
                     if (has_nav_menu('main_menu')) {
                          wp_nav_menu( $args );
                            }?> 
                    </div>
                </div><!-- /cols -->
            </div>
      </div><!-- gerneral-menu -->
    </div><!-- /container -->
  </header>
