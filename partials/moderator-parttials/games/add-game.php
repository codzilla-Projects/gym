<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
foreach ($pages as $page) {
  $dashLink = get_page_link($page->ID);
}
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

}else{
	$editbtn  =  "Add";	
}
if($_POST['saveGame'] && $_POST['saveGame'] === "Add"){
	$gameName  = $_POST['ml-game'];
	$gameText  = $_POST['ml-game-text'];
	$mlPost = array(
	  'post_title'    => wp_strip_all_tags( $gameName ),
	  'post_content'  => $gameText,
	  'post_status'   => 'publish',
	  'post_author'   => $uid,
	  'post_type'     => 'game',
	);	 
	$gid = wp_insert_post( $mlPost );
	update_post_meta($gid,'gym_game_gym',$current_gym_id);
    
    $image_data = $_FILES['ml-game-image'];
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
    echo '<script> window.location.href="'.$dashLink."?current-page=games".'"</script>';

}elseif ($_POST['saveGame'] && $_POST['saveGame'] === "update") {
	$gameName  = $_POST['ml-game'];
	$gameText  = $_POST['ml-game-text'];
	$mlPost = array(
	  'ID'		  => $_GET['gid'],
	  'post_title'    => wp_strip_all_tags( $gameName ),
	  'post_content'  => $gameText,
	);	 
	wp_update_post($mlPost);
    $old_img_url  =  get_the_post_thumbnail($gid);
    if(! empty($old_img_url)){
        wp_delete_attachment( $old_img_url );
       
    }
    $image_data = $_FILES['ml-game-image'];
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
	update_post_meta($_GET['gid'],'gym_game_gym',$current_gym_id);
    echo '<script> window.location.href="'.$dashLink."?current-page=games".'"</script>';
}
 ?>
<div class="card-dasboard">
	<div class="controls">
		<a href="<?php echo $dashLink."?current-page=add-game" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=games" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Games
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/games.svg" ?>">
			Add Game
		</div>
		<div class="card-data-body">
		<form method="post" action="#" enctype="multipart/form-data">
			<div class="input-group">
				<input type="text" name="ml-game" placeholder="New Game"  class="input-theme" value="<?php echo $post_title ?>">
			</div>
			<div class="input-group">
				<textarea cols="4" rows="2" name="ml-game-text" placeholder="Game Text"  class="input-theme" ><?php echo $post_content; ?> </textarea>
			</div>
			<div class="input-group">
                <div class='file'>
                    <label for='input-file'>
                        <i class="cmsmasters-icon-upload-cloud"></i>Select Game Image
                    </label>
					<input type="file" name="ml-game-image" class="input-theme"  id='input-file' >
                </div> 
			</div>
			
			<button name="saveGame" value="<?php echo $editbtn ?>" class="btn btn-theme-2 addingBtn"><?php echo $editbtn ?></button>
		</form>
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->
</div>
