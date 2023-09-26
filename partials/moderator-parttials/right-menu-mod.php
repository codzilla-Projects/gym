<?php 
$Page = get_pages(
	array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page-templates/profile-edit.php',
));
foreach ($Page as $page) {
  $pageLink = get_page_link($page->ID);
}
 ?>
<section class="dashboard-mod">
	<div class="container-fluid">
		<div class="dashboard-wrapper">
			<div class="menu-dashboard">
				<div class="right-menu">
					<ul class="setting-nav">
						<li>
							<a href="<?php echo $pageLink ?>">
								<i class="cmsmasters-icon-settings-alt"></i>		
								Profile
							</a>
						</li>							
						<li>
							<a href="<?php echo wp_logout_url()?>">
								<i class="cmsmasters-icon-power-1"></i>
								Logout			
							</a>
						</li>
					</ul>					
				</div><!-- /right-menu -->