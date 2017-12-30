'use strict';
jQuery(document).ready(function($) {
	var pre = jQuery('.order-list .box-item');
    var el = pre.find('.shop-info');
    jQuery('.box-shop-name').click(function() {
        parent = jQuery(this).parent('.box-item');
        parent.toggleClass('onopen');
        if(parent.hasClass('onopen') == true){
          parent.children('.shop-info').show(400);
        }else{
          parent.children('.shop-info').hide(400);
        }
      });
      
    el.each(function() {
        el.hide();
    });
});