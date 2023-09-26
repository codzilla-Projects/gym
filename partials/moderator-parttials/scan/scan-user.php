
<?php 
$gym_id = get_user_meta(get_current_user_id(),'user_gym_id',true);
$users = pullit_get_gym_users($gym_id);
 ?>

<!-- </script> -->
 <div class="card-dasboard">
	<div class="card-data">
		<div class="card-data-head">
			<img src="<?php echo SH_URL . "assets/images/qr-code1.png" ?>">
			Scan
		</div>
		<div class="card-data-body">
			<div class="scan-input">
				<form id="search-form" autocomplete="off">
					<label for="ml-user-absence">User</label>				
					<input type="text" name="ml-user-absence" id="ml-user-absence" autofocus class="input-theme">
				</form>
			</div>
		</div> 	<!-- /card-data-body -->
		<table id="table-data" class="d-none">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Attendance</th>
					<th>Barcode</th>
					<th>Renewal</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div><!-- card-data -->
</div><!-- /card-dasboard -->

<script type="text/template" id="user-logged-template">
	<div class="custom-alert-green">
		<i class=""></i> <span id="alert-text"></span>
	</div>
</script>

<script type="text/javascript">
	jQuery(document).ready($ => {
		$(document).on('change', '#ml-user-absence', event => {
			sendUserCode();
		});
		$(document).on('submit', '#search-form', event => {
			event.preventDefault();
			sendUserCode();
		});

		const sendUserCode = () => {
			if(window.ajaxSent) return false;
			$('.card-dasboard .card-data-body').prepend(`<img id="sl-spinner" src="${AJAX.loader}" style="width: 50px; height: auto;" />`);
			window.ajaxSent = true;
			$.post(AJAX.ajaxurl, {
				action: 'scan_code_action',
				userID: $('#ml-user-absence').val()
			}, res => {
				console.log(res);
				window.ajaxSent = false;
				$('#sl-spinner').remove();
				res = JSON.parse(res);
				switch(res.action) {
					case 1: 
						$('.card-dasboard .card-data-body').prepend($('#user-logged-template').html());
						$('#alert-text').text('Have been logged in successfully');
						$('.custom-alert-green i')[0].className = 'cmsmasters-icon-login-4';
						setTimeout(() => $(".custom-alert-green").remove(), 2000);
						$('#ml-user-absence').val('');
					break;
					case 2: 
						$('.card-dasboard .card-data-body').prepend($('#user-logged-template').html());
						$('#alert-text').text('Have been logged out successfully');
						$('.custom-alert-green i')[0].className = 'cmsmasters-icon-logout-3';
						setTimeout(() => $(".custom-alert-green").remove(), 2000);
						$('#ml-user-absence').val('');
					break;
					default:
						$('.card-dasboard .card-data-body').prepend($('#user-logged-template').html());
						$('#alert-text').text('No Action !!');
						$('.custom-alert-green i')[0].className = 'cmsmasters-icon-attention';
						setTimeout(() => $(".custom-alert-green").remove(), 2000);
						$('#ml-user-absence').val('');

				}
				console.log(res)
				// $('#data-table').removeClass('d-none');
				// const newRow = `<tr>
				// <td>${res.data.name}</td>
				// <td>${res.data.plan}</td>
				// <td>${res.data.sessions}</td>
				// <td>${res.data.phone}</td>
				// </tr>
				// `
				// $("#data-table tbody").html(newRow);
			});
		};
	});
</script>