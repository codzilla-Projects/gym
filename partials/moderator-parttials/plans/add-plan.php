<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
$dashLink = get_page_link($pages[0]->id);

$curresnt_user = wp_get_current_user();
$uid  = $curresnt_user->id;
$current_gym_id = get_user_meta($uid,'user_gym_id',true);
if( class_exists('SL_Multiple_Uploader') ){
    $img_uploader = new SL_Multiple_Uploader();
}
if ($_GET['action'] && $_GET['action'] === "edit") {
	$editbtn  =  "update";
	$gid = $_GET['gid'];
	$post =  get_post($gid);
	$post_title =  $post->post_title;
	$post_content = $post->post_content;
	$postImage  = get_the_post_thumbnail($gid);
	
	$ha_plan_price     = get_post_meta($gid , "ha_plan_price" ,true);
	$gym_plan_duration = get_post_meta($gid , "gym_plan_duration" ,true);
	$ha_session_num    = get_post_meta($gid , "ha_session_num" ,true);

}else{
	$editbtn  =  "Add";	
	$post_content =  "";

}

if(isset($_POST['saveGame']) && $_POST['saveGame'] === "Add"){
	$gameName  = $_POST['ml-plan'];
	$gameText  = $_POST['ml-plan-text'];
	$mlPost = array(
	  'post_title'    => wp_strip_all_tags( $gameName ),
	  'post_content'  => $gameText,
	  'post_status'   => 'publish',
	  'post_author'   => $uid,
	  'post_type'     => 'plan',
	);	 
	$gid = wp_insert_post( $mlPost );	
	update_post_meta($gid,'gym_plan_gym',$current_gym_id);

	add_post_meta($gid , "ha_plan_price" ,$_POST['ha_plan_price']);
	add_post_meta($gid , "ha_session_num" ,$_POST['ha_session_num']);
	add_post_meta($gid , "gym_plan_duration" ,$_POST['gym_plan_duration']);	
    
    $image_data = $_FILES['ml-plan-image'];
    if (! empty($image_data)){
        $upload = wp_upload_bits($image_data["name"] , null, file_get_contents($image_data["tmp_name"] ));

        
        $file_path = $upload['file'];

        $filetype = wp_check_filetype($file_path, null );
                  
        $args = array(
        'post_mime_type' => $filetype['type'],
        'post_title' => sanitize_file_name($post_title),
        'post_content' => '',
        'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $args, $file_path, $post_id );
        set_post_thumbnail( $gid, $attach_id );
    }
/*
	if ($_FILES) {
	    foreach ($_FILES as $file => $array) {
		    $newupload = insert_attachment($file,$gid);
	    }
	}
    */
    echo '<script> window.location.href="'.$dashLink."?current-page=plans".'"</script>';	


}elseif (isset($_POST['saveGame']) && $_POST['saveGame'] === "update") {
	$gameName  = $_POST['ml-plan'];
	$gameText  = $_POST['ml-plan-text'];
	$gid = $_GET['gid'];
	$mlPost = array(
	  'ID'		  => $gid,
	  'post_title'    => wp_strip_all_tags( $gameName ),
	  'post_content'  => $gameText,
	);	 
	wp_update_post($mlPost);
	update_post_meta($gid,'gym_plan_gym',$current_gym_id);
    
    $old_img_url  =  get_the_post_thumbnail($gid);
    if(! empty($old_img_url)){
        wp_delete_attachment( $old_img_url );
       
    }
    $image_data = $_FILES['ml-plan-image'];
    if (! empty($image_data)){
        $upload = wp_upload_bits($image_data["name"] , null, file_get_contents($image_data["tmp_name"] ));

        $file_path = $upload['file'];

        $filetype = wp_check_filetype($file_path, null );

        $args = array(
        'post_mime_type' => $filetype['type'],
        'post_title' => sanitize_file_name($post_title),
        'post_content' => '',
        'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment( $args, $file_path, $post_id );
        set_post_thumbnail( $gid, $attach_id );
    }
    
	if (isset($_POST['ha_plan_price']))
		update_post_meta($gid , "ha_plan_price" ,$_POST['ha_plan_price']);
	if (isset($_POST['ha_plan_price']))
		update_post_meta($gid , "ha_session_num" ,$_POST['ha_session_num']);
	if (isset($_POST['gym_plan_duration']))
		update_post_meta($gid , "gym_plan_duration" ,$_POST['gym_plan_duration']);	

    echo '<script> window.location.href="'.$dashLink."?current-page=plans".'"</script>';
}
 ?>
<div class="card-dasboard">
	<div class="controls">
		<a href="<?php echo $dashLink."?current-page=add-plan" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=plans" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Plans
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/myplan.svg" ?>">
			Add Plan
		</div>
		<div class="card-data-body">
		<form method="post" action="#" enctype="multipart/form-data">
			<div class="input-group">
				<input type="text" name="ml-plan" placeholder="New Plan"  class="input-theme" value="<?php echo $post_title ?>">
			</div>
			<div class="input-group">
				<textarea cols="4" rows="2" name="ml-plan-text" placeholder="Plan Text"  class="input-theme" ><?php echo $post_content; ?></textarea>
			</div>
			<div class="input-group">
				<input type="text" name="ha_plan_price" placeholder="Plan Price"  class="input-theme" value="<?php echo $ha_plan_price ?>">
			</div>
			<div class="input-group">
				<input type="text" name="ha_session_num" placeholder="Plan Sessions Number"  class="input-theme" value="<?php echo $ha_session_num ?>">
			</div>
			<div class="input-group">
				<input type="text" name="gym_plan_duration" placeholder="Plan Duration (Days)"  class="input-theme" value="<?php echo $gym_plan_duration ?>">
			</div>
			<div class="input-group">	
                <div class='file'>
                    <label for='input-file'>
                        <i class="cmsmasters-icon-upload-cloud"></i>Select Plan Image
                    </label>
				    <input type="file" name="ml-plan-image" class="input-theme" id='input-file'>
                </div>      
			</div>
			<button name="saveGame" value="<?php echo $editbtn ?>" class="btn btn-theme-2 addingBtn"><?php echo $editbtn ?></button>
		</form>
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->
</div>
