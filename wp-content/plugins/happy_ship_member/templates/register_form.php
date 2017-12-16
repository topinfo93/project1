<div id="customer_register_form" class="span6 customer_register_form">
    <?php if ( $attributes['show_title'] ) : ?>
        <h2 class="form_tittle"><?php _e( 'Đăng ký', 'happyship-member' ); ?></h2>
    <?php endif; ?>
    <!-- show error -->
    <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
        <?php foreach ( $attributes['errors'] as $error ) : ?>
            <p>
                <?php echo $error; ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
    <form id="customer_signup_form" action="<?php echo wp_registration_url(); ?>" method="post">
        <p class="form-row">
            <label for="user_email"><?php _e( 'Nhập Email Đăng ký', 'happyship-member' ); ?> <strong>*</strong></label>
            <input type="email" name="user_email" id="user_email" class="style-happy required">
        </p>
 
        <p class="form-row">
            <label for="user_login"><?php _e( 'Tên đăng nhập', 'happyship-member' ); ?></label>
            <input type="text" name="user_login" id="user_login" class="style-happy required">
        </p>
 
        <p class="form-row">
            <label for="last_name"><?php _e( 'Nhập họ tên', 'happyship-member' ); ?></label>
            <input type="text" name="user_nicename" id="user_nicename" class="style-happy">
        </p>

        <p class="form-row">
            <label for="user_pass"><?php _e( 'Mật khẩu', 'happyship-member' ); ?></label>
            <input type="password" name="user_pass" id="user_pass" class="style-happy required">
        </p>

        <p class="form-row">
            <label for="user_repass"><?php _e( 'Xác nhận lại mật khẩu', 'happyship-member' ); ?></label>
            <input type="password" name="user_repass" id="user_repass" class="style-happy required">
        </p>

        <p class="form-row">
            <label for="user_phone"><?php _e( 'Số điện thoại', 'happyship-member' ); ?></label>
            <input type="tel" name="user_phone" id="user_phone" class="style-happy required">
        </p>
        
        <p class="form-row">
            <label for="display_name"><?php _e( 'Tên Shop', 'happyship-member' ); ?></label>
            <input type="text" name="display_name" id="display_name" class="style-happy">
        </p>

        <p class="form-row">
            <label for="shop_address"><?php _e( 'Địa Chỉ Shop', 'happyship-member' ); ?></label>
            <input type="text" name="shop_address" id="shop_address" class="style-happy required">
        </p>

        <p class="form-row">
            <label for="shop_state"><?php _e( 'Nhập Quận / Huyện', 'happyship-member' ); ?></label>
            <select name="shop_state" id="shop_state" class="style-happy form-control selectpicker" class="style-happy required">
                <option value="" selected="" disabled="">Quận / Huyện</option>
                <option value="Quan-1">Quận 1</option>
                <option value="Quan-2">Quận 2</option>
                <option value="Quan-3">Quận 3</option>
                <option value="Quan-4">Quận 4</option>
                <option value="Quan-5">Quận 5</option>
                <option value="Quan-6">Quận 6</option>
                <option value="Quan-7">Quận 7</option>
                <option value="Quan-8">Quận 8</option>
                <option value="Quan-9">Quận 9</option>
                <option value="Quan-10">Quận 10</option>
                <option value="Quan-11">Quận 11</option>
                <option value="Quan-12">Quận 12</option>
                <option value="Quan-Binh-Tan">Quận Bình Tân</option>
                <option value="Quan-Binh-Thanh">Quận Bình Thạnh</option>
                <option value="Quan-Go-Vap">Quận Gò Vấp</option>
                <option value="Quan-Phu-Nhuan">Quận Phú Nhuận</option>
                <option value="Quan-Tan-Binh">Quận Tân Bình</option>
                <option value="Quan-Tan-Phu">Quận Tân Phú</option>
                <option value="Quan-Thu-Duc">Quận Thủ Đức</option>
                <option value="Huyen-Cu-Chi">Huyện Củ Chi</option>
            </select>
        </p>

        <p class="signup-submit">
            <input type="submit" name="submit" class="button register-button"
                   value="<?php _e( 'Đăng ký', 'happyship-member' ); ?>"/>
        </p>
    </form>
</div>