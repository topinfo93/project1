<div class="span6 create_new_order_form">
	<div class="form-info">
		<h2 class="form_tittle">Tạo đơn hàng</h2>
		<?php if( isset($_GET['success']) && $_GET['success'] == 'true'){ ?>
	    		<p class="messenger"> Bạn đã tạo đơn hàng thành công</p>
	    <?php } ?>
		<div class="wrap-form">
			<form id="customer_create_form" action="<?php echo site_url( 'member-account?action=create' );?>" method="post">
				<p class="form-row">
					<label for="kh_ten">Tên người nhận hàng</label>
					<input type="text" name="kh_ten" id="kh_ten" class="style-happy" placeholder="Nhập tên người nhận hàng">
				</p>
				
				<p class="form-row">
					<label for="kh_sdt">Số điện thoại người nhận</label>
					<input type="text" required="" name="kh_sdt" id="kh_sdt" class="style-happy" placeholder="Nhập sđt người nhận hàng">
				</p>
				<p class="form-row">
					<label for="kh_dc">Địa chỉ nhận hàng</label>
					<input type="text" name="kh_dc" id="kh_dc" class="style-happy" placeholder="Nhập địa chỉ nhận hàng">
				</p>
				<p class="form-row">
					<label for="kh_quan">Quận/Huyện người nhận</label>
					<select name="kh_quan" id="kh_quan" class="style-happy selectpicker" required="">
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
						<option value="Huyen-Binh-Chanh">Huyện Bình Chánh</option>
						<option value="Huyen-Hoc-Mon">Huyện Hóc Môn</option>

					</select>
				</p>
				<p class="form-row">
					<label for="kh_hanghoa">Tên hàng hóa</label>
					<input type="text" name="kh_hanghoa" id="kh_hanghoa" class="style-happy" placeholder="Nhập tên hàng hóa">
				</p>
				<p class="form-row">
					<label for="kh_kl">Trọng lượng hàng</label>
					<select name="kh_kl" id="kh_kl" class="style-happy selectpicker" required="">
						<option value="" selected="" disabled="">Chọn khối lượng</option>
						<option value="duoi-3kg">Dưới 3kg</option>
					</select>
				</p>
				<p class="form-row">
					<label for="kh_tth">Số tiền thu hộ (nếu có)</label>
					<input type="number" name="kh_tth" id="kh_tth" class="style-happy" placeholder="Nhập tiền thu hộ">
				</p>
				<p class="form-row">
					<label for="">Gói dịch vụ chuyển hàng</label>
					<select name="kh_goi" class="style-happy selectpicker" required="">
						<option value="" name="kh_goi" selected="" disabled="">Gói dịch vụ</option>
						<option value="tiet-kiem">Tiết kiệm</option>
						<option value="toc-hanh">Tốc hành</option>
					</select>
				</p>
				<p class="form-row">
					<label for="uppon_code"></label>
					<input type="text" name="uppon_code" id="uppon_code" class="style-happy" placeholder="Mã giảm giá">
				</p>
				<div class="field confirm-order">
					<p>Thông tin đơn hàng</p>
					<div class="order_content">
						<p><strong>Người nhận:</strong><span id="name_receiver"> name will changed here</span></p>
						<p><strong>Số điện thoại:</strong><span id="phone_receiver">000-000-0000</span></p>
						<p><strong>Địa chỉ :</strong><span id="add_receiver"> address will change here</span></p>
						<p><strong>(Gói) Chuyển hàng :</strong><span id="type_service"> type 1</span></p>
						<p><strong>Số tiền thu hộ :</strong><span id="money_receiver"> 000.000đ</span></p>
						<p class="order-footer"><strong>Tổng cước phí :</strong><span id="total_cost"></span></p>
					</div>
				</div>
				<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
				 <p class="signup-submit">
		            <input type="submit" name="submit" class="button register-button"
		                   value="<?php _e( 'Tạo đơn hàng', 'happyship-member' ); ?>"/>
		        </p>
			</form>
		</div>
	</div>

</div>