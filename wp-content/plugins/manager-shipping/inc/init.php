<?php 




function happy_enqueue_script()
{   
	wp_enqueue_style('bootstrap', HAPPY_URL . 'css/bootstrap.min.css');
	wp_enqueue_style('happy_custom_style', HAPPY_URL . 'css/happy.css');
    wp_enqueue_script( 'happy_custom_script', HAPPY_URL . 'js/happy.js' );
    wp_localize_script('sb-admin', 'sb_admin_ajax', array('url' => admin_url('admin-ajax.php')));
}
add_action('admin_enqueue_scripts', 'happy_enqueue_script');


function sb_test_ajax_callback() {
	global $wpdb;
	$shop_quan = 'Quan-1';
	$kh_quan = $_POST['kh_quan'];
	$kh_goi = $_POST['kh_goi'];

	$results = $wpdb->get_results( "SELECT * FROM `wp_price_manager` WHERE `nhan_hang` = '$shop_quan' AND `giao_hang` = '$kh_quan'", OBJECT);
	
	echo $results[0]->$kh_goi; 
}
add_action('wp_ajax_sb_test_ajax', 'sb_test_ajax_callback');