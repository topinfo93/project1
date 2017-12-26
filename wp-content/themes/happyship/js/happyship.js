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
    // $("#btn-confirm-createnew").click(function(e){
    //     e.preventDefault();
    //     var valid = $("#customer_create_form").valid();
    //     var valueOption = $('select[name="kh_goi"]').find(":selected").text();
    //     var Qhuyen = $('select#kh_quan').find(":selected").val();
    //     var nhan_hang = 'Quan-3';
    //     var giao_hang = 'Quan-1';
    //     // $.ajax({
    //     //     type: "post",
    //     //     dataType: "json",
    //     //     url: my_ajax_object.ajax_url,
    //     //     data: {
    //     //         action : 'get_price',
    //     //         nhan_hang : nhan_hang,
    //     //         giao_hang : giao_hang
    //     //     },
    //     //     success: function(data){
    //     //         console.log(data);
    //     //     }
    //     // });
    //     if(valid){
    //         var tnn = $('#kh_ten').val();
    //         var dtnn = $('#kh_sdt').val();
    //         var dcnn = $('#kh_dc').val();
    //         var dvch = valueOption;
    //         var tth = ($('#kh_tth').val()) ? $('#kh_tth').val() : 0;
    //         console.log(tth);
    //         $.confirm({
    //             title: 'Thông tin đơn hàng',
    //             content: '<div class="field confirm-order">'+
    //                         '<div class="order_content">'+
    //                             '<p><strong>Người nhận:</strong><span id="name_receiver">'+tnn+'</span></p>'+
    //                             '<p><strong>Số điện thoại:</strong><span id="phone_receiver">'+dtnn+'</span></p>'+
    //                             '<p><strong>Địa chỉ :</strong><span id="add_receiver"> '+dcnn+'</span></p>'+
    //                             '<p><strong>(Gói) Chuyển hàng :</strong><span id="type_service"> '+dvch+'</span></p>'+
    //                             '<p><strong>Số tiền thu hộ :</strong><span id="money_receiver"> '+tth+'đ</span></p>'+
    //                             '<p class="order-footer"><strong>Tổng cước phí :</strong><span id="total_cost"></span></p>'+
    //                         '</div>'+
    //                     '</div>',
    //             icon: 'fa fa-warning',
    //             type: 'orange',
    //             animation: 'zoom',
    //             closeIcon : true,
    //             columnClass : 'my-class',
    //             closeAnimation: 'scale',
    //             useBootstrap : false,
    //             boxWidth: '50%',
    //             bgOpacity : 0.8,
    //             theme : 'material',
    //             buttons: {
    //                 omg: {
    //                     text: 'Xác nhận',
    //                     btnClass: 'btn-agree button',
    //                     action: function(){
    //                         $('#create_form_submit').trigger('click');
    //                     }
    //                 },
    //                 close:{
    //                     text: 'Hủy',
    //                     btnClass: 'btn-cancel button',
                        
    //                 }
    //             }
    //         });
    //     }
    // });
	$( 'select[name="status_order_update"]' ).change(function() {
        $(this).closest('.order-content').find('p.foot-action').show(400);
    });
    setTimeout(function(){
       jQuery(".messenger_alert").fadeOut(800);
    }, 5000);
    //
    // function gridheight(){
    //     var order_items = $('.content-area').find('.order-items');
    //     if(order_items.length > 2){
    //         var i=0;
    //         var maxheight = 0;
    //         order_items.each(function(index) {
    //             i++;
    //             if($(this).height() > maxheight){
    //                 maxheight = $(this).height();
    //             }
    //             if(i% 2 == 0){
    //                 i=0;
    //                 $(this).height(maxheight);
    //                 maxheight = 0;
    //             }
    //         });
    //     }
    // }
    // gridheight();
    // $(window).resize(function(){
    //     gridheight();
    // });
    // $('select#kh_quan').on('change', function() {
    //     var giao_hang = this.value;
    //     var nhan_hang = "Quan-1";
    //     var kh_goi = "";
    //     $.ajax({
    //         type: "post",
    //         url: my_ajax_object.ajax_url,
    //         //url: '/getprice.php',
    //         data: {
    //             action : 'get_price',
    //             nhan_hang : nhan_hang,
    //             giao_hang : giao_hang
    //             //kh_goi    : kh_goi
    //         },
    //         success: function(data){
    //             console.log(data);
    //         }
    //     });
    // })
});