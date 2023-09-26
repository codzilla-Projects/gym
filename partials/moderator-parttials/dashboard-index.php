<?php 

$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));

foreach ($pages as $page) {
  $dashLink = get_page_link($page->ID);
}
$current_user     = wp_get_current_user();
$capcity = get_in_gym_users(get_user_gym_id());


?>

<div class="row">
		<?php if($_GET['message']): ?>
		<div class="alert alert-danger col-md-12 col-12" role="alert">
  		<?php echo stripslashes($_GET['message']) ?>
		</div>
	<?php endif;  ?>
	<div class="dachboard-item col-md-12 col-12">
			<div class="item-icon">
			<i class="cmsmasters-icon-user-group"></i>
			</div>
			Hall Capacity : <?php echo $capcity  ?>
	</div> 	
	<?php if ( in_array( 'gym-admin', (array) $current_user->roles ) ) {?>
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=moderators" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/moderators.png" ?>">
				</figure>				
				<h3 class="text-center">Moderators</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<?php } ?>
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=coaches" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/coaches.png" ?>">
				</figure>				
				<h3 class="text-center">Coaches</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=trainees" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/trainee.png" ?>">
				</figure>
				<h3 class="text-center">Trainees</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=games" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/games.png" ?>">
				</figure>
				<h3 class="text-center">Games</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=plans" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/plans.png" ?>">
				</figure>
				<h3 class="text-center">Plans</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=scan" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/qr-code1.png" ?>">
				</figure>
				<h3 class="text-center">Scan</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=update-schedule" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/schedule-.png" ?>">
				</figure>
				<h3 class="text-center">schedule</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<?php if ( in_array( 'gym-admin', (array) $current_user->roles ) || in_array( 'administrator', (array) $current_user->roles ) ) {?>
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=attendance" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/attendance.png" ?>">
				</figure>				
				<h3 class="text-center">Attendance</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<div class="col-md-4 col-12">
		<div class="menu-item-dashboard">
			<a href="<?php echo $dashLink."?current-page=feeds" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/rss.png" ?>">
				</figure>
				<h3 class="text-center">Feeds</h3>
			</a>
		</div><!-- /menu-item-dashboard -->						
	</div><!-- /colss -->
	<?php } ?>
</div><!-- /row -->