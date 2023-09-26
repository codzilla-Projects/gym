<?php get_header(); 
/**
** Template Name: Conatct us Template
**/

$contactPhone  =  get_option('sh_phone');
$email = get_option('sh_email');
$address  = get_option('sh_address');
if ($_POST['ml-submit'] && $_POST['ml-submit'] === "Send Message") {
	$content_ml  = $_POST['ml_usermessage'];
	$user_sender = $_POST['ml_userName'];
	$user_email  = $_POST['ml_usermail'];
	$subject	 = "Contact";
	$ml_message="<h1>".$subject.'</h1>'.'<br>'.$content_ml."<br> <strong>Sender Name:</strong> ".$user_sender."<br> <strong>Sender Email:</strong>".$user_email;

	$val = slavo_send_email( $admin_email, $subject, $ml_message);
}
?>

<section  class="main-content pt-5">
	<div class="container">
		<div class="row pt-5 pb-5">
			<div class="col-12 col-md-6">
				<h1 class="page-title">Let's Talk</h1>
				<div class="text">
					Fill out the form and we will get back to you promptly.
				</div>
				<form>
					<p class="form-group">
						<label for="ml_userName">
							Your Name
						</label>
						<input type="text" name="ml_userName" id="ml_userName"  class="input-theme">
					</p>
					<p class="form-group">
						<label for="ml_usermail">
							Your Email
						</label>
						<input type="text" name="ml_usermail" id="ml_usermail"  class="input-theme">
					</p>
					<p class="form-group">
						<label for="ml_usermessage">
							Your Message
						</label>
						<textarea name="ml_usermessage" id="ml_usermessage" cols="20" rows="4" class="input-theme"></textarea>
					</p>
					<input type="submit" name="ml-submit" value="Send Message" class="btn btn-theme">
				</form>
			</div><!-- /row -->
			<div class="col-12 col-md-6">
				<img src="<?php echo SH_URL. "./assets/images/message.png" ?>">
				<p class="contact-item">
					<i class="cmsmasters-icon-location-3"></i>
					<?php echo $address ?>
				<p class="contact-item">
					<i class="cmsmasters-icon-phone"></i>
					<?php echo $contactPhone ?>
				</p>
				<p class="contact-item">
					<i class="cmsmasters-icon-mail"></i>
					<?php echo $email ?>					
				</p>
			</div><!-- /row -->
		</div><!-- /row -->
	</div><!-- /conatiner -->	
</section>

<?php get_footer(); ?>