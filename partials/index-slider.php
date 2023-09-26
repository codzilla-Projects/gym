<?php
$args=array(
  'post_type'           => 'slider',
  'post_status'         => 'publish',
  'posts_per_page'      => 9,
  );
$sliderQuery = new WP_QUERY($args); 
?>
<section class="main-content">
	<div class="owl-carousel owl-theme ">
    <?php
        if( $sliderQuery->have_posts() ):
        while($sliderQuery->have_posts()): $sliderQuery->the_post();                   
        $img_url    =  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()),'full');
		$ml_slider_sub_title 	= get_post_meta( get_the_ID(), 'ml_slider_sub_title', true);

        $blog_title = get_the_title();     ?>
		<div class="slider-item ">
			<div class="background-image">
				<img src="<?php echo $img_url[0] ?>">
			</div><!-- /background-image -->
			<div class="slider-text-content">
				<div class="container">
					<div class="row">
						<div class="col-md-7 col-12">
							<div class="slider-text-container">
								<h1><?php the_title(); ?></h1>
								<h5><?php echo $ml_slider_sub_title ?></h5>
								<div class="text">
									<?php the_content(); ?>
								</div>				
							</div><!-- /slider-text-container -->						
						</div><!-- cols -->
					</div><!-- /row -->
				</div><!-- container -->
			</div><!-- /slider-text-content -->
		</div><!-- slider-item -->		
    <?php endwhile; endif;  wp_reset_query();  ?>
	</div>
</section>