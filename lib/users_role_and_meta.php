<?php
/******************

** Remove unuseful roles

*******************/

remove_role( 'editor' );

remove_role( 'author' );

remove_role( 'contributor' );

remove_role( 'subscriber' );

remove_role( 'coache' );


/******************

** Add Coach role

*******************/
add_role( 'coach', 'coach', array(

    'read'                  => true, // true allow that capability

    'edit_posts'            => true,

    'delete_posts'          => true, // Use false to explicitly deny

    'edit_published_posts'  => true,

    'publish_posts'         => true,

));

$coach = get_role( 'coach' );

/******************

** Add Trainee role

*******************/

add_role( 'trainee', 'Trainee', array(

    'read'                  => true, // true allow that capability

    'edit_posts'            => false,

    'delete_posts'          => false, // Use false to explicitly deny

    'edit_published_posts'  => false,

    'publish_posts'         => false,

));

$trainee = get_role( 'trainee' );

/******************

** Add Moderator role

*******************/

add_role( 'moderator', 'Moderator', array(

    'read'                  => true, // true allow that capability

    'edit_posts'            => false,

    'delete_posts'          => false, // Use false to explicitly deny

    'edit_published_posts'  => false,

    'publish_posts'         => false,

));

$moderator = get_role( 'moderator' );
$moderator->add_cap('upload_files');

/******************

** Add Gym Admin role

*******************/

add_role( 'gym-admin', 'Gym Admin', array(

    'read'                  => true, // true allow that capability

    'edit_posts'            => false,

    'delete_posts'          => false, // Use false to explicitly deny

    'edit_published_posts'  => false,

    'publish_posts'         => false,

));

$gymadmin = get_role( 'gym-admin' );
$gymadmin->add_cap('upload_files');




/*************

** Add Meta Fields To Roles

*************/

add_action( 'show_user_profile', 'extra_user_profile_fields' );

add_action( 'edit_user_profile', 'extra_user_profile_fields' );

add_action( "user_new_form", "extra_user_profile_fields" );



