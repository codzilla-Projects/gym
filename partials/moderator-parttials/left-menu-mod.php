<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
foreach ($pages as $page) {
  $dashLink = get_page_link($page->ID);
}

$current_user     = wp_get_current_user();
?>
<div class="left-menu">
	<ul class="right-mod-menu">	
		<li>
			<a href="<?php echo $dashLink ;?>">
				<i class="cmsmasters-icon-th-large-3"></i>
				Dashboard
			</a>
		</li>	
		<?php if ( in_array( 'gym-admin', (array) $current_user->roles ) ) {?>	
		<li>
			<a href="<?php echo $dashLink."?current-page=moderators" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/moderators-light.png" ?>">
				</figure>				
				Moderators
			</a>
		</li>	
		<?php } ?>	
		<li>
			<a href="<?php echo $dashLink."?current-page=coaches" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/coaches.png" ?>">
				</figure>				
				Coaches
			</a>
		</li>		
		<li>
			<a href="<?php echo $dashLink."?current-page=trainees" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/trainee.png" ?>">
				</figure>
				Trainees
			</a>
		</li>		
		<li>
			<a href="<?php echo $dashLink."?current-page=games" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/games.png" ?>">
				</figure>
				Games
			</a>
		</li>		
		<li>
			<a href="<?php echo $dashLink."?current-page=plans" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/plans.png" ?>">
				</figure>
				Plans
			</a>
		</li>		
		<li>
			<a href="<?php echo $dashLink."?current-page=scan" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/qr-code-white.png" ?>">
				</figure>
				Scan
			</a>
		</li>		
		<li>
			<a href="<?php echo $dashLink."?current-page=update-schedule" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/schedule-light.png" ?>">
				</figure>
				schedule
			</a>
		</li>		
		<?php if ( in_array( 'gym-admin', (array) $current_user->roles ) || in_array( 'administrator', (array) $current_user->roles ) ) {?>	
		<li>
			<a href="<?php echo $dashLink."?current-page=feeds" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/rss-white.png" ?>">
				</figure>
				Feeds
			</a>
		</li>		
		<li>
			<a href="<?php echo $dashLink."?current-page=attendance" ;?>">
				<figure>
					<img src="<?php echo SH_URL ."assets/images/attendance-light.png" ?>">
				</figure>				
				ِAttendance
			</a>
		</li>	
		<?php } ?>	

	</ul>
</div><!-- /left-menu- -->
</div><!-- /menu-dashboard -->
<div class="dashboard-content">