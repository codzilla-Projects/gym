<?php 
function gym_register_custom_menu_pages() {
  add_menu_page(
    'Theme Options',
    'theme Options',
    'manage_options',
    'content-area',
    'main_content_area_callback',
    get_option('sh_favicon_img'),
    2
  );
  add_menu_page( 
    'Coaches', 
    'Coaches', 
    'manage_options', 
    'coashes_details', 
    'coachesDataCallback', 
    'dashicons-businessman', 
    4
  );
}

add_action( 'admin_menu', 'gym_register_custom_menu_pages' );
require_once ( SH_ROOT . 'dashboard-pages/theme_options.php');
require_once ( SH_ROOT . 'dashboard-pages/coaches_data.php');

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_option('sh_logo_img'); ?>);
            width: 100%;
            height: 100px;
            background-size: contain;
            margin: 0 auto;
        }
        p#nav>a{
            display: none;
        }
        .login form{
            background: #164688!important;
        }
        .login label{
            font-weight: 600!important;
            color: #fff!important;
        }
        .wp-core-ui p .button {
            background: #d52938;
            border-color: #b2293a;
        }
    
    </style>
<?php }

function remove_wp_logo($wp_admin_bar) {
  $wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'remove_wp_logo', 999);

function change_footer_admin() {
  echo '<span id="footer-thankyou"><a href="https://codzilla.net" target="_blank">Powered by : Codzilla</a></span>';
}
add_filter('admin_footer_text', 'change_footer_admin');


function sh_clean($string){
  return trim(stripslashes(htmlspecialchars($string)));
}

function pullit_create_abscense_table(){

  require_once (ABSPATH .'/wp-admin/includes/upgrade.php');
  global $wpdb;
  global $wp_queries, $charset_collate;
  
  $table_name = $wpdb->prefix . "abscence";
  $charset_collate = '';
  $charset_collate .= " COLLATE utf8_general_ci"; 
/*
  if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name){
    $sql = "CREATE TABLE {$table_name} (
      id INTEGER(10) UNSIGNED AUTO_INCREMENT ,  
      user_id INTEGER(100),
      date VARCHAR(100),
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (id) ) {$charset_collate} ";
    dbDelta($sql);
  }
  */
}

function save_coach_abscence($post_data){

    global $wpdb;
    global $wp_queries, $charset_collate;
    
    $table_name = $wpdb->prefix . "abscence";
    $charset_collate = '';
    $charset_collate .= " COLLATE utf8_general_ci";
    
    $response = $wpdb->insert($table_name,array(
      'coach_id' => $post_data['coach_id'] ,
        'date'    => $post_data['abscence_date'] ,
    ));

    if($response) {
        return true;
    }

}

function get_coaches_abscence(){

    global $wpdb;
    $data = $wpdb->get_results( 
    $wpdb->prepare("SELECT * FROM {$wpdb->prefix}abscence ORDER BY created_at DESC",
        '' ) 
    );  

    return $data;
}

/* Handle Profile Edit */
 /* 
function sh_validate_edit_profile_trainee($user_id,$post_data,$profile_img){

 $user_id = sanitize_text_field($user_id);
  $firstname = sanitize_text_field($post_data['first_name']);
  $lastname = sanitize_text_field($post_data['last_name']);
  $phone = sanitize_text_field($post_data['phone']);
  $address = sanitize_text_field($post_data['address']);


  if ( empty( $firstname ) || empty( $lastname ) || empty( $phone ) || empty( $address ) ){
    $msg = __('All profile fields are required.','pullit');
    $response = [
    'status' => 'error',
    'msg'    => $msg
    ];
    return $response;
    wp_die();
  }

  if(!empty($profile_img['name'])){

    $avilable_ext = array('jpg','jpeg','png','gif');
    $img_path_parts = pathinfo($profile_img['name']);
    $img_extension = $img_path_parts['extension'];    
    //check file extension is acceptable or not 
    if( (!in_array($img_extension, $avilable_ext)) || ($profile_img['size'] > 2097152) ){
      $response = [
        'status'  => 'error',
        'msg' => __('Not allowed file format Or size bigger than 2MB.','pullit')
      ];
      return $response;
      wp_die();
    } 
  }   

  return sh_edit_profile_trainee($user_id,$firstname, $lastname , $phone, $address ,$profile_img);


}


function sh_edit_profile_trainee($user_id,$firstname,$lastname,$phone,$address,$profile_img){

  $user_args = array(
  'ID'            => $user_id,
  'display_name'  => $firstname." ".$lastname,
  'first_name'    => $firstname,
  'last_name'     => $lastname,
  );

  $uid = wp_update_user( $user_args );

  update_user_meta($user_id,'phone',$phone);
  update_user_meta($user_id,'address',$address);

  if(!empty($profile_img['name'])){
    $uploads_dir= wp_upload_dir()['basedir'] . '/profile-pics/';

    
    // check if there's an old profile_pic for the user
    $old_pic  = get_user_meta($user_id,'pullit_profile_pic',true);

    if($old_pic != null){
        $filepath = $uploads_dir.'profile-'.$user_id;
        unlink($filepath);
      }
      

    $pic_path_parts = pathinfo($profile_img['name']);
    $pic_new_name = "profile-".$user_id.".".$pic_path_parts['extension'];
    $upload_pic = $uploads_dir . $pic_new_name;

    $is_uploaded_pic = move_uploaded_file($profile_img['tmp_name'], $upload_pic);

    update_user_meta($user_id,'pullit_profile_pic',wp_upload_dir()['baseurl']."/profile-pics/".$pic_new_name);

  }


  $msg = __('Your profile has been updated successfully.','pullit');
  $response = [
    'status' => 'success',
    'msg'    => $msg
  ];
  return $response;
  wp_die();
}
*/

