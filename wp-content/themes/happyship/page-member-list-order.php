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

      
       

            <div class="wrapper">
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
                    <div class="grid-box-wrap">
                        <?php if(isset($alermessenger) && $alermessenger!=''):?>
                            <div class="messenger_alert">
                                <p class="alert"><?php echo $alermessenger;?></p>
                            </div>
                        <?php endif;?>
                        <h1>Danh sách đơn hàng</h1>
                        <hr class="line-up">
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
                                <div class="box-item <?php if($status_order =='cancel'){ echo "canceled";}?>">
                                    <div class="box-shop-name"><span>Người nhận:</span><?php echo $kh_ten;?>
                                    </div>
                                    <div class="to-info">
                                        <dl>
                                            <dt>Điện thoại:</dt>
                                            <dd><?php echo $kh_sdt;?></dd>
                                            <dt>Địa chỉ:</dt>
                                            <dd><?php echo $kh_dc;?></dd>
                                            <dt>Quận/huyện:</dt>
                                            <dd><?php echo $kh_quan;?></dd>
                                            <dt>Hàng hóa:</dt>
                                            <dd><?php echo $kh_hanghoa;?></dd>
                                            <dt>Khối lượng:</dt>
                                            <dd><?php echo $kh_kl;?></dd>
                                            <dt>Tiền thu hộ:</dt>
                                            <dd><?php echo $kh_tth;?></dd>
                                        </dl>
                                    </div>
                                    <?php if($status_order == 'pending'):?>
                                    <form action="<?php echo home_url("member-list-order");?>" class="mem_update_storder" method="POST">
                                        <div class="status"><span><?php echo $ODtittle;?></span>
                                            <select id="status_order_update" name="status_order_update">
                                                <?php $status = array(
                                                    'pending'=> 'đang xử lý',
                                                    'cancel'=> 'Hủy đơn hàng'
                                                );
                                                foreach ($status as $sts => $value) { ?>
                                                    <option value="<?php echo $sts; ?>" <?php echo selected( $sts, $status_order ); ?>>
                                                    <?php echo $value; ?> <?php } ?></option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="id_order_update" value="<?php echo $Id; ?>">
                                        <p class="foot-action">
                                            <input type="submit" name="update_status_od" class="button confirm-button" value="Lưu">
                                        </p>
                                    </form>
                                    <?php else:?>
                                        <div class="status"> <span><?php echo $ODtittle;?></span><?php echo $status_order;?></div>
                                    <?php endif;?>
                                </div>
                                
                            <?php endwhile;
                            endif; ?>
                            <?php if(($count_posts = wp_count_posts( 'happyship' )->publish) > 12) : ?>
                            <nav class="pagination">
                                <?php pagination_bar( $author_posts ); ?>
                            </nav>
                        <?php endif; ?>
                        
                    </div>
                    
                    <?php wp_reset_postdata();?>
              </div>
        </div>
    
    
    
    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
    
    <?php
    else :
        echo "not logged in";
    endif; ?>


<?php get_footer('order'); ?>