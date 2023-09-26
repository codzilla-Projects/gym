<?php
// echo '<script>const attendance = </script>'
// 
// $users = get_users(array( 'role__in' => ['moderator', 'coach']));
$users = pullit_get_gym_users( get_user_gym_id(),array('moderator', 'coach','trainee'));
?>
<div class="card-dasboard">
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/images/attendance.png" ?>">
			Attendance Sheet
		</div>
		<div class="card-data-body">
			<div class="attendance-sheet">
				<div class="form-group">
					<label>Select User</label>
					<!-- <select id="user-id" class="input-theme"> -->
					<input list="user-id" name="user" id="user" class="input-theme">
					<datalist id="user-id" >
						<!-- <option disabled="" selected="" value="">Select User</option> -->
						<?php foreach ($users as $user):
							$user_role = ucfirst($user->roles[0]);
						?>
						<option data-value="<?php echo $user->data->ID?>" value="<?php echo "{$user->data->display_name} ({$user_role})"; ?>" >
						<?php endforeach ?>
					</datalist>					
					<!-- </select> -->				
					</div>
				<div class="form-group">
					<label>Start Date</label>
					<input type="text" id="start_date" class="input-theme">
				</div>
				<div class="form-group">
					<label>End Date</label>
					<input type="text" id="end_date" class="input-theme">
				</div>		
				<div class="filter-btn">
					<i class="cmsmasters-icon-search"></i>
				</div>
			</div>
			<div class="d-none mt-3 attendance-data">
				<table class="table">
				    <thead class="thead-dark">
						<tr>
							<th>Action Date</th>
							<th>In Time</th>
							<th>Out Time</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>
