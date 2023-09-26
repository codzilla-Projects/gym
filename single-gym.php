
 <?php  
get_header();
if ( have_posts() ) : while ( have_posts() ) : the_post();
	$img_url  = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full');

    $id=get_the_ID();    

?>
<section class="single-post single_game  gym-container">
	<div class="container">
		<div class="post-wrapper">			
			<div class="img-container">
				<?php if($img_url):?>
					<img class="img-fluid" src="<?php echo $img_url[0]?> " alt="pullit Gym " />
				<?php else: ?>
					<img class="img-fluid" src="<?php  echo SH_URL . "assets/images/placegolder-gym.jpg"?> " alt="pullit Gym " />
				<?php endif; ?>			
			</div><!-- /img-container -->
			<div class="post-content">
				<h1 class="post-title">
					<?php the_title(); ?>
				</h1>
				<div class="text">
					<?php the_content() ?>
				</div>
			</div>
		</div>
	<?php include( SH_ROOT .  'partials/single-feeds.php' );?>
		<div class="mt-4">
			<h3 class="text-center">GYM Schedule</h3>
			<?php gym_schedule_viewer(get_the_ID()); ?>			
		</div>	
	</div><!-- /conatiner -->
</section><!-- /single-post -->
<?php endwhile; endif;
get_footer(); 
?>