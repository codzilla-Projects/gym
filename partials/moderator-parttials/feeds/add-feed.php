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
	
	$feeds_gym_id     = get_post_meta($gid , "feeds_gym_id" ,true);
	
}else{
	$editbtn  =  "Add";	
	$post_content =  "";

}

if(isset($_POST['saveGame']) && $_POST['saveGame'] === "Add"){
	$gameName  = $_POST['ml-feed'];
	$gameText  = $_POST['ml-feed-text'];
	$mlPost = array(
	  'post_title'    => wp_strip_all_tags( $gameName ),
	  'post_content'  => $gameText,
	  'post_status'   => 'publish',
	  'post_author'   => $uid,
	  'post_type'     => 'post',
	);	 
	$gid = wp_insert_post( $mlPost );	
	update_post_meta($gid,'feeds_gym_id',$current_gym_id);

    $image_data = $_FILES['ml-feed-image'];
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
	
    // save gallery work
    $gallery = get_option('gym_post_gallery_'.$current_gym_id);
    if(!empty($gallery)){
		update_post_meta($gid,'feed_gallery',$gallery);
		delete_option('gym_post_gallery_'.$current_gym_id);
    }

//	if ($_FILES) {
//	    foreach ($_FILES as $file => $array) {
//		    $newupload = insert_attachment($file,$gid);
//	    }
//	}
    echo '<script> window.location.href="'.$dashLink."?current-page=feeds".'"</script>';	


}elseif (isset($_POST['saveGame']) && $_POST['saveGame'] === "update") {
	$gameName  = $_POST['ml-feed'];
	$gameText  = $_POST['ml-feed-text'];
	$gid = $_GET['gid'];
	$mlPost = array(
	  'ID'		  => $gid,
	  'post_title'    => wp_strip_all_tags( $gameName ),
	  'post_content'  => $gameText,
	);	 
	wp_update_post($mlPost);

    $image_data = $_FILES['ml-feed-image'];
    if (! empty($image_data['name'])){
	    
	    $old_img_url  =  get_the_post_thumbnail($gid);
	    if(! empty($old_img_url)){
	        wp_delete_attachment( $old_img_url );
	    }

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
	update_post_meta($gid,'feeds_gym_id',$current_gym_id);

    echo '<script> window.location.href="'.$dashLink."?current-page=feeds".'"</script>';
}


if( class_exists('SL_Multiple_Uploader') ){
    $img_uploader = new SL_Multiple_Uploader();
}
?> 
<div class="card-dasboard">
	<div class="controls">
		<a href="<?php echo $dashLink."?current-page=add-feed" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=feeds" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Feeds
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/myplan.svg" ?>">
			Add Feed
		</div>
		<div class="card-data-body">
		<form method="post" action="#" enctype="multipart/form-data">
			<div class="input-group">
				<input type="text" name="ml-feed" placeholder="Feed Title"  class="input-theme" value="<?php echo $post_title ?>">
			</div>
			<div class="input-group">
<!-- 				<textarea cols="4" rows="2" name="ml-feed-text" placeholder="Feed Content"  class="input-theme" ><?php echo $post_content; ?></textarea>
 -->			
			<?php wp_editor( $post_content , 'ml-feed-text',  array('textarea_rows'=>5,'textarea_name'=> 'ml-feed-text', 'drag_drop_upload'=> true, 'wpautop' => false, 'media_buttons'=> true,'id'=>'ml-feed-text','class'=>'form-control text-right',) );  ?>
			
			</div>


			<?= $postImage != '' ? $postImage : ''; ?>
			<div class="input-group">
	        	<div class='file'>
                    <label for='input-file'>
                        <i class="cmsmasters-icon-upload-cloud"></i>Select Feed Image
                    </label>
				    <input type="file" name="ml-feed-image" class="input-theme" id='input-file'>
                </div>  
			</div>
			<div class="form-group">

			<?php 
				if ($_GET['action'] && $_GET['action'] === "edit") {
					$img_uploader->displayUploader('post', 'feed_gallery' ,$gid,'Gallery (Drag images here) :', 'Gallery (Drag images here) :'  );
				}else{
					$img_uploader->displayUploader('general', 'gym_post_gallery_'.$current_gym_id ,  "صور الجاليري ", 'Gallery (Drag images here) :'  );
				} 
			?>
			</div>
            
			<button name="saveGame" value="<?php echo $editbtn ?>" class="btn btn-theme-2 addingBtn"><?php echo $editbtn ?></button>
		</form>
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->
</div>
