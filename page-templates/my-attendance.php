<?php 
/**
** Template Name: Attendance Sheet
**/

$current_user     = wp_get_current_user();
if ( in_array( 'coach', (array) $current_user->roles ) ) {
  get_header('coach');
}else if ( in_array( 'trainee', (array) $current_user->roles ) ) {
  get_header('subscriber');
}
$firstDay  =  new DateTime('first day of this month');
$firstDay  = $firstDay->format('t, m Y');

$lastDay = new DateTime('last day of this month');
$lastDay =  $lastDay->format('t, m Y');
// $attendance = get_staff_attendace('2021/07/05' ,"2021/07/16" ,19);
$attendance = get_staff_attendace($firstDay ,$lastDay ,get_current_user_id());
?>
<section class="single-post">
    <div class="conatiner">
              <ul class="breadcrumb">
                <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                <li>My Attendance</li>
            </ul>
        <div class="post-wrapper">          
			<div class="mt-3 attendance-data">
				<table class="table">
				    <thead class="thead-dark">
						<tr>
							<th>Action Date</th>
							<th>In Time</th>
							<th>Out Time</th>
						</tr>
					</thead>
					<tbody>
							<?php 
								if ( empty($attendance )) {
									echo "<tr><td>there is no attendance for  you </td></tr>";
								}
						 ?>
						<?php for ($i = 0; $i < 60; $i+=2): ?>
							<?php 
							$in  	= explode(" ", $attendance[$i]->created_at);
							$output = explode(" ", $attendance[$i+1]->created_at);

							 ?>
							<tr>
								<td><?php echo $in[0]; ?></td>
								<td><?php echo $in[1]; ?></td>
								<td><?php echo $output[1]; ?></td>
							</tr>

						<?php  endfor ?>
					</tbody>
				</table>
			</div>                
        </div><!-- /post-content -->
        </div><!-- /post-wrapper -->
    </div><!-- /conatiner -->
</section><!-- /single-post -->


<?php get_footer() ?>