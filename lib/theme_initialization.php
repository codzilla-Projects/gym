<?php
add_action( 'init', 'gym_custom_post_types' );
/**********************
** create CPT Types
**********************/
function gym_custom_post_types() {
	
$cpts = [    
    array(
        'single'   => 'Plan',
        'plural'   => 'Plans',
        'cptname'  => 'plan',
        'icon'     => 'dashicons-editor-ol',
        'supports' => ["title","editor","thumbnail"],
        'show_in_menu'=> true,
        'position' => 7
    ),
    array(
        'single'   => 'Game',
        'plural'   => 'Games',
        'cptname'  => 'game',
        'icon'     => 'dashicons-clipboard',
        'supports' => ["title","editor","thumbnail"],
        'show_in_menu'=> true,
        'position' => 8 
    ),
    array(
        'single'   => 'Slide',
        'plural'   => 'Slides',
        'cptname'  => 'slider',
        'icon'     => 'dashicons-format-gallery',
        'supports' => ["title","editor","thumbnail"],
        'show_in_menu'=> true,
        'position' => 10 
    ),    
    array(
        'single'   => 'Gym',
        'plural'   => 'Gyms',
        'cptname'  => 'gym',
        'icon'     => 'dashicons-money-alt',
        'supports' => ["title","editor","thumbnail"],
        'show_in_menu'=> true,
        'position' => 6 
    ),
];
    
foreach ($cpts as $cpt) {
    $labels = array(
        'name'                  => _x( $cpt['single'], 'Post Type General Name', 'pullit' ),
        'singular_name'         => _x( $cpt['single'], 'Post Type Singular Name', 'pullit' ),
        'menu_name'             => __( $cpt['plural'], 'pullit' ),
        'all_items'             => __( 'All '.$cpt['plural'], 'pullit' ),
        'add_new_item'          => __( 'Add New '.$cpt['single'] , 'pullit' ),
        'add_new'               => __( 'Add New', 'pullit' ),
        'new_item'              => __( 'New '.$cpt['single'], 'pullit' ),
        'edit_item'             => __( 'Edit '.$cpt['single'], 'pullit' ),
        'update_item'           => __( 'Update '.$cpt['single'], 'pullit' ),
        'view_item'             => __( 'View '.$cpt['single'], 'pullit' ),
        'search_items'          => __( 'Search '.$cpt['plural'], 'pullit' ),
        'not_found'             => __( 'Not found', 'pullit' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'pullit' ),
        'featured_image'        => __( 'Featured Image', 'pullit' ),
        'set_featured_image'    => __( 'Set featured image', 'pullit' ),
        'remove_featured_image' => __( 'Remove featured image', 'pullit' ),
        'use_featured_image'    => __( 'Use as featured image', 'pullit' ),
    );
    $args = array(
        'label'                 => __( $cpt['plural'], 'pullit' ),
        'description'           => __( $cpt['plural'].' Description', 'pullit' ),
        'labels'                => $labels,
        'supports'              => $cpt['supports'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          =>$cpt['show_in_menu'],
        'menu_position'         => $cpt['position'],
        'menu_icon'             => $cpt['icon'],
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,    
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    
    // Register Custom Post Type>
	register_post_type( $cpt['cptname'], $args );

    }   

}


/*Meta Boxes Work*/
function registerMetaBoxes() {
    add_meta_box( 'plan-info','Plan Additional Informations', 'gymPlanInfo', 'plan','normal','default');
    add_meta_box( 'game-info','Game Additional Informations', 'gamePlanInfo', 'game','side','default');
    add_meta_box( "feeds-meta","Feeds More Details" , "gymFeeds", "post", "normal", "low" );
    add_meta_box( "slider", "Slider Sub title" , "gymSliderMeta", "slider", "normal", "low" );    
}
add_action( 'add_meta_boxes', 'registerMetaBoxes' );

/* Meta Boxes Callback Functions Work */
function gymPlanInfo( $plan ) {
    wp_nonce_field(basename(__FILE__),'wp_owt_cpt_nonce');
    $gyms = get_posts(['post_type'=>'gym','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC']);
?>
    <label>Gym</label>
    <?php $gym_id= get_post_meta($plan->ID,'gym_plan_gym',true); ?>
    <select  name="gym_plan_gym">
        <option>Please Select</option>
    <?php foreach ($gyms as $gym) : ?>
        <option value="<?= $gym->ID; ?>" <?= $gym_id == $gym->ID ? 'selected' : ''; ?> > <?php echo $gym->post_title; ?></option>
    <?php endforeach; ?>
    </select>
    <br><br>
    <label>Plan Price</label>
    <?php $plan_price= get_post_meta($plan->ID,'ha_plan_price',true); ?>
    <input  name="ha_plan_price" type="text" value="<?php echo $plan_price; ?>"  />
    <br><br>
    <label>Sessions Number</label>
    <?php $sessions_num= get_post_meta($plan->ID,'ha_session_num',true); ?>
    <input  name="ha_session_num" type="number" value="<?php echo $sessions_num; ?>"  />
    <br><br>
    <label>Plan Duration</label>
    <?php $duration= get_post_meta($plan->ID,'gym_plan_duration',true); ?>
    <input  name="gym_plan_duration" type="number" value="<?php echo $duration; ?>"  /> Month
<?php
}
/* Meta Boxes Callback Functions Work */
function gamePlanInfo( $plan ) {
    wp_nonce_field(basename(__FILE__),'wp_owt_cpt_nonce');
    $gyms = get_posts(['post_type'=>'gym','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC']);
?>
    <label>Gym</label>
    <?php $gym_id= get_post_meta($plan->ID,'gym_game_gym',true); ?>
    <select  name="gym_game_gym">
        <option>Please Select</option>
    <?php foreach ($gyms as $gym) : ?>
        <option value="<?= $gym->ID; ?>" <?= $gym_id == $gym->ID ? 'selected' : ''; ?> > <?php echo $gym->post_title; ?></option>
    <?php endforeach; ?>
    </select>
    <br><br>

<?php
}

/*function gymFeeds($post){
    $ml_Feeds_pricing   = get_post_meta( $post->ID, 'ml_Feeds_pricing', true);
    $ml_plan_sessions   = get_post_meta( $post->ID, 'ml_plan_sessions', true);
?>
<div class="backend-wrap">
    <label for="ml_Feeds_pricing"> Plan Price 
        <input type="text" name="ml_Feeds_pricing" id='ml_Feeds_pricing' value="<?php echo $ml_Feeds_pricing ?>">
    </label>
    <label for="ml_plan_sessions"> Plan Sessions
        <input type="text" name="ml_plan_sessions" id='ml_plan_sessions' value="<?php echo $ml_plan_sessions ?>">
    </label>
</div>
<?php
}*/

function gymFeeds($post){
    $gym_id   = get_post_meta( $post->ID, 'feeds_gym_id', true);
?>
<div class="backend-wrap">
    <label for="feeds_gym_id"> Gym ID
        <input type="number" name="feeds_gym_id" id='feeds_gym_id' value="<?php echo $gym_id ?>">
    </label>
    <p>Gym Title :<?php if(!empty($gym_id)){ echo get_post($gym_id)->post_title;} ?></p>
</div>
<?php
}


function mlSliderMeta($post) {
    $ml_slider_sub_title    = get_post_meta( $post->ID, 'ml_slider_sub_title', true);
?>
<div>
    <p>
        <span>Slider Sub Title</span>
        <?php wp_editor( $ml_slider_sub_title, 'ml_slider_sub_title' ); ?>      
    </p>
</div>
<?php
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function gym_save_meta_data( $post_id,$post ) {
    //var_dump($_POST);die();
/*    
    if ( ! isset( $_POST['wp_owt_cpt_nonce'] )|| ! wp_verify_nonce( $_POST['wp_owt_cpt_nonce'] , basename(__FILE__) ) ) {
        return $post_id ;
    }

    $post_slug='plan';
    if( $post_slug != $post->post_type){
        return;
    }
*/
    if(isset($_POST['gym_plan_gym'])){
        update_post_meta($post_id,'gym_plan_gym',sanitize_text_field($_POST['gym_plan_gym']));
    }else
        delete_post_meta($post_id,'ha_plan_price');

    if(isset($_POST['gym_game_gym'])){
        update_post_meta($post_id,'gym_game_gym',sanitize_text_field($_POST['gym_game_gym']));
    }else
        delete_post_meta($post_id,'ha_plan_price');

    if(isset($_POST['ha_plan_price'])){
        update_post_meta($post_id,'ha_plan_price',sanitize_text_field($_POST['ha_plan_price']));
    }else
        delete_post_meta($post_id,'ha_plan_price');
     
    if(isset($_POST['ha_session_num'])){
        update_post_meta($post_id,'ha_session_num',sanitize_text_field($_POST['ha_session_num']));
    }else
        delete_post_meta($post_id,'ha_session_num');
     
    if(isset($_POST['gym_plan_duration'])){
        update_post_meta($post_id,'gym_plan_duration',sanitize_text_field($_POST['gym_plan_duration']));
    }else
        delete_post_meta($post_id,'gym_plan_duration');
     
    if (isset($_POST['ml_Feeds_pricing'])) 
        update_post_meta($post_id,'ml_Feeds_pricing',$_POST['ml_Feeds_pricing']);
    
    if (isset($_POST['ml_plan_sessions'])) 
        update_post_meta($post_id,'ml_plan_sessions',$_POST['ml_plan_sessions']);
    
    if (isset($_POST['ml_slider_sub_title'])) 
        update_post_meta($post_id, 'ml_slider_sub_title',$_POST['ml_slider_sub_title']);

    if (isset($_POST['feeds_gym_id'])) 
        update_post_meta($post_id, 'feeds_gym_id',$_POST['feeds_gym_id']);

     
}
add_action( 'save_post', 'gym_save_meta_data',10,2 );

register_nav_menu("main_menu","Main Navigation"); 
