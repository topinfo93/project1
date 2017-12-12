(function($) {

    'use strict'

    var setHeight = function() { 

        var maxHeight = 0;

        jQuery(".wrap-shop .shop, .wrap-client .client").each(function(){
            if (jQuery(this).height() > maxHeight) { 
                maxHeight = jQuery(this).height(); 
            }
        });

        jQuery(".wrap-shop .shop, .wrap-client .client").height(maxHeight);
    }   


    // Dom Ready
    $(function() {

        setHeight();
        
    });


})(jQuery);