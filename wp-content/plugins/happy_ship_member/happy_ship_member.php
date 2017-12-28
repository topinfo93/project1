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
		// add menu and submenu
		add_action("admin_menu", array( "HappyShip_Login_Plugin","add_Happyship_Menu"));

		
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
	 	var_dump(user_can( $user, 'manage_options' ));
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

	 			$getpostdata = array(
	 				'user_login'    => $user_login,
	 				'user_email'    => $email,
			        'user_pass'     => $user_password,
			        'user_nicename' => $user_nicename,
			        'display_name'  => $display_name
	 			);
	 			
	 			$result = $this->register_user( $email, $getpostdata );
	 			if ( is_wp_error( $result ) ) {

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
        $postdata=array(
        	'user_phone' 	=> $_POST['user_phone'],
        	'shop_address'  => $_POST['shop_address'],
        	'shop_state'	=> $_POST['shop_state']
        );
        var_dump($postdata);
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
	                	'processing'=> 'đang chuyển hàng',
	                	'transformed' => 'đã chuyển hàng',
	                	'processed' => 'xử lý xong',
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
		wp_enqueue_style('admin-styles', get_template_directory_uri().'/assets_backend/css/style-dashboard.css');
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
	    }
	    $results = $wpdb->get_results( 'SELECT * FROM `wp_price_manager` WHERE `nhan_hang` = "'.$nhan_hang.'" AND `giao_hang` ="'.$giao_hang. '"');
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
		add_submenu_page('happy_order', __('Quản lí cước'), __('Quản lí cước'), 'edit_themes', 'my_new_submenu', array("HappyShip_Login_Plugin",'my_submenu_render'));
	}
	function my_menu_render() { 
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	    $allorder_query = array(
	      'posts_per_page' => '20',
	      'post_type'=> 'happyship',
	      'paged' => $paged
	    );
	    $happyships = new WP_Query($allorder_query);
	    ?>
	    <div class="wrap">
	        <h1><?php _e( 'Danh sách đơn hàng', 'happyship-member' ); ?></h1>
	        <p><?php _e( 'Helpful stuff here', 'happyship-member' ); ?></p>
	        <div class="order-list">
	        	<?php if ( $happyships->have_posts() ) : 
                        while( $happyships->have_posts() ) : $happyships->the_post();
                        	$authorID =  get_the_author_id(); 
                        	$shop = get_the_author_meta('display_name');
                        	$author_phone = get_user_meta($authorID ,'user_phone',true);
                        	$author_addr = get_user_meta($authorID ,'user_address',true);
                        	$author_state = get_user_meta($authorID ,'shop_state',true);
                        	$Id = get_the_ID();
                            $ODtittle = get_the_title();
                            $kh_ten = get_post_meta( $Id, 'kh_ten', true );
                            $kh_sdt = get_post_meta( $Id, 'kh_sdt', true );
                            $kh_dc = get_post_meta( $Id, 'kh_dc', true );
                            $kh_quan = get_post_meta( $Id, 'kh_quan', true );
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
				              <dd>Q.Tân Bình</dd>
				              <dt>Hàng hóa:</dt>
				              <dd><?php echo $kh_hanghoa;?></dd>
				              <dt>Khối lượng:</dt>
				              <dd><?php echo $kh_kl;?></dd>
				              <dt>tiền thu hộ:</dt>
				              <dd><?php echo (empty($kh_tth))?'0 đ': number_format($kh_tth).' đ';?></dd>
				            </dl>
				          </div>
				          <div class="status"> <span><?php echo  $ODtittle;?></span><?php echo $status_order;?></div>
				        </div>
               	<?php endwhile;endif; ?>
	        </div>
	    </div>
	    <?php
	}
	function my_submenu_render() {
        // Render our theme options page here ...
        echo "123";
	}
}
$personalize_login_pages_plugin = new HappyShip_Login_Plugin();


