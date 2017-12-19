<?php get_header('login'); ?>

<div class="container">
	<div class="row login-logout">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-login">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-6">
							<a href="#" class="active" id="login-form-link"><?php _e( 'Đăng nhập', 'happyship-member' ); ?></a>
						</div>
						<div class="col-xs-6">
							<a href="#" id="register-form-link"><?php _e( 'Quên Mật Khẩu', 'happyship-member' ); ?></a>
						</div>
					</div>
					<hr>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<?php echo do_shortcode('[custom-login-form]');?>

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

<?php get_footer('login'); ?>