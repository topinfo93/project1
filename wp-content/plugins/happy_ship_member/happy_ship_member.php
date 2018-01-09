<?php
/**
 * Plugin Name:       Happy Ship Shop member
 * Description:       A plugin that replaces the WordPress login flow with a custom page.
 * Version:           0.0.1
 * Author:            CatKing 18
 * Text Domain:       happyship-member
 */

class HappyShip_Login_Plugin {
    public function __construct() {

     	register_activation_hook( __FILE__, array( 'HappyShip_Login_Plugin', 'plugin_activated' ) );
		add_shortcode( 'custom-login-form', array( $this, 'render_login_form' ) );
		add_action( 'login_form_login', array( $this, 'redirect_to_custom_login' ) );
		add_filter( 'authenticate', array( $this, 'shipper_authenticate_username_password' ), 100, 3 );
		add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );
		add_action( 'wp_logout', array( $this, 'redirect_after_logout' ) );
		add_filter( 'login_redirect', array( $this, 'redirect_after_login' ), 10, 3 );
		add_shortcode( 'custom-register-form', array( $this, 'render_register_form' ) );
		add_action( 'login_form_register', array( $this, 'redirect_to_custom_register' ) );
		add_action( 'login_form_register', array( $this, 'do_register_user' ) );
		add_action('user_register', array( $this,'_addMetaData' ));
		add_action( 'login_form_lostpassword', array( $this, 'redirect_to_custom_lostpassword' ) );
		add_shortcode( 'custom-password-lost-form', array( $this, 'render_password_lost_form' ) );
		add_action( 'login_form_lostpassword', array( $this, 'do_password_lost' ) );
		add_filter( 'retrieve_password_message', array( $this, 'replace_retrieve_password_message' ), 10, 4 );
		add_action( 'login_form_rp', array( $this, 'redirect_to_custom_password_reset' ) );
		add_action( 'login_form_resetpass', array( $this, 'redirect_to_custom_password_reset' ) );
		add_shortcode( 'custom-password-reset-form', array( $this, 'render_password_reset_form' ) );
		add_action( 'login_form_rp', array( $this, 'do_password_reset' ) );
		add_action( 'login_form_resetpass', array( $this, 'do_password_reset' ) );
		add_shortcode( 'create_order', array( $this, 'render_creatorder_form' ) );
		add_action( 'create_new_order', array( $this, 'do_create_new_order' ) );
		//add_action( 'add_meta_boxes', array( 'HappyShip_Login_Plugin','add_order_meta_boxes' ));
		add_action( 'admin_init', array( 'HappyShip_Login_Plugin','add_order_meta_boxes' ) );
		add_action( 'save_post', array( 'HappyShip_Login_Plugin','save_order_happyship' ), 10, 2 );
 		add_action( 'wp_enqueue_scripts', array( 'HappyShip_Login_Plugin','my_enqueue' ) );
 		add_action( 'wp_ajax_nopriv_get_price', array( 'HappyShip_Login_Plugin','get_price' ) );
		add_action( 'wp_ajax_get_price', array( 'HappyShip_Login_Plugin','get_price' )  );
		// ajax xóa đơn hàng
		add_action( 'wp_ajax_nopriv_xoa_don_hang', array( 'HappyShip_Login_Plugin','xoa_don_hang' ) );
		add_action( 'wp_ajax_xoa_don_hang', array( 'HappyShip_Login_Plugin','xoa_don_hang' )  );
		// ajax cập nhật đơn hàng
		add_action( 'wp_ajax_nopriv_cap_nhat_donhang', array( 'HappyShip_Login_Plugin','cap_nhat_donhang' ) );
		add_action( 'wp_ajax_cap_nhat_donhang', array( 'HappyShip_Login_Plugin','cap_nhat_donhang' )  );
		//nhan doi ajax
		add_action( 'wp_ajax_nopriv_ft_xoa_don_hang', array( 'HappyShip_Login_Plugin','ft_xoa_don_hang' ) );
		add_action( 'wp_ajax_ft_xoa_don_hang', array( 'HappyShip_Login_Plugin','ft_xoa_don_hang' )  );
		add_action( 'wp_ajax_nopriv_ft_cap_nhat_donhang', array( 'HappyShip_Login_Plugin','ft_cap_nhat_donhang' ) );
		add_action( 'wp_ajax_ft_cap_nhat_donhang', array( 'HappyShip_Login_Plugin','ft_cap_nhat_donhang' )  );
		// add menu and submenu
		add_action("admin_menu", array( "HappyShip_Login_Plugin","add_Happyship_Menu"));
		add_action( 'admin_enqueue_scripts', array( 'HappyShip_Login_Plugin','load_custom_wp_admin_style' ) );
		add_action('edit_price_cod_n',array( "HappyShip_Login_Plugin","edit_price_cod_n"));
		add_action('update_price_cod_n',array( "HappyShip_Login_Plugin","update_price_cod_n"));
		add_action('edit_price_cod_d',array( "HappyShip_Login_Plugin","edit_price_cod_d"));
		add_action('update_price_cod_d',array( "HappyShip_Login_Plugin","update_price_cod_d"));
		add_action('edit_price_utt_m',array( "HappyShip_Login_Plugin","edit_price_utt_m"));
		add_action('update_price_utt_m',array( "HappyShip_Login_Plugin","update_price_utt_m"));
    }
    
    public static function plugin_activated() {
	    $pages_needcreate = array(
	        'member-login' => array(
	            'title' => __( 'Đăng Nhập', 'happyship-member' ),
	            'content' => '[custom-login-form]'
	        ),
	        'member-create-order' => array(
	            'title' => __( 'Tạo đơn hàng', 'happyship-member' ),
	            'content' => '[create_order]'
	        ),
	        'member-password-lost' => array(
		        'title' => __( 'Mất mật khẩu', 'happyship-member' ),
		        'content' => '[custom-password-lost-form]'
		    ),
		    'member-password-reset' => array(
		        'title' => __( 'Đổi mật khẩu', 'happyship-member' ),
		        'content' => '[custom-password-reset-form]'
		    ),
		    'member-list-order' => array(
		        'title' => __( 'Danh sách đơn hàng', 'happyship-member' ),
		        'content' => ''
		    ),
		    'member-order-detail' => array(
		    	'title' => __( 'Chi tiết đơn hàng', 'happyship-member' ),
		        'content' => ''
		    )
	    );
	 
	    foreach ( $pages_needcreate as $pages => $page ) {
	        
	        $query = new WP_Query( 'pagename=' . $pages );
	        if ( ! $query->have_posts() ) {
	            wp_insert_post(
	                array(
	                    'post_content'   => $page['content'],
	                    'post_name'      => $pages,
	                    'post_title'     => $page['title'],
	                    'post_status'    => 'publish',
	                    'post_type'      => 'page',
	                    'ping_status'    => 'closed',
	                    'comment_status' => 'closed',
	                )
	            );
	        }
	    }
	    //create table
	    global $wpdb;
	    $charset_collate = $wpdb->get_charset_collate();
	    $table_name = $wpdb->prefix . 'price_COD_N';
	    $table_name1 = $wpdb->prefix . 'price_COD_D';
	    $table_name2 = $wpdb->prefix . 'price_UTT_M';
	    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		    $sql = "CREATE TABLE $table_name (
		        id int(9) NOT NULL AUTO_INCREMENT,
		        nhan_hang varchar(255)  NULL,
		        giao_hang varchar(255)  NULL,
		        gia_thuong int(12)  NULL,
		        gia_super int(12)  NULL,
		        UNIQUE KEY id (id)
		    ) $charset_collate;";
		    $sql1 = "CREATE TABLE $table_name1 (
		        id int(9) NOT NULL AUTO_INCREMENT,
		        nhan_hang varchar(255)  NULL,
		        giao_hang varchar(255)  NULL,
		        gia_thuong int(12)  NULL,
		        gia_super int(12)  NULL,
		        UNIQUE KEY id (id)
		    ) $charset_collate;";
		    $sql2 = "CREATE TABLE $table_name2 (
		        id int(9) NOT NULL AUTO_INCREMENT,
		        nhan_hang varchar(255)  NULL,
		        giao_hang varchar(255)  NULL,
		        gia_thuong int(12)  NULL,
		        gia_super int(12)  NULL,
		        UNIQUE KEY id (id)
		    ) $charset_collate;";
		    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		    dbDelta( $sql );
		    dbDelta( $sql1 );
		    dbDelta( $sql2 );
		}
		$array = array("Quan-1","Quan-2","Quan-3","Quan-4","Quan-5","Quan-6","Quan-7","Quan-8","Quan-9","Quan-10","Quan-11","Quan-12","Quan-Thu-Duc","Quan-Go-Vap","Quan-Binh-Thanh","Quan-Tan-Phu","Quan-Tan-Binh","Quan-Phu-Nhuan","Quan-Binh-Tan","Huyen-Binh-Chanh","Huyen-Can-Gio","Huyen-Cu-Chi","Huyen-Hoc-Mon","Huyen-Nha-Be");
		foreach ($array as $from) {
			foreach ($array as $to) {
					$wpdb->query("INSERT INTO $table_name (`id`, `nhan_hang`, `giao_hang`, `gia_thuong`, `gia_super`) VALUES (NULL, '".$from."', '".$to."', '0', '0')");
					$wpdb->query("INSERT INTO $table_name1 (`id`, `nhan_hang`, `giao_hang`, `gia_thuong`, `gia_super`) VALUES (NULL, '".$from."', '".$to."', '0', '0')");
					$wpdb->query("INSERT INTO $table_name2 (`id`, `nhan_hang`, `giao_hang`, `gia_thuong`, `gia_super`) VALUES (NULL, '".$from."', '".$to."', '0', '0')");
			}
		}
	}
     
    public function render_login_form( $attributes, $content = null ) {
	    $default_attributes = array( 'show_title' => True );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	    $show_title = $attributes['show_title'];
	 
	    if ( is_user_logged_in() ) {
	        return __( 'Bạn đã đăng nhập.', 'happyship-member' );
	    }
	     
	    $attributes['redirect'] = '';
	    if ( isset( $_REQUEST['redirect_to'] ) ) {
	        $attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
	    }
	    $attributes['registered'] = isset( $_REQUEST['registered'] );
	    
	    $errors = array();
		if ( isset( $_REQUEST['login'] ) ) {
		    $error_codes = explode( ',', $_REQUEST['login'] );
		    foreach ( $error_codes as $code ) {
		        $errors []= $this->get_error_message( $code );
		    }
		}

		$attributes['errors'] = $errors;
		$attributes['logged_out'] = isset( $_REQUEST['logged_out'] ) && $_REQUEST['logged_out'] == true;
		
		$attributes['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';

		$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';

	    return $this->get_template_html( 'login_form', $attributes );
	}

	private function get_template_html( $template_name, $attributes = null ) {
	    if ( ! $attributes ) {
	        $attributes = array();
	    }
	 
	    ob_start();
	 
	    do_action( 'personalize_login_before_' . $template_name );
	 
	    require( 'templates/' . $template_name . '.php');
	 
	    do_action( 'personalize_login_after_' . $template_name );
	 
	    $html = ob_get_contents();
	    ob_end_clean();
	 
	    return $html;
	}

	function redirect_to_custom_login() {
	    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
	        $redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;
	     
	        if ( is_user_logged_in() ) {
	            $this->redirect_logged_in_user( $redirect_to );
	            exit;
	        }
	 
	        $login_url = home_url( 'member-login' );
	        if ( ! empty( $redirect_to ) ) {
	            $login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
	        }
	 
	        wp_redirect( $login_url );
	        exit;
	    }
	}

	private function redirect_logged_in_user( $redirect_to = null ) {
	    $user = wp_get_current_user();
	    if ( user_can( $user, 'manage_options' ) ) {
	        if ( $redirect_to ) {
	            wp_safe_redirect( $redirect_to );
	        } else {
	            wp_redirect( admin_url() );
	        }
	    } else {
	        wp_redirect( home_url( 'create_order' ) );
	    }
	}

	function shipper_authenticate_username_password($user, $username, $password) {
	    if ( $user instanceof WP_User ) {
	        return $user;
	    }
	 
	    if ( empty($username) || empty($password) ) {
	        if ( is_wp_error( $user ) )
	            return $user;
	 
	        $error = new WP_Error();
	 
	        if ( empty($username) )
	            $error->add('empty_username', __('<strong>Lỗi</strong>: Vui lòng nhập tên đăng nhập.'));
	 
	        if ( empty($password) )
	            $error->add('empty_password', __('<strong>Lỗi</strong>: Vui lòng nhập mật khẩu.'));
	 
	        return $error;
	    }
	 
	    $user = get_user_by('login', $username);
	 
	    if ( !$user ) {
	        return new WP_Error( 'invalid_username',
	            __( '<strong>Lỗi</strong>: Invalid username.' ) .
	            ' <a href="' . wp_lostpassword_url() . '">' .
	            __( 'Quên mật khẩu?' ) .
	            '</a>'
	        );
	    }
	 
	    $password = md5(sha1($password));
	    $user = apply_filters( 'wp_authenticate_user', $user, $password);
	    if ( is_wp_error($user) )
	        return $user;
	 
	    if ( ! wp_check_password( $password, $user->user_pass, $user->ID ) ) {
	        return new WP_Error( 'incorrect_password',
	            sprintf(
	                __( '<strong>ERROR</strong>: Mật khẩu cho %s không đúng.' ),
	                '<strong>' . $username . '</strong>'
	            ) .
	            ' <a href="' . wp_lostpassword_url() . '">' .
	            __( 'Mất mật khẩu?' ) .
	            '</a>'
	        );
	    }
	 
	    return $user;
	}

	function maybe_redirect_at_authenticate( $user, $username, $password ) {
		
	    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	    	
	        if ( is_wp_error( $user ) ) {
	            $error_codes = join( ',', $user->get_error_codes() );
	 
	            $login_url = home_url( 'member-login' );
	            $login_url = add_query_arg( 'login', $error_codes, $login_url );
	 
	            wp_redirect( $login_url );
	            exit;
	        }
	    }
	 
	    return $user;
	}

	private function get_error_message( $error_code ) {
	    switch ( $error_code ) {
	        case 'empty_username':
	            return __( 'Vui lòng nhập Email đã đăng ký', 'happyship-member' );

	 		case 'invalid_email':
	            return __( "Email này chưa từng đăng ký", 'happyship-member' );

	        case 'empty_password':
	            return __( 'Vui lòng nhập mật khẩu để đăng nhập.', 'happyship-member' );
	 
	        case 'invalid_username':
	            return __( "Tên đăng nhập hoặc email không đúng.", 'happyship-member' );
	 	
	        case 'incorrect_password':
	            $err = __( "Mật khẩu không đúng. <a href='%s'>Bạn quên mật khẩu</a>?",'happyship-member'  );
	            return sprintf( $err, wp_lostpassword_url() );
	 		
	 		case 'email':
			    return __( 'Email không hợp lệ!', 'happyship-member' );
			 
			case 'email_exists':
			    return __( 'Email đã được dùng để đăng ký trước đây', 'happyship-member' );
			 
			case 'closed':
			    return __( 'Đăng ký tài khoản không được chấp nhận.', 'happyship-member' );
 
			case 'empty_username':
			    return __( 'Vui lòng nhập email hoặc tên đăng nhập.', 'happyship-member' );
			 
			case 'invalidcombo':
			    return __( 'Email này chưa được đăng ký trước đây.', 'happyship-member' );

			case 'expiredkey':
				return __( 'There are no users registered with this email address.', 'happyship-member' );
			
			case 'invalidkey':
			    return __( 'Liên kết lấy mật khẩu không hợp lệ', 'happyship-member' );
			 
			case 'password_reset_mismatch':
			    return __( "Mật khẩu và mật khẩu xác nhận lại, không trùng khớp.", 'happyship-member' );
			     
			case 'password_reset_empty':
			    return __( "Vui lòng nhập mật khẩu mới", 'happyship-member' );

	        default:
	            break;
	    }
	     
	    return __( 'Đã có lỗi xảy ra. Vui lòng thử lại sau.', 'happyship-member' );
	}

	public function redirect_after_logout() {
	    $redirect_url = home_url( 'member-login?logged_out=true' );
	    wp_safe_redirect( $redirect_url );
	    exit;
	}

	public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {

	    $redirect_url = home_url();
	    if ( ! isset( $user->ID ) ) {
	        return $redirect_url;
	        exit;
	    }
	 	if ( user_can( $user, 'manage_options' ) ) {
	        if ( $requested_redirect_to == '' ) {
	            $redirect_url = admin_url();
	        } else {
	            $redirect_url = $requested_redirect_to;
	        }
	    } else {
	        $redirect_url = home_url( 'member-list-order' );
	    }
	    return wp_validate_redirect( $redirect_url, home_url() );
	}

	public function render_register_form( $attributes, $content = null ) {
		
	    $default_attributes = array( 'show_title' => true );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	    $attributes['errors'] = array();
		if ( isset( $_REQUEST['register-errors'] ) ) {
		    $error_codes = explode( ',', $_REQUEST['register-errors'] );
		 
		    foreach ( $error_codes as $error_code ) {
		        $attributes['errors'] []= $this->get_error_message( $error_code );
		    }
		}
	 	
	    if ( is_user_logged_in() ) {
	        return __( 'Bạn đã đăng nhập.', 'happyship-member' );
	    } elseif ( ! get_option( 'users_can_register' ) ) {
	        return __( 'Quản trị không cho phép người dùng đăng ký, vui lòng liên hệ quản trị viên', 'happyship-member' );
	    } else {
	        return $this->get_template_html( 'register_form', $attributes );
	    }

	}

	public function redirect_to_custom_register() {
	    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
	        if ( is_user_logged_in() ) {
	            $this->redirect_logged_in_user();
	        } else {
	            wp_redirect( home_url( 'member-login?action=register' ) );
	        }
	        exit;
	    }
	}

	private function register_user( $email, $postdata = array() ) {
	    $errors = new WP_Error();
	 
	    if ( ! is_email( $email ) ) {
	        $errors->add( 'email', $this->get_error_message( 'email' ) );
	        return $errors;
	    }
	 	
	    if ( username_exists( $email ) || email_exists( $email ) ) {
	        $errors->add( 'email_exists', $this->get_error_message( 'email_exists') );
	        return $errors;
	    }
	 	
	    if(isset($postdata['user_pass']) && $postdata['user_pass']!=''){
	    	$password = md5(sha1($postdata['user_pass']));
	    }

	    $user_id = wp_insert_user( $postdata );
	    //wp_new_user_notification( $user_id, $password );
	 	return $user_id;
	}

	public function do_register_user() {
	    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
	        $redirect_url = home_url( 'member-login?action=register' );
	 
	        if ( ! get_option( 'users_can_register' ) ) {
	            $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
	        } else {
	            $email = $_POST['user_email'];
	            $user_login = $_POST['user_login'];
	            $user_nicename = sanitize_text_field( $_POST['user_nicename'] );
	            $user_password = md5(sha1($_POST['user_pass']));
	 			$display_name = $_POST['display_name'];
	 			$user_phone = $_POST['user_phone'];
	 			$shop_address = $_POST['shop_address'];
	 			$shop_state = $_POST['shop_state'];
	 			//$shop_state_full = $_POST['shop_state_full'];

	 			$getpostdata = array(
	 				'user_login'    => $user_login,
	 				'user_email'    => $email,
			        'user_pass'     => $user_password,
			        'user_nicename' => $user_nicename,
			        'display_name'  => $display_name
	 			);
	 			$user_id = wp_insert_user( $getpostdata );
	 			if ( is_wp_error( $user_id ) ) {

	                $errors = join( ',', $result->get_error_codes() );
	                $redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );

	            } else {
	            	
	            	$redirect_url = home_url( 'member-login?action="register"' );
	                $redirect_url = add_query_arg( 'registered', $email, $redirect_url );
            	
	            }
	        }
	 
	        wp_redirect( $redirect_url );
	        exit;
	    }
	}
	public function _addMetaData($user_id){
        $postdata = array(
        	'user_phone' 	=> $_POST['user_phone'],
        	'shop_address'  => $_POST['shop_address'],
        	'shop_state'	=> $_POST['shop_state'],
        	'shop_code' 	=> $_POST['shop_code']
        );
        if (! empty($postdata) && is_array($postdata)) {
        	foreach ($postdata as $key => $val) {
            	add_user_meta($user_id, $key, $val);
            }
        }
    }
    
    public function redirect_to_custom_lostpassword() {
	    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
	        if ( is_user_logged_in() ) {
	            $this->redirect_logged_in_user();
	            exit;
	        }
	 
	        wp_redirect( home_url( 'member-login?action=lostpass' ) );
	        exit;
	    }
	}
	
	public function render_password_lost_form( $attributes, $content = null ) {

	    $default_attributes = array( 'show_title' => true );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 	$attributes['errors'] = array();
		if ( isset( $_REQUEST['errors'] ) ) {
		    $error_codes = explode( ',', $_REQUEST['errors'] );
		 
		    foreach ( $error_codes as $error_code ) {
		        $attributes['errors'] []= $this->get_error_message( $error_code );
		    }
		}

	    if ( is_user_logged_in() ) {
	        return __( 'Hiện tại bạn đã đăng nhập!.', 'happyship-member' );
	    } else {
	        return $this->get_template_html( 'password_lost_form', $attributes );
	    }

	}
	
	public function do_password_lost() {
	    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
	        $errors = retrieve_password();
	        if ( is_wp_error( $errors ) ) {
	            $redirect_url = home_url( 'member-login?action=lostpass' );
	            $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
	        } else {
	            $redirect_url = home_url( 'member-login' );
	            $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
	        }
	 
	        wp_redirect( $redirect_url );
	        exit;
	    }
	}

	public function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {
	    
	    $msg  = __( 'Xin chào!', 'happyship-member' ) . "\r\n\r\n";
	    $msg .= sprintf( __( 'Bạn vừa yêu cầu chúng tôi thay đổi mật khẩu cho tài khoản Email %s.', 'happyship-member' ), $user_login ) . "\r\n\r\n";
	    $msg .= __( "Nếu có sự nhầm lẫn, bạn không yêu cầu đổi mật khẩu, bạn không cần bận tâm về email này và mọi thứ sẽ không thay đổi.", 'happyship-member' ) . "\r\n\r\n";
	    $msg .= __( 'Nếu đúng bạn muốn thay đổi mật khẩu, xin vui lòng kích vào đường dẫn bên dưới:', 'happyship-member' ) . "\r\n\r\n";
	    $msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
	    $msg .= __( 'Xin cám ơn!', 'happyship-member' ) . "\r\n";
	 
	    return $msg;
	}
	
	public function redirect_to_custom_password_reset() {
	    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {

	        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
	        if ( ! $user || is_wp_error( $user ) ) {
	            if ( $user && $user->get_error_code() === 'expired_key' ) {
	                wp_redirect( home_url( 'member-login?login=expiredkey' ) );
	            } else {
	                wp_redirect( home_url( 'member-login?login=invalidkey' ) );
	            }
	            exit;
	        }
	 
	        $redirect_url = home_url( 'member-password-reset' );
	        $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
	        $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
	 
	        wp_redirect( $redirect_url );
	        exit;
	    }
	}
	
	public function render_password_reset_form( $attributes, $content = null ) {
	    
	    $default_attributes = array( 'show_title' => true );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 
	    if ( is_user_logged_in() ) {
	        return __( 'You are already signed in.', 'happyship-member' );
	    } else {
	        if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
	            $attributes['login'] = $_REQUEST['login'];
	            $attributes['key'] = $_REQUEST['key'];
	 
	            $errors = array();
	            if ( isset( $_REQUEST['error'] ) ) {
	                $error_codes = explode( ',', $_REQUEST['error'] );
	 
	                foreach ( $error_codes as $code ) {
	                    $errors []= $this->get_error_message( $code );
	                }
	            }
	            $attributes['errors'] = $errors;
	 
	            return $this->get_template_html( 'password_reset_form', $attributes );
	        } else {
	            return __( 'Đường dẫn hỏng hoặc hết hạn.', 'happyship-member' );
	        }
	    }
	}
	
	public function do_password_reset() {
	    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
	        $rp_key = $_REQUEST['rp_key'];
	        $rp_login = $_REQUEST['rp_login'];
	 
	        $user = check_password_reset_key( $rp_key, $rp_login );
	 
	        if ( ! $user || is_wp_error( $user ) ) {
	            if ( $user && $user->get_error_code() === 'expired_key' ) {
	                wp_redirect( home_url( 'member-login?login=expiredkey' ) );
	            } else {
	                wp_redirect( home_url( 'member-login?login=invalidkey' ) );
	            }
	            exit;
	        }
	 
	        if ( isset( $_POST['pass1'] ) ) {
	            if ( $_POST['pass1'] != $_POST['pass2'] ) {
	                
	                $redirect_url = home_url( 'member-password-reset' );
	 
	                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
	                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
	                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );
	 
	                wp_redirect( $redirect_url );
	                exit;
	            }
	 
	            if ( empty( $_POST['pass1'] ) ) {
	                
	                $redirect_url = home_url( 'member-password-reset' );
	 
	                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
	                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
	                $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
	 
	                wp_redirect( $redirect_url );
	                exit;
	            }
	 
	            reset_password( $user, $_POST['pass1'] );
	            wp_redirect( home_url( 'member-login?password=changed' ) );
	        } else {
	            echo "Yêu cầu xử lý hỏng.";
	        }
	 
	        exit;
	    }
	}
	// render create new order
	public function render_creatorder_form( $attributes, $content = null ) {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
	    	if( isset($_GET['action']) && $_GET['action'] == 'create'){
	    		do_action('create_new_order');
	    	}
	    }

	    $default_attributes = array( 'show_title' => true );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 	$attributes['errors'] = array();

	    if ( is_user_logged_in() ) {
	        return $this->get_template_html( 'create_order_form', $attributes );
	    } 
	}

	function do_create_new_order(){
		$post_information = array(
		    'post_title' => 'OD-',
		    'post_content' => 'OD-',
		    'post_type' => 'happyship',
		    'post_author'  => get_current_user_id(),
		    'post_status' => 'publish'
		);
		$id = wp_insert_post( $post_information );
		if($id){
			$post_id = $id;
			if(isset($_POST['kh_ten']) && $_POST['kh_ten']!=null){
				add_post_meta($post_id, 'kh_ten', $_POST['kh_ten']);
			}
			if(isset($_POST['kh_sdt']) && $_POST['kh_sdt']!=null){
				add_post_meta($post_id, 'kh_sdt', $_POST['kh_sdt']);
			}
			if(isset($_POST['kh_dc']) && $_POST['kh_dc']!=null){
				add_post_meta($post_id, 'kh_dc', $_POST['kh_dc']);
			}
			if(isset($_POST['kh_quan']) && $_POST['kh_quan']!=null){
				add_post_meta($post_id, 'kh_quan', $_POST['kh_quan']);
			}
			if(isset($_POST['kh_hanghoa']) && $_POST['kh_hanghoa']!=null){
				add_post_meta($post_id, 'kh_hanghoa', $_POST['kh_hanghoa']);
			}
			if(isset($_POST['kh_kl']) && $_POST['kh_kl']!=null){
				add_post_meta($post_id, 'kh_kl', $_POST['kh_kl']);
			}
			if(isset($_POST['kh_tth']) && $_POST['kh_tth']!=null){
				add_post_meta($post_id, 'kh_tth', $_POST['kh_tth']);
			}
			if(isset($_POST['kh_goi']) && $_POST['kh_goi']!=null){
				add_post_meta($post_id,'kh_goi', $_POST['kh_goi']);
			}
			if(isset($_POST['uppon_code']) && $_POST['uppon_code']!=null){
				add_post_meta($post_id, 'uppon_code', $_POST['uppon_code']);
			}
			if(isset($_POST['status_order']) && $_POST['status_order']!=null){
				add_post_meta($post_id, 'status_order', $_POST['status_order']);
			}
			if(isset($_POST['order_price']) && $_POST['order_price']!=null){
				add_post_meta($post_id, 'order_price', $_POST['order_price']);
			}
			$my_post = array(
			    'ID'           => $id,
			    'post_title'   => 'OD'.$id,
			    'post_content' => 'Order OD'.$id,
			);
			$post_id = wp_update_post( $my_post );
			if(!is_wp_error($post_id)){
				$post_title = $my_post['post_title'];
			}
			$location = home_url('member-create-order?success=true&orderid='.$post_title); 
			echo "<meta http-equiv='refresh' content='0;url=$location' />"; exit;
		}else{
			$location = home_url('member-create-order?success=false'); 
			echo "<meta http-equiv='refresh' content='0;url=$location' />"; exit;
		}
	}
	
	/**
	 * Register meta box(es).
	 */
	function add_order_meta_boxes() {
		
	    add_meta_box( 'thong-tin', 'Thông tin đơn hàng', array('HappyShip_Login_Plugin','wpdocs_my_display_callback'), 'happyship' );
	}
	
	/**
	 * Meta box display callback.
	 *
	 * @param WP_Post $post Current post object.
	 */
	function wpdocs_my_display_callback( $post ) {
	    // Retrieve current name of the Director and Movie Rating based on review ID
    	$kh_ten = get_post_meta( $post->ID, 'kh_ten', true );
    	$kh_sdt = get_post_meta( $post->ID, 'kh_sdt', true );
    	$kh_dc = get_post_meta( $post->ID, 'kh_dc', true );
    	$kh_quan = get_post_meta( $post->ID, 'kh_quan', true );
    	$kh_hanghoa = get_post_meta( $post->ID, 'kh_hanghoa', true );
    	$kh_kl = get_post_meta( $post->ID, 'kh_kl', true );
    	$kh_tth = get_post_meta( $post->ID, 'kh_tth', true );
    	$kh_goi = get_post_meta( $post->ID, 'kh_goi', true );
    	$status_order = get_post_meta( $post->ID, 'status_order', true );
 		wp_nonce_field( 'save_thongtin', 'thongtin_nonce' );?>
 		<table>
	        <tr>
	            <td style="width: 40%">Tên người nhận</td>
	            <td style="width: 60%">
	            	<input type="text" name="kh_ten" value="<?php echo $kh_ten; ?>" />
	            </td>
	        </tr>
	        <tr>
	            <td style="width: 40%">Số đt người nhận</td>
	            <td style="width: 60%">
	            	<input type="text" name="kh_sdt" value="<?php echo $kh_sdt; ?>" />
	            </td>
	        </tr>
	        <tr>
	            <td style="width: 40%">Quận / huyện người nhận</td>
	            <td style="width: 60%">
	            	<input type="text" name="kh_quan" value="<?php echo $kh_quan; ?>" />
	            </td>
	        </tr>
	        <tr>
	            <td style="width: 40%">Loại hàng hóa</td>
	            <td style="width: 60%">
	            	<input type="text" name="kh_hanghoa" value="<?php echo $kh_hanghoa; ?>" />
	            </td>
	        </tr>
	        <tr>
	            <td style="width: 40%">Khối lượng hàng</td>
	            <td style="width: 60%">
	            	<input type="text" name="kh_hanghoa" value="<?php echo $kh_hanghoa; ?>" />
	            </td>
	        </tr>
	        <tr>
	            <td style="width: 40%">Số tiền thu hộ</td>
	            <td style="width: 60%">
	            	<input type="text" name="kh_tth" value="<?php echo $kh_tth; ?>" />
	            </td>
	        </tr>
	        <tr>
	            <td style="width: 40%">Gói vận chuyển</td>
	            <td>
	                <select style="width: 100px" name="kh_goi">
	                <?php
	                $gdvs = array(
	                	'nttk'=> 'nội thành tiết kiệm',
	                	'ntct'=> 'nội thành cấp tốc',
	                	'huyen_ct' => 'huyện cấp tốc',
	                	'ngthanh_ct' => 'ngoại thành cấp tốc'
	                );
	                foreach ($gdvs as $gdv => $value) { ?>
	                 	<option value="<?php echo $gdv; ?>" <?php echo selected( $gdv, $kh_goi ); ?>>
	                    <?php echo $value; ?> <?php } ?>
	                </select>
	            </td>
	        </tr>
	        <tr>
	            <td style="width: 40%">Tình trạng theo dõi</td>
	            <td>
	                <select style="width: 60%" name="status_order">
	                <?php
	                $status = array(
	                	'pending'=> 'đang xử lý',
	                	'step1'=> 'chuyển hàng lần 1',
	                	'step2' => 'chuyển hàng lần 2',
	                	'shipped' => 'Đã giao hàng',
	                	'procescod' => 'Đã thanh toán COD',
	                	'cancel' => 'Hủy đơn hàng'
	                );
	                foreach ($status as $sts => $value) { ?>
	                 	<option value="<?php echo $sts; ?>" <?php echo selected( $sts, $status_order ); ?>>
	                    <?php echo $value; ?> <?php } ?>
	                </select>
	            </td>
	        </tr>
	    </table>
 		<?php
	}
	function save_order_happyship($orderid , $order){
		//die();
		if ( $order->post_type == 'happyship' ) {
	        // Store data in post meta table if present in post data
	        if ( isset( $_POST['kh_ten'] ) && $_POST['kh_ten'] != '' ) {
	            update_post_meta( $orderid, 'kh_ten', $_POST['kh_ten'] );
	        }
	        if ( isset( $_POST['kh_sdt'] ) && $_POST['kh_sdt'] != '' ) {
	            update_post_meta( $orderid, 'kh_quan', $_POST['kh_quan'] );
	        }
	        if ( isset( $_POST['kh_quan'] ) && $_POST['kh_quan'] != '' ) {
	            update_post_meta( $orderid, 'kh_ten', $_POST['kh_ten'] );
	        }
	        if ( isset( $_POST['kh_hanghoa'] ) && $_POST['kh_hanghoa'] != '' ) {
	            update_post_meta( $orderid, 'kh_hanghoa', $_POST['kh_hanghoa'] );
	        }
	        if ( isset( $_POST['kh_kl'] ) && $_POST['kh_kl'] != '' ) {
	            update_post_meta( $orderid, 'kh_kl', $_POST['kh_kl'] );
	        }
	        if ( isset( $_POST['kh_tth'] ) && $_POST['kh_tth'] != '' ) {
	            update_post_meta( $orderid, 'kh_tth', $_POST['kh_tth'] );
	        }
	        if ( isset( $_POST['kh_goi'] ) && $_POST['kh_goi'] != '' ) {
	            update_post_meta( $orderid, 'kh_goi', $_POST['kh_goi'] );
	        }
	        if ( isset( $_POST['status_order'] ) && $_POST['status_order'] != '' ) {
	            update_post_meta( $orderid, 'status_order', $_POST['status_order'] );
	        }
	    }
	}
	function my_enqueue() {
		wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery') );
	  	wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}
	function get_price() {
		global $wpdb;
		$price = 0;
		$usID = get_current_user_id();
		$nhan_hang = get_user_meta($usID,'shop_state', true);
		if ( isset($_POST) ) {
	     	$kh_goi = $_POST['kh_goi'];
			$giao_hang = $_POST['giao_hang'];
			$shop_code = str_replace("-","_",$_POST['shop_code']);
			$fromtb = 'wp_price_'.strtolower($shop_code);
	    }
	    $results = $wpdb->get_results( 'SELECT * FROM `'.$fromtb.'` WHERE `nhan_hang` = "'.$nhan_hang.'" AND `giao_hang` ="'.$giao_hang. '"');
	    if(($results[0]->id)+0 > 0){
			$price = $results[0]->$kh_goi;
		} 
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
			echo number_format($price);
		}
		die();
	}
	function add_Happyship_Menu(){
		add_menu_page(__('Happy Oders Ships'), __('Order Ship'), 'edit_themes', 'happy_order', array("HappyShip_Login_Plugin",'my_menu_render'), 'dashicons-external', 7);
		add_submenu_page('happy_order', __('Bảng Giá COD-N'), __('Bảng Giá COD-N'), 'edit_themes', 'price_codn', array("HappyShip_Login_Plugin",'bang_gia_codn'));
		add_submenu_page('happy_order', __('Bảng Giá COD-D'), __('Bảng Giá COD-D'), 'edit_themes', 'price_codd', array("HappyShip_Login_Plugin",'bang_gia_codd'));
		add_submenu_page('happy_order', __('Bảng Giá UTT-M'), __('Bảng Giá UTT-M'), 'edit_themes', 'price_uttm', array("HappyShip_Login_Plugin",'bang_gia_uttm'));
		add_submenu_page('', __('Danh sach tim kiem'), __('Danh sach tim kiem'), 'edit_themes', 'filter_result', array("HappyShip_Login_Plugin",'list_filter_render'));
		//thêm menu trang danh sách shop
		add_submenu_page('happy_order', __('Danh sách Shop'), __('Danh sách shop'), 'edit_themes', 'list_manager', array("HappyShip_Login_Plugin",'shop_list_render'));
		add_submenu_page('', __('Quản lí Shop'), __('Quản lí shop'), 'edit_themes', 'shop_manager', array("HappyShip_Login_Plugin",'shop_manager_render'));
		add_submenu_page('', __('Tìm Shop'), __('Tìm Shop'), 'edit_themes', 'find_shop', array("HappyShip_Login_Plugin",'find_shop_render'));
		add_submenu_page('', __('Chỉnh sửa đơn hàng'), __('Chỉnh sửa đơn hàng'), 'edit_themes', 'edit_order', array("HappyShip_Login_Plugin",'edit_order_render'));
	}
	function load_custom_wp_admin_style(){
		wp_enqueue_style('admin-styles', get_template_directory_uri().'/assets_backend/css/style-dashboard.css');
		wp_enqueue_script( 'jqueryui_js', "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" );
		wp_enqueue_script('admin-jsconfirm-script', get_template_directory_uri().'/js/jquery-confirm.min.js');
		wp_enqueue_style('admin-jsconfirm-styles', get_template_directory_uri().'/css/jquery-confirm.min.css');
		wp_enqueue_script('admin-custom-script', get_template_directory_uri().'/assets_backend/js/style-dashboard.js');
		wp_enqueue_style('jqueryui-styles', "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css");
		wp_enqueue_script( 'admin_ajax_script', get_template_directory_uri() . '/assets_backend/js/admin_ajax_script.js', array( 'jquery' ), '1.0.0', true );
		wp_localize_script( 'admin_ajax_script', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}
	// list order
	function my_menu_render() {
		global $wpdb;
		$paged = ( $_GET['paged'] ) ? $_GET['paged'] : 1;
		$allorder_query = array(
	      	'posts_per_page' => '12',
	      	'post_type'=> 'happyship',
	      	'paged' => $paged
	    );
	    
	    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	    	$arr_params=[];
	    	$redirect_to_result = isset( $_REQUEST['result_url'] ) ? $_REQUEST['result_url'] : null;
	    	$result_url = '';
	        if(isset($_POST['order_id']) && $_POST['order_id'] !=null ){
	    		$orid = $_POST['order_id'];
	    		$result_url = add_query_arg( 'order_id', $orid , $result_url );
	    	}
	    	if(isset($_POST['shop_name']) && $_POST['shop_name'] !=null){
	    		$shop_name = $_POST['shop_name'];
	    		$result_url = add_query_arg( 'shop_name', $shop_name , $result_url );
	    	}
	    	if(isset($_POST['date']) && $_POST['date'] !=null){
	    		$create_date = str_replace("/","-",$_POST['date']);
	    		$result_url = add_query_arg( 'date', $create_date , $result_url );
	    	}
		    if(isset($_POST['shop_phone']) && $_POST['shop_phone'] !=null){
		    	$shop_phone = $_POST['shop_phone'];
		    	$result_url = add_query_arg( 'shop_phone', $shop_phone , $result_url );
		    }
		    if(isset($_POST['order_statusing']) && $_POST['order_statusing'] !=null){
		    	$order_statusing = $_POST['order_statusing'];
		    	$result_url = add_query_arg( 'order_statusing', $order_statusing , $result_url );
		    }
		    $result_url= str_replace('?', '&', $result_url);
		    $location = menu_page_url('filter_result',false).$result_url; 
			echo "<meta http-equiv='refresh' content='0;url=$location' />"; exit;
		    exit;
	    }
	    $happyships = new WP_Query($allorder_query);
	    
	    ?>
	    <div class="wrap" id="page_happy_ship">
	        <h1><?php _e( 'Danh sách đơn hàng', 'happyship-member' ); ?></h1>
	        <hr>
	        <div class="filter_order">
	        	<button class="btn btn-filter"> Lọc tìm kiếm </button>
	        	<form action="" name="formfilter" method="POST" id="form_filter">
	        	<div class="filter_row">
	        		<input type="checkbox" id="checkbox_name" name="checkbox_name"/>
	        		<label for="checkbox_name">Tên shop</label>
	        		<div id="shop_name" class="filter_content" data-show="checkbox_name">
	        			<input type="text" name="shop_name" value="" placeholder="Nhập tên shop"/>
	        		</div>	
	        	</div>
	        	<div class="filter_row">
	        		<input type="checkbox" id="checkbox_odid"  name="checkbox_odid"/>
	        		<label for="checkbox_odid">ID đơn hàng</label>
	        		<div class="filter_content" data-show="checkbox_odid">
	        			<input type="text" name="order_id" value="" placeholder="Ví dụ: OD123"/>
	        		</div>
	        	</div>
	        	<div class="filter_row">
	        		<input type="checkbox" id="checkbox_date" name="checkbox_date"/>
	        		<label for="checkbox_date">Ngày tạo đơn</label>
	        		<div id="datepicker_create" class="filter_content" data-show="checkbox_date">
	        			<input class="datepicker" name="date" data-date-format="mm/dd/yyyy" placeholder="Kích chọn ngày">
	        		</div>	
	        		
	        	</div>
	        	<div class="filter_row">
	        		<input type="checkbox" id="checkbox_phone" name="checkbox_phone">
	        		<label for="checkbox_phone">Số điện thoại người nhận</label>
	        		<div class="filter_content" data-show="checkbox_phone">
	        			<input type="text" name="shop_phone" value="" placeholder="Nhập số điện thoại"/>
	        		</div>	
	        	</div>
	        	<div class="filter_row order_status">
	        		<label for="order_statusing">Tình trạng đơn hàng</label>
	        		<select name="order_statusing" id="order_statusing">
	        			<option value="">Tất cả</option>
	        			<?php $stating = array(
                            'pending'=> 'đang xử lý',
		                	'step1'=> 'chuyển hàng lần 1',
		                	'step2' => 'chuyển hàng lần 2',
		                	'shipped' => 'Đã giao hàng',
		                	'procescod' => 'Đã thanh toán COD',
		                	'cancel' => 'Hủy đơn hàng'
                        );
                        foreach ($stating as $sts => $value) { ?>
                            <option value="<?php echo $sts; ?>" <?php echo selected( $sts, $status_order ); ?>>
                            <?php echo $value; ?> <?php } ?></option>
                    </select>
	        		
	        	</div>
	        	<input type="hidden" name="result_url" value="<?php menu_page_url('filter_result') ?>"/>
	        	<div class="filter_row filter-submit">
	        		<button type="submit" id="" name="" class="btn btn-submit">Lọc</button>
	        	</div>
	        	</form>
	        </div>
	        <div class="order-list">
	        	<?php if ( $happyships->have_posts() ) : 
                        while( $happyships->have_posts() ) : $happyships->the_post();
                        	$authorID =  get_the_author_id(); 
                        	$shop = get_the_author_meta('display_name');
                        	$author_phone = get_user_meta($authorID ,'user_phone',true);
                        	$author_addr = get_user_meta($authorID ,'shop_address',true);
                        	$author_state = get_user_meta($authorID ,'shop_state',true);
                        	//$author_state_full = get_user_meta($authorID ,'author_state_full',true);
                        	$Id = get_the_ID();
                            $ODtittle = get_the_title();
                            $kh_ten = get_post_meta( $Id, 'kh_ten', true );
                            $kh_sdt = get_post_meta( $Id, 'kh_sdt', true );
                            $kh_dc = get_post_meta( $Id, 'kh_dc', true );
                            $kh_quan = get_post_meta( $Id, 'kh_quan', true );
                            //$kh_quan_full = get_post_meta( $Id, 'kh_quan_full', true );
                            $kh_hanghoa = get_post_meta( $Id, 'kh_hanghoa', true );
                            $kh_kl = get_post_meta( $Id, 'kh_kl', true );
                            $kh_tth = get_post_meta( $Id, 'kh_tth', true );
                            $kh_goi = get_post_meta( $Id, 'kh_goi', true );
                            $status_order = get_post_meta( $Id, 'status_order', true );
                        	?>
                        <div class="box-item <?php if($status_order =='cancel'){ echo "canceled";}?>">
				          <div class="box-shop-name"><span>Tên shop: </span><?php echo $shop;?></div>
				          <div class="shop-info">
				            <dl>
				              <dt>Điện thoại:</dt>
				              <dd><?php echo $author_phone;?></dd>
				              <dt>Địa chỉ:</dt>
				              <dd><?php echo $author_phone;?></dd>
				              <dt>Quận/huyện:</dt>
				              <dd><?php echo $author_state;?></dd>
				              <dt>Địa chỉ:</dt>
				              <dd><?php echo $author_addr;?></dd>
				            </dl>
				          </div>
				          <div class="to-info">
				            <dl>
				              <dt>Đến:</dt>
				              <dd><?php echo $kh_ten;?></dd>
				              <dt>Điện thoại:</dt>
				              <dd><?php echo $kh_sdt;?></dd>
				              <dt>Địa chỉ:</dt>
				              <dd><?php echo $kh_dc;?></dd>
				              <dt>Quận/huyện:</dt>
				              <dd><?php echo $kh_quan;?></dd>
				              <dt>Hàng hóa:</dt>
				              <dd><?php echo $kh_hanghoa;?></dd>
				              <dt>Khối lượng:</dt>
				              <dd><?php echo $kh_kl;?></dd>
				              <dt>tiền thu hộ:</dt>
				              <dd><?php echo (empty($kh_tth))?'0 đ': number_format($kh_tth).' đ';?></dd>
				            </dl>
				          </div>
				          <div class="status"><span><?php echo  $ODtittle;?></span><a href="" class="delete-btn custombtn" data-id="<?php the_ID(); ?>" data-nonce="<?php echo wp_create_nonce('my_delete_post_nonce') ?>">Xóa</a><?php echo $status_order;?></div>
				          <div class="foot-action" data-show="od<?php the_ID(); ?>">
				          	<select name="update_odstatus" class="update_odstatus">
				          		<?php $stating = array(
		                            'pending'=> 'đang xử lý',
				                	'step1'=> 'chuyển hàng lần 1',
				                	'step2' => 'chuyển hàng lần 2',
				                	'shipped' => 'Đã giao hàng',
				                	'procescod' => 'Đã thanh toán COD',
				                	'cancel' => 'Hủy đơn hàng'
		                        );
		                        foreach ($stating as $sts => $value) { ?>
		                            <option value="<?php echo $sts; ?>" <?php echo selected( $sts, $status_order ); ?>>
		                            <?php echo $value; ?> <?php } ?></option>
				          	</select>
				          	<button class="save_update_od" data-id="<?php the_ID(); ?>" data-nonce="<?php echo wp_create_nonce('edit_od_nonce');?>" disabled>cập nhật</button>
				          </div>
				        </div>
               	<?php endwhile;endif; ?>
	        </div>
	        <div class="clear"></div>
	        <?php if(($count_posts = wp_count_posts( 'happyship' )->publish) > 12) : ?>
            <nav class="pagination">
                <?php pagination_admin_bar( $happyships, $arr_params ); ?>
            </nav>
        <?php endif; ?>
	    </div>
	    
	    <?php
	}
	function bang_gia_codn() {
		global $wpdb;
		if (isset($_GET['edit']) && $_GET['edit'] != null ) { 
	     	do_action('edit_price_cod_n');
	    }
	    if (isset($_GET['update']) && $_GET['update'] != null) {
	        do_action('update_price_cod_n');
	    }
	    
        ?>
		<div class="wrap">
			<h1><?php _e( 'Bảng giá cước áp dụng đối với khách hàng mới', 'happyship-member' ); ?></h1>
			<p><?php _e( 'Giá dưới đây chỉ áp dụng cho kích thước hàng dưới 50cm3 và trọng lượng dưới 3kg', 'happyship-member' ); ?></p>
			<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Điểm nhận hàng</th>
                        <th>Điểm giao hàng</th>
                        <th>Giá tiết kiệm</th>
                        <th>Giá nhanh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $results = $wpdb->get_results( 'SELECT * FROM wp_price_cod_n', OBJECT ); 
                        foreach ($results as $key) { ?>
                    <tr>
                        <td>#<?php echo $key->id; ?></td>
                        <td><?php echo $key->nhan_hang; ?></td>
                        <td><?php echo $key->giao_hang; ?></td>
                        <td><?php echo number_format($key->gia_thuong); ?></td>
                        <td><?php echo number_format($key->gia_super); ?></td>
                        <td><a href="<?php  menu_page_url('price_codn'); ?>&edit=<?php echo $key->id; ?>">Chỉnh sửa</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
		</div>
	<?php }
	function bang_gia_codd() {
		global $wpdb;
		if (isset($_GET['edit']) && $_GET['edit'] != null ) { 
	     	do_action('edit_price_cod_d');
	    }
	    if (isset($_GET['update']) && $_GET['update'] != null) {
	        do_action('update_price_cod_d');
	    }
        ?>
		<div class="wrap">
			<h1><?php _e( 'Bảng giá cước áp dụng đối với khách hàng COD-D', 'happyship-member' ); ?></h1>
			<p><?php _e( 'Giá dưới đây chỉ áp dụng cho kích thước hàng dưới 50cm3 và trọng lượng dưới 3kg', 'happyship-member' ); ?></p>
			<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Điểm nhận hàng</th>
                        <th>Điểm giao hàng</th>
                        <th>Giá tiết kiệm</th>
                        <th>Giá nhanh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $results = $wpdb->get_results( 'SELECT * FROM wp_price_cod_d', OBJECT ); 
                        foreach ($results as $key) { ?>
                    <tr>
                        <td>#<?php echo $key->id; ?></td>
                        <td><?php echo $key->nhan_hang; ?></td>
                        <td><?php echo $key->giao_hang; ?></td>
                        <td><?php echo number_format($key->gia_thuong); ?></td>
                        <td><?php echo number_format($key->gia_super); ?></td>
                        <td><a href="<?php  menu_page_url('price_codd'); ?>&edit=<?php echo $key->id; ?>">Chỉnh sửa</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
		</div>
	<?php }
	function bang_gia_uttm() {
		global $wpdb;
		if (isset($_GET['edit']) && $_GET['edit'] != null ) { 
	     	do_action('edit_price_utt_m');
	    }
	    if (isset($_GET['update']) && $_GET['update'] != null) {
	        do_action('update_price_utt_m');
	    }
	    
        ?>
		<div class="wrap">
			<h1><?php _e( 'Bảng giá cước áp dụng đối với khách hàng ứng tiền trước UTT-M', 'happyship-member' ); ?></h1>
			<p><?php _e( 'Giá dưới đây chỉ áp dụng cho kích thước hàng dưới 50cm3 và trọng lượng dưới 3kg', 'happyship-member' ); ?></p>
			<table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Điểm nhận hàng</th>
                        <th>Điểm giao hàng</th>
                        <th>Giá tiết kiệm</th>
                        <th>Giá nhanh</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $results = $wpdb->get_results( 'SELECT * FROM wp_price_utt_m', OBJECT ); 
                        foreach ($results as $key) { ?>
                    <tr>
                        <td>#<?php echo $key->id; ?></td>
                        <td><?php echo $key->nhan_hang; ?></td>
                        <td><?php echo $key->giao_hang; ?></td>
                        <td><?php echo number_format($key->gia_thuong); ?></td>
                        <td><?php echo number_format($key->gia_super); ?></td>
                        <td><a href="<?php  menu_page_url('price_uttm'); ?>&edit=<?php echo $key->id; ?>">Chỉnh sửa</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
		</div>
	<?php }
	function edit_price_cod_n() {
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM wp_price_cod_n WHERE id = '.$_GET["edit"].'' , OBJECT );
        ?>
	<div class="happy-edit">
	    <div class="container">
	        <h2>Chỉnh sửa cước phí</h2>
	        <form method="post" action="<?php  menu_page_url('price_codn'); ?>&update=<?php echo $results[0]->id; ?>&type=cod_n">
	            <div class="form-group">
	                <label for="email">Điểm nhận hàng:</label><br>
	                <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->nhan_hang; ?>">
	            </div>
	            <div class="form-group">
	                <label for="pwd">Điểm giao hàng:</label> <br>
	                <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->giao_hang; ?>">
	            </div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <label for="gia_thuong">Giá tiết kiệm:</label> <br>
	                <input type="text" class="form-control" value="<?php echo $results[0]->gia_thuong; ?>" id="gia_thuong" name="gia_thuong">
	            </div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <label for="gia_super">Giá nhanh:</label> <br>
	                <input type="text" class="form-control" value="<?php echo $results[0]->gia_super; ?>" id="gia_super" name="gia_super">
	            </div>
	            <div class="clearfix"></div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <button type="submit" class="button btn-edit-submit">Lưu lại</button>
	            </div>
	            
	        </form>
	    </div>
	</div>
	<?php }
	function edit_price_cod_d() {
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM wp_price_cod_d WHERE id = '.$_GET["edit"].'' , OBJECT );
        ?>
	<div class="happy-edit">
	    <div class="container">
	        <h2>Chỉnh sửa cước phí</h2>
	        <form method="post" action="<?php  menu_page_url('price_codd'); ?>&update=<?php echo $results[0]->id; ?>&type=cod_d">
	            <div class="form-group">
	                <label for="email">Điểm nhận hàng:</label><br>
	                <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->nhan_hang; ?>">
	            </div>
	            <div class="form-group">
	                <label for="pwd">Điểm giao hàng:</label> <br>
	                <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->giao_hang; ?>">
	            </div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <label for="gia_thuong">Giá tiết kiệm:</label> <br>
	                <input type="text" class="form-control" value="<?php echo $results[0]->gia_thuong; ?>" id="gia_thuong" name="gia_thuong">
	            </div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <label for="gia_super">Giá nhanh:</label> <br>
	                <input type="text" class="form-control" value="<?php echo $results[0]->gia_super; ?>" id="gia_super" name="gia_super">
	            </div>
	            <div class="clearfix"></div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <button type="submit" class="button btn-edit-submit">Lưu lại</button>
	            </div>
	            
	        </form>
	    </div>
	</div>
	<?php }
	function edit_price_utt_m() {
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM wp_price_utt_m WHERE id = '.$_GET["edit"].'' , OBJECT );
        ?>
	<div class="happy-edit">
	    <div class="container">
	        <h2>Chỉnh sửa cước phí</h2>
	        <form method="post" action="<?php  menu_page_url('price_uttm'); ?>&update=<?php echo $results[0]->id; ?>&type=utt_m">
	            <div class="form-group">
	                <label for="email">Điểm nhận hàng:</label><br>
	                <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->nhan_hang; ?>">
	            </div>
	            <div class="form-group">
	                <label for="pwd">Điểm giao hàng:</label> <br>
	                <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->giao_hang; ?>">
	            </div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <label for="gia_thuong">Giá tiết kiệm:</label> <br>
	                <input type="text" class="form-control" value="<?php echo $results[0]->gia_thuong; ?>" id="gia_thuong" name="gia_thuong">
	            </div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <label for="gia_super">Giá nhanh:</label> <br>
	                <input type="text" class="form-control" value="<?php echo $results[0]->gia_super; ?>" id="gia_super" name="gia_super">
	            </div>
	            <div class="clearfix"></div>
	            <div class="clearfix"></div>
	            <div class="form-group">
	                <button type="submit" class="button btn-edit-submit">Lưu lại</button>
	            </div>
	            
	        </form>
	    </div>
	</div>
	<?php }
	function update_price_cod_n() { 
	    global $wpdb;
	    $table = $wpdb->prefix.'price_'.$_GET['type'];
	    $gia_thuong = $_POST['gia_thuong'];
	    $gia_super = $_POST['gia_super'];
	    $id = $_GET['update'];

	    $updated = $wpdb->query("UPDATE $table SET  `gia_thuong` = $gia_thuong,`gia_super` = $gia_super WHERE $table.`id` = $id;");
	    ?>
	    <div class="show-alert">
	    	<p class="alert success">Cập nhật thành công!</p>
	    </div>
	<?php }
	function update_price_cod_d() { 
	    global $wpdb;
	    $table = $wpdb->prefix.'price_'.$_GET['type'];
	    $gia_thuong = $_POST['gia_thuong'];
	    $gia_super = $_POST['gia_super'];
	    $id = $_GET['update'];

	    $updated = $wpdb->query("UPDATE $table SET  `gia_thuong` = $gia_thuong,`gia_super` = $gia_super WHERE $table.`id` = $id;");
	    ?>
	    <div class="show-alert">
	    	<p class="alert success">Cập nhật thành công!</p>
	    </div>
	<?php }
	function update_price_utt_m() { 
	    global $wpdb;
	    $table = $wpdb->prefix.'price_'.$_GET['type'];
	    $gia_thuong = $_POST['gia_thuong'];
	    $gia_super = $_POST['gia_super'];
	    $id = $_GET['update'];

	    $updated = $wpdb->query("UPDATE $table SET  `gia_thuong` = $gia_thuong,`gia_super` = $gia_super WHERE $table.`id` = $id;");
	    ?>
	    <div class="show-alert">
	    	<p class="alert success">Cập nhật thành công!</p>
	    </div>
	<?php }
	function list_filter_render(){
		global $wpdb;
		$paged = ( $_GET['paged'] ) ? $_GET['paged'] : 1;
		$allorder_query = array(
	      	'posts_per_page' => '20',
	      	'post_type'=> 'happyship',
	      	'paged' => $paged
	    );
		$arr_params=[];
    	if(isset($_GET['order_id']) && $_GET['order_id'] !=null ){
    		$orid = $_GET['order_id'];
    		$allorder_query['s'] = $orid;
    		$arr_params = array( 'orderid' => $orid );
    	}
    	if(isset($_GET['shop_name']) && $_GET['shop_name'] !=null){
    		$user = $wpdb->get_row( $wpdb->prepare("SELECT `ID` FROM $wpdb->users WHERE `display_name` = %s", $_GET['shop_name'] ) );
    		$allorder_query['author'] = $user->ID;
    		$arr_params = array( 'shop_name' => $user->ID );
    	}
    	if(isset($_GET['date']) && $_GET['date'] !=null){
    		$date = explode("-",$_GET['date']);
    		$day = $date[1];
    		$monthnum = $date[0];
    		$year = $date[2];
    		$allorder_query['day'] = $day;
    		$allorder_query['monthnum'] = $monthnum;
    		$allorder_query['year'] = $year;
    	}
	    if(isset($_GET['shop_phone']) && $_GET['shop_phone'] !=null){
	    	 $allorder_query['meta_query'] = array(
	    	 	array(
			         'key' => 'kh_sdt',
			         'value' => $_GET['shop_phone'],
			         'type' => 'CHAR',
			         'compare' => '=',
			       ),
	    	 );
	    }
	    if(isset($_GET['order_statusing']) && $_GET['order_statusing'] !=null){
	    	 $allorder_query['meta_query'] = array(
	    	 	array(
			         'key' => 'status_order',
			         'value' => $_GET['order_statusing'],
			         'type' => 'CHAR',
			         'compare' => '=',
			       ),
	    	 );
	    }
	    $happyships = new WP_Query($allorder_query);
	    ?>
	    <div class="wrap" id="page_happy_ship">
	        <h1><?php _e( 'Danh sách đơn hàng', 'happyship-member' ); ?></h1>
	        <hr>
	        <?php $count = $happyships->post_count;
	        	if($count > 0){
			?>
	        <div class="order-list">
	        	<?php if ( $happyships->have_posts() ) : 
                        while( $happyships->have_posts() ) : $happyships->the_post();
                        	$authorID =  get_the_author_id(); 
                        	$shop = get_the_author_meta('display_name');
                        	$author_phone = get_user_meta($authorID ,'user_phone',true);
                        	$author_addr = get_user_meta($authorID ,'shop_address',true);
                        	$author_state = get_user_meta($authorID ,'shop_state',true);
                        	//$author_state_full = get_user_meta($authorID ,'author_state_full',true);
                        	$Id = get_the_ID();
                            $ODtittle = get_the_title();
                            $kh_ten = get_post_meta( $Id, 'kh_ten', true );
                            $kh_sdt = get_post_meta( $Id, 'kh_sdt', true );
                            $kh_dc = get_post_meta( $Id, 'kh_dc', true );
                            $kh_quan = get_post_meta( $Id, 'kh_quan', true );
                            //$kh_quan_full = get_post_meta( $Id, 'kh_quan_full', true );
                            $kh_hanghoa = get_post_meta( $Id, 'kh_hanghoa', true );
                            $kh_kl = get_post_meta( $Id, 'kh_kl', true );
                            $kh_tth = get_post_meta( $Id, 'kh_tth', true );
                            $kh_goi = get_post_meta( $Id, 'kh_goi', true );
                            $status_order = get_post_meta( $Id, 'status_order', true );
                        	?>
                        <div class="box-item <?php if($status_order =='cancel'){ echo "canceled";}?>">
				          <div class="box-shop-name"><span>Tên shop: </span><?php echo $shop;?></div>
				          <div class="shop-info">
				            <dl>
				              <dt>Điện thoại:</dt>
				              <dd><?php echo $author_phone;?></dd>
				              <dt>Địa chỉ:</dt>
				              <dd><?php echo $author_phone;?></dd>
				              <dt>Quận/huyện:</dt>
				              <dd><?php echo $author_state;?></dd>
				              <dt>Địa chỉ:</dt>
				              <dd><?php echo $author_addr;?></dd>
				            </dl>
				          </div>
				          <div class="to-info">
				            <dl>
				              <dt>Đến:</dt>
				              <dd><?php echo $kh_ten;?></dd>
				              <dt>Điện thoại:</dt>
				              <dd><?php echo $kh_sdt;?></dd>
				              <dt>Địa chỉ:</dt>
				              <dd><?php echo $kh_dc;?></dd>
				              <dt>Quận/huyện:</dt>
				              <dd><?php echo $kh_quan;?></dd>
				              <dt>Hàng hóa:</dt>
				              <dd><?php echo $kh_hanghoa;?></dd>
				              <dt>Khối lượng:</dt>
				              <dd><?php echo $kh_kl;?></dd>
				              <dt>tiền thu hộ:</dt>
				              <dd><?php echo (empty($kh_tth))?'0 đ': number_format($kh_tth).' đ';?></dd>
				            </dl>
				          </div>
				          <div class="status"> <span><?php echo  $ODtittle;?></span><a href="" class="delete-btn ft_delete_od" data-id="<?php the_ID(); ?>" data-nonce="<?php echo wp_create_nonce('ft_delete_post_nonce') ?>">Xóa</a><?php echo $status_order;?></div>
				          <div class="foot-action" data-show="od<?php the_ID(); ?>">
				          	<select name="update_odstatus" class="update_odstatus">
				          		<?php $stating = array(
		                            'pending'=> 'đang xử lý',
				                	'step1'=> 'chuyển hàng lần 1',
				                	'step2' => 'chuyển hàng lần 2',
				                	'shipped' => 'Đã giao hàng',
				                	'procescod' => 'Đã thanh toán COD',
				                	'cancel' => 'Hủy đơn hàng'
		                        );
		                        foreach ($stating as $sts => $value) { ?>
		                            <option value="<?php echo $sts; ?>" <?php echo selected( $sts, $status_order ); ?>>
		                            <?php echo $value; ?> <?php } ?></option>
				          	</select>
				          	<button class="ft_save_update_od" data-id="<?php the_ID(); ?>" data-nonce="<?php echo wp_create_nonce('ft_edit_od_nonce');?>" disabled>cập nhật</button>
				          </div>
				        </div>
               	<?php endwhile;endif; ?>
	        </div>
	        <div class="clear"></div>
	        <?php if(($count_posts = wp_count_posts( 'happyship' )->publish) > 20) : ?>
            <nav class="pagination">
                <?php pagination_admin_bar( $happyships); ?>
            </nav>
        <?php endif; 
        	}else{
        		echo '<p>Không tìm thấy kết quả nào phù hợp</p>';		
        	}
        ?>

	    </div>
	    
	    <?php
	    // trang danh sách shop
	}
	// xóa đơn hàng
	function xoa_don_hang() {
		$return = array();
		$permission = check_ajax_referer( 'my_delete_post_nonce', 'nonce', false );
	    if( $permission == false ) {
	        $return['error'] = "lỗi mã lệnh.Bạn không có quyền xóa đơn hàng này!";
	    }
	    else {
	        $deleteod = wp_delete_post( $_REQUEST['id'] );
	        if($deleteod){
	        	$return['id'] = $deleteod->post_title;
	        }else{
	        	$return['error'] = "đơn hàng không tồn tại.Vui lòng kiểm tra lại!";
	        }
	    }
	 	wp_send_json($return);
	    die();
	}
	// xóa đơn hàng page filter
	function ft_xoa_don_hang() {
		$return = array();
		$permission = check_ajax_referer( 'ft_delete_post_nonce', 'nonce', false );
	    if( $permission == false ) {
	        $return['error'] = "lỗi mã lệnh.Bạn không có quyền xóa đơn hàng này!";
	    }
	    else {
	        $deleteod = wp_delete_post( $_REQUEST['id'] );
	        if($deleteod){
	        	$return['id'] = $deleteod->post_title;
	        }else{
	        	$return['error'] = "đơn hàng không tồn tại.Vui lòng kiểm tra lại!";
	        }
	    }
	 	wp_send_json($return);
	    die();
	}
	//cập nhật đơn hàng
	function cap_nhat_donhang(){
		$post_id = $_REQUEST['id'];
		$status = $_REQUEST['status'];
		$return = [];
		$permission = check_ajax_referer( 'edit_od_nonce', 'nonce', false );
	    if( $permission == false ) {
	        $return['error'] = "lỗi mã lệnh.Bạn không có quyền xóa đơn hàng này!";
	    }
	    else {
	        $updateod = update_post_meta( $post_id, 'status_order', $status );
	        if($updateod){
	        	$return['success'] = 'Cập nhật đơn hàng thành công!';
	        }else{
	        	$return['error'] = 'Cập nhật đơn hàng thất bại!';
	        }
	    }
	 	wp_send_json($return);
	    die();
	}
	//cập nhật đơn hàng page filter
	function ft_cap_nhat_donhang(){
		$post_id = $_REQUEST['id'];
		$status = $_REQUEST['status'];
		$return = [];
		$permission = check_ajax_referer( 'ft_edit_od_nonce', 'nonce', false );
	    if( $permission == false ) {
	        $return['error'] = "lỗi mã lệnh.Bạn không có quyền xóa đơn hàng này!";
	    }
	    else {
	        $updateod = update_post_meta( $post_id, 'status_order', $status );
	        if($updateod){
	        	$return['success'] = 'Cập nhật đơn hàng thành công!';
	        }else{
	        	$return['error'] = 'Cập nhật đơn hàng thất bại!';
	        }
	    }
	 	wp_send_json($return);
	    die();
	}
	// render xử lý trang danh sách shop
	function shop_list_render(){
		$count_args = array(
		    'role__not_in'      => 'Administrator'
		);
		$user_count_query = new WP_User_Query($count_args);
		$user_count = $user_count_query->get_results();
		$total_shop = $user_count ? count($user_count) : 1;
		$page = isset($_GET['p']) ? $_GET['p'] : 1;
		$shop_per_page = 20;
		$total_pages = 1;
		$offset = $shop_per_page * ($page - 1);
		$total_pages = ceil($total_shop / $shop_per_page);
		$user_query = new WP_User_Query( array( 
			'role__not_in' => 'Administrator' , 
			'number'    => $shop_per_page,
    		'offset'    => $offset ) 
			);
		$allshops = $user_query->get_results();
		if ( ! empty( $allshops ) ) {
			$i=0;
		?>
		<div class="wrap" id="page_shop_manager">
			<h1> Danh sách shop </h1>
			<hr>
			<div class="filter_shop">
	        	<button class="btn btn-filter"> Thống kê shop </button>
	        	<form action="" name="formfilter" method="POST" id="form_filter">
	        	<div class="filter_row">
	        		<select class="sl_filter" name="type_report" id="type_report">
	        			<option value="" selected>Chọn loại thống kê</option>
	        			<option value="byshopname">Theo Tên shop</option>
	        			<option value="byshopphone">Theo số điện thoại shop</option>
	        		</select>
	        		<div class="filter_content" data-show="byshopname">
	        			<input type="text" name="shopname" value="" placeholder="Nhập tên shop"/>
	        		</div>
	        		<div class="filter_content" data-show="byshopphone">
	        			<input type="text" name="shopphone" value="" placeholder="Nhập số đt shop"/>
	        		</div>	
	        	</div>
	        	<div class="filter_row">
	        		<select class="sl_filter" name="type_report" id="type_report">
	        			<option value="" selected>Chọn loại thống kê</option>
	        			<option value="bydate">Theo Ngày</option>
	        			<option value="bymonth">Theo Tháng, Năm</option>
	        		</select>
	        		<div class="filter_content" data-show="bydate">
	        			<input class="datepicker" name="reportdate" data-date-format="mm/dd/yyyy" placeholder="Kích chọn ngày">
	        		</div>
	        		<div class="filter_content" data-show="bymonth">
	        			<input class="reportmonth" name="reportmonth" data-date-format="dd/yyyy" placeholder="Kích chọn tháng/năm">
	        		</div>
	        	</div>
	        	<div class="filter_row reportmoney">
	        		<select class="sl_filter" name="paid_status" id="paid_status">
	        			<option value="all" selected> Tất cả</option>
	        			<option value="unpaid">Chưa thanh toán</option>
	        			<option value="paid">Đã thanh toán</option>
                    </select>
	        		
	        	</div>
	        	<input type="hidden" name="result_url" value="<?php menu_page_url('filter_result') ?>"/>
	        	<div class="filter_row filter-submit">
	        		<button type="submit" id="" name="" class="btn btn-submit">Lọc</button>
	        	</div>
	        	</form>
	        </div>
			<div class="list-shop">
				<table class="table table-shop">
	                <thead>
	                    <tr>
	                        <th>ID</th>
	                        <th>Tên shop</th>
	                        <th>Địa chỉ</th>
	                        <th>Số Điện thoại</th>
	                        <th>Shop COD</th>
	                        <th>Thao tác</th>
	                    </tr>
	                </thead>
	                <tbody>
	                   <?php foreach ( $allshops as $shop ) {
	                   	$idShop = $shop->ID;
	                   	$AddrShop = get_user_meta($idShop , 'shop_address',true);
	                   	$foneShop = get_user_meta($idShop , 'user_phone',true);
	                   	?>
	                   
	                    <tr>
	                        <td><?php echo $shop->ID; ?></td>
	                        <td><?php echo $shop->display_name; ?></td>
	                        <td><?php echo $AddrShop; ?></td>
	                        <td><?php echo $foneShop; ?></td>
	                        <td><?php echo $shop->shop_code; ?></td>
	                        <td><a href="<?php  menu_page_url('shop_manager'); ?>&edit=<?php echo $shop->ID; ?>">Sửa</a>
								<a href="<?php  menu_page_url('shop_manager'); ?>&delete=<?php echo $shop->ID; ?>" id="delete_shop" data-href="">Xóa</a>
	                        </td>
	                    </tr>
	                    <?php } ?>
	                </tbody>
            </table>
			
		<?php }else{ echo '<p> Chưa có shop thành viên </p>';}?>
			</div>
			<?php $query_string = $_SERVER['QUERY_STRING'];
			$base = menu_page_url('shop_list',false) . '&' . remove_query_arg('p', $query_string) . '%_%';
			?>
			<?php if($user_count > $shop_per_page):?>
			<div class="pagination">
			<?php
			echo paginate_links( array(
			    'base' => $base,
			    'format' => '&p=%#%',
			    'prev_text' => __('&laquo;'),
			    'next_text' => __('&raquo;'),
			    'total' => $total_pages,
			    'current' => $page,
			    'end_size' => 1,
			    'mid_size' => 5,
			));
			?>
			</div>
		<?php endif; ?>
		</div>

	<?php }
	function shop_manager_render(){?>
		<div class="wrap" id="edit_shop_page">
 			<h1> Chỉnh sửa thông tin shop</h1>
 			<hr>
	<?php
		if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
		 	if(isset($_GET['edit']) && !empty($_GET['edit'])){
		 		$shop_id = $_GET['edit'];
		 		$shop = get_user_by( 'ID', $shop_id );
		 		$shop_code = (get_user_meta($shop_id , 'shop_code', true))?get_user_meta($shop_id , 'shop_code', true) : 'COD-D';
		 		$shop_name = $shop->display_name;
		 		?>
		 		
					<form action="" name="edit-shop" method="POST">
						<p>
							<label for="shop_name_new">Tên shop :</label>
							<input type="text" name="shop_name_new" id="shop_name_new" value="<?php echo $shop_name ?>">
						</p>
						<p>
							<label for="shop_code">Mã COD Shop:</label>
							<select name="shop_code" id="shop_code">
								<?php
				                $shop_code_type = array(
				                	'COD-D'=> 'Shop COD mới',
				                	'COD-N'=> 'Shop COD',
				                	'UTT-M' => 'Shop Ứng tiền trước'
				                );
				                foreach ($shop_code_type as $sc => $scn) { ?>
				                 	<option value="<?php echo $sc; ?>" <?php echo selected( $sc, $shop_code ); ?>>
				                    <?php echo $scn; ?> <?php } ?>
								<option value=""></option>
							</select>
						</p>
						<?php wp_nonce_field( 'save_edit_shop', 'edit_shop_nonce' );?>
						<input type="hidden" id="shop_id" name="shop_id" value="<?php echo $shop_id;?>">
						<p>
							<input type="submit" class="btn btn-submit" value="Lưu sửa đổi">
						</p>
					</form>
		 		<?php
		 	}
		 	if(isset($_GET['delete']) && !empty($_GET['delete'])){
		 		$shop_id = $_GET['delete'];?>
		 		<form action="" id="delete-shop" name="delete-shop" method="POST">
		 			<input type="hidden" name="shop_id_delete" value="<?php echo $shop_id;?>">
		 			<?php wp_nonce_field( 'do_del_shop', 'do_del_nonce' );?>
		 			<p class="note_alert"> Bạn thật sự muốn xóa shop này vĩnh viễn? </p>
					<input type="submit" class="btn btn-confirm-del" value="Xác nhận xóa"/>
		 		</form>
		 		<a href="<?php menu_page_url('list_manager') ?>" class="btn"  id="btn-cancel-del">Không xóa</a>
		 		<?php
		 	}
		}
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			if ( isset( $_POST['edit_shop_nonce'] ) && ! wp_verify_nonce( $_POST['edit_shop_nonce'], 'save_edit_shop' ) ) {

		   		echo '<p> Lỗi kiểm tra mã lưu.Bạn không thể lưu thay đổi!</p>';
		   		exit;

			} else {
				if(isset($_POST['shop_name_new']) && !empty($_POST['shop_name_new'])){
					$new_name = $_POST['shop_name_new'];
				}
				if(isset($_POST['shop_code']) && !empty($_POST['shop_code'])){
					$new_shopcode = $_POST['shop_code'];
				}
				if(isset($_POST['shop_id']) && !empty($_POST['shop_id'])){
					$user_id = $_POST['shop_id'];

					if( get_user_meta($_POST['shop_id'],'shop_code')){
						$update = update_user_meta( $user_id, 'shop_code', $new_shopcode );
					}else{
						$add_id = add_user_meta( $user_id, 'shop_code', $new_shopcode);
					}
					if($update || $add_id){
						echo '<p> Bạn Đã lưu thay đổi thành công!</p>';
					}
				}else{
					echo '<p> Đã có lỗi xảy ra.Bạn không thể lưu thay đổi này!</p>';
		   			exit;
				}		   
			}
			if ( isset( $_POST['do_del_nonce'] ) && ! wp_verify_nonce( $_POST['do_del_nonce'], 'do_del_shop' ) ) {
				echo '<p> Lỗi quyền xóa.Bạn không thể xóa thông tin này!</p>';
	   			exit;
			}else{
				if(isset($_POST['shop_id_delete']) && !empty($_POST['shop_id_delete'])){
					$delected = wp_delete_user( $_POST['shop_id_delete'], null );
				}
				if($delected){
					echo '<p> Bạn Đã Xóa thành công!</p>';
				}else{
					echo "<p> Xóa không thành công!</p>";
				}
			}
		}?>
		<a href="<?php menu_page_url('list_manager');?>" class="btn">Quay lại</a>
		</div>
	<?php
	}
	// Chỉnh sửa order
	function edit_order_render(){
		if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
			if(isset($_GET['odid']) && !empty($_GET['odid'])){
				$post = get_post( $_GET['odid'] );
				$authoid = $post->post_author;
				$orderofshop = get_user_by('ID',$authoid);
				$shop_name = $orderofshop->display_name;
				$ordertitle = $post->post_title;
				$orderstatus = get_post_meta( $_GET['odid'], 'status_order', true );?>
				<div class="wrap">
					<p>Bạn đang chỉnh sửa đơn hàng <?php echo $ordertitle;?></p>
					<form action="" name="sua_donhang" method="POST">
						<p class="form-row">
							<label for="">Tình trạng đơn hàng</label>
						</p>
					</form>
				</div>
				<?php
			}
		}
	}
	// lọc shop
	function find_shop_render(){

	}
}
$personalize_login_pages_plugin = new HappyShip_Login_Plugin();


