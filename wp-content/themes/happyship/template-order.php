<?php /* Template Name: Order */ 
get_header(); ?>
<?php 
/* nếu khách hàng chưa đăng nhập sẽ chuyển đến trang đăng nhập */
	if ( !is_user_logged_in() ) {
	   wp_redirect( home_url('tai-khoan') );
	}
?>
<div class="order">
	<form action="/build-order" method="post">
		<div class="title"><h1>TẠO ĐƠN HÀNG</h1></div>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-info">

						<div class="title-form">Thông tin khách hàng</div>
						<div class="wrap-form">
							<div class="field">
								<div class="number">1</div>
								<input type="text" name="kh_ten" placeholder="Nhập tên người nhận hàng">
							</div>
							
							<div class="field">
								<div class="number">2</div>
								<input type="text" required="" name="kh_sdt" placeholder="Nhập sđt người nhận hàng">
							</div>
							<div class="field">
								<div class="number">3</div>
								<input type="text" name="kh_dc" placeholder="Nhập địa chỉ nhận hàng">
							</div>
							<div class="field">
								<div class="number">4</div>
								<select name="kh_quan" class="form-control selectpicker" required="">
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
							</div>
							<div class="field">
								<div class="number">6</div>
								<input type="text" name="kh_hanghoa" placeholder="Nhập tên hàng hóa">
							</div>
							<div class="field">
								<div class="number">7</div>
								<select name="kh_kl" class="form-control selectpicker" required="">
									<option value="" selected="" disabled="">Chọn khối lượng</option>
									<option value="duoi-3kg">Dưới 3kg</option>
								</select>
							</div>
							<div class="field">
								<div class="number">8</div>
								<input type="number" name="kh_tth" placeholder="Nhập tiền thu hộ">
							</div>
							<div class="field">
								<div class="number">9</div>
								<select name="kh_goi" class="form-control selectpicker" required="">
									<option value="" name="kh_goi" selected="" disabled="">Gói dịch vụ</option>
									<option value="gia_tiet_kiem">Tiết kiệm</option>
									<option value="gia_nhanh">Tốc hành</option>
									<option value="super_happy">Super Happy</option>
								</select>
							</div>
							<div class="field">
								<div class="number">10</div>
								<input type="text" name="code" placeholder="Mã giảm giá">
							</div>
						</div>
						
					</div>

				</div>
				<div class="col-md-6 col-sm-12">
					<?php if (!isset($_SESSION['logged'])): ?>
						<div class="form-info">
							<div class="title-form">Thông tin shop</div>
							<div class="wrap-form">
								<div class="field">
									<div class="number">1</div>
									<input type="text" name="shop_ten" placeholder="Nhập tên shop">
								</div>
								
								<div class="field">
									<div class="number">2</div>
									<input type="number" required="" name="shop_sdt" placeholder="Nhập sđt shop">
								</div>
								<div class="field">
									<div class="number">3</div>
									<input type="text" name="shop_dc" placeholder="Nhập địa chỉ shop">
								</div>
								<div class="field">
									<div class="number">4</div>
									<select name="shop_quan" class="form-control selectpicker" required="">
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
								</div>
								<div class="field">
									<div class="number">5</div>
									<input type="text" name="shop_phuong" placeholder="Nhập tên phường">
								</div>
								<div class="field">
									<div class="number">6</div>
									<input type="text" placeholder="Nhập mã xác minh" required="" name="pass1">
								</div>
								<div class="field">
									<div class="number">7</div>
									<input type="text" required="" placeholder="Nhập lại mã xác minh" name="pass2" >
								</div>
							</div>
						</div>
					<?php endif; ?>

					<div class="confirm">
						<div class="fee">
							<div class="left">Cước phí</div>
							<div class="right">0</div>
							<input type="text" name="fee" hidden="">
						</div>
						<button type="submit">Xác nhận đơn hàng</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	

</div>



<?php get_footer(); ?>
