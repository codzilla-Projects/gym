<?php 
$args=array(
  'post_type'           => 'post',
  'post_status'         => 'publish',
  'posts_per_page'      => 3,
  );
$articles_query = new WP_QUERY($args); 

?>
<div class="container">
	<h2 class="text-center mt-4">
		Latest Feed
	</h2>
	<div class="row">
<?php
  if( $articles_query->have_posts() ):
              while($articles_query->have_posts()): $articles_query->the_post();                   
                    $img_url         =  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()),'medium');

                $blog_title = get_the_title(); ?>
                <div class=" col-12 col-sm-4 col-md-6">
                    <div class="post-item">
                        <div class="card m-5">
                            <img class="card-img-top img-fluid" src="<?php echo $img_url[0] ?>" alt="Card image cap">
                            <div class="card-body">
                                <a class="h2 navbar-brand post-tit" href="<?php the_permalink();?>">
                                  <?php  echo $blog_title ?>
                                </a>
                                    <div class="text">
                                        <?php the_excerpt();?>                            
                                    </div>
                                    <a class="read_more" href="<?php the_permalink();?>">Read More</a>
                            </div><!-- /card-body -->
                        </div><!-- /card -->
                    </div><!-- post-item -->
                </div><!-- /cols -->
                <?php endwhile;?>

                          <?php wp_reset_query(); ?>
            <?php endif ?>
	</div><!-- row -->
</div><!-- /container -->