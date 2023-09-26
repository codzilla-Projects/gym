<?php
add_action("wp_ajax_get_game_coach_data", "get_game_coach_data");
add_action("wp_ajax_nopriv_get_game_coach_data", "get_game_coach_data");


function get_game_coach_data() {
	// if (empty($_POST['coachesIDs']) || empty($_POST['gamesIDs']) ) {
	// 	exit( json_encode(array( 'status' => 'error', 'message' => 'Empty coachesIDs or GamesIDs') ) );
	// }
	$games_posts = get_posts(array(
		'post__in' 	=> $_POST['gamesIDs'],
		'post_type' => 'game'
	));
	$games = array();
	foreach ($games_posts as $game) {
		$games[$game->ID] = $game;
		$thumb = get_the_post_thumbnail_url($game->ID, 'thumbnail');
		$games[$game->ID]->thumb = $thumb;
	}
	$coaches = array();
	foreach ($_POST['coachesIDs'] as $id) {
		$user = get_userdata($id);
		$profile_picture = get_user_meta($id, 'pullit_profile_pic', true);
		$profile_picture = empty($profile_picture) ? SH_URL . 'assets/images/user.png' : $profile_picture;
		$user->profile_picture = $profile_picture;
		$coaches[$id] = $user;
	}
	echo json_encode(array('games' => $games, 'coaches' => $coaches)); die();
}
add_action("wp_ajax_add_presence", "add_presence");
add_action("wp_ajax_nopriv_add_presence", "add_presence");

function add_presence() {
	$uid = $_POST['uerId'];
	$error = array();
	if (!empty($_POST['uerId'])) {
		$user_meta  = get_userdata($uid);
		$user_roles = $user_meta-> roles ; 
		
		if($user_roles === "coach"){


		}elseif($user_roles === 'trainee'){
			$session_num = get_user_meta( $uid, 'trainee_session_num', true );
			if ($session_num > 0 ) {
				$session_num = $session_num - 1;
				update_user_meta( $uid, "trainee_session_num", $session_num);
			}else{
				array_push($error, "This user has ended his subscription sessions  "); 
			}
			
		}
	}
	echo json_encode(array('error'=> $error ,)); die();
}

add_action("wp_ajax_scan_code_action", "scan_code_action");
add_action("wp_ajax_nopriv_scan_code_action", "scan_code_action");
// trainee_session_num
function scan_code_action() {
	$min_user_lifetime = 1;
	$user_id = $_POST['userID'];
	$user_data = get_userdata($user_id);
	if(!$user_data) {
		echo json_encode(array('status'=> 'NO_DATA'));
		die();
	}
	$action = 0;
	if( in_array('trainee', $user_data->roles) ) {
		$gym_id = get_user_gym_id($user_id);
		
		$time_entered = get_user_meta($user_id, 'sl_user_in', true);
		if( $time_entered ){
			if(time() - $time_entered >= $min_user_lifetime * 60 ) {
				user_left_gym($gym_id, $user_id);
				record_staff_attendance($user_id);
				$action = 2;
			}
			else {
				echo json_encode(array('status'=> 'SUCCESS', 'action' => $action));
				die();
			}
		}
		else {
			user_entered_gym($gym_id, $user_id);
			$sessionsRemaining = get_user_meta($user_id, 'trainee_session_num', true);
			$sessionsRemaining = empty($sessionsRemaining) ? 0 : $sessionsRemaining;
			$sessionsRemaining --;
			update_user_meta( $user_id, 'trainee_session_num', $sessionsRemaining,);
			record_staff_attendance($user_id);
			$action = 1;
		}
		$response = array('status'=> 'SUCCESS', 'action' => $action);
		if($sessionsRemaining < 0) {
			$response['warning'] = 'sessionsOut';
		}
		echo json_encode($response);
		die();
	}
	else if ( in_array('coach', $user_data->roles) || in_array('moderator', $user_data->roles) ) {
			$user_in = get_user_meta($user_id, 'sl_user_in', true);
			$action = !$user_in ? 1 : 2;
			record_staff_attendance($user_id);
			echo json_encode(array('status'=> 'SUCCESS', 'action' => $action));
			die();
	}
	else {
		echo json_encode(array('status'=> 'SUCCESS', 'action' => $action));
		die();
	}
}

add_action("wp_ajax_fetch_attendance", "fetch_attendance");
add_action("wp_ajax_nopriv_fetch_attendance", "fetch_attendance");
function fetch_attendance() {

	$user_id 	= $_POST['user_id'];
	$start_date = $_POST['start_date'];
	$end_date 	= $_POST['end_date'];

	$start_date = explode('/', $start_date);
	$start_date = implode('-', $start_date);

	$end_date 	= explode('/', $end_date);
	$end_date 	= implode('-', $end_date);

	$response = array(
		"status" 	=> "SUCCESS",
		"message" 	=> "message",
		"data"		=> get_staff_attendace($start_date, $end_date, $user_id)
	);
	echo json_encode( $response );
	die();

}