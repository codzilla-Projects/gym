<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
foreach ($pages as $page) {
	$dashLink = get_page_link($page->ID);	
}
if(!empty($_GET['uid'])){
	$response = pullit_delete_user($_GET['uid']);
	if(!empty($response)){
		if($response['status'] == 'error'){
			echo "<div class='alert alert-danger'>".$response['msg']."</div>";
		}else{
			echo "<div class='alert alert-success'>".$response['msg']."</div>";
		}
	}
}
$moderators = pullit_get_gym_users(get_user_gym_id(),'moderator');

?>
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
			<img src="<?php echo SH_URL . "assets/svg/game-placeholder.svg" ?>">
			moderators
		</div>
		<div class="card-data-body">
			 <table class="table">
			    <thead class="thead-dark">
			      <tr>
						<th>Moderator Name</th>
						<th>Moderator Phone</th>
						<th>Moderator Email</th>
						<th>Edit</th>
						<th>Remove</th>
			      </tr>
			    </thead>
			    <tbody>
				<?php foreach ($moderators as $moderator):  
					$uid = $moderator->ID;
					$phone = get_user_meta( $uid, 'phone', true ); 
				?>
			      <tr>					
			        <td><?php echo $moderator->user_login  ?></td>
			        <td><?php echo $phone ?></td>
			        <td><?php echo $moderator->user_email ?></td>
				        <td>
				        	<a href ="<?php echo $dashLink."?current-page=add-moderator&action=edit&&uid=".$uid ;  ?>" class="btn-transparent color-blue" title="Edit">
				        		<i class="cmsmasters-icon-pen-1"></i>	
				        	</a>
				        </td>
				        <td>
				        	<a class="btn-transparent color-yellow" href="<?php echo $dashLink."?current-page=moderators&action=delete&&uid=".$uid ;  ?>" onclick="return confirm( 'Are You Sure You Want to delete ths coach ?');"><i class="cmsmasters-icon-trash"></i></a>
				        </td>
			      </tr>
			     
				<?php endforeach ?>
                </tbody>
			  </table>
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->
</div><!-- /card-dasboard -->