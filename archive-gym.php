<?php 
/**
* Template Name: Gym Archive
**/

	get_header();


$paged  =  (get_query_var( 'paged' )) ?  absint( get_query_var( 'paged' ) ) : 1;
$args = array(
  'post_type'=> 'gym',
  'post_status'=>'publish',
  'posts_per_page'=> 8,
  'paged'         => $paged,
);
$gymsListing = new WP_Query($args);
if($gymsListing->have_posts()) :?>
<div class="gym-container">	
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo home_url('/'); ?>">Home</a></li>
			<li>ALl GYMS</li>
		</ul>
		<h2>All GYMS</h2>
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
					<a href="<?php  the_permalink()?>" class="gym-item-body"><h3><?php the_title() ?></h3></a>
				</div>
			</div><!-- /cols -->
		<?php 	endwhile; ?>
			<?php 
	                    $args = array(
                        'format'             => '/paged=%#%',
                        'current'            => max( 1, get_query_var('paged') ),
                        'total'              => $gymsListing->max_num_pages,
                        'show_all'           => false,
                        'end_size'           => 1,
                        'mid_size'           => 10,
                        'prev_next'          => true,
                        'prev_text'          =>('<i class="feather icon-chevrons-right"></i>'),
                        'next_text'          =>('<i class="feather icon-chevrons-left "></i>'),
                        'type'               => 'list',
                    );
            echo paginate_links($args);  ?>
		</div><!-- /row -->
	</div><!-- /container -->
</div><!-- /gym-container -->
<?php endif; wp_reset_query();
get_footer();

 ?>