/*========================================*/
function pullit_validate_edit_profile($user_id,$post_data,$profile_img){
/*  var_dump($profile_img);
  die();
*/  $user_id   = sanitize_text_field($user_id);
  $firstname = sanitize_text_field($post_data['first_name']);
  $lastname = sanitize_text_field($post_data['last_name']);
  $phone = sanitize_text_field($post_data['phone']);
  $address = sanitize_text_field($post_data['address']);


  if ( empty( $firstname ) || empty( $lastname ) || empty( $phone ) || empty( $address ) ){
        $msg = __('Required profile field is missing.','pullit');
      $response = [
        'status' => 'error',
        'msg'    => $msg
      ];
      return $response;
      wp_die();
  }
  if(!empty($profile_img['name'])){

    $avilable_ext = array('jpg','jpeg','png','gif');
    $img_path_parts = pathinfo($profile_img['name']);
    $img_extension = $img_path_parts['extension'];    
    //check file extension is acceptable or not 
    if( (!in_array($img_extension, $avilable_ext)) || ($profile_img['size'] > 2097152) ){
      $response = [
        'status'  => 'error',
        'msg' => __('Not allowed file format Or size bigger than 2MB.','pullit')
      ];
      return $response;
      wp_die();
    } 
  }   

  return pullit_update_profile($user_id,$firstname, $lastname , $phone, $address ,$profile_img);


}


function pullit_update_profile($user_id,$firstname,$lastname,$phone,$address,$profile_img){

  $user_args = array(
  'ID'            => $user_id,
  'display_name'  => $firstname." ".$lastname,
  'first_name'    => $firstname,
  'last_name'     => $lastname,
  );

  $uid = wp_update_user( $user_args );
  $user_meta = get_userdata($user_id);
  $user_roles=$user_meta->roles; 

  update_user_meta($user_id,'phone',$phone);

  // update_user_meta($user_id,'address',$address);
  // address
  update_user_meta($user_id,"address",$address);


  if(!empty($profile_img['name'])){

    $uploads_dir= wp_upload_dir()['basedir'] . '/profile-pics/';

    
    // check if there's an old profile_pic for the user
    $old_pic  = get_user_meta($user_id,"pullit_profile_pic",true);
    if($old_pic != null){
        $filepath = $uploads_dir.'profile-'.$user_id;
        $vasdsa = unlink($filepath);
      }
      

    $pic_path_parts = pathinfo($profile_img['name']);
    $pic_new_name = "profile-".$user_id.".".$pic_path_parts['extension'];
    $upload_pic = $uploads_dir . $pic_new_name;

    $is_uploaded_pic = move_uploaded_file($profile_img['tmp_name'], $upload_pic);
    update_user_meta($user_id,"pullit_profile_pic",wp_upload_dir()['baseurl']."/profile-pics/".$pic_new_name);

  }


  $msg = __('Your profile has been updated successfully.','pullit');
  $response = [
    'status' => 'success',
    'msg'    => $msg
  ];
  return $response;
  wp_die();
}


function sh_change_user_password($pass_data ){
  $user_data = wp_get_current_user();
  $check = wp_check_password($pass_data['old_pass'], $user_data->user_pass, $user_data->ID );
  if($check == true) {
    if( ($pass_data['new_pass']) === ($pass_data['pass_confirm']) ){
      $user_args = array(
        'ID'                => $user_data->ID,
        'user_pass'         => $pass_data['new_pass'],
      );
      $uid = wp_update_user( $user_args );
      if($uid){             
        $response = array(
          'status' => 1, 
          'msg'    =>'Passworrd has been updated successfully.',
        );       
      }
    }else{
      $response = array(
        'status' => 0, 
        'msg'    =>'Password and password confirmation doesn\'t match.',
      );  
    }
  }else{
    $response = array(
      'status' => 0, 
      'msg'    =>'Old password is incorrect !!',
    ); 
  }

  return $response;

}

function sh_check_logged_in(){
  if (!is_user_logged_in()) {
    wp_redirect(home_url('login'));
    exit;
  }
}

function gym_user_login_check_redirect($role){
  // if (!is_user_logged_in()) {
  //   wp_redirect(home_url('login'));
  //   exit;
  // }
  // if(!current_user_can($role)){
  //   wp_redirect(home_url());
  //   exit;
  // }
}

add_filter( 'login_redirect', 'tf_after_login_redirection_by_user_roles', 10, 99 );  
function tf_after_login_redirection_by_user_roles( $redirect_to, $request, $user ) {
  if ( isset( $user->roles ) && is_array( $user->roles ) ) :
    if ( in_array( 'trainee', $user->roles ) || in_array( 'coach', $user->roles ) ) :

      $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/dashboard-index.php'
      ));
      foreach ($pages as $page) {
          $pullit_trainee_coaches_db = get_page_link($page->ID);
        }
      return $pullit_trainee_coaches_db;

    elseif ( in_array( 'moderator', $user->roles ) || in_array( 'gym-admin', $user->roles ) ) :
    
      $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/moderator-dashboard.php'
      ));
      foreach ($pages as $page) {
        $pullit_mod_admin_db = get_page_link($page->ID);
      }
      return $pullit_mod_admin_db;
    
    else:
    
    return admin_url();

    endif;

  else:
    return $redirect_to;
  endif;
}

add_theme_support( 'post-thumbnails' );
/*Change number of  letters of the excrept */
function custom_excerpt_length( $length ) {
        return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
/*Change More of the excrept */
function new_excerpt_more( $more ) {
  return '....';
}
add_filter('excerpt_more', 'new_excerpt_more');

// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    if (!$data['type']) {
        $wp_filetype = wp_check_filetype($filename, $mimes);
        $ext = $wp_filetype['ext'];
        $type = $wp_filetype['type'];
        $proper_filename = $filename;
        if ($type && 0 === strpos($type, 'image/') && $ext !== 'svg') {
            $ext = $type = false;
        }
        $data['ext'] = $ext;
        $data['type'] = $type;
        $data['proper_filename'] = $proper_filename;
    }
    return $data;


}, 10, 4);


add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
});


add_action('admin_head', function () {
    echo '<style type="text/css">
         .media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
      width: 100% !important;
      height: auto !important;
    }</style>';
});



//** * Enable preview / thumbnail for webp image files.*/
function webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);

