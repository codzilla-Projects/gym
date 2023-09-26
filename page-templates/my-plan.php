<?php 
/**
** Template Name: My Plan
**/

sh_check_logged_in();

$user_id = get_current_user_id();

get_header('subscriber');

$myplan = get_post(get_user_meta($user_id,'trainee_plan',true));

?>
    <section class="single-post">
    <div class="conatiner">
              <ul class="breadcrumb">
                <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                <li>My Plan</li>
            </ul>
        <div class="post-wrapper">          
            <div class="img-container">
                <?php 
                    $thumbnail = get_the_post_thumbnail_url($myplan->ID);
                    $Plan_img = empty($thumbnail) ? get_option('sh_logo_img') : $thumbnail; ; 
                ?>
                <img src="<?= $Plan_img; ?>" class="post-image">
            </div><!-- /img-container -->
            <div class="post-content">
                <h1 class="post-title">
                    <?= $myplan->post_title; ?>
                </h1>
                <div class="text">
                    <?= $myplan->post_content; ?>
                </div>  <!-- /text -->  
                <div class="post-extra-data">
                    <span>
                        Plan Price: <?= get_post_meta($myplan->ID,'ha_plan_price',true);  ?>
                    </span>  
                    <br>  
                    <span>
                        Session Numbers: <?= get_post_meta($myplan->ID,'ha_session_num',true);  ?>
                    </span>                    
                </div>     
                
            </div><!-- /post-content -->
        </div><!-- /post-wrapper -->
    </div><!-- /conatiner -->
</section><!-- /single-post -->
<?php
get_footer(); 
?>