<?php get_header(); 
?>
<?php if ( is_active_sidebar( 'manager-order-widget' )) {
	$mainClass = 'span8';
	$sidebarClass = 'sidrbar-right span4';
	}else{
	 	$mainClass = '';
		$sidebarClass = '';
	 }

?>
<?php if(isset($_SESSION['logged'])){
	var_dump($_SESSION['logged']);
}?>
<div class="main-contain">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="main-content">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<div class="breadcum-block">
	            <div class="container">
	                <div class="row-fluid">
	                    <a href="<?php echo home_url();?>" class="home">Trang chủ </a><span class="current"> > <?php the_title(); ?></span>
	                </div>
	            </div>
	        </div>

			<section class="main-content">
				<div class="container">
                    <div class="row-fluid">
                    	<div class="widget-area span4">
							<div class="widget wiget-menu">
								<h3 class="wiget-menu-tittle">Danh mục</h3>
								<ul class="customer_menu">
								
									<li class="current-menu"><a href="" class="active"> Tạo đơn hàng</a></li>
									<li><a href=""> Sửa thông tin cá nhân </a></li>
									<li><a href=""> Đăng xuất</a></li>

								</ul>
							</div>
							<div class="widget wiget-follow-order">
								<form id="follow_order" action="" method="POST">
									<h3 class="wiget-follow-order">Theo dõi đơn hàng</h3>
									<p class="form-row">
										<label for="order_id">Nhập mã đơn hàng:</label>
										<input type="text" name="order_id" id="order_id" class="style-happy" placeholder="Nhập mã đơn hàng bạn muốn theo dõi">
									</p>
								</form>
							</div>
							<div class="widget wiget-shop-info">
								<h3 class="wiget-follow-order">Thông tin tài khoản của tôi</h3>
								<div class="myaccount_content">
									<p><strong>Tên:</strong><span id="name_receiver"> name will changed here</span></p>
									<p><strong>Số điện thoại:</strong><span id="phone_receiver">000-000-0000</span></p>
									<p><strong>Địa chỉ :</strong><span id="add_receiver"> address will change here</span></p>
									<p><strong>Quận / Huyện :</strong><span id="type_service"> type 1</span></p>
									<p><strong>Email :</strong><span id="money_receiver"> 000.000đ</span></p>
									<p><a href="/update-info" id="change_info">Thay đổi thông tin</a></p>
								</div>
							</div>
						</div>
                    	<div class="content-area <?php echo $mainClass; ?>">
							<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
							<?php the_content(); ?>
							<div class="entry-links"><?php wp_link_pages(); ?></div>
						</div>
						<!-- <?php if ( is_active_sidebar( 'manager-order-widget' )) :?>
						<div class="widget-area <?php echo $sidebarClass; ?>">
							<?php get_sidebar('manager-order-widget'); ?>
						</div>	
						<?php endif;?> -->
						
					</div>
				</div>
			</section>
		</article>
	</div>
	<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
	<?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>