/******************* ********************
** Admin Login page
******************** *******************/
function gymLoginLogoChanger() { ?>
    <?php $logo = get_option('sh_logo_img'); ?>
 <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) { 
    var anchor_tag=document.getElementById('login').getElementsByTagName('h1')[0].getElementsByTagName('a')[0].setAttribute('href',"<?php bloginfo('url'); ?>");
    var anchor_tag=document.getElementById('login').getElementsByTagName('h1')[0].getElementsByTagName('a')[0].setAttribute('Title',"Powered By");
    });
 </script>
 <style type="text/css">
     body, #wp-auth-check{
        background: #FFF !important;
        color: #130c49;
     }
    .login form .input, .login input[type=text]{
     border-radius: 5px;
    }
    .login form{
     border-radius: 5px;
     color: #FFF;
    }
    .login h1 a {
     background-image: url('<?php echo $logo ?>');
     background-size: 100%;
     width: 171px;
    height: 149px;
    margin-top: 0;
     margin-top: 0;
     margin-bottom: -20px;
    }
    body,#wp-auth-check{
     background: #FFF;
     background-size: 100% auto;
     background-repeat: repeat-y;
    }
    .login form{
     background: #130c49;
     border: 1px solid #fff;
    }
    #wp-submit{
        background:#E1C415;
        border: 0;
        box-shadow: none;
        color: #130c49;
        text-shadow: none;
        font-weight: 600;
    }
    #wp-submit:hover{
        opacity: 0.8;
    }

    .login #backtoblog a:hover, .login #backtoblog a:active, .login #backtoblog a:focus, .login #nav a:hover, .login #nav a:active ,.login #nav a:focus, .login h1 a:hover, .login h1 a:active, .login h1 a:focus{
     color: #E1C415;
     outline: 0px;
     border:0px;
     box-shadow: none;
    }
    .login #login_error, .login .message{
      box-shadow: 1px 1px 5px 2px #333;
    }
    .login #backtoblog, .login #nav{
        display: inline-block;
        margin-top: 20px;   
        width: 158px;
        padding: 0 ;
        margin:15px 0; 
    }
     .login #backtoblog a, .login #nav a, .login h1 a{
        color: #FFF;
        display: inline-flex;
    }
 
 </style>
<?php 
}
add_action( 'login_head', 'gymLoginLogoChanger' );

/*Email Sender*/
function slavo_send_email ($recipients, $subject = '', $message = '',$sender_name='pullitt (no reply)',$sender_email=''){
    if($sender_email=='')
        $sender_email=get_option('admin_email');
    $message = stripslashes($message);
    $subject = stripslashes($subject); 

    $email_name_from  = $sender_name;
    $email_addr_from  = $sender_email;

    $headers = 'From: '. $email_name_from .' <'. $email_addr_from .'>'. PHP_EOL ;

    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
    $mailtext = "<html><head><title>" . $subject . "</title></head><body>" . nl2br($message) . "</body></html>";
    return wp_mail($recipients, $subject, $mailtext, $headers);
}


function gym_nav_menu_items_manipulation($items) {

    $user_role = wp_get_current_user()->roles[0];

    if ( in_array( $user_role, ['coach','trainee'] ) ) :
      $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/dashboard-index.php'
      ));
      foreach ($pages as $page) {
        $dash_link = get_page_link($page->ID);
      }

    elseif ( in_array( $user_role,['moderator','gym-admin'] ) ) :
      $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'page-templates/moderator-dashboard.php'
      ));
      foreach ($pages as $page) {
        $dash_link = get_page_link($page->ID);
      }
    else :
    endif;

    if(!empty($dash_link)) :
      $dash = '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="'.$dash_link.'">Dashboard</a></li>';
      $items = $items.$dash;
    endif;

    $login = '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="'.wp_login_url().'">Login</a></li>';
    $logout = '<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="'.wp_logout_url().'">Logout</a></li>';
    if (!is_user_logged_in()){
      $items = $items . $login;
    }else{
      $items = $items . $logout;
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'gym_nav_menu_items_manipulation' );



/*Inser media*/
function insert_attachment($file_handler,$post_id,$setthumb='false') {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    $attach_id = media_handle_upload( $file_handler, $post_id );
    set_post_thumbnail( $post_id, $attach_id );
    $url = wp_get_attachment_url($attach_id);
    if ($setthumb) update_post_meta($post_id,'_thumbnail_id', array($url));
    return $attach_id;
}

/**
 * Get user's Gym
 * @param moderator_id [int]
 * @return gym_id [int, boolean(false)]
 */
function get_user_gym_id($user_id = false) {
  if(empty($user_id))
    $user_id = get_current_user_id();
  return intval(get_user_meta($user_id, 'user_gym_id', true ));
}

/**
 * Increment Gym's in-hall trainees
 * @param $gym_id, $user_id [int]
 * @return  [boolean] increment success or not if no gym_id provided
 */
function increment_gym_users($gym_id = false, $user_id = false) {
  if( empty($gym_id) ||empty($user_id) ) return false;
  $no_users = get_post_meta($gym_id, 'users_in_gym_no', true);
  $no_users = $no_users ? intval($no_users) : 0;
  $no_users ++;
  update_post_meta($gym_id, 'users_in_gym_no', $no_users);
  //ids thing
  $users_ids = get_post_meta($gym_id, 'users_in_gym', true);
  $users_ids = $no_users ? explode(',', $no_users) : array();
  array_push($users_ids, $user_id);
  update_post_meta($gym_id, 'users_in_gym', join(',', $users_ids));
  return true;
}

/**
 * Decrement Gym's in-hall trainees
 * @param gym_id [int], user_id [int]
 * @return [boolean] increment success or not if no gym_id provided
 */
function decrement_gym_users($gym_id = false, $user_id = false) {
  if( empty($gym_id) || empty($user_id) ) return false;
  $no_users = get_post_meta($gym_id, 'users_in_gym_no', true);
  $no_users = $no_users ? intval($no_users) : 0;
  $no_users --;
  update_post_meta($gym_id, 'users_in_gym_no', $no_users);
  //ids thing
  $users_ids = get_post_meta($gym_id, 'users_in_gym', true);
  $users_ids = $no_users ? explode(',', $no_users) : array();
  foreach ($users_ids as $i => $value) {
    if ($value === $user_id ) {
      unset($users_ids[$i]);
    }
  }
  update_post_meta($gym_id, 'users_in_gym', join(',', $users_ids));
  return true;
}

/**
 * Loggin user in of gym
 * @param gym_id [int], user_id [int]
 * @return [boolean] false on insufficient params and true no. on success
 */
function user_entered_gym($gym_id = false, $user_id = false) {
  if( empty($gym_id) || empty($user_id) ) return false;
  $time = time();
  $record_id = update_user_meta($user_id, 'sl_user_in', $time);
  increment_gym_users($gym_id, $user_id);
  return $record_id;
}
/**
 * Loggin user out of gym
 * @param gym_id [int], user_id [int]
 * @return [boolean] false on insufficient params and true no. on success
 */
