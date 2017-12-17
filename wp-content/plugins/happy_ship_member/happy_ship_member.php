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
		add_shortcode( 'account-info', array( $this, 'render_creatorder_form' ) );
    }
    
    public static function plugin_activated() {
	    $pages_needcreate = array(
	        'member-login' => array(
	            'title' => __( 'HappyShip Đăng Nhập', 'happyship-member' ),
	            'content' => '[custom-login-form]'
	        ),
	        'member-account' => array(
	            'title' => __( 'HappyShip Tài khoản', 'happyship-member' ),
	            'content' => '[account-info]'
	        ),
	        'member-register' => array(
		        'title' => __( 'HappyShip Đăng Ký', 'happyship-member' ),
		        'content' => '[custom-register-form]'
		    ),
		    'member-password-lost' => array(
		        'title' => __( 'HappyShip Mất mật khẩu', 'happyship-member' ),
		        'content' => '[custom-password-lost-form]'
		    ),
		    'member-password-reset' => array(
		        'title' => __( 'HappyShip Đổi mật khẩu', 'happyship-member' ),
		        'content' => '[custom-password-reset-form]'
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
	        wp_redirect( home_url( 'member-account' ) );
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
	            return __( "Email này không đúng", 'happyship-member' );

	        case 'empty_password':
	            return __( 'Vui lòng nhập mật khẩu để đăng nhập.', 'happyship-member' );
	 
	        case 'invalid_username':
	            return __( "Email này chưa được đăng ký.?", 'happyship-member' );
	 	
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
	    }
	 
	    if ( user_can( $user, 'manage_options' ) ) {
	        if ( $requested_redirect_to == '' ) {
	            $redirect_url = admin_url();
	        } else {
	            $redirect_url = $requested_redirect_to;
	        }
	    } else {
	        $redirect_url = home_url( 'member-account' );
	    }
	 
	    return wp_validate_redirect( $redirect_url, home_url() );
	}

	public function render_register_form( $attributes, $content = null ) {
		$attributes['errors'] = array();
		if ( isset( $_REQUEST['register-errors'] ) ) {
		    $error_codes = explode( ',', $_REQUEST['register-errors'] );
		 
		    foreach ( $error_codes as $error_code ) {
		        $attributes['errors'] []= $this->get_error_message( $error_code );
		    }
		}
	    
	    $default_attributes = array( 'show_title' => true );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 
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
	            wp_redirect( home_url( 'member-register' ) );
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
	        $redirect_url = home_url( 'member-register' );
	 
	        if ( ! get_option( 'users_can_register' ) ) {
	            $redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
	        } else {
	            $email = $_POST['user_email'];
	            $user_login = sanitize_text_field( $_POST['user_login'] );
	            $user_nicename = sanitize_text_field( $_POST['user_nicename'] );
	            $user_password = md5(sha1($_POST['user_pass']));
	 			$display_name = sanitize_text_field( $_POST['display_name'] );
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

	            	$redirect_url = home_url( 'member-login' );
	                $redirect_url = add_query_arg( 'registered', $email, $redirect_url );
            	
	            }
	        }
	 
	        wp_redirect( $redirect_url );
	        exit;
	    }
	}
	public function _addMetaData($user_id)
    {
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
	 
	        wp_redirect( home_url( 'member-password-lost' ) );
	        exit;
	    }
	}
	
	public function render_password_lost_form( $attributes, $content = null ) {
	    
	    $attributes['errors'] = array();
		if ( isset( $_REQUEST['errors'] ) ) {
		    $error_codes = explode( ',', $_REQUEST['errors'] );
		 
		    foreach ( $error_codes as $error_code ) {
		        $attributes['errors'] []= $this->get_error_message( $error_code );
		    }
		}

	    $default_attributes = array( 'show_title' => true );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 
	    if ( is_user_logged_in() ) {
	        return __( 'You are already signed in.', 'happyship-member' );
	    } else {
	        return $this->get_template_html( 'password_lost_form', $attributes );
	    }

	}
	
	public function do_password_lost() {
	    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
	        $errors = retrieve_password();
	        if ( is_wp_error( $errors ) ) {
	            $redirect_url = home_url( 'member-password-lost' );
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
		// $attributes['errors'] = array();
		// if ( isset( $_REQUEST['register-errors'] ) ) {
		//     $error_codes = explode( ',', $_REQUEST['register-errors'] );
		 
		//     foreach ( $error_codes as $error_code ) {
		//         $attributes['errors'] []= $this->get_error_message( $error_code );
		//     }
		// }
	    
	    $default_attributes = array( 'show_title' => true );
	    $attributes = shortcode_atts( $default_attributes, $attributes );
	 
	    // if ( is_user_logged_in() ) {
	    //     return __( 'Bạn đã đăng nhập.', 'happyship-member' );
	    // } elseif ( ! get_option( 'users_can_register' ) ) {
	    //     return __( 'Quản trị không cho phép người dùng đăng ký, vui lòng liên hệ quản trị viên', 'happyship-member' );
	    // } else {
	    //     return $this->get_template_html( 'register_form', $attributes );
	    // }
	    return $this->get_template_html( 'create_order_form', $attributes );
	}
}
// Initialize the plugin
$personalize_login_pages_plugin = new HappyShip_Login_Plugin();