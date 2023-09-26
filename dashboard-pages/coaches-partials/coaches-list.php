<?php 
	function wp_get_current_url() {
		return home_url( $_SERVER['REQUEST_URI'] );
	}
	$currentUrl =  get_self_link();
 ?>
<div class="card-coach">
	<table class="table-ml">
		<thead class="coaches-header">
			<th>Coach Picture</th>
			<th>Name</th>
			<th>E-mail</th>
			<th>Action</th>
		</thead>
		<tbody>


	<?php 
	foreach ($coaches as $coach) {	
         $profile_picture  = get_user_meta($coach->data->ID ,"pullit_profile_pic" ,true);
         $path = $currentUrl ."&&uid=" . $coach->data->ID;
	 ?>
		<tr class="coach-item">
				<td>
                   <?php if(empty($profile_picture)): ?>
	                <img  src="<?php echo SH_URL ."/assets/images/user.png" ;?>" >
	                <?php else :?>
	                <img  src="<?php echo $profile_picture ?>" >
	             <?php endif ;?>					
				</td>
				<td>
					<span class="name"><?php echo $coach->user_nicename ?></span>
				</td>
				<td>
					<span class="email"><?php echo $coach->user_email ?></span>
				</td>
				<td>
					 <a href="<?php echo $path ?>">View</a>
				</td>
			</tr>   
	<?php }?>
		</tbody>
	</table>
</div>