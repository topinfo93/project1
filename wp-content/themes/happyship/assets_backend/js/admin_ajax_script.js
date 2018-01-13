jQuery(document).ready(function($) {
	$(document).on( 'click', '.delete-btn.custombtn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var nonce = $(this).data('nonce');
        var post = $(this).parents('.box-item:first');
        var mess = '';
        $.confirm({
            title: 'Thông tin đơn hàng',
            content: '<p> Bạn thật sự muốn xóa đơn hàng này?</p>',
            icon: 'fa fa-warning',
            type: 'red',
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
                    btnClass: 'btn-danger button',
                    action: function(){
                        $.ajax({
                            type: 'post',
                            url: MyAjax.ajaxurl,
                            data: {
                                'action': 'xoa_don_hang',
                                nonce: nonce,
                                id: id
                            },
                            success: function( result ) {
                                console.log(result);
                                if( result.error ) {
                                    mess = result.error;
                                    $.alert(mess);
                                }else{
                                    post.fadeOut( function(){
                                        post.remove();
                                    });
                                    mess = 'Bạn đã xóa thành công đơn hàng '+result.id;
                                    $.alert(mess);
                                    setTimeout(function(){ location.reload(); }, 3000);
                                }
                            }
                            
                        });
                        //return false;
                    }
                },
                close:{
                    text: 'Hủy',
                    btnClass: 'btn-cancel button',
                }
            }
        });
    });
    $(document).on( 'click', '.delete-btn.ft_delete_od', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var nonce = $(this).data('nonce');
        var post = $(this).parents('.box-item:first');
        var mess = '';
        $.confirm({
            title: 'Thông tin đơn hàng',
            content: '<p> Bạn thật sự muốn xóa đơn hàng này?</p>',
            icon: 'fa fa-warning',
            type: 'red',
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
                    btnClass: 'btn-danger button',
                    action: function(){
                        $.ajax({
                            type: 'post',
                            url: MyAjax.ajaxurl,
                            data: {
                                'action': 'ft_xoa_don_hang',
                                nonce: nonce,
                                id: id
                            },
                            success: function( result ) {
                                console.log(result);
                                if( result.error ) {
                                    mess = result.error;
                                    $.alert(mess);
                                }else{
                                    post.fadeOut( function(){
                                        post.remove();
                                    });
                                    mess = 'Bạn đã xóa thành công đơn hàng '+result.id;
                                    $.alert(mess);
                                    setTimeout(function(){ location.reload(); }, 3000);
                                }
                            }
                            
                        });
                    }
                },
                close:{
                    text: 'Hủy',
                    btnClass: 'btn-cancel button',
                }
            }
        });
    });
    $('#page_happy_ship .box-item  .save_update_od').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var nonce = $(this).data('nonce');
        var status = $(this).data('status');
        $.confirm({
            title: 'Bạn đang chỉnh sửa đơn hàng OD'+id,
            content: '<p> Bạn thật sự muốn cập nhật đơn hàng này?</p>',
            icon: 'fa fa-warning',
            type: 'red',
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
                    btnClass: 'btn-danger button',
                    action: function(){
                        $.ajax({
                            type: 'post',
                            url: MyAjax.ajaxurl,
                            data: {
                                'action': 'cap_nhat_donhang',
                                nonce: nonce,
                                id: id,
                                status : status
                            },
                            success: function( result ) {
                                if(result.error){
                                    $.alert(result.error);
                                }else{
                                    $.alert(result.success);
                                    setTimeout(function(){ location.reload(); }, 3000);
                                }
                            }
                        });
                        //return false;
                    }
                },
                close:{
                    text: 'Hủy',
                    btnClass: 'btn-cancel button',
                }
            }
        });
    });
    $('#page_happy_ship .box-item  .ft_save_update_od').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var nonce = $(this).data('nonce');
        var status = $(this).data('status');
        $.confirm({
            title: 'Bạn đang chỉnh sửa đơn hàng OD'+id,
            content: '<p> Bạn thật sự muốn cập nhật đơn hàng này?</p>',
            icon: 'fa fa-warning',
            type: 'red',
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
                    btnClass: 'btn-danger button',
                    action: function(){
                        $.ajax({
                            type: 'post',
                            url: MyAjax.ajaxurl,
                            data: {
                                'action': 'ft_cap_nhat_donhang',
                                nonce: nonce,
                                id: id,
                                status : status
                            },
                            success: function( result ) {
                                if(result.error){
                                    $.alert(result.error);
                                }else{
                                    $.alert(result.success);
                                    setTimeout(function(){ location.reload(); }, 3000);
                                }
                            }
                            
                        });
                        //return false;
                    }
                },
                close:{
                    text: 'Hủy',
                    btnClass: 'btn-cancel button',
                }
            }
        });
    });
    // auto complete
    $( "#autoshopname" ).autocomplete({
      source: function( request, response ) {
        $.ajax( {
          url: MyAjax.ajaxurl,
          type: 'post',
          dataType: "jsonp",
          data: {
            'action': 'auto_shop_name',
            name: request.term
          },
          success: function( data ) {
            console.log(data);
            response( data );
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
        log( "Selected: " + ui.item.value + " aka " + ui.item.id );
      }
    });
    function showValues() {
        var fields = $( "form" ).serializeArray();
        var result =[];
        jQuery.each( fields, function( i, field ) {
            result.push(field.value);
        });
        var date = result[1];
        var month = result[2];
        var payment = result[3];
        var id = result[4]
        $.ajax( {
            url: MyAjax.ajaxurl,
            type: 'post',
            data: {
                'action': 'auto_shop_name',
                date: date,
                month: month,
                payment:payment,
                id: id
            },
            success: function( data ) {
                console.log(data);
                if(data.fail == 'fail'){
                    $('#result_report').html('<p class="note"> Không có đơn hàng </p>')
                }else{
                    var danhsach = data.danhsach;
                    console.log(danhsach);
                    var html = '<p class="rp-total"><strong>Tổng Đơn hàng:</strong>'+ data.count +'</p><p class="tien_thieu"><strong>Tổng Số Tiền chưa thanh toán:</strong>'+ data.tien_no_khach +'</p>';
                        html+='<p class="tien_tra"><strong> Tiền đã trả khách :</strong>'+ data.tien_da_tra_khach +'</p>';
                        html+='<div class="danhsach"><button class="btn btn-filter" id="showreport">Danh sách</button><div class="danhsach_ct" style="display:none;">';
                    $.each(danhsach, function(i, item) {

                        var tennn = item[0];;
                        var sdt = item[1];
                        var dc = item[2];
                        var ngay = item[3];
                        html+='<div class="box_"><p><strong>đến :</strong>'+tennn+'</p><p><strong>Số đt</strong>'+sdt+'</p><p><strong>Đ/c:</strong>'+dc+'</p><p><strong>Ngày:</strong>'+ngay+'</p></div>';
                    })
                    html+='<div><div>';
                    $('#result_report').html(html);
                }
            }
        });
    }
    $( "select#paid_status, input#reportdate, input#reportmonth" ).on( "change", showValues );
   
    $('#type_report').on('change', function() {
        var these = $(this);
        var theseval = these.val();
        if(theseval === 'bymonth'){
            $('#reportdate').val('');
        }else if(theseval === 'bydate'){
            $('#reportmonth').val('');
        }else{
            $('#reportdate').val('');
            $('#reportmonth').val('');
            these.closest('.filter_row').find('.filter_content').each(function(index, el) {
                $(this).hide();
            });
        }
    });
});