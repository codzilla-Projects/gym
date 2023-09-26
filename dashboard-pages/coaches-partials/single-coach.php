<?php 
    $args = array(
        'role'    => 'trainee',
        'orderby' => 'user_nicename',
        'order'   => 'ASC',
        'meta_key' => 'trainee_trainer',
	    'meta_value' => $_GET['uid']
        );
	$students = get_users( $args );
	$count= 1;
	$profile_picture  = get_user_meta($_GET['uid'] ,"pullit_profile_pic" ,true);
	$profile_data = get_userdata( $_GET['uid']);
	$coach_game = get_user_meta($_GET['uid'],'coach_categories',true); 
	$coach_game = get_user_meta($_GET['uid'],'coach_categories',true); 
	$user_phone = get_user_meta( $_GET['uid'], 'phone', true );
	
	if($_POST['submit-delete'] && $_POST['submit-delete'] === "delete" ){
		$trainee_ID = $_POST['trainee_id'];
		update_user_meta(  $trainee_ID, 'trainee_trainer', "no");
	}

 ?>
<div class="card-coach">
	<div class="user-info">
		<div class="image">
           <?php if(empty($profile_picture)): ?>
            <img  src="<?php echo SH_URL ."/assets/images/user.png" ;?>" >
            <?php else :?>
            <img  src="<?php echo $profile_picture ?>" >
         <?php endif ;?>
		</div>
		<div class="data-profile">
			<div><h3><?php echo $profile_data->display_name ?></h3></div>
			<div><h5><?php echo $profile_data->user_email ?></h5></div>
			<div><?php echo $profile_data->coach_game ?></div>
			<div><?php echo $profile_data->coach_game ?></div>
			<a href="<?php echo get_edit_user_link($_GET['uid']) ?>">Edit  Profile</a>
		</div>
	</div>
</div>
<div class="card-coach">
	<div class="students-data">
	<h3>Private Trainees</h3>
	<table class="table-trainee">
		<thead class="trainee-header">
				<th> Number</th>
				<th> Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Remove</th>
			</thead>
			<tbody>
				<?php 
				if(!empty($students)){
				foreach ($students as $student): ?>
					<?php $user_phone = get_user_meta( $student->ID, 'phone', true ); ?>
				<tr>
					<td><?php echo $count?></td>
					<td><?php echo $student->display_name ?></td>
					<td><?php echo $student->user_email ?></td>
					<td><?php echo $user_phone ?></td>
					<td>
						<form action="#" method="post">
							<input type="hidden" name="trainee_id" value="<?php echo $student->ID ;?>">
							<button type="submit" name="submit-delete" value="delete">Remove</button>
						</form>
					</td>				
				</tr>		
				<?php $count = $count+1 ; ?>			
				<?php endforeach ;}else{?>
					<p>No Data can Be Found</p>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
