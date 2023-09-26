<?php
/**
** Template Name: Coach games
**/
$user_id = get_current_user_id();
get_header('coach');
$games = get_user_meta($user_id,'coach_categories',true);
?>
<div id="layoutSidenav_content">  
    <main id="blogs">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                <li>My Games</li>
            </ul>
            <div class="row">
                <?php foreach ($games as $game_id): $game_data=get_post($game_id);?>    
                <div class="col-12 col-lg-2">
                    <div class="student-item ">
                          <div class="hero-img">
                            <?php    $game_picture  = get_the_post_thumbnail_url($game_id);
                            if(empty($game_picture)): ?>
                            <img class="img-fluid " src="<?php echo SH_URL ."assets/images/game-placeholder.svg" ;?>" alt ="Pull It Gym" >
                            <?php else :?>
                                <img class="img-fluid " src="<?php echo $game_picture; ?>" alt ="Pull It Gym" >
                            <?php endif ;?>                         
                          </div>
                        <div class="description">
                          <h3><a href="<?= get_permalink($game_id); ?>"><?php echo $game_data->post_title; ?></a></h3>
                        </div>             
                    </div>                  
                </div><!-- /cols -->    
                <?php endforeach ?>
        </div><!-- /row -->
    </div>
</main>
<?php get_footer(); ?>