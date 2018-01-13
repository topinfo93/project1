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
    $('.datepicker').datepicker({dateFormat: 'dd-mm-yy'});
    // filter order page
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
        content.show();

      }else{
        var content = $(this).closest('.filter_row').find('.filter_content');
        content.hide();
        inputvalue.val('');
      }
    });
    // filter shop page
    $('#page_shop_manager .filter_shop .btn-filter').click(function() {
        $(this).toggleClass('actived');
        var isshow = $('form#form_filter').is(':hidden');
        if(isshow){
          $('form#form_filter').fadeIn('400');
        }else{
           $('form#form_filter').fadeOut('400');
        }
    });
    $('.sl_filter').on('change', function() {
      var show = $(this).val();
      if( show != ''){
        $(this).closest('.filter_row').find('.filter_content').hide();
        $(this).closest('.filter_row').find('.filter_content[data-show="'+show+'"]').show(400);
      }
    });
    $('#page_happy_ship select.update_odstatus').on('change', function() {
      var $that = $(this).closest('.foot-action').find('button');
      var valueth = $(this).val();
      $that.attr("data-status",valueth);
      $that.prop("disabled", false);
    });
    $('#result_report .danhsach_ct').hide();
    $("#result_report").on("click","#showreport", function(){
      var kk = $(this).closest('.danhsach').find('.danhsach_ct').is(':hidden');
      if(kk){
        $(this).closest('.danhsach').find('.danhsach_ct').show();
      }else{
        $(this).closest('.danhsach').find('.danhsach_ct').hide();
      }
    });
});