function user_left_gym($gym_id = false, $user_id = false) {
  if( empty($gym_id) ) return false;
  $status = delete_user_meta($user_id, 'sl_user_in');
  decrement_gym_users($gym_id, $user_id);
  return $status;
}
/**
 * Insert Staff in-out action
 * @param staff_id [int]
 * @return [boolean] false on insufficient params or failure and true no. on success
 */
function record_staff_attendance($staff_id = false) {
  if( empty($staff_id) ) return false;
  global $wpdb;
  global $charset_collate;
  $table_name = $wpdb->prefix . "attendance";
  $charset_collate = '';
  $charset_collate .= " COLLATE utf8_general_ci";

  $user_in = get_user_meta($staff_id, 'sl_user_entered', true);
  if (!$user_in) {
    $event = 1;
    update_user_meta($staff_id, 'sl_user_entered', '1');
  }
  else {
    $event = 2;
    delete_user_meta($staff_id, 'sl_user_entered');
  }
  $event = !$user_in ? 1 : 2;
  
  date_default_timezone_set('Africa/Cairo');
  $response = $wpdb->insert($table_name,array(
    'user_id'     => $staff_id,
    'event'       => $event,
    'created_at'  => date('Y-m-d H:i:s', time()),
  ));
  if($response) {
      return true;
  }
  return false;
}

/**
 * Insert Staff in-out action
 * @param staff_id [int]
 * @return [boolean] false on insufficient params or failure and true no. on success
 */
function get_staff_attendace($from_date = false, $to_date = false, $user_id = false) {
  global $wpdb;
  $from_date = !$from_date ? date('y-m-d H:i') : $from_date;
  $to_date = !$to_date ? date('y-m-d H:i') : $to_date;
 
  $table_name = $wpdb->prefix . "attendance";

  $user_where = !$user_id ? '' : " `user_id` = {$user_id} AND ";

  $sql = "SELECT * FROM `{$table_name}` WHERE {$user_where} `created_at` BETWEEN '{$from_date}' AND '{$to_date}'";

  $results =  $wpdb->get_results($sql);
  return $results;
}
/**
 * Get Gym's  in-hall trainees
 * @param gym_id [int]
 * @return [mixed boolean, int] boolean false on failure and integer no. on success
 */
function get_in_gym_users($gym_id = false) {
  if( empty($gym_id) ) return false;
  global $wpdb;
  $user_no = get_post_meta($gym_id, 'users_in_gym_no', true);
  $user_no = empty($user_no) ? 0 : intval($user_no);
  $users_ids = get_post_meta($gym_id, 'users_in_gym', true);
  if(empty($users_ids)) return 0;
  $sql = "SELECT `user_id`, `meta_value` from `{$wpdb->prefix}usermeta` WHERE `user_id` IN ({$users_ids}) AND `meta_key` = 'sl_user_in'";
  $users_times = $wpdb->get_results($sql);
  $current_time = time();
  foreach($users_times as $user_time ) {
    if($current_time - intval($user_time->meta_value) >= 3 * 60 * 60) {
      user_left_gym($gym_id, $user_time->user_id);
      $user_no = $user_no === 0 ? 0 : $user_no - 1;
    }
  }
  return $user_no;
}

