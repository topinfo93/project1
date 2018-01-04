'use strict';
jQuery(document).ready(function($) {
	var pre = jQuery('.order-list .box-item');
    var el = pre.find('.shop-info');
    jQuery('.box-shop-name').click(function() {
        parent = jQuery(this).parent('.box-item');
        parent.toggleClass('onopen');
        if(parent.hasClass('onopen') == true){
          parent.children('.shop-info').show(600);
        }else{
          parent.children('.shop-info').hide(400);
        }
      });
      
    el.each(function() {
        el.hide();
    });
    $('.datepicker').datepicker();

    $('#page_happy_ship .filter_order .btn-filter').click(function(event) {
      $(this).toggleClass('actived');
      var isshow = $('form#form_filter').is(':hidden');
      if(isshow){
        $('form#form_filter').fadeIn('400');
      }else{
         $('form#form_filter').fadeOut('400');
      }
    });
    var checkbox = $('#form_filter input[type="checkbox"]');
    checkbox.click(function(event) {
      var content = $(this).closest('.filter_row').find('.filter_content');
      var inputvalue = content.children('input');
      if($(this).prop('checked')){
        var data = $(this).attr('name');
        var value = content.find('input').val();
        console.log(value); 
        content.show();

      }else{
        var content = $(this).closest('.filter_row').find('.filter_content');
        content.hide();
        inputvalue.val('');
      }
    });
    
});