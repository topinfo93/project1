<?php /* Template Name: Build Order */ 
require_once(get_template_directory().'/PHPMailer/mailer.php');


global $wpdb;

if (isset($_SESSION['logged'])):

	$results = $wpdb->get_results('SELECT * FROM `wp_ordered_manager` WHERE `sdt_shop` = "'.$_SESSION['logged'].'"', OBJECT );

	$inserted = $wpdb->query("INSERT INTO `wp_ordered_manager` (`id`, `nguoi_nhan`, `sdt_nguoi_nhan`, `dia_chi_nguoi_nhan`, `quan_huyen_nhan`, `ten_hang`, `khoi_luong`, `thu_ho`, `goi_dv`, `ma_giam_gia`,`ten_shop`, `sdt_shop`, `dia_chi_shop`, `quan_huyen_shop`, `phuong_shop`, `pass`, `fee`, `trang_thai`) VALUES (NULL, '".$_POST['kh_ten']."', '".$_POST['kh_sdt']."', '".$_POST['kh_dc']."', '".$_POST['kh_quan']."', '".$_POST['kh_hanghoa']."', '".$_POST['kh_kl']."', '".$_POST['kh_tth']."', '".$_POST['kh_goi']."', '".$_POST['code']."','".$results[0]->ten_shop."', '".$results[0]->sdt_shop."', '".$results[0]->dia_chi_shop."', '".$results[0]->quan_huyen_shop."', '".$results[0]->phuong_shop."', '".$results[0]->pass."','".$_POST['fee']."', 'wait');");

	if($inserted == 1){
        happy_mail($wpdb->insert_id);
		header('Location: '.get_home_url().'/success/?id='.$wpdb->insert_id);

	}else{

		header('Location: '.get_home_url());

	}

else:

	if($_POST['pass1'] === $_POST['pass2'] && $_POST['pass1'] != '' ){
		
		$inserted = $wpdb->query("INSERT INTO `wp_ordered_manager` (`id`, `nguoi_nhan`, `sdt_nguoi_nhan`, `dia_chi_nguoi_nhan`, `quan_huyen_nhan`, `ten_hang`, `khoi_luong`, `thu_ho`, `goi_dv`, `ma_giam_gia`,`ten_shop`, `sdt_shop`, `dia_chi_shop`, `quan_huyen_shop`, `phuong_shop`, `pass`, `fee`, `trang_thai`) VALUES (NULL, '".$_POST['kh_ten']."', '".$_POST['kh_sdt']."', '".$_POST['kh_dc']."', '".$_POST['kh_quan']."', '".$_POST['kh_hanghoa']."', '".$_POST['kh_kl']."', '".$_POST['kh_tth']."', '".$_POST['kh_goi']."', '".$_POST['code']."','".$_POST['shop_ten']."', '".$_POST['shop_sdt']."', '".$_POST['shop_dc']."', '".$_POST['shop_quan']."', '".$_POST['shop_phuong']."', '".$_POST['pass1']."','".$_POST['fee']."', 'wait');");
	}

	if($inserted == 1){
		$lastid = $wpdb->insert_id;
		$results = $wpdb->get_results( 'SELECT * FROM `wp_ordered_manager` WHERE `id` = '.$lastid, OBJECT );
		$_SESSION['logged'] = $results[0]->sdt_shop;

		header('Location: '.get_home_url().'/success/?id='.$wpdb->insert_id);

	}else{

		header('Location: '.get_home_url());

	}



endif;
?>