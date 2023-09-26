<?php 
sh_check_logged_in();
$user_id = get_current_user_id();
$myplan = get_post(get_user_meta($user_id,'trainee_plan',true));
$num = get_post_meta($myplan->ID,'ha_session_num',true);
$startDate = get_user_meta( $user_id, 'trainee_start_date', true );
$endDate = get_user_meta( $user_id, 'trainee_end_date', true );

?>
    <section class="single-post">
    <div class="conatiner">
		<div class="row ">
			<div class="col-12 col-md-5 ">
				<div class="dachboard-item second-color">
					<div class="item-icon">
						<i class="cmsmasters-icon-clipboard"></i>
					</div>
					Session Numbers:  <?php echo $num ; ?> Sessions
				</div> 						
			</div>	<!-- /cols -->
			<div class="col-12 col-md-5 ">
			</div>	<!-- /cols -->
			<div class="col-12 col-md-5 ">
				<div class="dachboard-item third-color">
					<div class="item-icon">
						<i class="cmsmasters-icon-calendar-empty"></i>
					</div>
					Start Date:  <?php echo $startDate ; ?>
				</div> 						
			</div>	<!-- /cols -->
			<div class="col-12 col-md-5 ">
				<div class="dachboard-item forth-color">
					<div class="item-icon">
						<i class="cmsmasters-icon-calendar"></i>
					</div>
					End Date:  <?php echo $endDate ; ?>
				</div> 						
			</div>	<!-- /cols -->
		</div><!-- /row -->                
    </div><!-- /conatiner -->
</section><!-- /single-post -->
