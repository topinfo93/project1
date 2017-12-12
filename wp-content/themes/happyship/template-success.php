<?php /* Template Name: Success */ 
get_header(); 
?>

<div class="order success">
	<div class="title"><h1></h1></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="form-info">
					<div class="title-form" style="text-align: center; background-color: #d2e7ac;">Đơn hàng của bạn đã được gửi thành công</div>
					<div class="wrap-form">
						<div class="code"><h2>Mã đơn hàng</h2><span>HS <?php echo $_GET['id']; ?>	</span></div>
						<div class="sms">Theo dõi tất cả đơn hàng bằng số điện thoại đăng ký<input type="text" placeholder="Nhập số điện thoại"><button>Xác nhận</button></div>

					</div>
					<div class="clearfix"></div>
				</div>

				<div class="note">
					<div>1. Vui lòng chuẩn bị đơn hàng trước khi Shipper đến lấy</div>
					<div>2. Vui lòng ghi mã đơn hàng lên túi đựng hàng</div>
				</div>

			</div>
		</div>
	</div>
	
	

</div>



<?php get_footer(); ?>
