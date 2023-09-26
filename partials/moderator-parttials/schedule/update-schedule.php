<?php 
	$user_id = get_current_user_id();
	$gym_id = get_user_gym_id($user_id);
	
    if(isset($_POST['working-pattern']) && !empty($_POST['working-pattern'])){
        if($gym_id) {
            update_post_meta($gym_id, 'sch_working_pattern', $_POST['working-pattern']);
            update_post_meta($gym_id, 'sch_starting', $_POST['starting-time']);
            update_post_meta($gym_id, 'sch_ending', $_POST['ending-time']);
            
            unset($_POST['working-pattern']);
            unset($_POST['starting-time']);
            unset($_POST['ending-time']);
    
            $schedule = array();
            foreach($_POST as $key => $value) {
                $key_tokens = explode('_', $key);
                //data selector index is 1
                //day index is 2
                //time index is 3
                $schedule[$key_tokens[2]][$key_tokens[3]][$key_tokens[1]] = $value;
            }
    
            update_post_meta($gym_id, 'sl_schedule', $schedule);
            $notice = array(
                'type' 		=> 'updated',
                'message' 	=> 'Data was updated successfully'
            );
        }
	}

	// $all_games = get_posts(array(
	// 	'post_type' 		=> 'game',
	// 	'posts_per_page' 	=> -1,
	// 	'post_status' 		=> 'any'
	// ));
	$all_games = pullit_get_gym_games(get_user_gym_id()); 

	$all_coaches = pullit_get_gym_users( get_user_gym_id(), array('coach'));

	$old_data = get_post_meta($gym_id, 'sl_schedule', true);
	$old_data = json_encode($old_data);

	$working_pattern = get_post_meta($gym_id, 'sch_working_pattern', true);
	$starting = get_post_meta($gym_id, 'sch_starting', true);
	$ending = get_post_meta($gym_id, 'sch_ending', true);

	//globalizing data
	echo "<script type=\"text/javascript\"> window.oldData = '{$old_data}';</script>";
	echo "<script type=\"text/javascript\"> window.working_pattern = '{$working_pattern}';</script>";
	echo "<script type=\"text/javascript\"> window.starting = '{$starting}';</script>";
	echo "<script type=\"text/javascript\"> window.ending = '{$ending}';</script>";
	// echo '<pre>';
	// print_r($old_data);
	// echo '</pre>';

	if(!empty($notice)) {
		// echo "<div id=\"message\" class=\"{$notice['type']} notice is-dismissible'\"><p>{$notice['message']}.</p><button type=\"button\" class=\"notice-dismiss\"><span class=\"screen-reader-text\">Dismiss this notice.</span></button></div>";
	}
?>
<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
<script type="text/javascript" src="<?php echo SH_URL .'assets/admin/js/schedule-functions.js' ?>"></script>
	<div id="content-wrapper">
			<div class="card-container">
				<div class="card-head">
					<h3>Month Shcedule</h3>
				</div>
				<div class="card-data-body">
					<form action="#" method="post">
						<div class="working-hour">
							<h4>Working Hours</h4>
							<select name="working-pattern" id="working-pattern">
								<option value="24" selected>24 hours</option>
								<option value="limited">Limited</option>
							</select>							
						</div>
						<div id="hours-limits" style="display: none;">
							<div class="form-group">
								<label for="starting-time">Starting Hour</label>
								<input type="time" name="starting-time" id="starting-time" value="00:00">
							</div>
							<div class="form-group" style="margin-left: 15px">
								<label for="ending-time">Ending Hour</label>
								<input type="time" name="ending-time" id="ending-time" value="23:00">
							</div>
						</div>
						<div class="navigate-schedule">
							<table class="table table-striped" id="schedule-table">
								<thead></thead>
								<tbody></tbody>
							</table>
							<div class="form-group text-center">
								<input type="submit" value="Update Data" class="button-primary btn btn-theme">
							</div>
								<!-- <button type="button" class="btn_choose_sent bg_btn_chose_1">
									<input type="radio" name="name" checked />Female
								</button>
								<button type="button" class="btn_choose_sent bg_btn_chose_2">
									<input type="radio" name="name" />Male
								</button> -->
						</div>
					</form>
				</div>
				<div id="games-data" 
					data-ids="<?php foreach($all_games as $game) echo $game->ID.','; ?>"
					data-names="<?php foreach($all_games as $game) echo $game->post_title.','; ?>"
				>&nbsp;</div>
				<div id="coaches-data" 
					data-ids="<?php foreach($all_coaches as $coach) echo $coach->ID.','; ?>"
					data-names="<?php foreach($all_coaches as $coach) echo $coach->data->display_name.'###'; ?>"
				>&nbsp;</div>
			</div>
		</div>
	</div>
</section>

<?php 