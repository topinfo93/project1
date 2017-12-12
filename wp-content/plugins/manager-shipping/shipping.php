<?php
    /*
    Plugin Name: Shipping Manager
    Plugin URI: http://giaohanghappy.com
    Description: a plugin to manager shipping
    Version: 1.0
    Author: Mr. Eleven
    Author URI: http://giaohanghappy.com
    */
    
    
    define( 'HAPPY_VERSION', '1.0.0' );
    define( 'HAPPY_PATH', plugin_dir_path( __FILE__ ) );
    define( 'HAPPY_URL', plugin_dir_url( __FILE__ ) );
    

register_activation_hook( __FILE__, 'my_plugin_create_db' );

function my_plugin_create_db() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'price_manager';
    $table_name2 = $wpdb->prefix . 'ordered_manager';
    $happyship_member = $wpdb->prefix. 'happyship_member';

    $sql = "CREATE TABLE $table_name (
        id int(9) NOT NULL AUTO_INCREMENT,
        nhan_hang varchar(255)  NULL,
        giao_hang varchar(255)  NULL,
        gia_tiet_kiem int(12)  NULL,
        gia_nhanh int(12)  NULL,
        super_happy int(12)  NULL,
        UNIQUE KEY id (id)
    ) $charset_collate;";

    $sql2 = "CREATE TABLE $table_name2 (
        id int(9) NOT NULL AUTO_INCREMENT,
        nguoi_nhan varchar(255)  NULL,
        sdt_nguoi_nhan varchar(255)  NULL,
        dia_chi_nguoi_nhan varchar(255)  NULL,
        quan_huyen_nhan varchar(255)  NULL,
        ten_hang varchar(255)  NULL,
        khoi_luong varchar(255)  NULL,
        thu_ho varchar(255)  NULL,
        goi_dv varchar(255)  NULL,
        ma_giam_gia varchar(255)  NULL,
        ten_shop varchar(255)  NULL,
        sdt_shop varchar(255)  NULL,
        dia_chi_shop varchar(255)  NULL,
        quan_huyen_shop varchar(255)  NULL,
        phuong_shop varchar(255)  NULL,
        pass varchar(255)  NULL,
        fee varchar(255)  NULL,
        trang_thai varchar(255)  NULL,
        ngay_tao_don varchar(255)  NULL,
        ngay_sua_don varchar(255)  NULL,
        UNIQUE KEY id (id)
      ) $charset_collate;";
    $sql_member = "CREATE TABLE $happyship_member (
        mid bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_name varchar(100) NOT NULL,
        user_pass varchar(255) NOT NULL,
        shop_name varchar(100) NOT NULL,
        user_email varchar(255) NOT NULL,
        shop_address varchar(255) DEFAULT NULL,
        shop_phone varchar(12) NOT NULL,
        status tinyint(1) NOT NULL DEFAULT '1',
        user_registered datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        display_name varchar(150) NOT NULL,
        PRIMARY KEY  (mid)
        
    ) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    dbDelta( $sql2 );
    dbDelta( $sql_member );
}

require_once( HAPPY_PATH . 'inc/init.php' );
require_once( HAPPY_PATH . 'inc/manager-shipping.php' );
    