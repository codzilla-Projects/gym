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
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">  


 <?php wp_head();
	$curresnt_user = wp_get_current_user();
	$curresnt_user_name  = $curresnt_user->user_nicename[0];
	$curresnt_user_mail  = $curresnt_user->user_email;
	$profile_picture  = get_user_meta(get_current_user_id() ,"pullit_profile_pic" ,true);
	$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
foreach ($pages as $page) {
	$dashLink = get_page_link($page->ID);
}
  ?>
</head>
<body class="<?php echo body_class() ?>">
	<header id="mod-header">
		<div class="container-fluid">
			<div class="row  align-items-center" >
				<div class="col-12 col-md-2">
                  <a href="<?php echo $dashLink ?>" class="main-logo"> 
	                   <img class="img-fluid" src="<?php echo get_option('sh_logo_img') ?>" alt ="Pull It Gym" >
                  </a>
				</div><!-- /cols -->
				<div class="col-12 col-md-7">
					<div class="shortcuts-area">
						<div class="left-side">
							<div class="close-shortcut">
								<i class="cmsmasters-icon-cancel-2"></i>						
							</div>							
						</div>					
						<div class="right-side">
							<a href="<?php echo $dashLink."?current-page=add-trainee" ?>" class="new-shortcut" title="Add New trainee">
								<i class="cmsmasters-icon-check-empty"></i>						
							</a>						
							<div class="search d-none">
								<form>
								    <input class="search-text" type="search" name="q-search" placeholder="search ..." >
								    <button type="submit" class="submit-search" name ="submit-search" >
								    	<i class="cmsmasters-icon-search-3"></i>
								    </button>
								</form>
								<div class="search-btn"><i class="cmsmasters-icon-search-3"></i></div>
							</div>							
						</div>					
					</div>
				</div><!-- /cols -->
				<div class="col-12 col-md-3">
					<div class="profile-area">
						<h3><?php echo $curresnt_user_mail ?></h3>
						<?php if (empty($profile_picture)): ?>
						<div class="img-area">
							<?php  echo $curresnt_user_name?>
						</div>
						<?php else:?>
                            <img src="<?php echo $profile_picture ?>" alt ="Pull It Gym"  class="img-profile">			
						<?php endif ?>
					</div>	
				</div><!-- /cols -->		
			</div><!-- /row -->
		</div><!-- /container -->
		<div class="menu-moderator">
			<div class="menu-circle">
				<a href="javascript:void(0)">
					<i class="cmsmasters-icon-menu"></i>
				</a>				
			</div>
		</div><!-- menu-moderator -->
	</header>
  