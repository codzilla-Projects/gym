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
$coaches = pullit_get_gym_users(get_user_gym_id(),'coach');

if (isset($_GET['searchCoash']) && $_GET['searchCoash'] === "search") {
    
    $searchKeyword=$_GET['keyword'];
    
    $coaches = pullit_get_gym_users_search(get_user_gym_id(),$searchKeyword,'coach');
    
}
$paged  =  (get_query_var( 'paged' )) ?  absint( get_query_var( 'paged' ) ) : 1;  

?>


<!-- Search Form -->
<form  class=" d-md-inline-block form-inline ml-auto" action="#"  method="get">
    <input type="text" name="current-page" value="coaches"  hidden > 
    <input type="text" name="keyword" placeholder="Search for..."  class="input-theme search-input">
    <button type="submit" name="searchCoash" value="search" id="search-tag">
    	<i class="cmsmasters-icon-search-1"></i>			
    </button>
    
</form>


<div class="card-dasboard">
	<div class="controls">
		<a href="<?php echo $dashLink."?current-page=add-coach" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=coaches" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Coaches
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/game-placeholder.svg" ?>">
			Coaches
		</div>
		<div class="card-data-body">
			 <table class="table">
			    <thead class="thead-dark">
			      <tr>
						<th>Coach Image</th>
						<th>Coach Name</th>
						<th>Coach Phone</th>
						<th>Coach Email</th>
						<th>Coach Barcode</th>
						<th>Edit</th>
						<th>Remove</th>
			      </tr>
			    </thead>
			    <tbody>
				<?php 
				foreach ($coaches as $coach):  
					$uid = $coach->ID;					
					$phone = get_user_meta( $uid, 'phone', true ); 
	                $profile_picture  = get_user_meta($uid  ,"pullit_profile_pic" ,true);
				?>
			      <tr>
			        <td>
					<?php         
					if(empty($profile_picture)): ?>
						<img class="img-fluid" src="<?php echo SH_URL ."assets/images/user.png" ;?>" alt ="Pull It Gym" >
					<?php else :?>
						<img class="img-fluid" src="<?php echo $profile_picture ?>" alt ="Pull It Gym" >
					<?php endif ;?>
			        </td>
			        <td><?php echo $coach->user_login  ?></td>
			        <td><?php echo $phone ?></td>
			        <td><?php echo $coach->user_email ?></td>
			        <td>
			        	<a href="javascript:void(0)" class="pullit_barcode">
				        	<img class="user-barcode" alt='Bar Code' src="<?php echo SH_URL ."barcode.php?codetype=Code39&size=40&text=".$uid; ?>" />
<!-- 				        	<img class="user-barcode" alt='Bar Code' src="<?php //echo SH_URL ."barcode.php?codetype=Code39&size=40&text=".$uid."&print=true"; ?>" />
 -->				        </a>
			        </td>
			        <td>
			        	<a href ="<?php echo $dashLink."?current-page=add-coach&&action=edit&&uid=".$uid ;  ?>" class="btn-transparent color-blue" title="Edit"><i class="cmsmasters-icon-pen-1"></i>	</a>
			        </td>
			        <td>
			        	<!-- <form method="get">
			        		<input type="hidden" name="plan_id" value="<?php //echo $uid  ?>">
				        	<button name ="delete-game" type="submit" class="btn-transparent color-yellow" title="Remove" value="remove">
				        		<i class="cmsmasters-icon-trash"></i>	
				        	</button>
			        	</form> -->
			        	<a class="btn-transparent color-yellow" href="<?php echo $dashLink."?current-page=coaches&action=delete&&uid=".$uid ;  ?>" onclick="return confirm( 'Are You Sure You Want to delete ths coach ?');"><i class="cmsmasters-icon-trash"></i></a>
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