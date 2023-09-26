<?php 

$current_user     = wp_get_current_user();
if ( in_array( 'coach', (array) $current_user->roles ) ) {
  get_header('coach');
}else if ( in_array( 'trainee', (array) $current_user->roles ) ) {
  get_header('subscriber');
}
else if(in_array( 'administrator', (array) $current_user->roles ) || in_array( 'moderator', (array) $current_user->roles ) || in_array( 'gym-admin', (array) $current_user->roles )){
  get_header('mod');
  get_template_part("partials/moderator-parttials/right-menu-mod")  ;
   get_template_part("partials/moderator-parttials/left-menu-mod") ;
}else{
  get_header();	
}

if ( have_posts() ) : while ( have_posts() ) : the_post();
	$img_url  = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()),'full');
	$post_month 	 = get_the_date('F',get_the_id()) ;
	$post_year  	 = get_the_date('Y',get_the_id());
	$post_day   	 = get_the_date('j',get_the_id());
	$post_day_name   = get_the_date('l',get_the_id());
	$url = urlencode(get_the_permalink());
	$tw_url = home_url("/") . "?p=" .get_the_ID() ;

?>
<section class="single-post feed-container">
	<div class="conatiner">
		<div class="post-wrapper">			
			<div class="img-container">
				<img src="<?php echo $img_url[0] ?>" alt="gym photo" >
		        <div class="clearfix"></div>
				<div class="gallery-container">
			        <?php $gimages =  get_post_meta(get_the_ID(),'feed_gallery'); ?>
		            <?php   if($gimages != null && $gimages != '') { ?>    
	                <?php  foreach ($gimages[0] as $image) { ?>
	                    <a href="<?php echo $image;?>" data-fancybox="group" >
							<img src="<?php echo $image;?>" alt="PullitGym" />
						</a>
	                <?php  } ?>
	                <?php } ?>		
				</div>
			</div><!-- /img-container -->

			<div class="post-content">
				<h1 class="post-title">
					<?php the_title(); ?>
				</h1>
				<div class="post-extra-data">
					<span>
						<i class="cmsmasters-icon-calendar"></i>
						<?php echo $post_day . "  ". $post_month  ."  " .$post_year?>
					</span>				
				</div>
				<div class="text">
					<?php the_content(); ?>
				</div>	<!-- /text -->		
				<div class="shareIcons">
					<p>Share Post:</p>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>&amp;src=sdkpreparse"  target="_blank" >
						<i class="cmsmasters-icon-facebook-1"></i>
					</a>
					<a href="https://twitter.com/intent/tweet?status=<?php echo $tw_url; ?>+&via=@PullitGym" target="_blank">
						<i class="cmsmasters-icon-twitter-1"></i>
					</a>
				</div>
			</div><!-- /post-content -->
		</div><!-- /post-wrapper -->
	</div><!-- /conatiner -->
</section><!-- /single-post -->
<?php
endwhile; endif;

if(in_array( 'administrator', (array) $current_user->roles ) || in_array( 'moderator', (array) $current_user->roles ) || in_array( 'gym-admin', (array) $current_user->roles )){?>
          </div>
        </div>
    </div>
</section>
<?php };

get_footer(); ?>