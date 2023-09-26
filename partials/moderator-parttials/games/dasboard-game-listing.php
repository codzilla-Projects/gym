<?php 
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/moderator-dashboard.php'
));
$dashLink = get_page_link($pages[0]->id);

$games_query = pullit_get_gym_games(get_user_gym_id());

if($_POST['delete-game'] && $_POST['delete-game']==="remove"){
	$attch_id = get_post_thumbnail_id($_POST['game_id']);
	wp_delete_attachment($attch_id);
	wp_delete_post($_POST['game_id']);
    echo '<script> window.location.href="'.$dashLink."?current-page=games".'"</script>';
}
?>
<div class="card-dasboard">
	<div class="controls">
		<a href="<?php echo $dashLink."?current-page=add-game" ?>" class="btn btn-theme">
			<i class="cmsmasters-icon-doc"></i>
			Add new
		</a>
		<a href="<?php echo $dashLink."?current-page=games" ?>" class="btn btn-theme-1">
			<i class="cmsmasters-icon-layers"></i>
			Games
		</a>
	</div>
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/svg/games.svg" ?>">
			Games
		</div>
		<div class="card-data-body">
			 <table class="table">
			    <thead class="thead-dark">
			      <tr>
						<th>Game Image</th>
						<th>Game Name</th>
						<th>Game Description</th>
						<th>Edit</th>
						<th>Delete</th>
			      </tr>
			    </thead>
			    <tbody>
	      <?php  if( !empty($games_query)):
              // foreach($games_query as $game):
	      	while ($games_query->have_posts()): $games_query->the_post();  
								$img_url  = wp_get_attachment_image_src(get_post_thumbnail_id($game->ID));
              ?>
			      <tr>
			        <td>
			        	<?php if ($img_url[0]): ?>
				        	<img src="<?php  echo $img_url[0] ?>" class="img-holder">
		        		<?php else: ?>
				        	<img src="<?php  echo SH_URL . "assets/images/games.png" ?>" class="img-holder">		        			
			        	<?php endif ?>
			        </td>
			        <td><?php the_title() ?></td>
			        <td><?php  the_excerpt() ?></td>
			        <td>
			        	<a href ="<?php echo $dashLink."?current-page=add-game&&action=edit&&gid=".$game->ID;  ?>" class="btn-transparent color-blue" title="Edit">
			        		<i class="cmsmasters-icon-pen-1"></i>	
			        	</a>
			        </td>
			        <td>
			        	<form action="#" method="post">
			        		<input type="hidden" name="game_id" value="<?php echo $game->ID; ?>">
				        	<button name ="delete-game" type="submit" class="btn-transparent color-yellow" title="Remove" value="remove">
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
					     			 There is no plans exsist for this Gym
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
                        'total'              => $games_query->max_num_pages,
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
	</div> 	<!-- /card-data-body -->
	</div><!-- card-data -->


</div>