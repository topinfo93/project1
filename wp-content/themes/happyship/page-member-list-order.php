<?php 
if ( !is_user_logged_in() ) {
    $login_url = home_url( 'member-login' );
    wp_redirect( $login_url );
}
?>
<?php get_header('order'); ?>
<?php if ( is_active_sidebar( 'sidebar-order-page' )) {
  $mainClass = 'span9';
  $sidebarClass = 'sidebar-right span3';
  }else{
    $mainClass = '';
    $sidebarClass = '';
   }
?>
<?php if(is_user_logged_in()) :
    global $current_user;
    wp_get_current_user();
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $author_query = array(
      'posts_per_page' => '12',
      'author' => $current_user->ID,
      'post_type'=> 'happyship',
      'paged' => $paged
    );
    $author_posts = new WP_Query($author_query);
?>
<?php if($_SERVER['REQUEST_METHOD'] =="POST"){
    if(isset($_POST['id_order_update']) && isset($_POST['status_order_update'])){
        $oid = $_POST['id_order_update'];
        $status_order_update = $_POST['status_order_update'];
        if(get_post_meta( $oid, 'status_order', true )){
            $update = update_post_meta($oid,'status_order',$status_order_update);
            if($update){
                $alermessenger = __('Bạn đã cập nhật đơn hàng OD'.$oid.' thành công!','happyship-member');
            }else{
                $alermessenger = __('Cập nhật đơn hàng OD'.$oid.' thất bại!','happyship-member');
            }
        }
    }
}?>
<div class="main-contain">

  
  <div class="main-content">
   
      
        <!-- <div class="filter-block">
            <div class="container">
                <div class="row-fluid">
                    <p class="filter-box span4">
                        <label for="filterby-status">Tình trạng</label>
                        <select name="filterby-status" id="filterby-status">
                            <option value="all">Tất cả</option>
                            <option value="pending">Đang xử lý</option>
                            <option value="transformed">Đã giao</option>
                            <option value="processed">Hoàn thành</option>
                            <option value="cancel">Đã hủy</option>
                        </select>
                    </p>
                    <p class="filter-box span4">
                        <label for="filterby-date">Thời gian</label>
                        <select name="filterby-date" id="filterby-date">
                            <option value="">Chọn ngày / tháng)</option>
                            <option value="pending">Đang xử lý</option>
                            <option value="transformed">Đã giao</option>
                            <option value="processed">Hoàn thành</option>
                            <option value="cancel">Đã hủy</option>
                        </select>
                    </p>
                </div>
            </div>
        </div> -->

        <section class="main-content">
            <div class="container">
                    <div class="row-fluid">
                        <div class="content-area">
                            <p>
                                <a href="<?php echo home_url('member-create-order');?>" class="button"> Tạo đơn hàng</a>
                            </p>
                        </div>
                        <?php //if ( is_active_sidebar( 'sidebar-order-page' )) : ?>
                       <!--  <div class="widget-area <?php //echo $sidebarClass; ?>">
                            <?php //dynamic_sidebar('sidebar-order-page'); ?>
                        </div>   -->
                        <?php //endif; ?>
                        <div class="content-area <?php //echo $mainClass; ?>">
                            <?php if(isset($alermessenger) && $alermessenger!=''):?>
                                <div class="messenger_alert">
                                    <p class="alert"><?php echo $alermessenger;?></p>
                                </div>
                            <?php endif;?>
                            <!-- <p>
                                <a href="<?php// echo home_url('member-create-order');?>" class="button"> Tạo đơn hàng</a>
                            </p> -->
                            <?php if ( $author_posts->have_posts() ) : 
                                while( $author_posts->have_posts() ) : $author_posts->the_post(); 
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
                                
                                    <div class="order-items span4 <?php if($status_order == 'cancel'){echo 'canceled';}?>">
                                        <div class="order-content">
                                            <p class="order_tittle"><?php echo $ODtittle;?></p>
                                            <p><strong>Người nhận :</strong><span><?php echo $kh_ten;?></span></p>
                                            <p><strong>Số ĐT nhận :</strong><span><?php echo $kh_sdt;?></span></p>
                                            <p><strong>Địa chỉ nhận :</strong><span><?php echo $kh_dc;?></span></p>
                                            <p><strong>Thuộc Quận/Huyện :</strong><span><?php echo $kh_quan;?></span></p>
                                            <p><strong>Loại hàng :</strong><span><?php echo $kh_hanghoa;?></span></p>
                                            <p><strong>Khối lượng :</strong><span><?php echo $kh_kl;?></span></p>
                                            <p><strong>Số tiền thu hộ :</strong><span><?php echo $kh_tth;?></span></p>
                                            <p><strong>Gói vận chuyển :</strong><span><?php echo $kh_goi;?></span></p>
                                            <?php if($status_order == 'pending'):?>
                                            <form action="<?php echo home_url("member-list-order");?>" class="mem_update_storder" method="POST">
                                                <p><strong>Tình trạng :</strong><span>
                                                    <select style="width: 60%" id="status_order_update" name="status_order_update">
                                                    <?php
                                                    $status = array(
                                                        'pending'=> 'đang xử lý',
                                                        'cancel'=> 'Hủy đơn hàng'
                                                    );
                                                    foreach ($status as $sts => $value) { ?>
                                                        <option value="<?php echo $sts; ?>" <?php echo selected( $sts, $status_order ); ?>>
                                                        <?php echo $value; ?> <?php } ?></option>
                                                    </select>
                                                </span></p>
                                                <input type="hidden" name="id_order_update" value="<?php echo $Id; ?>">
                                                <p class="foot-action">
                                                    <input type="submit" name="update_status_od" class="button confirm-button" value="Cập nhật đơn hàng">
                                                </p>
                                            </form>
                                           
                                            
                                                <?php else:?>
                                                    <p><strong>Tình trạng :</strong><span><?php echo $status_order;?></span></p>

                                                <?php endif;?>   
                                            
                                            
                                        </div>
                                    </div>
                                <?php endwhile;
                                endif; ?>
                                <?php if(($count_posts = wp_count_posts( 'happyship' )->publish) > 12) : ?>
                                <nav class="pagination">
                                    <?php pagination_bar( $author_posts ); ?>
                                </nav>
                            <?php endif; ?>
                            <div class="entry-links"><?php wp_link_pages(); ?></div>
                        </div>
                        
                        <?php wp_reset_postdata();?>
                  </div>
            </div>
        </section>
    
    </div>
    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
    
    <?php
    else :
        echo "not logged in";
    endif; ?>
</div>

<?php get_footer('order'); ?>