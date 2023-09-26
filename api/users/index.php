<?php

// error_reporting('E_ALL');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

header('Content-Type: application/json');

require_once('../../wp-load.php');
require_once('../helpers/API-Handler.php');
require_once('../helpers/Validation-Handler.php');

if ( isset($_POST['action']) && $_POST['action'] === 'get-user-data')  {
	
	$userID = $_POST['userID'];
	
	if( !isset($userID) || empty($userID) ) errorResponse('Empty User ID!!');

	$userData = get_userdata($userID);
	
	$token = tokenEncode(
		$userID,
		$userData->data->user_login,
		$userData->data->user_email,
		$userData->roles[0]
	);
	

	$profilePicID = get_user_meta($userID, 'pullit_profile_pic', true);

	if(empty($profilePicID)) {
		$profilePic = SH_URL .'assets/images/user.png';
	}

	// global $wpdb;
	// $SQL = "SELECT * FROM `{$wpdb->prefix}usermeta` WHERE `user_id` = {$userID}";
	// $user_custom = $wpdb->get_results($SQL);
	
	$response = array(
		'token'			   => $token,
		'userID'		   => $userID,
		'userName'		   => $userData->data->user_login,
		'email'			   => $userData->data->user_email,
		'displayName'	   => $userData->data->display_name,
        'firstName'	       => get_user_meta( $userID, 'first_name', true ),
        'lastName'		   => get_user_meta( $userID, 'last_name', true ),
		'phone'        	   => get_user_meta($userID, 'phone', true),
		'address'          => get_user_meta($userID, 'phone', true),
		'profilePic'       => $profilePic,
		'userRole'		   => $userData->roles[0],
		'startDate'        => get_user_meta($userID,'trainee_start_date',true),
		'endDate'          => get_user_meta($userID,'trainee_end_date',true),
		'plan'             => get_post(get_user_meta($userID,'trainee_plan',true))->post_title,
		'hasPrivate'       => get_user_meta($userID,'ha_private_trainer',true),
		'privateCoach'     => get_userdata(get_user_meta($userID,'trainee_trainer',true))->display_name,
		'barCode'          => SH_URL.'barcode.php?codetype=Code39&size=40&text='.$userID,
		'remainigSessions' => get_user_meta($userID,'trainee_session_num',true),
		'inHallUsers'      => get_in_gym_users(get_user_meta($userID,'user_gym_id',true))
	);
	sendResponse($response);
}

if ( isset($_POST['action']) && $_POST['action'] === 'login')  {

	$username = sh_clean($_POST['username']);
	$password = sh_clean($_POST['password']);

	if( !isset($username) || empty($username) ) errorResponse('Empty Username!!');
	if( !isset($password) || empty($password) ) errorResponse('Empty Password!!');

	$user_exists = get_user_by('login', $username);
	if(!$user_exists){
		$user_exists = get_user_by('email', $username);
		if(!$user_exists){
			errorResponse('Username/Email Does not Exist!!', 403);
		}
	}
	if(!wp_check_password($password, $user_exists->data->user_pass)){
		errorResponse('Password Error!!', 403);
	}

	$userID = $user_exists->data->ID;
	
	$token = tokenEncode(
		$userID,
		$user_exists->data->user_login,
		$user_exists->data->user_email,
		$user_exists->roles[0]
	);
	

	$profilePicID = get_user_meta($userID, 'pullit_profile_pic', true);

	if(empty($profilePicID)) {
		$profilePic = SH_URL .'assets/images/user.png';
	}

	// global $wpdb;
	// $SQL = "SELECT * FROM `{$wpdb->prefix}usermeta` WHERE `user_id` = {$userID}";
	// $user_custom = $wpdb->get_results($SQL);
	
	$response = array(
		'token'			   => $token,
		'userID'		   => $userID,
		'userName'		   => $user_exists->data->user_login,
		'email'			   => $user_exists->data->user_email,
		'displayName'	   => $user_exists->data->display_name,
        'firstName'	       => get_user_meta( $userID, 'first_name', true ),
        'lastName'		   => get_user_meta( $userID, 'last_name', true ),
		'phone'        	   => get_user_meta($userID, 'phone', true),
		'address'          => get_user_meta($userID, 'phone', true),
		'profilePic'       => $profilePic,
		'userRole'		   => $user_exists->roles[0],
		'startDate'        => get_user_meta($userID,'trainee_start_date',true),
		'endDate'          => get_user_meta($userID,'trainee_end_date',true),
		'plan'             => get_post(get_user_meta($userID,'trainee_plan',true))->post_title,
		'hasPrivate'       => get_user_meta($userID,'ha_private_trainer',true),
		'privateCoach'     => get_userdata(get_user_meta($userID,'trainee_trainer',true))->display_name,
		'barCode'          => SH_URL.'barcode.php?codetype=Code39&size=40&text='.$userID,
		'remainigSessions' => get_user_meta($userID,'trainee_session_num',true),
		'inHallUsers'      => get_in_gym_users(get_user_meta($userID,'user_gym_id',true))
	);
	sendResponse($response);

}


if ( isset($_POST['action']) && $_POST['action'] === 'update-user-profile')  {
   
    $user_data = tokenChecker();
	$user_id = $user_data['user_id'];
    if(empty($user_id)) errorResponse('User ID !!');
    
	$lang = $_GET['lang'];
	if(empty($lang)) errorResponse('Language ysta !!');
    $msgs = array(
		'success' => [
			'ar' => 'تم تحديث البيانات بنجاح',
			'en' => 'User update successfully '
		],
        'emptypic' => [
			'ar' => 'لم يتم إختيار صورة للملف الشخصى',
			'en' => 'Profile Image Is Empty !! '
		],
		'error' => [
			'ar' => 'شئ ما خطأ حدث  . برجاء التجربة مرة أخرى.',
			'en' => 'Something Is Wrong !!'
		]
	);

    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $phone = $_POST['phone'];


    if($user_id){
    	wp_update_user([
    		'ID' => $user_id,
    		'display_name' => $first_name." ".$last_name,
		]);
     	update_user_meta( $user_id, 'phone', $phone );
     	update_user_meta( $user_id, 'first_name', $first_name );
     	update_user_meta( $user_id, 'last_name', $last_name );


		$profile_pic = $_FILES['profile_pic'];
        if(! empty($profile_pic['name'])){
            
            //upload the picture and get id
            $upload = wp_upload_bits($profile_pic["name"], null, file_get_contents($profile_pic["tmp_name"]));


            $file_path = $upload['file'];

            $filetype = wp_check_filetype($file_path, null );

            $args = array(
            'post_mime_type' => $filetype['type'],
            'post_title' => sanitize_file_name($profile_pic['name']),
            'post_content' => '',
            'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment( $args, $file_path);
            //check if user has an old attachment
            $old_pic_id = get_user_meta($user_id,'wp_user_avatar',true);
            //if ! empty delete the attachment
            if(! empty($old_pic)){
                wp_delete_attachment( $old_pic_id );
                //update the user meta.
                update_user_meta( $user_id, 'wp_user_avatar', $attach_id );
            }else{
                //update the user meta.
                update_user_meta( $user_id, 'wp_user_avatar', $attach_id );
            }
        // }else{
            // errorResponse($msgs['emptypic'][$lang]);
        }
        //PASSWORD UPDATE
        if(!empty($_POST['password'])) {
        	wp_set_password( $_POST['password'], $user_id );
        }
       
        
		sendResponse($msgs['success'][$lang]);
	}else{
		errorResponse($msgs['error'][$lang]);
	}
}