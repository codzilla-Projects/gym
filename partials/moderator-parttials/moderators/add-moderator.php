<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
$dashLink = get_page_link($pages[0]->id);
$current_user     = wp_get_current_user();

if (isset($_GET['action']) && $_GET['action'] === "edit") {
	$editbtn  =  "update";
	$uid = $_GET['uid'];
	$data = gym_get_moderator_data($uid);
}else{
	$editbtn  =  "Add";	
}

if(isset($_POST['saveModerator']) && $_POST['saveModerator'] === "Add"){

	$response = gym_save_new_moderator($_POST);
	if($response['status'] == 1)
	    echo '<script> window.location.href="'.$dashLink."?current-page=moderators".'"</script>';	


}elseif (isset($_POST['saveModerator']) && $_POST['saveModerator'] === "update") {

	$response = gym_update_moderator($_POST);

	if($response['status'] == 1)
    echo '<script> window.location.href="'.$dashLink."?current-page=moderators".'"</script>';

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
		<a href="<?php echo $dashLink."?current-page=add-moderator" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=moderators" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Moderators
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/myplan.svg" ?>">
			Add Moderator
		</div>
		<div class="card-data-body">
		<form method="post" action="#" >
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
						<input type="email" name="gym-user-email" placeholder="User Email"  class="input-theme" value="<?= !empty($data) ? $data->user_email : ''; ?>" <?php if($editbtn  ==  "update") {echo "readonly" .'  data_id="readOnly"';}?>>
					</div>
				</div><!-- /cols -->

				<div class="col-12 col-md-6">
					<div class="input-group">
						<input type="text" name="gym-user-phone" placeholder="Phone Number"  class="input-theme" value="<?= !empty($data) ? $data->phone : ''; ?>">
					</div>					
				</div><!-- /cols -->
				<div class="col-12 col-md-6">
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
			<input type="hidden" name="gym-user-id" value="<?= $uid;?>">
			<button name="saveModerator" value="<?php echo $editbtn ?>" class="btn btn-theme-2 addingBtn"><?php echo $editbtn ?></button>
		</form>
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->
</div>
