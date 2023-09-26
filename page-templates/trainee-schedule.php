<?php 
/**
** Template Name: trainee Schedule Template
**/

$current_user     = wp_get_current_user();
if ( in_array( 'coach', (array) $current_user->roles ) ) {
  get_header('coach');
}else if ( in_array( 'trainee', (array) $current_user->roles ) ) {
  get_header('subscriber');
  }
  
?>
<div id="layoutSidenav_content">  
    <main id="blogs">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                <li>Schedule</li>
            </ul>
            <?php 

			gym_schedule_viewer( get_user_gym_id(get_current_user_id()) );
             ?>

    	</div>
	</main>
<?php get_footer(); ?>