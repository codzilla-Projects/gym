<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
foreach ($pages as $page) {
	$dashLink = get_page_link($page->ID);	
}
if(!empty($_GET['uid'])){
	$response = pullit_delete_user($_GET['uid']);
	if(!empty($response)){
		if($response['status'] == 'error'){
			echo "<div class='alert alert-danger'>".$response['msg']."</div>";
		}else{
			echo "<div class='alert alert-success'>".$response['msg']."</div>";
		}
	}
}
$trainees = pullit_get_gym_users(get_user_gym_id(),'trainee');

if (isset($_GET['searchTrainee']) && $_GET['searchTrainee'] === "search") {
    
    $searchKeyword=$_GET['keyword'];
    $trainees = pullit_get_gym_users_search(get_user_gym_id(),$searchKeyword,'trainee');
}

$gym_id = get_user_gym_id();
$plans = pullit_get_gym_plans($gym_id);
if(isset($_POST['save']) && $_POST['save'] === "save"){
	planRenewal($_POST);
}

?>
<!-- Search Form -->
<form  class=" d-md-inline-block form-inline ml-auto" action="#"  method="get">
    <input type="text" name="current-page" value="trainees"  hidden >
    <input type="text" name="keyword" placeholder="Search for..." class="input-theme search-input">    
    <button type="submit" name="searchTrainee" value="search" id="search-tag">
    	<i class="cmsmasters-icon-search-1"></i>	
    </button>    
</form>
<div class="card-dasboard">
	<div class="controls">
		<a href="<?php echo $dashLink."?current-page=add-trainee" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=trainees" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Trainees
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/game-placeholder.svg" ?>">
			Trainees
		</div>
		<div class="card-data-body">
			 <table class="table">
			    <thead class="thead-dark">
			      <tr>
						<th>Trainee Image</th>
						<th>Trainee Name</th>
						<th>Trainee Phone</th>
						<th>Trainee Email</th>
						<th>Trainee Barcode</th>
						<th>Edit</th>
						<th>Remove</th>
						<th>Renew</th>
			      </tr>
			    </thead>
			    <tbody>
				<?php foreach ($trainees as $trainee): ?>
					<?php 
					$uid = $trainee->ID;
					$phone = get_user_meta( $uid, 'phone', true ); 
		            $profile_picture  = get_user_meta($uid  ,"pullit_profile_pic" ,true);
				?>
			      <tr>
			        <td>
					<?php if(empty($profile_picture)): ?>
						<img class="img-fluid" src="<?php echo SH_URL ."assets/images/user.png" ;?>" alt ="Pull It Gym" >
					<?php else :?>
						<img class="img-fluid" src="<?php echo $profile_picture ?>" alt ="Pull It Gym" >
					<?php endif ;?>
			        </td>
			        <td><?php echo $trainee->user_login  ?></td>
			        <td><?php echo $phone ?></td>
			        <td><?php echo $trainee->user_email ?></td>
			        <td>
			        	<a href="javascript:void(0)" class="pullit_barcode">
				        	<img class="user-barcode" alt='Bar Code' src="<?php echo SH_URL ."barcode.php?codetype=Code39&size=40&text=".$uid; ?>" />
				        </a>
			        </td>
<!-- 			        <td><img class="user-barcode" alt='Bar Code' src="<?php // echo SH_URL ."barcode.php?codetype=Code39&size=40&text=".$uid."&print=true"; ?>" /></td> -->
			        <td>
				        	<a href ="<?php echo $dashLink."?current-page=add-trainee&&action=edit&&uid=".$uid ;  ?>" class="btn-transparent color-blue" title="Edit">
				        		<i class="cmsmasters-icon-pen-1"></i>	
				        	</a>
				        </td>
				        <td>
				        	<a class="btn-transparent color-yellow" href="<?php echo $dashLink."?current-page=trainees&action=delete&&uid=".$uid ;  ?>" onclick="return confirm( 'Are You Sure You Want to delete ths coach ?');"><i class="cmsmasters-icon-trash"></i></a>
				        </td>
				        <td>
				        	<a class="btn-transparent color-yellow renew" data-uid="<?php echo $uid ?>"  data-toggle="modal" data-target="#planModal" href="javascript:void(0)" id ="renew" ><i class="cmsmasters-icon-refresh-alt"></i></a>
				        </td>
			      </tr>
				<?php endforeach ?>
                </tbody>
			  </table>
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->
</div><!-- /card-dasboard -->
<script type="text/javascript">
$(function () {
    $(".pullit_barcode").click(function () {
        var contents = $(this).html();
        var frame1 = $('<iframe />');
        frame1[0].name = "barcodeframe";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open('','',500,500);
        frameDoc.document.write('<html><head><title>Pullit</title>');
/*        frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
*/        frameDoc.document.write('</head><body>');
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["barcodeframe"].focus();
            window.frames["barcodeframe"].print();
            frame1.remove();
        }, 1000);
    });
});
</script>


<div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-labelledby="planModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="barcodeModalTitle">Choose Plan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post">
					<div class="input-group">
						<label>Select Plan</label><br>
						<select  name="gym-user-plan" class="input-theme">
							<option>Please Select</option>
						<?php  while ($plans->have_posts()): $plans->the_post();  						?>
							<option value="<?php echo get_the_id() ?>" ><?php echo the_title(); ?></option>
						<?php endwhile; ?>						
	              		</select>
					</div>		
					<input type="hidden" name="user-id" value="" id="userData">
					<div class="row">
						<div class="col-12 col-md-6">
							<div class="input-group">
								<label>Start Date</label>
								<input type="text" name="gym-user-start-date" placeholder="Start Date"  class="input-theme" value="<?= $data->start_date; ?>" id="start_date" >
							</div>			
						</div><!-- /cols -->
						<div class="col-12 col-md-6">
							<div class="input-group">
								<label>End Date</label>
								<input type="text" name="gym-user-end-date" placeholder="End Date"  class="input-theme" value="<?= $data->end_date; ?>" id="end_date" >
							</div>
						</div><!-- /cols -->	
					</div><!-- /row -->	
					<input type="submit" name="save"  value="save" class="btn btn-theme-1">					
				</form>				
			</div><!-- Modal Body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-theme" data-dismiss="modal">Close</button>
			</div>
	    </div>
  </div>
</div>