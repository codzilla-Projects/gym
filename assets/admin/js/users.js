jQuery(document).ready(function($) {
	var role_init = $('#role').val();
	$('.all_roles').fadeOut(100,function(){
		$('#'+role_init).fadeIn(200);
	});
	$('#role').on('change', () => {
		var role = $('#role').val();
		$('.all_roles').fadeOut(100,function(){
			$('#'+role).fadeIn(200);
		});
	});
});