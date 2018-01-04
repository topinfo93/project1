'use strict';

jQuery(document).ready(function ($) {
	jQuery.extend(jQuery.validator.messages, {
	    required: "Vui lòng nhập trường này.",
	    email: "Vui lòng nhập email hợp lệ.",
	    number: "Vui lòng nhập số.",
	    digits: "Vui lòng chỉ nhập ký tự số.",
	    equalTo: "Mật khẩu xác nhận không trùng khớp.",
	    accept: "Please enter a value with a valid extension.",
	    maxlength: jQuery.validator.format("Vui lòng nhập nhiều hơn {0} ký tự."),
	    minlength: jQuery.validator.format("Vui lòng nhập ít nhất {0} ký tự."),
	    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
	    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
	    max: jQuery.validator.format("Vui lòng nhập lớn hơn hoặc bằng {0}."),
	    min: jQuery.validator.format("Vui lòng nhập bé hơn hoặc bằng {0}.")
	});
	$('#user_email').attr( 'placeholder', 'Tên đăng nhập hoặc Email' );
	$('#user_password').attr( 'placeholder', 'Nhập mật khẩu' );
	$('#user_email').addClass('required');
	$('#user_password').addClass( 'required');
	$('#customer_register_form').hide();
	$('#password-lost-form').hide();
	$("#customer_login_form").validate();
	$("#lostpasswordform").validate();
	$("#customer_signup_form").validate();
	setTimeout(function(){
	   jQuery("#show-messenger p,#show-register-messenger p,#lostpass_errors p").fadeOut(800);
	}, 5000);
	// $( 'select#shop_state' ).change(function() {
 //        $( 'select#shop_state_full' ).val($(this).val());
 //    });
});