function pullit_get_gym_users($gym_id,$role = null){
  $paged  =  (get_query_var( 'paged' )) ?  absint( get_query_var( 'paged' ) ) : 1;  
  $args =  array( 
    'orderby'         => 'name',
    'order'           => 'ASC',
    // 'number'          => 2,
    // 'offset'          => 0,
    // 'paged'           => $paged,
  ); 
  
  if(!empty($role)){
    if(is_array($role)){
      $args['role__in'] = $role;
    }else{
      $args['role'] = $role;
    }
  }

  if(!empty($gym_id)){
      $args['meta_query'] =  [
      array(
          'key'     => 'user_gym_id',
          'value'   => $gym_id,
          'compare' => '==',
      ),
    ];  
  }
    $user_query = new WP_User_Query( $args );
  $users = get_users($args);
  return $users;
}
function pullit_get_gym_users_search($gym_id,$search_keyword,$role = null){
    $args =  array( 
    'search'         => "*{$search_keyword}*",
    'orderby'         => 'name',
    'order'           => 'ASC',
  ); 
  
  if(!empty($role)){
    if(is_array($role)){
      $args['role__in'] = $role;
    }else{
      $args['role'] = $role;
    }
  }

  if(!empty($gym_id)){
      $args['meta_query'] =  [
      array(
          'key'     => 'user_gym_id',
          'value'   => $gym_id,
          'compare' => '==',
      ),
    ];  
  }
  
  
  $users = get_users($args);
  return $users ;
}
function pullit_get_gym_games($gym_id){
  $paged  =  (get_query_var( 'paged' )) ?  absint( get_query_var( 'paged' ) ) : 1;
  $args = array(
      'post_type'=>'game',
      'post_status'=>'publish',
      'posts_per_page'=> 25,
      'paged'         => $paged,
      'orderby'=>'title',
      'order'=>'ASC',
      'meta_query' => array(
        array(
          'key'     => 'gym_game_gym',
          'value'   => $gym_id,
          'compare' => '=',
        )
      ),
  );
  $games = new WP_Query($args);
  return $games;
}
function pullit_get_gym_plans($gym_id){
  $paged  =  (get_query_var( 'paged' )) ?  absint( get_query_var( 'paged' ) ) : 1;
  $args = array(
      'post_type'=>'plan',
      'post_status'=>'publish',
      'posts_per_page'=> 25,
      'paged'         => $paged,
      'orderby'=>'title',
      'order'=>'ASC',
      'meta_query' => array(
        array(
          'key'     => 'gym_plan_gym',
          'value'   => $gym_id,
          'compare' => '=',
        )
      ),
  );
  $plans = new WP_Query($args);
  return $plans;
}
function pullit_get_gym_feeds($gym_id){
  $paged  =  (get_query_var( 'paged' )) ?  absint( get_query_var( 'paged' ) ) : 1;
  $args = array(
        'post_type'=>'post',
        'post_status'=>'publish',
        'posts_per_page'=> 25,
        'paged'         => $paged,
        'orderby'=>'title',
        'order'=>'ASC',
        'meta_query' => array(
          array(
            'key'     => 'feeds_gym_id',
            'value'   => $gym_id,
            'compare' => '=',
          )
        ),
    );
  $feeds = new WP_Query($args);
  return $feeds;
}
function gym_save_new_coach($post_data,$files_data){
  /** Form Validation **/
  $user_name = trim(stripcslashes(htmlspecialchars($post_data['gym-user-name'])));
  if( empty($user_name) )
    $errors[] = '<strong>Error : </strong>User name is required .';

    if( username_exists($user_name) )
    $errors[] = '<strong>Error : </strong>User name already exists , please choose another one';

  $email = trim(stripcslashes(htmlspecialchars($post_data['gym-user-email'])));
  if( empty($email) )
    $errors[] = '<strong>Error : </strong>Email is required .';

  if( !is_email( $email ) || email_exists( $email ) )
    $errors[] = '<strong> Error : </strong> You can\'t register with this email it is not valid or already exists .';

  $password = trim(stripcslashes(htmlspecialchars($post_data['gym-user-password'])));
  if( empty($password) )
    $errors[] = '<strong>Error : </strong>Password is required .';

  if( $password != $post_data['gym-user-password-confirmation'] )
    $errors[] = '<strong>Error : </strong>The password and repassword fields don\'t match';
  

  if(!empty($files_data['gym-plan-image']['name'])){

    $avilable_ext = array('jpg','jpeg','png','gif');
    $img_path_parts = pathinfo($files_data['gym-plan-image']['name']);
    $img_extension = $img_path_parts['extension'];    
    //check file extension is acceptable or not 
    if( (!in_array($img_extension, $avilable_ext)) || ($files_data['gym-plan-image']['size'] > 2097152) ){
      $errors[] = '<strong>Error : </strong>Not allowed file format Or size bigger than 2MB.';
    } 
  }

  $gym_id = get_user_meta(get_current_user_id() , 'user_gym_id',true);

  if( empty($errors) ){


    $user_args = array(
      'user_pass'     => $post_data['gym-user-password'],
      'user_login'    => $post_data['gym-user-name'],
      'user_email'    => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'          => 'coach',
    );

    $uid = wp_insert_user( $user_args );



    if( !empty($_POST['gym-user-games']) ){
      update_user_meta( $uid, 'coach_categories', $_POST['gym-user-games'] );
    }
    if( !empty($_POST['gym-user-phone']) ){
      update_user_meta( $uid, 'phone', $_POST['gym-user-phone'] );
    }
    if( !empty($_POST['gym-user-address']) ){
      update_user_meta( $uid, 'address', $_POST['gym-user-address'] );
    }
    if( !empty($_POST['gym-user-attendance']) ){
      update_user_meta( $uid, 'ha_coach_days', $_POST['gym-user-attendance'] );
    }
    if( !empty($_POST['gym-user-gender']) ){
      update_user_meta( $uid, 'gym_coach_gender', $_POST['gym-user-gender'] );
    }

    update_user_meta( $uid, 'user_gym_id', $gym_id );

    if(!empty($files_data['gym-plan-image']['name'])){

      $uploads_dir= wp_upload_dir()['basedir'] . '/profile-pics/';

      $pic_path_parts = pathinfo($files_data['gym-plan-image']['name']);
      $pic_new_name = "profile-".$uid.".".$pic_path_parts['extension'];
      $upload_pic = $uploads_dir . $pic_new_name;

      $is_uploaded_pic = move_uploaded_file($files_data['gym-plan-image']['tmp_name'], $upload_pic);
      update_user_meta($uid,'pullit_profile_pic',wp_upload_dir()['baseurl']."/profile-pics/".$pic_new_name);
    }
      $response = array(
        'status' => 1 
      );    
  }else{
      $response = array(
        'status' => 0 ,
        'msg'    => $errors 
      );    
    }
  return $response;
}

function gym_get_caoch_data($uid){

  $data = get_userdata($uid);

  $data->first_name = get_user_meta( $uid, 'first_name',true );
  $data->last_name = get_user_meta( $uid, 'last_name',true );
  $data->categories = get_user_meta( $uid, 'coach_categories',true );
  $data->phone = get_user_meta( $uid, 'phone', true );
  $data->address = get_user_meta( $uid, 'address', true );
  $data->days = get_user_meta( $uid, 'ha_coach_days', true );
  $data->gender = get_user_meta( $uid, 'gym_coach_gender', true );
  $data->profile_pic = get_user_meta($uid,'pullit_profile_pic', true );
  
  return $data;
}

