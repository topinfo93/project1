jQuery(document).ready(function($) {
	$(document).on( 'click', '.delete-btn.custombtn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var nonce = $(this).data('nonce');
        var post = $(this).parents('.box-item:first');
        alert();
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
                                if( result == 'success' ) {
                                    post.fadeOut( function(){
                                        post.remove();
                                    });
                                }
                            }
                        })
                        return false;
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