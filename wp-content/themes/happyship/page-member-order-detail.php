<?php 
if ( !is_user_logged_in() ) {
    $login_url = home_url( 'member-login' );
    wp_redirect( $login_url );
}
?>
<?php get_header(); ?>
<?php if ( is_active_sidebar( 'sidebar-order-page' )) {
  $mainClass = 'span9';
  $sidebarClass = 'sidebar-right span3';
  }else{
    $mainClass = '';
    $sidebarClass = '';
   }
?>
<?php if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    if(isset($_GET['action'])&& $_GET['action'] == 'cancel' && isset($_GET['orderId'])){
        $id = $_GET['orderId'];
        // delete post order
        
    }
} ?>
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
<div class="main-contain">

  
  <div class="main-content">
   
      
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
                        <?php if ( is_active_sidebar( 'sidebar-order-page' )) : ?>
                        <div class="widget-area <?php echo $sidebarClass; ?>">
                            <?php dynamic_sidebar('sidebar-order-page'); ?>
                        </div>  
                        <?php endif; ?>
                        <div class="content-area <?php echo $mainClass; ?>">
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
                                
                                    <div class="order-items">
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
                                            <p><strong>Tình trạng :</strong><span><?php echo $status_order;?></span></p>
                                            <?php if($status_order == 'pending'):?>
                                            <p class="foot-action"><a href="<?php echo home_url('member-order-detail/?action=cancel&orderId=').$Id;?>">Chỉnh sửa đơn hàng</a></p>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                <?php endwhile;
                                endif; ?>
                                <nav class="pagination">
                                    <?php pagination_bar( $author_posts ); ?>
                                </nav>
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

<?php get_footer(); ?>