function extra_user_profile_fields( $user ) { 

	?>


<div class="all_roles" id="trainee">
    <h3><?php _e("Extra Trainee information", "pullit"); ?></h3>
    <table class="form-table ha_trainee_meta">

        <tr>
            <th><label for="gym_trainee_gender"><?php _e("Gender"); ?></label></th>
            <td>
            <?php $gym_trainee_gender = get_user_meta($user->ID,'gym_trainee_gender',true); ?>
            <select name="gym_trainee_gender" id="gym_trainee_gender" class="regular-text">
                <?php if(empty($gym_trainee_gender)) : ?>
                    <option selected disabled hidden><?php esc_attr_e( 'Please select' ); ?></option>
                <?php endif; ?>
                    <option value="male" <?php echo $gym_trainee_gender == 'male' ? 'selected' : ''; ?> >Male</option>          
                    <option value="female" <?php echo $gym_trainee_gender == 'female' ? 'selected' : ''; ?> >Female</option>          
            </select>
            </td>
        </tr>


        <tr>

            <th><label for="trainee_start_date"><?php _e("Start Date"); ?></label></th>

            <td>

                <input type="date" name="trainee_start_date" id="trainee_start_date" value="<?php echo esc_attr( get_user_meta( $user->ID , 'trainee_start_date', true ) ); ?>" class="regular-text" /><br />

                <span class="description"><?php _e("Please enter trainee start date."); ?></span>

            </td>

        </tr>

            <tr>

            <th><label for="trainee_end_date"><?php _e("End Date"); ?></label></th>

            <td>

                <input type="date" name="trainee_end_date" id="trainee_end_date" value="<?php echo esc_attr( get_user_meta( $user->ID , 'trainee_end_date', true ) ); ?>" class="regular-text" /><br />

                <span class="description"><?php _e("Please enter trainee end date."); ?></span>

            </td>

        </tr>

        <!-- ============================================ -->
        <tr>

            <th><label for="trainee_plan"><?php _e("Plan"); ?></label></th>

            <td>
                <?php $trainee_plan = get_user_meta($user->ID,'trainee_plan',true); ?>
                <select name="trainee_plan" id="trainee_plan">
                    <?php if(empty($trainee_plan)) : ?>
                        <option selected disabled hidden><?php esc_attr_e( 'Please select' ); ?></option>
                        <?php endif;  
                        $plans = get_posts(array('post_type'=>'plan','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC')); 
                        foreach ($plans as $plan) {
                        ?>
                        <option value="<?php echo $plan->ID; ?>" <?php echo $trainee_plan == $plan->ID ? 'selected' : ''; ?> ><?php echo $plan->post_title; ?></option>          
                        <?php } ?>
                </select>

                <span class="description"><?php _e("Please choose trainee plan."); ?></span>

            </td>

        </tr>
        <!-- ======================================================================= -->
        <tr>

            <th><label for="ha_private_trainer"><?php _e("Trainee has a private coach"); ?></label></th>

            <td>
                <?php $private_trainer = get_user_meta( $user->ID, 'ha_private_trainer', true );?>

                <input type="checkbox" name="ha_private_trainer" value="1" <?= $private_trainer == '1' ?'checked': ''; ?> >

                <span class="description"><?php _e("If yes please check here."); ?></span>
            </td>

        </tr>

        <tr>

            <th><label for="trainee_triner"><?php _e("Coach"); ?></label></th>

            <td>
                <?php $trainee_trainer = get_user_meta($user->ID,'trainee_trainer',true); ?>
                <select name="trainee_trainer" id="trainee_trainer">
                    <?php if(empty($trainee_trainer)) : ?>
                        <option selected disabled hidden><?php esc_attr_e( 'Please select' ); ?></option>
                        <?php endif;  
                        $trainers = get_users(array('role__in' => array( 'coach'),'orderby'=>'title','order'=>'ASC')); 
                        foreach ($trainers as $trainer) {
                        ?>
                        <option value="<?php echo $trainer->ID; ?>" <?php echo $trainee_trainer == $trainer->ID ? 'selected' : ''; ?> ><?php echo $trainer->display_name ; ?></option>          
                        <?php } ?>
                </select>

                <span class="description"><?php _e("Please choose coach."); ?></span>

            </td>

        </tr>

        <tr>

            <th><label for="trainee_session_num"><?php _e("Sessions number"); ?></label></th>

            <td>

                <input type="number" name="trainee_session_num" id="trainee_session_num" value="<?php echo esc_attr( get_user_meta( $user->ID , 'trainee_session_num', true ) ); ?>" class="regular-text" /><br />

                <span class="description"><?php _e("Please enter trainee sessions number."); ?></span>

            </td>

        </tr>


    </table>
</div>
<div class="all_roles" id="coach">
    <h3><?php _e("Extra Coach information", "pullit"); ?></h3>
    <table class="form-table ha_coach_meta">
        <tr>
            <th><label for="gym_coach_gender"><?php _e("Gender"); ?></label></th>
            <td>
            <?php $gym_coach_gender = get_user_meta($user->ID,'gym_coach_gender',true); ?>
            <select name="gym_coach_gender" id="gym_coach_gender" class="regular-text">
                <?php if(empty($gym_coach_gender)) : ?>
                    <option selected disabled hidden><?php esc_attr_e( 'Please select' ); ?></option>
                <?php endif; ?>
                    <option value="male" <?php echo $gym_coach_gender == 'male' ? 'selected' : ''; ?> >Male</option>          
                    <option value="female" <?php echo $gym_coach_gender == 'female' ? 'selected' : ''; ?> >Female</option>          
            </select>
            </td>
        </tr>
        
        <tr>
            <?php $days=array('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');?>
              <?php $coach_days = get_user_meta($user->ID,'ha_coach_days',true); ?>

                <th><label for="ha_coach_days"><?php _e("Attendance Days"); ?></label></th>

                <td>
                    <select name="ha_coach_days[]" id="ha_coach_days" class="form-control" multiple>

                      <?php foreach ($days as $day)  : ?>

                      <option value="<?php echo $day; ?>" 

                        <?php if(!empty($coach_days)) { ?>

                          <?php if( in_array($day, $coach_days) ) echo "selected"; ?> 

                        <?php }else{ ?>

                        <?php } ?>

                        ><?php echo $day; ?></option>

                      <?php endforeach; ?>

                    </select>
                </td>

        </tr> 

        <tr>

            <th><label for="coach_categories"><?php _e("Games"); ?></label></th>

            <td>
                <?php $coach_games = get_user_meta($user->ID,'coach_categories',true); ?>
                <select name="coach_categories[]" id="coach_categories" multiple>
                    <?php if(empty($coach_games)) : ?>
                        <option selected disabled hidden><?php esc_attr_e( 'Please select' ); ?></option>
                    <?php endif;  
                        $games = get_posts(array('post_type'=>'game','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC')); 
                        foreach ($games as $game) {
                        ?>

                        <option value="<?php echo $game->ID; ?>" 

                        <?php if(!empty($coach_games)) {  ?>

                          <?php if( in_array($game->ID, $coach_games) ) echo "selected"; ?> 

                        <?php }else{ ?>

                        <?php } ?>

                        ><?php echo $game->post_title; ?></option>
                        <?php } ?>

                </select>

            </td>

        </tr>
        
    </table>
</div>
<div class="" id="">
    <h3><?php _e("Extra information", "pullit"); ?></h3>
    <table class="form-table ha_coach_meta">
         <tr>

            <th><label for="phone"><?php _e("Phone"); ?></label></th>

            <td>

                <input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_user_meta( $user->ID , 'phone', true ) ); ?>" class="regular-text" /><br />

            </td>

        </tr>

        <tr>

            <th><label for="address"><?php _e("Address"); ?></label></th>

            <td>

                <input type="text" name="address" id="address" value="<?php echo esc_attr( get_user_meta( $user->ID , 'address', true ) ); ?>" class="regular-text" /><br />

            </td>

        </tr>
        
        <tr>

            <th><label for="user_gym_id"><?php _e("Gym"); ?></label></th>

            <td>
                <?php 
                $gyms = get_posts(['post_type'=>'gym','post_status'=>'publish','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC']); 
                $user_gym_id = get_user_meta($user->ID,'user_gym_id',true); 
                ?>
                <select name="user_gym_id" id="user_gym_id">
                    <?php if(empty($user_gym_id)) : ?>
                        <option selected disabled hidden><?php esc_attr_e( 'Please select' ); ?></option>
                    <?php endif;  
                        foreach ($gyms as $gym) {
                    ?>
                        <option value="<?php echo $gym->ID; ?>" <?=  $user_gym_id == $gym->ID ? 'selected' : ''; ?> ><?php echo $gym->post_title; ?></option>
                    <?php } ?>

                </select>

            </td>

        </tr>

        <tr>

            <th><label for="pullit_profile_pic"><?php _e("Profile Picture"); ?></label></th>

            <td>

                <input type="text" name="pullit_profile_pic" id="pullit_profile_pic" value="<?php echo esc_attr( get_user_meta( $user->ID , 'pullit_profile_pic', true ) ); ?>" class="regular-text" /><br />

            </td>

        </tr>
   



    </table>
