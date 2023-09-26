<?php 
function sh_validation($error , $lang){
	$errors = array(
		'username_missing' => [
			'ar' => 'برجاء إدخال إسم المستخدم.',
			'en' => 'Missing username.'
		], 
		'username_exists' => [
			'ar' => 'إسم المستخدم موجود بالفعل.',
			'en' => 'Username exists , please choose another username.'
		],
		'email_missing' => [
			'ar' => 'برجاء إدخال البريد الإلكترونى.',
			'en' => 'Missing email address.'
		],
		'email_exists' => [
			'ar' => 'البريد الإلكترونى موجود بالفعل أو غير صحيح.',
			'en' => 'You cannot register with this email address it is not valid or already exists.'
		],
		'email_invalid' => [
			'ar' => 'بريد إلكترونى غير صحيح .',
			'en' => 'Invalid email address, please use a valid one.'
		],
		'password_missing' => [
			'ar' => 'برجاء إضافة كلمة مرور.',
			'en' => 'Missing password.'
		],
		'repassword_missing' => [
			'ar' => 'برجاء إدخال تأكيد كلمة المرور.',
			'en' => 'Missing password confirmation.'
		],
		'password_mismatch' => [
			'ar' => 'كلمة المرور غير متطابقة.',
			'en' => 'Password and Password confirmation mismatch.'
		],
		'address_missing' => [
			'ar' => 'برجاء إدخال العنوان الأول.',
			'en' => 'First address is missing.'
		],
		'country_missing' => [
			'ar' => 'برجاء إختيار الدولة.',
			'en' => 'Country is missing.'
		],
		'postal_missing' => [
			'ar' => 'برجاء إدخال العنوان البريدى.',
			'en' => 'Postal/zip Code is missing.'
		],
		'phone_missing' => [
			'ar' => 'برجاء إدخال  رقم الهاتف.',
			'en' => 'Missing Phone.'
		],
		'phone_notverified' => [
			'ar' => 'برجاء إجراء التحقق من رقم الهاتف.',
			'en' => 'Please verify your phone.'
		],
		'terms_missing' => [
			'ar' => 'برجاء الموافقة على الشروط و الأحكام',
			'en' => 'Missing terms agreement.'
		],
		'username_empty' => [
			'ar' => 'برجاء إدخال إسم المستخدم أو البريد الإلكترونى.',
			'en' => 'Username/Email address empty.'
		],
		'email_empty' => [
			'ar' => 'برجاء إدخال البريد الإلكترونى.',
			'en' => 'Email address empty.'
		],
		'password_empty' => [
			'ar' => 'برجاء إدخال كلمة السر.',
			'en' => 'Password empty.'
		],
		'username_notexists' => [
			'ar' => 'المستخدم غير موجود.',
			'en' => 'Username / Email address not exists.'
		],
		'email_notexists' => [
			'ar' => 'البريد الإلكترونى غير موجود.',
			'en' => 'Email address not exists.'
		],
		'wrong_password' => [
			'ar' => 'كلمة المرور غير صحيحة.',
			'en' => 'Wrong Password.'
		],
		'mail_problem' => [
			'ar' => 'هنالك مشكلة ما, برجاء المحاولة مرة أخرى.',
			'en' => 'There is a problem , please try again.'
		],
		'mail_success' => [
			'ar' => 'تم إرسال بريد إعادة تعيين كلمة المرور بنجاح.',
			'en' => 'Reset password mail has been sent successfully.'
		]
	);

	return $errors[$error][$lang];
}