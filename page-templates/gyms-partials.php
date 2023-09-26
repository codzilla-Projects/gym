<?php 
$args = array(
  'post_type'=> 'gym',
  'post_status'=>'publish',
  'posts_per_page'=> 8,
);
$gymsListing = new WP_Query($args);
if($gymsListing->have_posts()) :?>

<div class="gym-container">	
	<div class="container">
		<h2>All GYM</h2>
		<div class="row">
			<?php 
			 	while($gymsListing->have_posts()): $gymsListing->the_post();
                    $FeatureImage = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'medium');
		?>
			<div class="col-12 col-md-4">
				<div class="gym-item">
					<?php if($FeatureImage):?>
					<img class="img-fluid" src="<?php echo $FeatureImage[0]?> " alt="pullit Gym " />
				<?php else: ?>
					<img class="img-fluid" src="<?php  echo SH_URL . "assets/images/placegolder-gym.jpg"?> " alt="pullit Gym " />
				<?php endif; ?>
					<h3><?php the_title() ?></h3>
				</div>
			</div><!-- /cols -->
		<?php 	endwhile; ?>
		</div><!-- /row -->
	</div><!-- /container -->
</div><!-- /gym-container -->
<?php endif; wp_reset_query();