function gym_update_coach($post_data,$files_data){
  /** Form Validation **/
  $user_name = trim(stripcslashes(htmlspecialchars($post_data['gym-user-name'])));
  if( empty($user_name) )
    $errors[] = '<strong>Error : </strong>User name is required .';

  $email = trim(stripcslashes(htmlspecialchars($post_data['gym-user-email'])));
  if( empty($email) )
    $errors[] = '<strong>Error : </strong>Email is required .';

  $password = trim(stripcslashes(htmlspecialchars($post_data['gym-user-password'])));
  if( !empty($password) ){
    if( $password != $post_data['gym-user-password-confirmation'] )
    $errors[] = '<strong>Error : </strong>The password and repassword fields don\'t match';
  }
  

  if(!empty($files_data['gym-plan-image']['name'])){

    $avilable_ext = array('jpg','jpeg','png','gif');
    $img_path_parts = pathinfo($files_data['gym-plan-image']['name']);
    $img_extension = $img_path_parts['extension'];    
    //check file extension is acceptable or not 
    if( (!in_array($img_extension, $avilable_ext)) || ($files_data['gym-plan-image']['size'] > 2097152) ){
      $errors[] = '<strong>Error : </strong>Not allowed file format Or size bigger than 2MB.';
    } 
  }

  $gym_id = get_user_meta(get_current_user_id() , 'user_gym_id',true);

  $uid = $post_data['gym-user-id'];
  if( empty($errors) ){

  if(!empty($post_data['gym-user-password'])){
    $user_args = array(
      'ID'            => $uid,
      'user_pass'   => $post_data['gym-user-password'],
      'user_login'  => $post_data['gym-user-name'],
      'user_email'  => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'      => 'coach', 
      );

  }else{

    $user_args = array(
      'ID'            => $uid,
      'user_login'  => $post_data['gym-user-name'],
      'user_email'  => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'      => 'coach', 
      );

  }
  $uid = wp_update_user( $user_args );

  if( !empty($_POST['gym-user-games']) ){
    update_user_meta( $uid, 'coach_categories', $_POST['gym-user-games'] );
  }
  if( !empty($_POST['gym-user-phone']) ){
    update_user_meta( $uid, 'phone', $_POST['gym-user-phone'] );
  }
  if( !empty($_POST['gym-user-address']) ){
    update_user_meta( $uid, 'address', $_POST['gym-user-address'] );
  }
  if( !empty($_POST['gym-user-attendance']) ){
    update_user_meta( $uid, 'ha_coach_days', $_POST['gym-user-attendance'] );
  }
  if( !empty($_POST['gym-user-gender']) ){
    update_user_meta( $uid, 'gym_coach_gender', $_POST['gym-user-gender'] );
  }

  update_user_meta( $uid, 'user_gym_id', $gym_id );

  if(!empty($files_data['gym-plan-image']['name'])){
    $uploads_dir= wp_upload_dir()['basedir'] . '/profile-pics/';

    $old_pic  = get_user_meta($uid,'pullit_profile_pic',true);

    if($old_pic != null){
      $filepath = $uploads_dir.'profile-'.$uid;
      $awdsa = unlink($filepath);
    }

    $pic_path_parts = pathinfo($files_data['gym-plan-image']['name']);
    $pic_new_name = "profile-".$uid.".".$pic_path_parts['extension'];
    $upload_pic = $uploads_dir . $pic_new_name;

    $is_uploaded_pic = move_uploaded_file($files_data['gym-plan-image']['tmp_name'], $upload_pic);
    update_user_meta($uid,'pullit_profile_pic',wp_upload_dir()['baseurl']."/profile-pics/".$pic_new_name);
  
  }

  $response = array(
    'status' => 1 
  );  

}else{
  $response = array(
    'status' => 0 ,
    'msg'    => $errors 
  );    
}
return $response;  
}

function gym_save_new_moderator($post_data){
  /** Form Validation **/
  $user_name = trim(stripcslashes(htmlspecialchars($post_data['gym-user-name'])));
  if( empty($user_name) )
    $errors[] = '<strong>Error : </strong>User name is required .';

    if( username_exists($user_name) )
    $errors[] = '<strong>Error : </strong>User name already exists , please choose another one';

  $email = trim(stripcslashes(htmlspecialchars($post_data['gym-user-email'])));
  if( empty($email) )
    $errors[] = '<strong>Error : </strong>Email is required .';

  if( !is_email( $email ) || email_exists( $email ) )
    $errors[] = '<strong> Error : </strong> You can\'t register with this email it is not valid or already exists .';

  $password = trim(stripcslashes(htmlspecialchars($post_data['gym-user-password'])));
  if( empty($password) )
    $errors[] = '<strong>Error : </strong>Password is required .';

  if( $password != $post_data['gym-user-password-confirmation'] )
    $errors[] = '<strong>Error : </strong>The password and repassword fields don\'t match';
  
  $gym_id = get_user_meta(get_current_user_id() , 'user_gym_id',true);

  if( empty($errors) ){

    $user_args = array(
      'user_pass'     => $post_data['gym-user-password'],
      'user_login'    => $post_data['gym-user-name'],
      'user_email'    => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'          => 'moderator',
    );

    $uid = wp_insert_user( $user_args );

    update_user_meta( $uid, 'user_gym_id', $gym_id );

    if( !empty($_POST['gym-user-phone']) ){
      update_user_meta( $uid, 'phone', $_POST['gym-user-phone'] );
    }

      $response = array(
        'status' => 1 
      );    
  }else{
      $response = array(
        'status' => 0 ,
        'msg'    => $errors 
      );    
    }
  return $response;
}

function gym_get_moderator_data($uid){

  $data = get_userdata($uid);

  $data->first_name = get_user_meta( $uid, 'first_name',true );
  $data->last_name = get_user_meta( $uid, 'last_name',true );
  $data->phone = get_user_meta( $uid, 'phone',true );
  
  return $data;
}
function gym_update_moderator($post_data){
  /** Form Validation **/
  $user_name = trim(stripcslashes(htmlspecialchars($post_data['gym-user-name'])));
  if( empty($user_name) )
    $errors[] = '<strong>Error : </strong>User name is required .';

  $email = trim(stripcslashes(htmlspecialchars($post_data['gym-user-email'])));
  if( empty($email) )
    $errors[] = '<strong>Error : </strong>Email is required .';

  $password = trim(stripcslashes(htmlspecialchars($post_data['gym-user-password'])));
  if( !empty($password) ){
    if( $password != $post_data['gym-user-password-confirmation'] )
    $errors[] = '<strong>Error : </strong>The password and repassword fields don\'t match';
  }
  
  $gym_id = get_user_meta(get_current_user_id() , 'user_gym_id',true);

  $uid = $post_data['gym-user-id'];
  if( empty($errors) ){

  if(!empty($post_data['gym-user-password'])){
    $user_args = array(
      'ID'            => $uid,
      'user_pass'   => $post_data['gym-user-password'],
      'user_login'  => $post_data['gym-user-name'],
      'user_email'  => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'      => 'moderator', 
      );

  }else{

    $user_args = array(
      'ID'            => $uid,
      'user_login'  => $post_data['gym-user-name'],
      'user_email'  => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'      => 'moderator', 
      );

  }
  $uid = wp_update_user( $user_args );

  update_user_meta( $uid, 'user_gym_id', $gym_id );

  if( !empty($_POST['gym-user-phone']) ){
    update_user_meta( $uid, 'phone', $_POST['gym-user-phone'] );
  }

  $response = array(
    'status' => 1 
  );  

}else{
  $response = array(
    'status' => 0 ,
    'msg'    => $errors 
  );    
}
return $response;  
}

