<?php 

function ha_insert_abscence_callback(){
    if($_POST['AddCoachAbsc']) {$response = save_coach_abscence($_POST);}
?>
<div class="container">
        <div class="card text-center">
          <div class="card-header">
             Add Coach Abscence
          </div>
          <div class="card-body">
            <p class="card-text">You can insert coach abscence to your system from this page.</p>
               <?php 
                    if(isset($response) && $response === true){
                        echo "<div class='alert alert-success'>Record Has been added successfully.</div>";
                    }
                ?>
            <form role="form" method="post" action="#" id="abscenceForm">
                <div class="box-body">
                      <div class="form-group ">
                            <label for="coash_id"><?php _e("Coach Name"); ?></label>
                            <?php
                                $args = array(
                                    'role'    => 'coache',
                                    'orderby' => 'user_nicename',
                                    'order'   => 'ASC'
                                    );
                                $coaches = get_users( $args );
                            ?>
                            <select name="coach_id" id="coach_id">
                                <?php if(empty($_POST['coach_id'])) : ?>
                                    <option selected disabled hidden><?php esc_attr_e( 'Please select' ); ?></option>
                                    <?php endif;  

                                    foreach ($coaches as $coache) {
                                    ?>
                                    <option value="<?php echo $coache->ID; ?>" <?php echo $_POST['coach_id'] == $coache->ID ? 'selected' : ''; ?> ><?php echo $coache->display_name; ?></option>          
                                    <?php } ?>
                            </select>

                     </div>


                    <div class="form-group ">
                        <label for="abscence_date"><?php _e("Abscence Date"); ?></label>

                        <input type="date" name="abscence_date" id="abscence_date" value="<?php if( $_POST['abscence_date'] != '' ) echo $_POST['abscence_date']; ?>" class="regular-text" /><br />


                    </div>
                </div>
                  <!-- /.box-body -->
                <input type="submit" name="AddCoachAbsc" class="btn btn-primary btn-lg margin-center margin-bottom" value="Add">
            </form>
          </div>
          
        </div>
       
   
   
</div>
<?php } ?>