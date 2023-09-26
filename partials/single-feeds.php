<?php 
$args=array(
    'post_type'           =>'post',
	'post_status'         => 'publish',	
	'meta_query' => array(
        array(
          'key'     => 'feeds_gym_id',
          'value'   => get_the_ID(),
          'compare' => '=',
        )
    ),
	'posts_per_page'      => -1,
  );

$articles_query = new WP_QUERY($args); 
if( $articles_query->have_posts() ):?>
	<h2 class="text-center mt-4">
		Latest Feed
	</h2>
	<div class="feedsSlider owl-carousel owl-theme">
    <?php
      while($articles_query->have_posts()): $articles_query->the_post();                   
            $img_url         =  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()),'medium');
            $blog_title = get_the_title(); ?>
            <div class="post-item">
                <div class="card m-5">
                    <img class="post-image img-fluid" src="<?php echo $img_url[0] ?>" alt="Card image cap">
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
        <?php endwhile;?>

      <?php wp_reset_query(); ?>
	</div><!-- row -->
</div>
<?php endif ?>