<?php 
/**
** Template Name: Blog library Template
**/

$current_user     = wp_get_current_user();
if ( in_array( 'coach', (array) $current_user->roles ) ) {
  get_header('coach');
}else if ( in_array( 'trainee', (array) $current_user->roles ) ) {
  get_header('subscriber');
  }

$paged  =  (get_query_var( 'paged' )) ?  absint( get_query_var( 'paged' ) ) : 1;

$args=array(
  'post_type'           => 'post',
  'post_status'         => 'publish',
  'posts_per_page'      => 8,
  'paged'               => $paged,
);
$articles_query = new WP_QUERY($args); 

?>
<div id="layoutSidenav_content">  
    <main id="blogs">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                <li>Feeds</li>
            </ul>
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
                                    <?php //echo wp_trim_words($blog_title ,6, ' ...' );?>     
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
                <div class="pagin w-100 justify-content-center">
                    <nav aria-label="Page navigation card">
                        <?php    
                        $args = array(
                        'format'             => '?paged=%#%',
                        'current'            => max( 1, get_query_var('paged') ),
                        'total'              => $blogs->max_num_pages,
                        'show_all'           => false,
                        'end_size'           => 1,
                        'mid_size'           => 2,
                        'prev_next'          => true,
                        'next_text'          => 'التالي   »',
                        'prev_text'          => '« السابق  ',
                        'type'               => 'list',
                        );
                        ?>
                        <?php echo paginate_links($args); ?>
                    </nav>
                </div>
            <?php wp_reset_query(); ?>
            <?php endif ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>