</div>
<?php	

}

add_action('user_register', 'save_extra_user_profile_fields');  
add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
/*    var_dump($_POST);
    die();
*/   
    if($_POST['gym_trainee_gender'] != ""){

        update_user_meta( $user_id, 'gym_trainee_gender', $_POST['gym_trainee_gender'] );

    }
    if($_POST['gym_coach_gender'] != ""){

        update_user_meta( $user_id, 'gym_coach_gender', $_POST['gym_coach_gender'] );

    }

    if($_POST['trainee_start_date'] != ""){

		update_user_meta( $user_id, 'trainee_start_date', $_POST['trainee_start_date'] );

	}
    if($_POST['trainee_end_date'] != ""){

		update_user_meta( $user_id, 'trainee_end_date', $_POST['trainee_end_date'] );

	}

    if($_POST['trainee_plan'] != ""){

		update_user_meta( $user_id, 'trainee_plan', $_POST['trainee_plan'] );

	}
    if($_POST['ha_private_trainer'] != ""){

		update_user_meta( $user_id, 'ha_private_trainer', $_POST['ha_private_trainer'] );

	}
    if($_POST['trainee_trainer'] != ""){

		update_user_meta( $user_id, 'trainee_trainer', $_POST['trainee_trainer'] );

	}
    if($_POST['trainee_session_num'] != ""){

		update_user_meta( $user_id, 'trainee_session_num', $_POST['trainee_session_num'] );

	}
	if($_POST['coach_categories'] != ""){

		update_user_meta( $user_id, 'coach_categories', $_POST['coach_categories'] );

	}

    if($_POST['phone'] != ""){

		update_user_meta( $user_id, 'phone', $_POST['phone'] );

	}
    if($_POST['address'] != ""){

		update_user_meta( $user_id, 'address', $_POST['address'] );

	}
    if($_POST['ha_coach_days'] != ""){

		update_user_meta( $user_id, 'ha_coach_days', $_POST['ha_coach_days'] );

	}
    if($_POST['pullit_profile_pic'] != ""){

        update_user_meta( $user_id, 'pullit_profile_pic', $_POST['pullit_profile_pic'] );

    }

    if($_POST['gym_id'] != ""){

        update_user_meta( $user_id, 'gym_id', $_POST['gym_id'] );

    }    
    if($_POST['user_gym_id'] != ""){

        update_user_meta( $user_id, 'user_gym_id', $_POST['user_gym_id'] );
    }
    
    
}


function gym_modify_user_columns( $column ) {
    $column['Gym'] = 'Gym';
    return $column;
}
add_filter( 'manage_users_columns', 'gym_modify_user_columns' );

function gym_modify_user_columns_work( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'Gym' :
            return get_post(get_user_meta($user_id , 'user_gym_id',true))->post_title;
        break;
        default:
        break;

    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'gym_modify_user_columns_work', 10, 3 );