function gym_save_new_trainee($post_data,$files_data){
  /** Form Validation **/
  $user_name = trim(stripcslashes(htmlspecialchars($post_data['gym-user-name'])));
  if( empty($user_name) )
    $errors[] = '<strong>Error : </strong>User name is required .';

    if( username_exists($user_name) )
    $errors[] = '<strong>Error : </strong>User name already exists , please choose another one';

  $email = trim(stripcslashes(htmlspecialchars($post_data['gym-user-email'])));
  if( empty($email) )
    $errors[] = '<strong>Error : </strong>Email is required .';

  if( !is_email( $email ) || email_exists( $email ) )
    $errors[] = '<strong> Error : </strong> You can\'t register with this email it is not valid or already exists .';

  $password = trim(stripcslashes(htmlspecialchars($post_data['gym-user-password'])));
  if( empty($password) )
    $errors[] = '<strong>Error : </strong>Password is required .';

  if( $password != $post_data['gym-user-password-confirmation'] )
    $errors[] = '<strong>Error : </strong>The password and repassword fields don\'t match';
  

  if(!empty($files_data['gym-plan-image']['name'])){

    $avilable_ext = array('jpg','jpeg','png','gif');
    $img_path_parts = pathinfo($files_data['gym-plan-image']['name']);
    $img_extension = $img_path_parts['extension'];    
    //check file extension is acceptable or not 
    if( (!in_array($img_extension, $avilable_ext)) || ($files_data['gym-plan-image']['size'] > 2097152) ){
      $errors[] = '<strong>Error : </strong>Not allowed file format Or size bigger than 2MB.';
    } 
  }

  $gym_id = get_user_gym_id();

  if( empty($errors) ){
    $user_args = array(
      'user_pass'     => $post_data['gym-user-password'],
      'user_login'    => $post_data['gym-user-name'],
      'user_email'    => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'          => 'trainee',
    );

    $uid = wp_insert_user( $user_args );

    if( !empty($_POST['gym-user-phone']) ){
      update_user_meta( $uid, 'phone', $_POST['gym-user-phone'] );
    }
    if( !empty($_POST['gym-user-address']) ){
      update_user_meta( $uid, 'address', $_POST['gym-user-address'] );
    }
    if( !empty($_POST['gym-user-gender']) ){
      update_user_meta( $uid, 'gym_trainee_gender', $_POST['gym-user-gender'] );
    }
    if( !empty($_POST['gym-user-start-date']) ){
      update_user_meta( $uid, 'trainee_start_date', $_POST['gym-user-start-date'] );
    }
    if( !empty($_POST['gym-user-end-date']) ){
      update_user_meta( $uid, 'trainee_end_date', $_POST['gym-user-end-date'] );
    }
    if( !empty($_POST['gym-user-plan']) ){
      update_user_meta( $uid, 'trainee_plan', $_POST['gym-user-plan'] );
    }
    if( !empty($_POST['gym-user-sessions']) ){
      update_user_meta( $uid, 'trainee_session_num', $_POST['gym-user-sessions'] );
    }
    if( !empty($_POST['gym-user-has-private']) ){
      update_user_meta( $uid, 'ha_private_trainer', $_POST['gym-user-has-private'] );
      if( !empty($_POST['gym-user-caoch-id']) ){
        update_user_meta( $uid, 'trainee_trainer', $_POST['gym-user-caoch-id'] );
      }
    }

    update_user_meta( $uid, 'user_gym_id', $gym_id );

    if(!empty($files_data['gym-plan-image']['name'])){

      $uploads_dir= wp_upload_dir()['basedir'] . '/profile-pics/';

      $pic_path_parts = pathinfo($files_data['gym-plan-image']['name']);
      $pic_new_name = "profile-".$uid.".".$pic_path_parts['extension'];
      $upload_pic = $uploads_dir . $pic_new_name;

      $is_uploaded_pic = move_uploaded_file($files_data['gym-plan-image']['tmp_name'], $upload_pic);
      update_user_meta($uid,'pullit_profile_pic',wp_upload_dir()['baseurl']."/profile-pics/".$pic_new_name);
    }
      $response = array(
        'status' => 1 
      );    
  }else{
      $response = array(
        'status' => 0 ,
        'msg'    => $errors 
      );    
    }
  return $response;
}
function planRenewal($post_data){

    if( !empty($post_data['gym-user-start-date']) ){
      update_user_meta( $post_data['user-id'], 'trainee_start_date', $post_data['gym-user-start-date'] );
    }
    if( !empty($post_data['gym-user-end-date']) ){
      update_user_meta( $post_data['user-id'], 'trainee_end_date', $post_data['gym-user-end-date'] );
    }
    if( !empty($post_data['gym-user-plan']) ){
      update_user_meta( $post_data['user-id'], 'trainee_plan', $post_data['gym-user-plan'] );
    }
    if( !empty($post_data['gym-user-sessions']) ){
      update_user_meta( $post_data['user-id'], 'trainee_session_num', $post_data['gym-user-sessions'] );
    }
    $response = array(
        'status' => 1 
      );    
  return $response;  

}

function gym_get_trainee_data($uid){

  $data = get_userdata($uid);

  $data->first_name = get_user_meta( $uid, 'first_name',true );
  $data->last_name = get_user_meta( $uid, 'last_name',true );
  $data->phone = get_user_meta( $uid, 'phone', true );
  $data->address = get_user_meta( $uid, 'address', true );
  $data->gender = get_user_meta( $uid, 'gym_trainee_gender', true );
  $data->start_date = get_user_meta( $uid, 'trainee_start_date',true );
  $data->end_date = get_user_meta( $uid, 'trainee_end_date',true );
  $data->traineeplan = get_user_meta( $uid, 'trainee_plan', true );
  $data->session_num = get_user_meta( $uid, 'trainee_session_num', true );
  $data->has_private_trainer = get_user_meta( $uid, 'ha_private_trainer', true );
  $data->private_trainer_id = get_user_meta( $uid, 'trainee_trainer', true );
  $data->profile_pic = get_user_meta($uid,'pullit_profile_pic', true );
  
  return $data;
}

