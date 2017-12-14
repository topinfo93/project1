<?php /* Template Name: Login page */ 
get_header(); ?>
<?php 
global $wpdb;

$usertable = $wpdb->prefix. 'happyship_member';
$error = [];
if ($_GET['action'] == "dnhap") {
    if( isset($_POST['username']) && isset($_POST['shoppassword'])){
        $username = $_POST['username'];$user_passMD5 = md5(sha1($_POST['shoppassword']));
        $results = $wpdb->get_results("SELECT * FROM ".$usertable." WHERE user_name = '".$username."' AND user_pass = '".$user_passMD5."'");
        if( $results ){
            $_SESSION[$username] = $results[0];
            $id = $results[0]->mid;$name = $results[0]->user_name;
            wp_set_current_user( $id, $name );
        }else{
            $error['fail_login'] = '<p>Tên đăng nhập hoặc mật khẩu không đúng!.</p>';
        }
    }
}elseif ($_GET['action'] == "dagky") {
    $username = $_POST['username'];$user_email = $_POST['shopemail'];
    $check = $wpdb->get_results("SELECT * FROM ".$usertable." WHERE user_name = '".$username."' AND user_email = '".$user_email."'");
    if($check){
        $error['register_fail'] = '<p class="error" style="display:block;">Đăng ký thất bại!.Email đã đăng ký trước đây.</p><a id="go-linkforgot">Quên mật khẩu</a>';
    }else{
        $insertnewmem = $wpdb->insert( 
            $usertable, 
            array( 
                'mid' => '',
                'user_name' => $_POST['username'],
                'user_pass' => md5(sha1($_POST['creatpassword'])),
                'shop_name' => $_POST['shopname'],
                'user_email' => $_POST['shopemail'],
                'shop_address' => $_POST['shopaddress'],
                'shop_phone' => $_POST['mobilephone'],
                'status' => '',
                'user_registered' => current_time( 'timestamp' ),
                'display_name' => $_POST['displayname'],
            )
        );
        if($insertnewmem){
            $error['register_susscess'] = '<p class="susscess">Đăng ký thành công!.</p>';
        }else{
            echo "đăng ký thất bại";
        }
    }
}elseif ($_GET['action'] == "lmatkhau") {
    echo "laymatkhau";
}

?>
<div class="main-contain">
    <div class="breadcum-block">
        <div class="container">
            <div class="row-fluid">
                <a href="<?php echo home_url();?>" class="home">Trang chủ </a><span class="current"> > Đăng ký</span>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row-fluid">
                <div class="span6">
                    <div class="form-style" id="login-form-box">
                        <h2>Đăng Nhập</h2>
                        <form action="<?php echo home_url('tai-khoan');?>?action=dnhap" id="customer-login" method="post" class="customer-form">
                            <div class="form-group">
                                <label for="shopname">Tên đăng nhập</label>
                                <input type="text" name="username" id="shopname" tabindex="1" class="input-style form-control required" placeholder="Username" value="">
                            </div>
                            <div class="form-group">
                                <label for="shoppassword">Mật khẩu</label>
                                <input type="password" name="shoppassword" id="shoppassword" tabindex="2" class="input-style form-control required" placeholder="Mật khẩu">
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
                        <?php if(isset($error) && !empty($error['fail_login'])){ echo $error['fail_login'];}  ?>
                    </div>
                    <div class="form-style" id="forgot-form-box" style="display: none;">
                        <h2>Lấy mật khẩu</h2>
                        <form action="<?php echo home_url('tai-khoan');?>?action=lmakhau" id="customer-forgot" method="post" class="customer-form">
                            <div class="form-group">
                                <label for="shopemail" class="required">Email đăng ký</label>
                                <input type="email" name="usermail" id="shopemail" tabindex="1" class="input-style form-control required" placeholder="Nhập email đã đăng ký" value="">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login themebtn" value="Lấy mật khẩu">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="span6 form-style" id="register-form-box">
                    <h2>Đăng Ký</h2>
                     
                    <form action="<?php echo home_url('tai-khoan');?>?action=dagky" id="customer-register" method="post" class="customer-form">
                        <?php if(isset($error) && !empty($error['register_susscess'])){ echo $error['fail_login'];}  ?>
                     <?php if(isset($error) && !empty($error['register_fail'])){ echo $error['register_fail'];}  ?>
                        <div class="form-group">
                            <label for="shopname" class="required">Tên shop</label>
                            <input type="text" name="shopname" id="shopname" tabindex="1" class="input-style form-control required" placeholder="Nhập tên shop" value="">
                        </div>
                        <div class="form-group">
                            <label for="displayname" class="required">Tên đăng nhập</label>
                            <input type="text" name="displayname" id="displayname" tabindex="1" class="input-style form-control required" placeholder="Nhập nick name" value="">
                        </div>
                        <div class="form-group">
                            <label for="shopname">Họ tên</label>
                            <input type="text" name="username" id="username" tabindex="1" class="input-style form-control" placeholder="Nhập Họ tên" value="">
                        </div>
                        <div class="form-group">
                            <label for="shopemail" class="required">Email</label>
                            <input type="email" name="shopemail" id="shopemail" tabindex="1" class="input-style form-control required" placeholder="Nhập email" value="">
                        </div>
                        <div class="form-group">
                            <label for="shoppassword" class="required">Mật khẩu</label>
                            <input type="password" name="creatpassword" id="creatpassword" tabindex="2" class="input-style form-control required" placeholder="Password" minlength="8">
                        </div>
                        <div class="form-group">
                            <label for="shoprepassword" class="required">Nhập lại mật khẩu</label>
                            <input type="password" name="shoprepassword" id="shoprepassword" tabindex="2" class="input-style form-control required" equalTo="#creatpassword" placeholder="Password" minlength="8">
                        </div>
                        <div class="form-group">
                            <label for="shopaddress">Địa chỉ shop</label>
                            <input type="text" name="shopaddress" id="shopaddress" tabindex="1" class="input-style form-control" placeholder="Nhập địa chỉ shop" value="">
                        </div>
                        <div class="form-group">
                            <label for="mobilephone" class="required">Số điện thoại</label>
                            <input type="tel" name="mobilephone" id="mobilephone" tabindex="1" class="input-style form-control required digits" placeholder="0901234567" value="">
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
