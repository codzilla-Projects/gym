<?php 

function main_content_area_callback(){

	$wp_editor_settings = array( 
		'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ), 
		'textarea_rows'=> 2
	);    

	$args = array(
		'post_type'		=> 'page',
		'post_status'	=> 'publish',
		'posts_per_page'=> -1,
	);
	$pages 	= get_posts( $args );

	if( isset( $_POST['sh_save'] ) && !empty( $_POST['sh_save']) ){

		foreach ($_POST as $key => $value) {

			if(in_array($key,['sh_map_code'])){

				$value = stripcslashes($value);

			}				

			update_option( $key, $value);

		}

	}

	$ml_feeds 	  	 = get_option('ml_feeds');
	$ml_edit_profile 	  	 = get_option('ml_edit_profile');
	$ml_p_trainee_schedule 	  	 = get_option('ml_p_trainee_schedule');
	$ml_game_page		 	  	 = get_option('ml_game_page');


?>

<div class="container">

	<div class="row">

		<div class="col-md-12">

			<!-- Top Navigation -->

			<header class="codrops-header">

				<br>

				<h1 class="text-center sh-title">Pullit Options</h1>

				<br>

			</header>

		</div>

		<div class="col-sm-3">

			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

				<a class="nav-link active" id="v-pills-firstsection-tab" data-toggle="pill" href="#v-pills-firstsection" role="tab" aria-controls="v-pills-firstsection" aria-selected="true">Logo</a>

				<a class="nav-link " id="v-pills-fourthsection-tab" data-toggle="pill" href="#v-pills-fourthsection" role="tab" aria-controls="v-pills-fourthsection" aria-selected="true">Pages</a>

				<a class="nav-link" id="v-pills-secondsection-tab" data-toggle="pill" href="#v-pills-secondsection" role="tab" aria-controls="v-pills-secondsection" aria-selected="false">Contact Us</a>

				<a class="nav-link" id="v-pills-thirdsection-tab" data-toggle="pill" href="#v-pills-thirdsection" role="tab" aria-controls="v-pills-thirdsection" aria-selected="false">Social Media</a>

			</div>

		</div>

		<div class="col-sm-9">

	  		<form class="form-horizontal gray_back" method="post" action="#">

			    <div class="tab-content" id="v-pills-tabContent">

			        <div class="tab-pane fade show active" id="v-pills-firstsection" role="tabpanel" aria-labelledby="v-pills-firstsection-tab">
                        <div class="form-group">
						  <label for="sh_website_logo" class="col-sm-12 control-label">Fav Icon</label>
						  <div class="col-sm-12">
						  	<?php if(!empty($favicon_img = get_option('sh_favicon_img'))) : ?>
						    <img class="first_img" src="<?php echo $favicon_img; ?>" height="100" style="max-width:100%" />
							<?php endif; ?>
						    <input class="first_img_url sh_half" type="text" name="sh_favicon_img" size="60" value="<?php echo get_option('sh_favicon_img'); ?>">
						    <a href="#" class="first_img_upload btn btn-info">Choose</a>
						  </div>
						</div>
                        <div class="form-group">
						  <label for="sh_website_logo" class="col-sm-12 control-label">Logo</label>
						  <div class="col-sm-12">
						  	<?php if(!empty($logo_img = get_option('sh_logo_img'))) : ?>
						    <img class="second_img" src="<?php echo $logo_img; ?>" height="100" style="max-width:100%" />
							<?php endif; ?>
						    <input class="second_img_url sh_half" type="text" name="sh_logo_img" size="60" value="<?php echo get_option('sh_logo_img'); ?>">
						    <a href="#" class="second_img_upload btn btn-info">Choose</a>
						  </div>
						</div>
			        </div>

			        <div class="tab-pane fade" id="v-pills-secondsection" role="tabpanel" aria-labelledby="v-pills-secondsection-tab">

						<div class="form-group">

							<label for="sh_phone" class="col-sm-12 control-label">Phone number</label>

							<div class="col-sm-12">

								<input type="text" class="form-control" id="sh_phone" name="sh_phone" value="<?php echo get_option('sh_phone'); ?>">

							</div>

						</div>	

						<div class="form-group">

							<label for="sh_email" class="col-sm-12 control-label">Email</label>

							<div class="col-sm-12">

								<input type="email" class="form-control" id="sh_email" name="sh_email" value="<?php echo get_option('sh_email'); ?>">

							</div>
						</div>
						<div class="form-group">

							<label for="sh_address" class="col-sm-12 control-label">Address</label>

							<div class="col-sm-12">

								<input type="text" class="form-control" id="sh_address" name="sh_address" value="<?php echo get_option('sh_address'); ?>">
							</div>
						</div>
				    </div>	      

					<div class="tab-pane fade" id="v-pills-thirdsection" role="tabpanel" aria-labelledby="v-pills-thirdsection-tab">

						<div class="form-group">

							<label for="sh_fb" class="col-sm-12 control-label">Facebook</label>

							<div class="col-sm-12">

								<input type="text" class="form-control" id="sh_fb" name="sh_fb" value="<?php echo get_option('sh_fb'); ?>">

							</div>

						</div>

						<div class="form-group">

							<label for="sh_insta" class="col-sm-12 control-label">Instagram</label>

							<div class="col-sm-12">

								<input type="text" class="form-control" id="sh_insta" name="sh_insta" value="<?php echo get_option('sh_insta'); ?>">

							</div>

						</div>

						<div class="form-group">

							<label for="sh_youtube" class="col-sm-12 control-label">YouTube</label>

							<div class="col-sm-12">

								<input type="text" class="form-control" id="sh_youtube" name="sh_youtube" value="<?php echo get_option('sh_youtube'); ?>">

							</div>

						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-fourthsection" role="tabpanel" aria-labelledby="v-pills-fourthsection-tab">
								<div class="page-item col-md-10 col-md-offset-1 pd-20">
							<label for="ml_p_trainee_schedule">Schedule Page </label>
							<select name="ml_p_trainee_schedule" id="ml_p_trainee_schedule" style="width:100%;">
								<?php foreach ($pages as $page): ?>
									<option value="<?php echo $page->ID ?>" <?php echo $ml_p_trainee_schedule == $page->ID ? 'selected' : ''; ?> > <?php echo $page->post_title ?></option>
								<?php endforeach; ?>

							</select>
						</div>
						<div class="page-item col-md-10 col-md-offset-1 pd-20">
							<label for="ml_edit_profile">Profile Page </label>
							<select name="ml_edit_profile" id="ml_edit_profile" style="width:100%;">
								<?php foreach ($pages as $page): ?>
									<option value="<?php echo $page->ID ?>" <?php echo $ml_edit_profile == $page->ID ? 'selected' : ''; ?> > <?php echo $page->post_title ?></option>
								<?php endforeach; ?>

							</select>
						</div>
						<div class="page-item col-md-10 col-md-offset-1 pd-20">
							<label for="ml_game_page"> Game Page </label>
							<select name="ml_game_page" id="ml_game_page" style="width:100%;">
								<?php foreach ($pages as $page): ?>
									<option value="<?php echo $page->ID ?>" <?php echo $ml_game_page == $page->ID ? 'selected' : ''; ?> > <?php echo $page->post_title ?></option>
								<?php endforeach; ?>

							</select>
						</div>
						<div class="page-item col-md-10 col-md-offset-1 pd-20">
							<label for="ml_feeds"> Blog Page </label>
							<select name="ml_feeds" id="ml_feeds" style="width:100%;">
								<?php foreach ($pages as $page): ?>
									<option value="<?php echo $page->ID ?>" <?php echo $ml_feeds == $page->ID ? 'selected' : ''; ?> > <?php echo $page->post_title ?></option>
								<?php endforeach; ?>

							</select>
						</div>
				    </div>
			    </div>

				<div class="form-group">

					<div class="col-sm-12">

					<input type="submit" class="btn btn-default btn-lg sh_save_data" name="sh_save" value="Save Options">

					</div>

				</div>

			</form>

	 	</div>

	</div>

</div>

<?php

}

