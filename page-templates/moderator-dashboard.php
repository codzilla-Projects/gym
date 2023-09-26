<?php 
/**
** Template Name: Moderator Dashboard 
**/
adminCan();
get_header('mod'); 
get_template_part("partials/moderator-parttials/right-menu-mod");
get_template_part("partials/moderator-parttials/left-menu-mod")	;


	$current_page = isset($_GET['current-page']) ? $_GET['current-page'] : '';
	switch ($current_page) {
		case 'games':
		  get_template_part('partials/moderator-parttials/games/dasboard-game-listing');
		break;
		case 'add-game':
		  get_template_part('partials/moderator-parttials/games/add', 'game');
		break;
		case 'plans':
		  get_template_part('partials/moderator-parttials/plans/plan-listing');
		break;
		case 'add-plan':
		  get_template_part('partials/moderator-parttials/plans/add', 'plan');
		break;
		case 'add-coach':
		  get_template_part('partials/moderator-parttials/coaches/add', 'coach');
		break;
		case 'coaches':
		  get_template_part('partials/moderator-parttials/coaches/coach-listing');
		break;
		case 'add-trainee':
		  get_template_part('partials/moderator-parttials/trainees/add', 'trainee');
		break;
		case 'trainees':
		  get_template_part('partials/moderator-parttials/trainees/trainee-listing');
		break;
		case 'update-schedule':
		  get_template_part('partials/moderator-parttials/schedule/update', 'schedule');
		break;
		case 'scan':
		  get_template_part('partials/moderator-parttials/scan/scan', 'user');
		break;

		case 'add-moderator':
			moderatorCant();
			get_template_part('partials/moderator-parttials/moderators/add', 'moderator');
		break;
		case 'moderators':
			moderatorCant();
		  get_template_part('partials/moderator-parttials/moderators/moderator-listing');
		break;
		case 'feeds':
			moderatorCant();
		  get_template_part('partials/moderator-parttials/feeds/feeds-listing');
		break;
		case 'add-feed':
			moderatorCant();
		  get_template_part('partials/moderator-parttials/feeds/add', 'feed');
		break;
		case 'attendance':
			moderatorCant();
		  get_template_part('partials/moderator-parttials/attendance/user-attendance');
		break;
		default:
		  get_template_part('partials/moderator-parttials/dashboard', 'index');
		break;
	}

   ?>
			</div><!-- /dashboard-content -->
		</div><!-- /dashboard-wrapper -->
	</div><!-- /conatiner -->
</section>
 <?php get_footer(); ?>