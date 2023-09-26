<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
$dashLink = get_page_link($pages[0]->id);

$days=array('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
$games = pullit_get_gym_games(get_user_gym_id()); 

if (isset($_GET['action']) && $_GET['action'] === "edit") {
	$editbtn  =  "update";
	$uid = $_GET['uid'];
	$data = gym_get_caoch_data($uid);
}else{
	$editbtn  =  "Add";	
}


if(isset($_POST['saveCoach']) && $_POST['saveCoach'] === "Add"){

	$response = gym_save_new_coach($_POST,$_FILES);

	if($response['status'] == 1)
	    echo '<script> window.location.href="'.$dashLink."?current-page=coaches".'"</script>';	


}elseif (isset($_POST['saveCoach']) && $_POST['saveCoach'] === "update") {

	$response = gym_update_coach($_POST,$_FILES);

	if($response['status'] == 1)
    echo '<script> window.location.href="'.$dashLink."?current-page=coaches".'"</script>';

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
		<a href="<?php echo $dashLink."?current-page=add-coach" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=coaches" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Coaches
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/myplan.svg" ?>">
			Add Coach
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
			</div><!-- /row -->
			<div class="row">
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
			</div><!-- /row -->
			 <fieldset id="user-gender">
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
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="input-group">
				    	<?php if(!empty($data)){$coach_games = $data->categories; }else{ $coach_games = []; }  ?>
						<label>Select Game(s)</label><br>
						<select  multiple name="gym-user-games[]">
						<?php foreach ($games as $game) : if(empty(	$game ->ID)) continue ?>
	                        <option value="<?= $game->ID; ?>" <?php if( in_array($game->ID, $coach_games) ) echo "selected"; ?> ><?php echo $game->post_title; ?></option>
                        <?php endforeach; ?>
						</select>
					</div>					
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
					<div class="input-group">
				    	<?php if(!empty($data)){$coach_days = $data->days; }else{ $coach_days = []; }  ?>
						<label>Select Attendance Days</label><br>
						<select  multiple name="gym-user-attendance[]">
						<?php foreach ($days as $day)  : ?>
							<option value="<?= $day; ?>" <?php if( in_array($day, $coach_days) ) echo "selected"; ?> ><?php echo $day; ?></option>
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
                        <i class="cmsmasters-icon-upload-cloud"></i>Select Coach Image
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
