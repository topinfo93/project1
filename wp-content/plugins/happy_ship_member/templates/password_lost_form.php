<div id="password-lost-form" class="span6">
    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
        <div class="show-mess" id="lostpass_errors">
            <?php foreach ( $attributes['errors'] as $error ) : ?>
                <p class="login-error">
                    <?php echo $error; ?>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <p class="note">
        <?php
            _e(
                "Vui lòng nhập địa chỉ Email đã đăng ký,chúng tôi sẽ gửi mật khẩu đến email này.",
                'happyship-member'
            );
        ?>
    </p>
 
    <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
        <p class="form-row">
            <label for="user_login1"><?php _e( 'Email', 'happyship-member' ); ?>
            <input placeholder="Nhập email" type="email" name="user_login" id="user_login1" class="style-happy required">
        </p>
 
        <p class="lostpassword-submit">
            <input type="submit"  name="submit" class="button lostpassword-button"
                   value="<?php _e( 'Đổi mật khẩu', 'happyship-member' ); ?>"/>
        </p>
    </form>
</div>