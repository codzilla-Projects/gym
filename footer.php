   
<?php 
$facebook =  get_option('sh_fb');
$instagram = get_option('sh_insta'); 
$youTube =  get_option('sh_youtube');
 ?>
    <footer class="mt-auto" id="footer">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Pullit <?= date('Y'); ?></div>
                <div class="socialmedia">
                    <p>Follow us :</p>
                    <ul>
                         <?php if (!empty($facebook) && $facebook !== ""): ?>
                             
                        <li>
                            <a href="<?php echo $facebook ?>" title="Facebook Link">
                                <i class="cmsmasters-icon-facebook-1"></i>
                            </a>
                        </li>
                         <?php endif ?>
                         <?php if (!empty($instagram) && $instagram !== ""): ?>
                        <li>
                            <a href="<?php echo $instagram  ?>" title="Instagram Link">
                                <i class="cmsmasters-icon-instagram"></i>
                            </a>
                        </li>
                         <?php endif ?>
                         <?php if (!empty($youTube ) && $youTube  !== ""): ?>
                        <li>
                            <a href="<?php echo $youTube  ?>" title="YouTube Link">
                                <i class="cmsmasters-icon-youtube"></i>
                            </a>
                        </li>
                         <?php endif ?>
                    </ul>
                </div>

            </div>
        </div>
    </footer>
</div>
</div>
<?php 
   $current_user     = wp_get_current_user();
   $uid              = $current_user->data->ID; 
?>

<div class="modal fade" id="barcodeModal" tabindex="-1" role="dialog" aria-labelledby="barcodeModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="barcodeModalTitle">My Card</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img alt='testing' src="<?php echo SH_URL ."barcode.php?codetype=Code39&size=40&text=".$uid ."&print=true"; ?>" class="myparcode"/>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-theme" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>    

</section>
<?php wp_footer() ?>
	</body>	
</html>