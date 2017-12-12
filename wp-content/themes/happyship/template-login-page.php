<?php /* Template Name: Login page */ 
get_header(); ?>

<div class="main-contain">
    <div class="breadcum-block">
        <div class="container">
            <div class="row-fluid">
                <a href="index.html" class="home">Trang chủ </a><span class="current"> > Đăng ký</span>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <div class="form-style" id="login-form-box">
                        <h2>Đăng Nhập</h2>
                        <form action="" id="customer-login" method="post" class="customer-form">
                            <div class="form-group">
                                <label for="shopname">Tên shop</label>
                                <input type="text" name="username" id="shopname" tabindex="1" class="input-style form-control required" placeholder="Username" value="">
                            </div>
                            <div class="form-group">
                                <label for="shoppassword">Mật khẩu</label>
                                <input type="password" name="shoppassword" id="shoppassword" tabindex="2" class="input-style form-control required" placeholder="Password">
                            </div>
                            <div class="forgot-link">
                                <a href="" id="forgot-link">Quên mật khẩu?</a>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login themebtn" value="Đăng nhập">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-style" id="forgot-form-box" style="display: none;">
                        <h2>Lấy mật khẩu</h2>
                        <form action="" id="customer-forgot" method="post" class="customer-form">
                            <div class="form-group">
                                <label for="shopemail">Email đăng ký</label>
                                <input type="email" name="usermail" id="shopemail" tabindex="1" class="input-style form-control required" placeholder="Nhập email đã đăng ký" value="">
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login themebtn" value="Lấy mật khẩu">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="span6 form-style" id="register-form-box">
                    <h2>Đăng Ký</h2>
                    <form action="" id="customer-login" method="post" class="customer-form">
                        <div class="form-group">
                            <label for="shopname" class="required">Tên shop</label>
                            <input type="text" name="shopname" id="shopname" tabindex="1" class="input-style form-control required" placeholder="Nhập tên shop" value="">
                        </div>
                        <div class="form-group">
                            <label for="shopname" class="required">Họ tên</label>
                            <input type="text" name="username" id="username" tabindex="1" class="input-style form-control required" placeholder="Nhập Họ tên" value="">
                        </div>
                        <div class="form-group">
                            <label for="email" class="required">Email</label>
                            <input type="email" name="email" id="email" tabindex="1" class="input-style form-control required" placeholder="Nhập email" value="">
                        </div>
                        <div class="form-group">
                            <label for="shoppassword" class="required">Mật khẩu</label>
                            <input type="password" name="password" id="shoppassword" tabindex="2" class="input-style form-control required" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="shoprepassword" class="required">Nhập lại mật khẩu</label>
                            <input type="password" name="repassword" id="shoprepassword" tabindex="2" class="input-style form-control required" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="shopname">Địa chỉ shop</label>
                            <input type="text" name="username" id="username" tabindex="1" class="input-style form-control required" placeholder="Username" value="">
                        </div>
                        <div class="form-group">
                            <label for="shopname" class="required">Số điện thoại</label>
                            <input type="number" name="username" id="username" tabindex="1" class="input-style form-control required" placeholder="Số điện thoại" value="">
                        </div>
                        
                        <div class="form-group">
                            <div class="register-submit">
                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login themebtn" value="Đăng Ký">
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <p> Vui lòng nhập đầy đủ thông tin (* bắt buộc)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php get_footer(); ?>
