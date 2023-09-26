<?php 
/**
** Template Name: Change My Password
**/
if( isset( $_POST['change_password'] ) ) {
  $response = sh_change_user_password($_POST);
}

$current_user     = wp_get_current_user();
if ( in_array( 'coach', (array) $current_user->roles ) ) {
  get_header('coach');
}else if ( in_array( 'trainee', (array) $current_user->roles ) ) {
  get_header('subscriber');
}else if(in_array( 'administrator', (array) $current_user->roles ) || in_array( 'moderator', (array) $current_user->roles ) || in_array( 'gym-admin', (array) $current_user->roles )){
  get_header('mod');
  get_template_part("partials/moderator-parttials/right-menu-mod")  ;
   get_template_part("partials/moderator-parttials/left-menu-mod") ;
 }?>
                <div id="layoutSidenav_content">  
                    <main id="blogs">
                        <div class="container-fluid">
                      <section id="content">

                        <div class="content-wrap">

                          <div class="container clearfix">

                            <div class="row clearfix">
                              <div class="col-lg-12 m-2">
                              <?php if(isset($response) && $response['status']=='1') :?>
                                    <div class="alert alert-success" role="alert"><?php echo $response['msg']; ?></div>
                                      <?php elseif(isset($response) && $response['status']=='0') :?>
                                    <div class="alert alert-danger" role="alert"> <strong><?= __('Error!','pullit'); ?> </strong><?php echo $response['msg'];?></div>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </div>
                              <div class="col-md-12 sh_content_block">

                                <div class="heading-block noborder">
                                  <h3><?php _e('Change My Password Info','pullit'); ?></h3>
                                </div>

                                <div class="clear"></div>

                                <div class="row clearfix">

                                    <form class="row mb-0" id="change-my-password" enctype="multipart/form-data" method="post">
                                      <div class="form-process"></div>
                                      <div class="col-12 m-2 form-group">
                                            <label for="old-password"><?php _e('Old Password:','pullit'); ?></label>
                                            <input type="password" id="old_pass" name="old_pass" value="" class="form-control not-dark" required/>
                                      </div>
                                      <div class="col-12 m-2 form-group">
                                            <label for="new-password"><?php _e('New Password:','pullit'); ?></label>
                                            <input type="password" id="new_pass" name="new_pass" value="" class="form-control not-dark" required/>
                                      </div>
                                      <div class="col-12 m-2 form-group">
                                            <label for="confirm-password"><?php _e('Confirm Password:','pullit'); ?></label>
                                            <input type="password" id="pass_confirm" name="pass_confirm" value="" class="form-control not-dark" required/>
                                      </div>              
                                      <div class="col-12 m-2 justify-content-end align-items-center">
                                            <button type="submit" name="change_password" class="btn btn-theme"><?php _e('Save Changes','pullit'); ?></button>
                                    </div>
                                    </form>         
                              </div>
                              
                            </div>

                          </div>

                        </div>

                      </section><!-- #content end -->
                    </div>
                  </main>
                </div>
            <?php 
if(in_array( 'administrator', (array) $current_user->roles ) || in_array( 'moderator', (array) $current_user->roles ) || in_array( 'gym-admin', (array) $current_user->roles )){?>
          </div>
        </div>
    </div>
</section>
<?php }; get_footer(); ?>