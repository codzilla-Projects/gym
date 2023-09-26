<?php 
/**
** Template Name:  Dashboard  Index
**/
   $current_user     = wp_get_current_user();
   $uid              = $current_user->data->ID; 

if ( in_array( 'coach', (array) $current_user->roles ) ) {
	get_header('coach');
}else if ( in_array( 'trainee', (array) $current_user->roles ) ) {
	get_header('subscriber');
}
else{
  if (!is_user_logged_in()) {
    wp_redirect(home_url('login'));
    exit;
  }
	get_header();

}

$capcity = get_in_gym_users(get_user_gym_id());
 ?>

 <section class="main-dashboard">
 	<div class="container">
 		<div class="row justify-content-between">
 			<div class="col-md-8 col-12">
 				<div class="row ">
 					<div class="col-12 col-md-5 ">
		 				<div class="dachboard-item">
		 					<div class="item-icon">
		 						<i class="cmsmasters-icon-user-group"></i>
		 					</div>
		 					Hall Capacity : <?php echo $capcity  ?>
		 				</div> 						
 					</div>	<!-- /cols -->
 				</div><!-- /row -->
 				<?php if (in_array('coach',(array) $current_user->roles)): ?>
 					<?php get_template_part("partials/coach","trainees"); ?>
 					<?php elseif ( in_array( 'trainee', (array) $current_user->roles ) ):
 					 get_template_part("partials/plan","partials"); ?> 					
 				<?php endif ?>
 			</div>	<!-- /cols -->
 			<div class="col-md-4 col-12">
 				<div id="app">
					<section id="myCalendar">
					  <div class="hbContainer">
					    <div class="calendarYearMonth center">
					      <p class="left calBtn" onclick="prevMonth()"> <i class="cmsmasters-icon-angle-left"></i> </p>
					      <h2 id="yearMonth"></h2>
					      <p class="right calBtn" onclick="nextMonth()"> <i class="cmsmasters-icon-angle-right"></i></p>
					    </div>
					    <div>
					      <ol class="calendarList1">
					        <li class="day-name">Sat</li>
					        <li class="day-name">Sun</li>
					        <li class="day-name">Mon</li>
					        <li class="day-name">Tue</li>
					        <li class="day-name">Wed</li>
					        <li class="day-name">Thu</li>
					        <li class="day-name">Fri</li>
					      </ol>
					      <ol class="calendarList2" id="calendarList">
					      </ol>
					    </div>
					  </div>
					</section>
				</div>
 			</div>	<!-- /cols -->
 		</div><!-- /row -->
 	</div><!-- /container -->
 </section>
 <?php get_footer(); ?>