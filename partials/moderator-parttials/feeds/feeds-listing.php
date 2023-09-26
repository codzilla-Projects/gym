<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
$dashLink = get_page_link($pages[0]->id);

$feeds_query = pullit_get_gym_feeds(get_user_gym_id());


if($_POST['delete-feed'] && $_POST['delete-feed']==="remove"){
	$attch_id = get_post_thumbnail_id($_POST['feed_id']);
	wp_delete_attachment($attch_id);
	wp_delete_post($_POST['feed_id']);
    echo '<script> window.location.href="'.$dashLink."?current-page=feeds".'"</script>';
}
?>
<div class="card-dasboard">
	<div class="controls">
		<a href="<?php echo $dashLink."?current-page=add-feed" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=feeds" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Feeds
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/images/rss.png" ?>">
			Feeds
		</div>
		<div class="card-data-body">
				 <table class="table  table-hover responsive nowrap" >
				    <thead class="thead-dark">
				      <tr>
							<th>Image</th>
							<th>Title</th>
							<th>Edit</th>
							<th>Delete</th>
				      </tr>
				    </thead>
				    <tbody>
		     		 <?php  if( !empty($feeds_query)): 
		     		 	// foreach($feeds_query as $feed):  
	     		 		while ($feeds_query->have_posts()): $feeds_query->the_post();  
						$img_url  =  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()));?>
				      <tr>
				        <td>
				        	<?php if ($img_url[0]): ?>
					        	<img src="<?php  echo $img_url[0] ?>" class="img-holder">
			        		<?php else: ?>
			        			<span class="placeholder"><?php echo get_the_title(get_the_ID())[0]; ?></span>
				        	<?php endif ?>
				        </td>
    			        <td><?php the_title() ?></td>
				        <td>
				        	<a href ="<?php echo $dashLink."?current-page=add-feed&&action=edit&&gid=".get_the_id()  ?>" class="btn-transparent color-blue" title="Edit">
				        		<i class="cmsmasters-icon-pen-1"></i>	
				        	</a>
				        </td>
				        <td>
				        	<form action="#" method="post">
				        		<input type="hidden" name="feed_id" value="<?php echo get_the_id() ?>">
					        	<button name ="delete-feed" type="submit" onclick="return confirm( 'Are You Sure You Want to delete ths feed ?');" class="btn-transparent color-yellow" title="Remove" value="remove">
					        		<i class="cmsmasters-icon-trash"></i>	
					        	</button>
				        	</form>
				        </td>
				      </tr>
				       <?php endwhile;?>
				     <?php else: ?>
				     	<tr>
				     		<td>
					     		<p>
					     			 There is no feeds exsist for this Gym
					     		</p>				     			
				     		</td>
				     	</tr>
	            <?php endif ?>
				        </tbody>
				  <tfoot>
				    <tr>
				    	<td>
			    	   <?php $args = array(
                        'format'             => '/?paged=%#%',
                        'current'            => max( 1, get_query_var('paged') ),
                        'total'              => $feeds_query->max_num_pages,
                        'show_all'           => false,
                        'end_size'           => 1,
                        'mid_size'           => 10,
                        'prev_next'          => true,
                        'prev_text'          =>('<i class="cmsmasters-icon-angle-left"></i>'),
                        'next_text'          =>('<i class="cmsmasters-icon-angle-right "></i>'),
                        'type'               => 'list',
                    );
                    echo paginate_links($args); ?>
                    </td>
	                </tr>
				    </tfoot>
				  </table>
			</div>
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->


</div>