<?php
function gym_admin_scripts_styles($hook) {

	wp_enqueue_style( 'gym-main', SH_URL . 'assets/admin/css/main-style.css');

	if( in_array($hook , ['toplevel_page_content-area','coach-abscence_page_insert_coach_abscence', 'toplevel_page_schedule']) ) {

		wp_enqueue_style( 'gym-bootsrtap', SH_URL . 'assets/admin/css/bootstrap.min.css');
		wp_enqueue_style( 'gym-style', SH_URL . 'assets/admin/css/style.css');
		wp_enqueue_script( 'gym-bootsrtap', SH_URL .'assets/admin/js/bootstrap.min.js', array() ,false, true );
		wp_enqueue_script( 'gym-script', SH_URL .'assets/admin/js/script.js', array() ,false, true );
	}

	if($hook === 'toplevel_page_content-area') {
		if(function_exists( 'wp_enqueue_media' )){
			wp_enqueue_media();
		}else{
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
		}
	}

	if( in_array($hook,['user-new.php','user-edit.php','profile.php']) ) {
		wp_enqueue_script( 'gym-users', SH_URL .'assets/admin/js/users.js', array() ,false, true );
	}

    if(in_array($hook, ['toplevel_page_coash-abscence']) ){
		wp_enqueue_style( 'gym-dataTables-css', SH_URL . 'assets/admin/datatables/css/jquery.dataTables.min.css');
		wp_enqueue_style( 'gym-dataTables-buttons-css', SH_URL . 'assets/admin/datatables/css/buttons.dataTables.min.css');
		wp_enqueue_script( 'gym-jquery-js', SH_URL .'assets/admin/datatables/js/jquery-3.5.1.js', array() ,false, true );
        wp_enqueue_script( 'gym-datatables-js', SH_URL .'assets/admin/datatables/js/jquery.dataTables.min.js', array('gym-jquery-js') ,false, true );
        wp_enqueue_script( 'gym-coash-table-js', SH_URL .'assets/admin/js/dt-initialization.js', array('gym-jquery-js','gym-datatables-js') ,false, true );
        wp_enqueue_script( 'gym-dataTables-buttons-js', SH_URL .'assets/admin/datatables/js/dataTables.buttons.min.js', array() ,false, true );
        wp_enqueue_script( 'gym-jszip-js', SH_URL .'assets/admin/datatables/js/jszip.min.js', array() ,false, true );
        wp_enqueue_script( 'gym-pdfmake-js', SH_URL .'assets/admin/datatables/js/pdfmake.min.js', array() ,false, true );
        wp_enqueue_script( 'gym-vfs_fonts-js', SH_URL .'assets/admin/datatables/js/vfs_fonts.js', array('gym-pdfmake-js') ,false, true );
        wp_enqueue_script( 'gym-buttons-html5-js', SH_URL .'assets/admin/datatables/js/buttons.html5.min.js', array('gym-pdfmake-js') ,false, true );
    }
} 
add_action('admin_enqueue_scripts', 'gym_admin_scripts_styles');



function gym_scripts_styles() {

	wp_enqueue_style( 'gym-bootstrap-css', SH_URL . 'assets/css/bootstrap.min.css' );
    wp_enqueue_style( 'gym-style-css', SH_URL . 'assets/css/style.css' );    
	wp_enqueue_style( 'date-picker-style', SH_URL . 'assets/css/date-picker-default.date.css');
	wp_enqueue_style( 'date-default-style', SH_URL . 'assets/css/date-picker-default.css');
	wp_enqueue_style( 'gym-style', SH_URL . 'assets/css/ml-style.css');
	wp_enqueue_style( 'gym-fancycss', SH_URL . 'assets/css/jquery.fancybox.min.css');

	wp_enqueue_script('gym_jquery',SH_URL. 'assets/js/jquery.js',array());
	wp_enqueue_script('gym-bootstrap-js',SH_URL. 'assets/js/bootstrap.min.js',array('gym_jquery'));
	wp_enqueue_script('gym-bootstrap-bundle-js',SH_URL. 'assets/js/bootstrap.bundle.min.js',array('gym_jquery'));
	wp_enqueue_script('jquery-slim',SH_URL. 'assets/js/jquery-3.5.1.slim.min.js',array('gym_jquery'));
	wp_enqueue_script('owl.carousel',SH_URL. 'assets/js/owl.carousel.min.js',true);
	wp_enqueue_script('gym-scripts-js',SH_URL. 'assets/js/scripts.js',array('gym_jquery'));
	wp_enqueue_script('gym-picker-js',SH_URL. 'assets/js/picker.js',array('gym_jquery'));
	wp_enqueue_script('gym-picker-date-js',SH_URL. 'assets/js/picker.date.js',array('gym_jquery'));
	wp_enqueue_script('gym-calendar-js',SH_URL. 'assets/js/calendar.js',array('gym_jquery'));
	wp_enqueue_script('gym-fancyjs',SH_URL. 'assets/js/jquery.fancybox.min.js',true);
	wp_enqueue_script('gym-functions',SH_URL. 'assets/js/ml-functions.js',true);



	wp_localize_script( 'gym-functions', 'AJAX', array( 'ajaxurl' => admin_url( 'admin-ajax.php'), 'loader' => SH_URL.'assets/images/loader.gif' ));        

}
add_action( 'wp_enqueue_scripts', 'gym_scripts_styles' );