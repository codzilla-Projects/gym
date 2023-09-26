<?php 
error_reporting(1);
show_admin_bar(false);
define('SH_ROOT', get_template_directory() . '/');
define('SH_URL', get_template_directory_uri() . '/');
define('SH_ADMIN', admin_url());

require_once ( SH_ROOT . 'lib/theme_initialization.php');
require_once ( SH_ROOT . 'lib/enqueue_scripts.php');
require_once ( SH_ROOT . 'lib/ajax_functions.php');
require_once ( SH_ROOT . 'lib/gym_functions.php');
require_once ( SH_ROOT . 'lib/schedule_viewers.php');
require_once ( SH_ROOT . 'lib/users_role_and_meta.php');