function gym_update_trainee($post_data,$files_data){
  /** Form Validation **/
  $user_name = trim(stripcslashes(htmlspecialchars($post_data['gym-user-name'])));
  if( empty($user_name) )
    $errors[] = '<strong>Error : </strong>User name is required .';

  $email = trim(stripcslashes(htmlspecialchars($post_data['gym-user-email'])));
  if( empty($email) )
    $errors[] = '<strong>Error : </strong>Email is required .';

  $password = trim(stripcslashes(htmlspecialchars($post_data['gym-user-password'])));
  if( !empty($password) ){
    if( $password != $post_data['gym-user-password-confirmation'] )
    $errors[] = '<strong>Error : </strong>The password and repassword fields don\'t match';
  }
  

  if(!empty($files_data['gym-plan-image']['name'])){

    $avilable_ext = array('jpg','jpeg','png','gif');
    $img_path_parts = pathinfo($files_data['gym-plan-image']['name']);
    $img_extension = $img_path_parts['extension'];    
    //check file extension is acceptable or not 
    if( (!in_array($img_extension, $avilable_ext)) || ($files_data['gym-plan-image']['size'] > 2097152) ){
      $errors[] = '<strong>Error : </strong>Not allowed file format Or size bigger than 2MB.';
    } 
  }

  $gym_id = get_user_gym_id();

  $uid = $post_data['gym-user-id'];
  if( empty($errors) ){

  if(!empty($post_data['gym-user-password'])){
    $user_args = array(
      'ID'            => $uid,
      'user_pass'   => $post_data['gym-user-password'],
      'user_login'  => $post_data['gym-user-name'],
      'user_email'  => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'      => 'trainee', 
      );

  }else{

    $user_args = array(
      'ID'            => $uid,
      'user_login'  => $post_data['gym-user-name'],
      'user_email'  => $post_data['gym-user-email'],
      'display_name'  => $post_data['gym-first-name']." ".$post_data['gym-last-name'],
      'first_name'    => $post_data['gym-first-name'],
      'last_name'     => $post_data['gym-last-name'],
      'role'      => 'trainee', 
      );

  }
  $uid = wp_update_user( $user_args );

  if( !empty($_POST['gym-user-phone']) ){
    update_user_meta( $uid, 'phone', $_POST['gym-user-phone'] );
  }
  if( !empty($_POST['gym-user-address']) ){
    update_user_meta( $uid, 'address', $_POST['gym-user-address'] );
  }
  if( !empty($_POST['gym-user-gender']) ){
    update_user_meta( $uid, 'gym_trainee_gender', $_POST['gym-user-gender'] );
  }
  if( !empty($_POST['gym-user-start-date']) ){
    update_user_meta( $uid, 'trainee_start_date', $_POST['gym-user-start-date'] );
  }
  if( !empty($_POST['gym-user-end-date']) ){
    update_user_meta( $uid, 'trainee_end_date', $_POST['gym-user-end-date'] );
  }
  if( !empty($_POST['gym-user-plan']) ){

    update_user_meta( $uid, 'trainee_plan', $_POST['gym-user-plan'] );
  }
  if( !empty($_POST['gym-user-sessions']) ){
    update_user_meta( $uid, 'trainee_session_num', $_POST['gym-user-sessions'] );
  }
  if( !empty($_POST['gym-user-has-private']) ){
    update_user_meta( $uid,'ha_private_trainer',$_POST['gym-user-has-private']);
    if( !empty($_POST['gym-user-caoch-id']) ){
      update_user_meta( $uid, 'trainee_trainer', $_POST['gym-user-caoch-id'] );
    }
  }

  update_user_meta( $uid, 'user_gym_id', $gym_id );

  if(!empty($files_data['gym-plan-image']['name'])){
    $uploads_dir= wp_upload_dir()['basedir'] . '/profile-pics/';

    $old_pic  = get_user_meta($uid,'pullit_profile_pic',true);

    if($old_pic != null){
      $filepath = $uploads_dir.'profile-'.$uid;
      $awdsa = unlink($filepath);
    }

    $pic_path_parts = pathinfo($files_data['gym-plan-image']['name']);
    $pic_new_name = "profile-".$uid.".".$pic_path_parts['extension'];
    $upload_pic = $uploads_dir . $pic_new_name;

    $is_uploaded_pic = move_uploaded_file($files_data['gym-plan-image']['tmp_name'], $upload_pic);
    update_user_meta($uid,'pullit_profile_pic',wp_upload_dir()['baseurl']."/profile-pics/".$pic_new_name);
  
  }

  $response = array(
    'status' => 1 
  );  

}else{
  $response = array(
    'status' => 0 ,
    'msg'    => $errors 
  );    
}
return $response;  
}


function pullit_delete_user($toBedDleted){
  $user = get_userdata( $toBedDleted );
  if( $user === false ) {
    $response = [
      'status' =>'error',
      'msg' =>'USer Doesn\'t Exist'
    ];    
  }else{
    $gym_id = get_user_gym_id();
    $user_gym_id = get_user_meta($toBedDleted,'user_gym_id',true);

    if($gym_id == $user_gym_id){

      $toBeDeleted_role = $user->roles[0];

      $current_role = wp_get_current_user()->roles[0];
      if($current_role == 'gym-admin') $allowed = ['coach','trainee','moderator'];
      if($current_role == 'moderator') $allowed = ['coach','trainee'];

      if(in_array($toBeDeleted_role, $allowed)){
        wp_delete_user($toBedDleted);
        $response = [
          'status' =>'success',
          'msg' =>'User Has Been Deleted Successfully'
        ];                  
      }else{
        $response = [
          'status' =>'error',
          'msg' =>'You are not allowed to do this action'
        ];                  
      }

    }else{
      $response = [
        'status' =>'error',
        'msg' =>'You Can\'t delete a user that is not assigned to your gym'
      ];          
    }
  
  }
  return $response;
}


function adminCan(){
  $curresnt_user = wp_get_current_user();
  if ( !in_array( "gym-admin", (array) $curresnt_user->roles ) && !in_array( 'administrator', (array) $curresnt_user->roles )&& !in_array( 'moderator', (array) $curresnt_user->roles ) ) {
      wp_redirect(wp_logout_url());     
      exit;
  }
}
function moderatorCant(){
    $curresnt_user = wp_get_current_user();
    $pages = get_pages(array(
      'meta_key' => '_wp_page_template',
      'meta_value' => 'page-templates/moderator-dashboard.php'
    ));
  $dashLink = get_page_link($pages[0]->id);
  if (in_array( 'moderator', (array) $curresnt_user->roles ) ) {
    echo '<script> window.location.href="'.$dashLink."?message= You can't access this page".'"</script>';

  }
}

/******************** *********************
** Pareparing Attachment Queries
** Non Admins only access their own
********************* ********************/
add_filter( 'ajax_query_attachments_args', 'slRestrictAttachments', 10, 1 );
function slRestrictAttachments( $query = array() ) {
  global $current_user;
    $user_id = get_current_user_id();
    if( $current_user->roles[0]!='administrator' ) {
        $query['author'] = $user_id;
    }
    return $query;
}