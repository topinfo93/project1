'use strict';

jQuery.extend(jQuery.validator.messages, {
    required: "Xin vui lòng nhập trường này.",
    remote: "Please fix this field.",
    email: "Vui lòng nhập email hợp lệ.Ví du: example@gmail.com,example2@yahoo.com,...",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Vui lòng nhập ký tự số hợp lệ.",
    digits: "Vui lòng chỉ nhập số",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Xin vui lòng nhập đúng với mật khẩu.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Vui lòng nhập ít nhất {0} ký tự."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});
jQuery(document).ready(function ($) {
    $("#customer_create_form").validate();
	$( 'select[name="status_order_update"]' ).change(function() {
        $(this).closest('form.mem_update_storder').find('p.foot-action').show(400);
    });
    setTimeout(function(){
       jQuery(".messenger_alert").fadeOut(800);
    }, 5000);
    function autoGridBox(){
        var ww = $(window).width();
        var boxs = $(".row-fluid .grid-box-wrap").find('.box-item');
        var n = boxs.lenght;
        var inrow = 0;
        var maxinrow = 0;
        if(ww > 1024){
            inrow = 4;
        }else if(ww <=1204 && ww >=768){
            inrow = 3;
        }else if(ww <= 767 && ww >=480){
            inrow = 2;
        }else{
            inrow = 1;
        }
        var i=0;
        $.each(boxs,function() {
            i++;var hasName = (name === 'true') ? 'Y' :'N';
            maxinrow =($(this).height() > maxinrow) ? $(this).height() : maxinrow;
            if(i == inrow && inrow!=1){
                $(this).after('<hr class="lin_">');
                i=0;
                maxinrow=0;
            }
            console.log(maxinrow);
        });
    }
    autoGridBox();
    $( window ).resize(function() {
        $('.grid-box-wrap').find('hr.lin_').each(function(index, el) {
            $(this).remove();
        });
        autoGridBox();
    });
});
