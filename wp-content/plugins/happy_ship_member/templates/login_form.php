<div class="login-form-container span6">
    <div class="show-mess" id="show-messenger">
    <!-- Show errors if there are any -->
        <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
            <?php foreach ( $attributes['errors'] as $error ) : ?>
                <p class="login-error">
                    <?php echo $error; ?>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Show logged out message if user just logged out -->
        <?php if ( $attributes['logged_out'] ) : ?>
            <p class="login-info">
                <?php _e( 'Bạn vừa Đăng Xuất. Bạn có muốn đăng nhập lại?', 'happyship-member' ); ?>
            </p>
        <?php endif; ?>
        <!--  -->
        <?php if ( $attributes['lost_password_sent'] ) : ?>
            <p class="login-info">
                <?php _e( 'Check your email for a link to reset your password.', 'happyship-member' ); ?>
            </p>
        <?php endif; ?>
        <!--  -->
        <?php if ( $attributes['password_updated'] ) : ?>
            <p class="login-info">
                <?php _e( 'Your password has been changed. You can sign in now.', 'happyship-member' ); ?>
            </p>
        <?php endif; ?>
        <?php if ( $attributes['registered'] ) : ?>
            <p class="login-info">
                <?php
                    printf(
                        __( 'Bạn đã vừa Đăng ký thành công tài khoản tại <strong>%s</strong>. Bạn có thể đăng nhập ngay bay giờ', 'happyship-member' ),
                        get_bloginfo( 'name' )
                    );
                ?>
            </p>
        <?php endif; ?>
    </div>
    <?php
        wp_login_form(
            array(
                'form_id'=> 'customer_login_form',
                'label_username' => __( 'Nhập Email (hoặc Tên đăng nhập)', 'happyship-member' ),
                'id_username' =>'user_email',
                'id_password' => 'user_password',
                'label_password' => __( 'Mật khẩu', 'happyship-member' ),
                'label_log_in' => __( 'Đăng Nhập', 'happyship-member' ),
                'label_remember' => __( 'Ghi nhớ đăng nhập', 'happyship-member' ),
                'redirect' => $attributes['redirect'],
            )
        );
    ?>
     
    <a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
        <?php _e( 'Quên mật khẩu?', 'happyship-member' ); ?>
    </a>
</div>
