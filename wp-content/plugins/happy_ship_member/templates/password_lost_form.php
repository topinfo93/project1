<div id="password-lost-form" class="span6">
    <?php if ( $attributes['show_title'] ) : ?>
        <h2 class="form_tittle"><?php _e( 'Bạn Quên mật khẩu?', 'happyship-member' ); ?></h3>
    <?php endif; ?>
 
    <p>
        <?php
            _e(
                "Vui lòng nhập địa chỉ Email đã đăng ký,chúng tôi sẽ gửi thông tin đến email này.",
                'happyship-member'
            );
        ?>
    </p>
 
    <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
        <p class="form-row">
            <label for="user_login"><?php _e( 'Email', 'happyship-member' ); ?>
            <input type="text" name="user_login" id="user_login" class="style-happy required">
        </p>
 
        <p class="lostpassword-submit">
            <input type="submit" name="submit" class="button lostpassword-button"
                   value="<?php _e( 'Đổi mật khẩu', 'happyship-member' ); ?>"/>
        </p>
    </form>
</div>