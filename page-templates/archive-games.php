<?php 
/**
** Template Name: Games Archive Template
**/
get_header('coach'); 

$paged  =  (get_query_var( 'paged' )) ?  absint( get_query_var( 'paged' ) ) : 1;
$args=array(
  'post_type'           => 'game',
  'post_status'         => 'publish',
  'lang'                => $current_language,
  'posts_per_page'      => 9,
  'paged'               => $paged,
  );
$games_query = new WP_QUERY($args); 

?>
<div id="layoutSidenav_content">  
    <main id="games">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                <li>Games</li>
            </ul>
            <div class="row">
                <?php
        if( $games_query->have_posts() ):
              while($games_query->have_posts()): $games_query->the_post();               

                $game_title = get_the_title(); ?>
                <div class=" col-12 col-sm-4 col-md-3">
                    <div class="post-item text-center">
                        <div class="card ha_game m-2">
                            <img class="card-img-top img-fluid" src="<?= get_the_post_thumbnail_url(get_the_id(),'medium'); ?>" alt="Card image cap">
                            <div class="card-body">
                                <a class="h2 navbar-brand post-tit" href="<?php the_permalink();?>">
                                  <?php  echo $game_title;?>
                                </a>
                                    
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
                        'total'              => $games_query->max_num_pages,
                        'show_all'           => false,
                        'end_size'           => 1,
                        'mid_size'           => 2,
                        'prev_next'          => true,
                        'next_text'          => 'Next   »',
                        'prev_text'          => '« Previous  ',
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