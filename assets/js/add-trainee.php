<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
$dashLink = get_page_link($pages[0]->id);

$gym_id = get_user_gym_id();
$games = pullit_get_gym_games($gym_id); 
$plans = pullit_get_gym_plans($gym_id);
$coaches = pullit_get_gym_users($gym_id,'coach');

if (isset($_GET['action']) && $_GET['action'] === "edit") {
	$editbtn  =  "update";
	$uid = $_GET['uid'];
	$data = gym_get_trainee_data($uid);
	$user_plan = $data->traineeplan;
}else{
	$editbtn  =  "Add";	
}

if(isset($_POST['saveCoach']) && $_POST['saveCoach'] === "Add"){

	$response = gym_save_new_trainee($_POST,$_FILES);

	if($response['status'] == 1)
	    echo '<script> window.location.href="'.$dashLink."?current-page=trainees".'"</script>';	

}elseif (isset($_POST['saveCoach']) && $_POST['saveCoach'] === "update") {

	$response = gym_update_trainee($_POST,$_FILES);

	if($response['status'] == 1)
    echo '<script> window.location.href="'.$dashLink."?current-page=trainees".'"</script>';
}
?>
 <?php if(isset($response) && $response['status'] == 0) :?>
 <div class="alert alert-danger">
	<?php foreach ($response['msg'] as $msg) : ?>
		<p><?= $msg; ?></p>
	<?php endforeach; ?> 	
 </div>
<?php endif; ?>
<div class="card-dasboard">
	<div class="controls">
		<a href="<?php echo $dashLink."?current-page=add-trainee" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>

		<a href="<?php echo $dashLink."?current-page=trainees" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Trainees
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/myplan.svg" ?>">
			<?= $_GET['action'];  ?> Trainee
		</div>
		<div class="card-data-body">
		<form method="post" action="#" enctype="multipart/form-data">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="text" name="gym-first-name" placeholder="First Name"  class="input-theme" value="<?= !empty($data) ? $data->first_name : ''; ?>">
					</div>					
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="text" name="gym-last-name" placeholder="Last Name"  class="input-theme" value="<?= !empty($data) ? $data->last_name : ''; ?>">
					</div>					
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="text" name="gym-user-name" placeholder="User Name"  class="input-theme" value="<?= !empty($data) ? $data->user_login : ''; ?>" <?php if($editbtn  ==  "update"){echo "readonly" .'  data_id="readOnly"';} ?>>
					</div>
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="email" name="gym-user-email" placeholder="User Email"  class="input-theme" value="<?= !empty($data) ? $data->user_email : ''; ?>" <?php if($editbtn  ==  "update"){echo "readonly" .'  data_id="readOnly"';} ?>>
					</div>
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="text" name="gym-user-address" placeholder="Address"  class="input-theme" value="<?= !empty($data) ? $data->address : ''; ?>">
					</div>					
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="text" name="gym-user-phone" placeholder="Phone Number"  class="input-theme" value="<?= !empty($data) ? $data->phone : ''; ?>">
					</div>					
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="password" name="gym-user-password" placeholder="Password"  class="input-theme" value="">
					</div>			
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="password" name="gym-user-password-confirmation" placeholder="Password Confirmation"  class="input-theme" value="">
					</div>
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<label>Select Plan</label><br>
						<select  name="gym-user-plan" class="input-theme">
							<option>Please Select</option>
						<?php foreach ($plans as $plan)  : ?>
							<option value="<?= $plan->ID; ?>" <?= $user_plan == $plan->ID ?'selected':''; ?>><?php echo $plan->post_title; ?></option>
						<?php endforeach; ?>						
                  		</select>
					</div>			
				</div><!-- /cols -->

				<div class="col-12 col-md-6">
					<div class="input-group">
						<label>Start Date</label>
						<input type="text" name="gym-user-start-date" placeholder="Start Date"  class="input-theme" value="<?= $data->start_date; ?>" id="start_date" >
					</div>			
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
						<label>End Date</label>
						<input type="text" name="gym-user-end-date" placeholder="End Date"  class="input-theme" value="<?= $data->end_date; ?>" id="end_date" >
					</div>
				</div><!-- /cols -->
			</div><!-- /row -->
			<div class="row">
				<?php /* ?>
 				<div class="col-12 col-md-6">
					<div class="input-group" class="input-theme">
				    	<?php if(!empty($data)){$coach_games = $data->categories; }else{ $coach_games = []; }  ?>
						<label>Select Game(s)</label><br>
						<select  multiple name="gym-user-games[]" class="input-theme">
						<?php foreach ($games as $game) : ?>
	                        <option value="<?= $game->ID; ?>" <?php if( in_array($game->ID, $coach_games) ) echo "selected"; ?> ><?php echo $game->post_title; ?></option>
                        <?php endforeach; ?>
						</select>
					</div>					
				</div>
				<div class="col-12 col-md-6">
					<div class="input-group">
				    	<?php if(!empty($data)){$coach_days = $data->days; }else{ $coach_days = []; }  ?>
						<label>Select Attendance Days</label><br>
						<select  multiple name="gym-user-attendance[]" class="input-theme">
						<?php foreach ($days as $day)  : ?>
							<option value="<?= $day; ?>" <?php if( in_array($day, $coach_days) ) echo "selected"; ?> ><?php echo $day; ?></option>
						<?php endforeach; ?>						
                  		</select>
					</div>					
				</div>
				<?php */ ?>
				<div class="col-12 col-md-6">
					<div class="input-group">
						<label>Trainee has a private coach</label>
						<input type="checkbox" name="gym-user-has-private" onclick='handleClick(this)'  value="1" <?= $data->has_private_trainer ?'checked' : ''; ?> >
					</div>
				</div><!-- /cols -->
				<fieldset id="user-gender" class="col-12 col-md-6">
				 	Gender
				    <label for="r1">
				    	<?php if(!empty($data)){$gender = $data->gender; }  ?>
				      <input type="radio" id="r1" name="gym-user-gender" value="female" <?= $gender == 'female' ? 'checked' : ''; ?> >
				      <span class="label-text">Female</span>
				    </label>
				    <label for="r2">
				      <input type="radio" id="r2" name="gym-user-gender" value="male" <?= $gender == 'male' ? 'checked' : ''; ?> >
				      <span class="label-text">Male</span>
				    </label>
				    </fieldset>
				<div class="col-12 col-md-6">
					<div class="input-group" id="coach-selecting">
						<label>Select Coach</label><br>
						<select name="gym-user-caoch-id" class="input-theme">
							<option>Please Select</option>
						<?php foreach ($coaches as $coach)  : ?>
							<option value="<?= $coach->ID; ?>" <?= $data->private_trainer_id ? 'selected' : ''; ?> ><?php echo $coach->display_name; ?></option>
						<?php endforeach; ?>						
                  		</select>
					</div>					
				</div><!-- /cols -->
			</div><!-- /row -->
			<div class="input-group">
				<?php if(!empty($data->profile_pic)) : ?>
				<img src="<?= $data->profile_pic; ?>" class="img-fluid">
				<?php endif; ?>
                <div class='file'>
                    <label for='input-file'>
                        <i class="cmsmasters-icon-upload-cloud"></i>Select Trainee Image
                    </label>
					<input type="file" name="gym-plan-image" class="input-theme" id='input-file' >
                </div>  


			</div>
			<input type="hidden" name="gym-user-id" value="<?= $uid;?>">
			<button name="saveCoach" value="<?php echo $editbtn ?>" class="btn btn-theme-2 addingBtn"><?php echo $editbtn ?></button>
		</form>
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->
</div>
