<?php 

$current_user     = wp_get_current_user();
$uid  = $current_user->data->ID ;

$args = array(
    'role'    => 'trainee',
    'orderby' => 'user_nicename',
    'order'   => 'ASC',
    // 'meta_key' => 'trainee_trainer', //any custom field name
    // 'meta_value' => $uid,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'user_gym_id',
            'value' =>  get_user_gym_id(),
        ) ,
        array(
            'key' => 'trainee_trainer',
            'value' => $uid ,
        ) ,
    ),
);

$students =  new WP_User_Query( $args );
$students = $students->get_results();

?>
<div id="layoutSidenav_content">  
    <main id="blogs">
        <div class="container-fluid">
            <div class="row">
                <?php 
                if(!empty($students)):
                    foreach ($students as $student):

                 ?>    
                <?php $user_phone = get_user_meta( $student->ID, 'phone', true ); ?>

                <div class="col-12 col-lg-4">
                    <div class="student-item">
                          <div class="hero-img">
                            <?php    $profile_picture  = get_user_meta($student->ID ,"profile_pic" ,true);
                            if(empty($profile_picture)): ?>
                            <img class="img-fluid" src="<?php echo SH_URL ."assets/images/user.png" ;?>" alt ="Pull It Gym" >
                            <?php else :?>
                                <img class="img-fluid profile-img" src="<?php echo $profile_picture ?>" alt ="Pull It Gym" >
                            <?php endif ;?>                         
                          </div>
                        <div class="description">
                          <h3><?php echo $student->display_name ?></h3>
                            <p><?php echo $student->user_email ?></p>
                            <p><?php echo $user_phone ?></p>
                        </div>             
                    </div>                  
                </div><!-- /cols -->    
                <?php endforeach; else:  ?>
                <p class="no-result">
                    <i class="cmsmasters-icon-attention-alt"></i>
                لا يوجد لديك  متدربين </p>
                <?php endif ?>
                  <div class="pagin w-100 justify-content-center">
                    <nav aria-label="Page navigation card">
                        <?php    
                        $args = array(
                        'format'             => '?paged=%#%',
                        'current'            => max( 1, get_query_var('paged') ),
                        'total'              => $students->max_num_pages,
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
        </div><!-- /row -->
    </div>
</main>
</div>