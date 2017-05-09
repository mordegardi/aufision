$('header li a[href="#"]').click(() => {
	$('.login-form').fadeIn();
	$('.overlay').fadeIn();
});

$('.overlay, .login-form img').click(() => {
	$('.login-form').fadeOut();
	$('.overlay').fadeOut();
});
