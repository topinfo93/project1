<?php /* Template Name: Manager Order */ 
get_header(); ?>
<div class="create">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<button class="btn"><a href="<?php echo get_home_url(); ?>/order">Tạo đơn hàng mới</a></button>
			</div>
		</div>
	</div>
</div>
<div class="manager" style="height: 100%;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<?php
				global $wpdb;
				$phone = $_POST['phone'];
				$pass = $_POST['verify'];

				if (isset($_SESSION['logged'])) {
					$results = $wpdb->get_results( 'SELECT * FROM `wp_ordered_manager` WHERE `sdt_shop` = "'.$_SESSION['logged'].'"', OBJECT );
				}else{
					$results = $wpdb->get_results( "SELECT * FROM `wp_ordered_manager` WHERE `sdt_shop` = ".$phone." AND `pass` = ".$pass, OBJECT );
					$_SESSION['logged'] = $phone;
				}
				
				if(count($results) > 0): 
		
					foreach ($results as $key) { ?>

					    <div class="box-item">
					        <div class="wrap-shop">
					            <div class="shop">
					                <div class="left">ID</div>
					                <div class="right">HS<?php echo $key->id; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					        </div>

					        <div class="wrap-client">
					            <div class="client">
					                <div class="left">Tên</div>
					                <div class="right"><?php echo $key->nguoi_nhan; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="client">
					                <div class="left">SĐT</div>
					                <div class="right"><?php echo $key->sdt_nguoi_nhan; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="client">
					                <div class="left">Đ/C</div>
					                <div class="right"><?php echo $key->dia_chi_nguoi_nhan; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="client">
					                <div class="left">Phường</div>
					                <div class="right"><?php echo $key->phuong_nhan; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="client">
					                <div class="left">Quận/huyện</div>
					                <div class="right"><?php echo $key->quan_huyen_nhan; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="client">
					                <div class="left">Tên hàng</div>
					                <div class="right"><?php echo $key->ten_hang; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="client">
					                <div class="left">Khối lượng</div>
					                <div class="right"><?php echo $key->khoi_luong; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="client">
					                <div class="left">Tiền thu hộ</div>
					                <div class="right"><?php echo $key->thu_ho; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="client">
					                <div class="left">Gói</div>
					                <div class="right"><?php echo $key->goi_dv; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="clearfix" style="clear:both;"></div>
					        </div>
					        
					        <div class="wrap-shop">
					            <div class="shop">
					                <div class="left">Tên Shop</div>
					                <div class="right"><?php echo $key->ten_shop; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="shop">
					                <div class="left">SĐT Shop</div>
					                <div class="right"><?php echo $key->sdt_shop; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="shop">
					                <div class="left">Đ/C</div>
					                <div class="right"><?php echo $key->dia_chi_shop; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="shop">
					                <div class="left">Phường</div>
					                <div class="right"><?php echo $key->phuong_shop; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="shop">
					                <div class="left">Quận/huyện</div>
					                <div class="right"><?php echo $key->quan_huyen_shop; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="shop">
					                <div class="left">Mã xác minh</div>
					                <div class="right"><?php echo $key->pass; ?></div>
					                <div class="clearfix" style="clear:both;"></div>
					            </div>
					            <div class="clearfix" style="clear:both;"></div>
					        </div>

					        <div class="wrap-status">
					            <div class="left">Trạng thái</div>
					            <div class="right"><?php echo $key->trang_thai; ?></div>
					            <div class="clearfix" style="clear:both;"></div>
					        </div>
					        <div class="wrap-status">
					           <a href="/printer?id=<?php echo $key->id; ?>" style="background: #262626;color: #fff;border-radius: 10px;padding: 5px 10px;text-decoration: none;">In hóa đơn</a>
					            <div class="clearfix" style="clear:both;"></div>
					        </div>
					    </div>

				    <?php } ?>
				<?php else: ?>
					<h1 style="text-align: center;margin-top: 40px;font-size: 27px;">Không tồn tại đơn hàng nào</h1>
					<div style="text-align: center;margin-top: 10px;">
						<button><a href="/">Quay lại trang chủ</a></button>
					</div>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php 




 ?>

<?php get_footer(); ?>
