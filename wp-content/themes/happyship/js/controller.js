$(document).ready(function () {
	if ($('.login_home').length > 0) {
		check_login_ajax();
	}
});

function loginFrontend(username_id, pass_id, btn_login_id) {
	if ($('#' + btn_login_id).attr("disabled") == "disabled") {
		return false;
	}
	var username = $('#' + username_id).val().trim();
	var pass = $('#' + pass_id).val().trim();

	// valid input
	if (username == '' || pass == '') {
		alert("Vui lòng nhập username và password!");
		return false;
	}
	// xu ly
	$('#' + btn_login_id).attr("disabled", true);
	$('#' + btn_login_id).val('Đang đăng nhập...');
	var data = {
		'Email' : username,
		'Password' : pass
	}
	// save cookie
	document.cookie="ghn_username_ontime=" + username + "; path=/";
	// Send data login
	check_login_alert = true;
	crossDomainPost($('#' + btn_login_id).attr("action"), data);
}

function crossDomainPost(url, data) {
	// Add the iframe with a unique name
	var iframe = document.createElement("iframe");
	var uniqueString = "login_form";
	document.body.appendChild(iframe);
	iframe.style.display = "none";
	iframe.setAttribute('onload', "check_login_ajax();");
	iframe.contentWindow.name = uniqueString;

	// construct a form with hidden inputs, targeting the iframe
	var form = document.createElement("form");
	form.target = uniqueString;
	form.action = url;
	form.method = "POST";

	// repeat for each parameter
	$.each(data,function(index, value){
		var input = document.createElement("input");
		input.type = "hidden";
		input.name = index;
		input.value = value;
		form.appendChild(input);
	});

	document.body.appendChild(form);
	form.submit();
}

function check_login_ajax() {
	$.ajax({
		url : url_check_login,// lay tu file view
		type : "POST",
		dataType : 'jsonp',
		//jsonp: "z7ndsgy4wgLyNN2jR",
		headers : {},
		//crossDomain : true,
		success : function(jsonp_data) {
			//console.log(jsonp_data.yeah);
			//$.cookie("ghn_username_ontime", $('#f_username').val().trim(), { path: '/' });
			//$.removeCookie("test", { path: '/' });
		},
		error : function(jqXHR, textStatus, ex) {
			//console.log('error ajax: ' + textStatus + "," + ex + "," + jqXHR.responseText);
			$('#btn_login').attr("disabled", false);
			$('#btn_login').val('Đăng nhập');
			//alert("Lỗi đăng nhập. Vui lòng đăng nhập lại");
		}
	});
}
// result check login
var check_login_alert = false;
function z7ndsgy4wgLyNN2jR(jsonp_data) {
	//console.log("z7ndsgy4wgLyNN2jR:"+jsonp_data.yeah);
	if (jsonp_data.yeah) {
		var username = getCookie("ghn_username_ontime");
		//$('.login_home').html('<p>Bạn đã đăng nhập với tài khoản: </p>' + username);
		$('.login_home').html('<img src="'+$('.login_home').attr('temp_url')+'/images/login-success.jpg" width="100%" />');
		$('.login_home').css('padding', '0');
		ontime_islogin = true;
	} else {
		if (check_login_alert) {
			check_login_alert = false;
			alert("Tên đăng nhập hoặc Mật khẩu không đúng");
		}
	}
	$('.btn_login').removeAttr("disabled");
	$('#btn_login').val('Đăng nhập');
	$('.btn_login_mobi').removeAttr("disabled");
	$('#btn_login_mobi').val('Đăng nhập');
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}
/* ********************************** */

function validateEmail(x) {
	var atpos = x.indexOf("@");
	var dotpos = x.lastIndexOf(".");
	if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
		// alert("Not a valid e-mail address");
		return false;
	} else {
		return true;
	}
}

function enter_submit_login(e, ext) {
	var code = e.keyCode || e.which;
	if (code == 13) {
		loginFrontend('f_username' + ext, 'f_passwork' + ext, 'btn_login' + ext);
	}
}

function faq_view(id) {
	if ($('#'+id).css("display") == "none") {
		$('#'+id).show(500);
	} else {
		$('#'+id).hide(500);
	}
}

/* ********************************** */
