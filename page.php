<?php 
get_header();
 if( have_posts() ): while( have_posts() ): the_post();?>
<section class="main-content pt-5 pb-5">
 	<div class="container"> 		
		<div class="page-title pt-5">
			<p class="h2 text-center" ><?php the_title(); ?></p >
		</div>
		<div class="text text-center">
			<?php
			the_content();
			?>
		</div>
 	</div>
<?php endwhile; endif;
get_footer();

 ?>
 