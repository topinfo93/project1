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
});