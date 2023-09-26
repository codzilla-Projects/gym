<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,POST,OPTIONS");
header("Access-Control-Max-Age: 86400");

function errorResponse($message, $code = 400) {
	switch($code) {
		case 400:
			header("HTTP/1.1 400 Bad Request");
			break;
		case 403: 
			header('HTTP/1.0 403 Forbidden');
			break;
	}
	echo json_encode(array('status' => 'error', 'message' => $message));
	exit;
}

function sendResponse($data) {
	$response = array(
		'status' 	=> 'success',
		'message'	=> 'OK',
		'data'		=> $data
	);
	header("HTTP/1.1 200 OK");
	echo json_encode($response);
	exit;
}

function tokenEncode($user_id, $user_login, $user_email, $user_role) {
	if(empty($user_id)){
		errorResponse(`insufficient parameters {user_id}`);
	}
	if(empty($user_login)){
		errorResponse(`insufficient parameters {user_login}`);
	}
	if(empty($user_email)){
		errorResponse(`insufficient parameters {user_email}`);
	}
	if(empty($user_role)){
		errorResponse(`insufficient parameters {user_role}`);
	}
	$params = array(
		'user_id'		=> $user_id,
		'user_login'	=> $user_login,
		'user_email'	=> $user_email,
		'user_email'	=> $user_email,
		'user_role'		=> $user_role,
		'time'			=> time()
	);
	$params = http_build_query($params);

	$hashed_params = base64_encode($params);
	$salted = array(
		'salt1' => 'renew12',
		'salt2'	=> '7andoos',
		'salt3'	=> 'nono7',
		'salt4'	=> 'shawky',
		'salt5'	=> 'abdulrahman',
	);
	$salted = http_build_query($salted);

	$hashed_salted = base64_encode($salted . '###' . $hashed_params);
	return $hashed_salted;
}

function tokenChecker() {
	$token = $_SERVER['HTTP_AUTH'];
	//$token = str_replace('Rofan ', '', $token);
	$decoded = tokenDecoder($token);
	if(
		empty($decoded['userData']['user_id'])
		|| empty($decoded['userData']['user_login'])
		|| empty($decoded['userData']['user_email'])
		|| empty($decoded['userData']['user_role'])
		|| empty($decoded['userData']['time'])
		|| $decoded['salt']['salt1'] !== 'renew12'
		|| $decoded['salt']['salt2'] !== '7andoos'
		|| $decoded['salt']['salt3'] !== 'nono7'
		|| $decoded['salt']['salt4'] !== 'shawky'
		|| $decoded['salt']['salt5'] !== 'abdulrahman'
	){
		errorResponse('Invalid Authorization Token', 403);
	}
	return $decoded['userData'];
}

function tokenDecoder($token) {
	$salted_token = base64_decode($token);
	$token = explode('###', $salted_token);
	$data = base64_decode($token[1]);
	parse_str($token[0], $salt);
	parse_str($data, $output);

	return array(
		'userData' 	=> $output,
		'salt'		=> $salt
	);
}
