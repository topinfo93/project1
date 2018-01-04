jQuery(document).ready(function($) {
    $("#btn-confirm-createnew").click(function(e){
        e.preventDefault();
        var valid = $("#customer_create_form").valid();
        var valueOption = $('select[name="kh_goi"]').find(":selected").val();
        var textOption = $('select[name="kh_goi"]').find(":selected").text();
        var giao_hang = $('select[name="kh_quan"]').find(":selected").val();
        $.ajax({
            type: "post",
            url: my_ajax_object.ajax_url, // or example_ajax_obj.ajaxurl if using on frontend
            data: {
                'action': 'get_price',
                kh_goi : valueOption,
                giao_hang : giao_hang
            },
            success:function(data) {
                // This outputs the result of the ajax request
                var ttt = data;
                if(valid){
                    var tnn = $('#kh_ten').val();
                    var dtnn = $('#kh_sdt').val();
                    var dcnn = $('#kh_dc').val();
                    var dvch = textOption;
                    var tth = ($('#kh_tth').val()) ? $('#kh_tth').val() : 0;
                    $.confirm({
                        title: 'Thông tin đơn hàng',
                        content: '<div class="field confirm-order">'+
                                    '<div class="order_content">'+
                                        '<p><strong>Người nhận:</strong><span id="name_receiver">'+tnn+'</span></p>'+
                                        '<p><strong>Số điện thoại:</strong><span id="phone_receiver">'+dtnn+'</span></p>'+
                                        '<p><strong>Địa chỉ :</strong><span id="add_receiver"> '+dcnn+'</span></p>'+
                                        '<p><strong>(Gói) Chuyển hàng :</strong><span id="type_service"> '+dvch+'</span></p>'+
                                        '<p><strong>Số tiền thu hộ :</strong><span id="money_receiver"> '+tth+'đ</span></p>'+
                                        '<p class="order-footer"><strong>Cước phí :</strong><span id="total_cost">'+ttt+'đ</span></p>'+
                                    '</div>'+
                                '</div>',
                        icon: 'fa fa-warning',
                        type: 'orange',
                        animation: 'zoom',
                        closeIcon : true,
                        columnClass : 'my-class',
                        closeAnimation: 'scale',
                        useBootstrap : false,
                        boxWidth: '50%',
                        bgOpacity : 0.8,
                        theme : 'material',
                        buttons: {
                            omg: {
                                text: 'Xác nhận',
                                btnClass: 'btn-agree button',
                                action: function(){
                                    $('#create_form_submit').trigger('click');
                                }
                            },
                            close:{
                                text: 'Hủy',
                                btnClass: 'btn-cancel button',
                                
                            }
                        }
                    });
                }
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        }); 
        
    });
    
      
});
