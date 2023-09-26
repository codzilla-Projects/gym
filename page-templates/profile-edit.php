<?php 
/**
** Template Name: Edit My Profile
**/
sh_check_logged_in();
if ( in_array( 'coach', (array) $current_user->roles ) ) {
  get_header('coach');
    $role  = 'coach';

}else if ( in_array( 'trainee', (array) $current_user->roles ) ) {
  get_header('subscriber');
    $role  = 'trainee';
}else if(in_array( 'administrator', (array) $current_user->roles ) || in_array( 'moderator', (array) $current_user->roles ) || in_array( 'gym-admin', (array) $current_user->roles )){
  get_header('mod');
    $role  = 'moderator';
  get_template_part("partials/moderator-parttials/right-menu-mod")  ;
   get_template_part("partials/moderator-parttials/left-menu-mod") ;
}else{
  if (!is_user_logged_in()) {
    wp_redirect(home_url('login'));
    exit;
  }
}
$current_user     = wp_get_current_user();
$user_id = get_current_user_id();
$tPage = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/change_my_password.php'
));
foreach ($tPage as $page) {
  $change_my_password = get_page_link($page->ID);
}
if ( isset($_POST['edit-profile'] ) ) {
    $response = pullit_validate_edit_profile($user_id,$_POST,$_FILES["profile_pic"]);
    $_POST = array();
}
?>
<div id="layoutSidenav_content">  
    <main id="blogs">
        <div class="container-fluid">
            <section id="content">
                <div class="content-wrap">
                  <div class="container">                
                        <div class=" sh_content_block">
                            <div class="alert-area">
                                <?php if ( !empty( $response ) && isset($response) ) { ?>
                                  <?php if($response['status'] == 'success') : ?>
                                    <div class="alert alert-success" role="alert"> <?= $response['msg']?></div>
                                  <?php else : ?>
                                    <div class="alert alert-danger" role="alert"> <strong><?= __('Error!','pullit'); ?> </strong><?= $response['msg']?></div>
                                  <?php endif; ?>
                                <?php } ?>
                            </div>
                            <form class="row mb-0" id="edit-profile-form" enctype="multipart/form-data" method="post">                       
                                  <div class="form-group">
                                        <label for="first-name"><?php _e('First Name:','pullit'); ?></label>
                                        <input type="text" id="first_name" name="first_name" value="<?php echo isset( $_POST['first_name']) ? $_POST['first_name'] : get_user_meta( $user_id, 'first_name', true ); ?>" class="form-control input-theme not-dark" required/>
                                  </div>
                                  <div class="form-group">
                                    
                                        <label for="last-name"><?php _e('Last Name:','pullit'); ?></label>
                                        <input type="text" id="last_name" name="last_name" value="<?php echo isset( $_POST['last_name']) ? $_POST['last_name'] : get_user_meta( $user_id, 'last_name', true ); ?>" class="form-control input-theme not-dark" required/>
                                  </div>
                                  <div class="form-group">
                                        <label for="phone"><?php _e('Phone :','pullit'); ?></label>
                                        <input type="text" id="phone" name="phone" value="<?php echo isset( $_POST['phone']) ? $_POST['phone'] : get_user_meta( $user_id, 'phone', true ); ?>" class="form-control not-dark input-theme"  required/>
                                  </div>              
                                  <div class="form-group">
                                    
                                        <label for="address"><?php _e('Address :','pullit'); ?></label>
                                        <input type="text" id="address" name="address" value="<?php echo isset( $_POST['address']) ? $_POST['address'] : get_user_meta( $user_id, "address", true ); ?>" class="form-control input-theme not-dark" required/>
                                  </div>             
                                  <div class="form-group">
                                    
                                        <label for="profile_pic"><?php _e('Change Profile Picture :','pullit'); ?></label>
                                        <div class="input-group">
                                          <input type="file" id="profile_pic" name="profile_pic" value="" class="not-dark" accept="image/*" />
                                         </div>
                                  </div>
                                  <input type="hidden" name="currentuserRole"  value="<?php echo $role  ?>">
                                        <button type="submit" name="edit-profile" class="btn btn-theme "><?php _e('Save Changes','pullit'); ?></button>
                                    
                                    <a href="<?php echo $change_my_password; ?>" class="btn btn-theme "><?php _e('Change My Password','pullit') ?></a>	                 
                            </form>         
                       </div><!-- /sh_content_block -->
                  </div><!-- /container -->             
                </div><!-- /content-wrap -->
            </section><!-- #content end -->
        </div><!-- /container-fluid -->
    </main>
</div>
<?php if(in_array( 'administrator', (array) $current_user->roles ) || in_array( 'moderator', (array) $current_user->roles ) || in_array( 'gym-admin', (array) $current_user->roles )){?>
          </div>
        </div>
    </div>
</section>
<?php };
 get_footer(); ?>