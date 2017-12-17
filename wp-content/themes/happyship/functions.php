<?php
define('HAPPYSHIP_DIR', trailingslashit(get_template_directory()));
define( 'HAPPYSHIP_LINK', trailingslashit( get_template_directory_uri()));
add_action('after_setup_theme', 'blankslate_setup');


function blankslate_setup()
{
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    global $content_width;
    if (!isset($content_width))
        $content_width = 1170;
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'blankslate')
    ));
}
add_action('wp_enqueue_scripts', 'blankslate_load_scripts');
function blankslate_load_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'custom', HAPPYSHIP_LINK . '/js/custom.js', array(), '1.0.0', true );
}

add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => "</li>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));

    register_sidebar( array (
        'name' => esc_html__( 'Sidebar Slider', 'iseo' ),
        'id' => 'slider-widget',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ) );

    register_sidebar( array (
        'name' => esc_html__( 'Sidebar Manager Order', 'iseo' ),
        'id' => 'manager-order-widget',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>",
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ) );
}

register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'iseo' ),
        'footer' => esc_html__( 'Footer Menu', 'iseo' )
    ) );
//////////////////////////////////
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/style-login.css' );
    
}

// add_action( 'admin_enqueue_scripts', 'load_admin_style' );



// function load_admin_style() {
//     wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
// }

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Vận đơn';
    $submenu['edit.php'][5][0] = 'Vận đơn';
    $submenu['edit.php'][10][0] = 'Tạo vận đơn';
    $submenu['edit.php'][16][0] = 'News Tags';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Vận đơn';
    $labels->singular_name = 'Vận đơn';
    $labels->add_new = 'Tạo vận đơn';
    $labels->add_new_item = 'Tên hàng hóa'; 
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'Vận đơn';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'Vận đơn';
    $labels->name_admin_bar = 'Vận đơn';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}
/* render template creat new order*/
function get_template_html($template_name, $attributes = null )
{
    if ( ! $attributes ) {
            $attributes = array();
        }
     
        ob_start();
     
        do_action( 'personalize_login_before_' . $template_name );
     
        require( 'templates/' . $template_name . '.php');
     
        do_action( 'personalize_login_after_' . $template_name );
     
        $html = ob_get_contents();
        ob_end_clean();
     
        return $html;
}
