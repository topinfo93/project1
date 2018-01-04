<?php $showForm = true;?>
<div class="create_new_order_form">
	<div class="form-info">
		<h2 class="form_tittle">Tạo đơn hàng</h2>
		<div id="show_create_mess">
		<?php 
		if( isset($_GET['success']) && $_GET['success'] == "true" && isset($_GET['orderid'])){ ?>
    		<p class="messenger create_succ"> Bạn đã tạo đơn hàng thành công! Mã đơn hàng của bạn là <strong><?php echo $_GET['orderid']; ?></strong></p>
    		<p> Đến trang <a href="<?php echo site_url( 'member-list-order' );?>">danh sách đơn hàng </a></p>
	    <?php $showForm = false; } elseif( isset($_GET['success']) && $_GET['success'] == "false") {?>
	    	<p class="messenger create_error"> Tạo đơn hàng thất bại! Vui lòng thử lại.</p>
	    <?php } ?>
	    </div>
	    <!-- show error -->
	    <?php if($showForm):?>
		<div class="wrap-form">
			<form id="customer_create_form" action="<?php echo site_url( 'member-create-order?action=create' );?>" method="post">
				<p class="form-row">
					<label for="kh_ten">Tên người nhận hàng</label>
					<input type="text" name="kh_ten" id="kh_ten" class="style-happy required" placeholder="Nhập tên người nhận hàng">
				</p>
				
				<p class="form-row">
					<label for="kh_sdt">Số điện thoại người nhận</label>
					<input type="text" name="kh_sdt" id="kh_sdt" class="style-happy required digits" placeholder="Nhập sđt người nhận hàng">
				</p>
				<p class="form-row">
					<label for="kh_dc">Địa chỉ nhận hàng</label>
					<input type="text" name="kh_dc" id="kh_dc" class="style-happy required" placeholder="Nhập địa chỉ nhận hàng">
				</p>
				<p class="form-row">
					<label for="kh_quan">Quận/Huyện người nhận</label>
					<select name="kh_quan" id="kh_quan" class="style-happy selectpicker required">
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
				<!-- <p class="form-row">
					<input type="hidden" name="kh_quan_full" id="kh_quan_full" class="style-happy">
				</p> -->
				<p class="form-row">
					<label for="kh_hanghoa">Tên hàng hóa</label>
					<input type="text" name="kh_hanghoa" id="kh_hanghoa" class="style-happy" placeholder="Nhập tên hàng hóa">
				</p>
				<p class="form-row">
					<label for="kh_kl">Trọng lượng hàng</label>
					<select name="kh_kl" id="kh_kl" class="style-happy selectpicker required">
						<option value="" selected="" disabled="">Chọn khối lượng</option>
						<option value="duoi-3kg">Dưới 3kg</option>
					</select>
				</p>
				<p class="form-row">
					<label for="kh_tth">Số tiền thu hộ (nếu có)</label>
					<input type="text" name="kh_tth" id="kh_tth" class="style-happy number" placeholder="Nhập tiền thu hộ">
				</p>
				<p class="form-row">
					<label for="">Gói dịch vụ chuyển hàng</label>
					<select name="kh_goi" class="style-happy selectpicker required">
						<option value="" name="kh_goi">Gói dịch vụ</option>
						<option value="gia_tiet_kiem">Tiết kiệm</option>
						<option value="gia_nhanh">Tốc hành</option>
						<option value="super_happy">Siêu tốc</option>
					</select>
				</p>
				<p class="form-row">
					<label for="uppon_code">Mã giảm giá</label>
					<input type="text" name="uppon_code" id="uppon_code" class="style-happy" placeholder="Mã giảm giá">
				</p>

				<p class="form-row" style="display: none;">
					<label for="status_order"></label>
					<input type="hidden" name="status_order" id="status_order" class="style-happy" value="pending">
				</p>
				
				<?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>
				<p class="signup-submit" style="display: none;">
		            <input type="submit" id="create_form_submit" name="submit" class="button register-button" value="<?php _e( 'Tạo đơn hàng', 'happyship-member' ); ?>"/>
		        </p>
				<p style="text-align: center;">
					<button id="btn-confirm-createnew" class="button confirm-button">Tạo đơn hàng</button>
				</p>
				
			</form>
		</div>
		<?php endif;?>
	</div>

</div>
