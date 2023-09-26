<?php 
function coachesDataCallback(){
	$args = array(
		'role'    => 'coach',
		'orderby' => 'user_nicename',
		'order'   => 'ASC'
	);
	$coaches = get_users( $args );

	// echo home_url( $wp->request );

	if($_GET['uid']){
		include( SH_ROOT . 'dashboard-pages/coaches-partials/single-coach.php');
	}else{
		include( SH_ROOT . 'dashboard-pages/coaches-partials/coaches-list.php');
	} 
}
?>