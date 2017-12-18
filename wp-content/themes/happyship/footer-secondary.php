<!-- Include jQuery -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
    <!-- Include the Sidr JS -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.sidr.js"></script>
    <script>

    $(document).ready(function () {
      $('#only-click').sidr({
        name: 'other-name',
        bind: 'click',
        onOpen: function () {
          console.log($.sidr('status'));
        },
        onClose: function () {
          console.log($.sidr('status'));
        },
        onOpenEnd: function () {
          console.log($.sidr('status'));
        },
        onCloseEnd: function () {
          console.log($.sidr('status'));
        }
      });
    });

    $( window ).resize(function () {
      $.sidr('close', 'sidr');
    });
      var pre = jQuery('.grid-box-wrap .box-item');
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

    </script>
  </body>
</html>