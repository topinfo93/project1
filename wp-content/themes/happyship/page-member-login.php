<?php get_header('login'); ?>
<?php 
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
		$action = '';
		if(isset($_GET['action'])){
			$action = $_GET['action'];
		}
	}
?>
<div class="container">
	<div class="row login-logout">
		<div class="logo-happy col-md-6 col-md-offset-3">
			<a href="<?php echo home_url(); ?>">
				<img src="<?php echo get_template_directory_uri(); ?>/images/happy_ship.png" alt="Happy ship" class="img-reponsive"/>
			</a>
		</div>
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-login">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-4">
							<a href="#" class="active" id="login-form-link"><?php _e( 'Đăng nhập', 'happyship-member' ); ?></a>
						</div>
						<div class="col-xs-4">
							<a href="#" id="register-form-link"><?php _e( 'Đăng ký', 'happyship-member' ); ?></a>
						</div>
						<div class="col-xs-4">
							<a href="#" id="forgot-form-link"><?php _e( 'Quên Mật Khẩu', 'happyship-member' ); ?></a>
						</div>
					</div>
					<hr>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12 contain-form">

							<!-- start login form -->
							<div id="login-form-content">
							<?php echo do_shortcode('[custom-login-form]');?>
							</div>
							<!-- end login form -->

							<!-- start register form -->
							<?php echo do_shortcode('[custom-register-form]');?>
							<!-- end register form -->

							<!-- start forgot form -->
							<?php echo do_shortcode('[custom-password-lost-form]');?>
							<!-- end forgot form -->

							<form id="register-form" action="" method="post" role="form" style="display: none;">
								
								<div class="form-group">
									<input type="email" name="email" id="email" tabindex="1" class="form-control required email" placeholder="Email Address" value="">
								</div>
								
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-sm-offset-3">
											<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Lấy mật khẩu">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		
	    $('#login-form-link').click(function(e) {
			$("#login-form-content").delay(100).fadeIn(100);
	 		$("#password-lost-form").fadeOut(100);
	 		$("#customer_register_form").fadeOut(100);
			$('#register-form-link').removeClass('active');
			$('#forgot-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		$('#register-form-link').click(function(e) {
			$("#login-form-content").fadeOut(100);
			$("#customer_register_form").delay(100).fadeIn(100);
	 		$("#password-lost-form").fadeOut(100);
			$('#login-form-link').removeClass('active');
			$('#forgot-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		$('#forgot-form-link').click(function(e) {
			$("#password-lost-form").delay(100).fadeIn(100);
	 		$("#login-form-content").fadeOut(100);
	 		$("#customer_register_form").fadeOut(100);
			$('#login-form-link').removeClass('active');
			$('#register-form-link').removeClass('active')
			$(this).addClass('active');
			e.preventDefault();
		});

		var act = '<?php echo $action; ?>';
		if(act == 'register'){
			$('#register-form-link').trigger("click");
		}
		if(act == 'lostpass'){
			$('#forgot-form-link').trigger("click");
		}
	});
	
</script>
<?php get_footer('login'); ?>