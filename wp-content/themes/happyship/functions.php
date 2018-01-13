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
    wp_enqueue_style( 'happyship', get_template_directory_uri() . '/css/style.css', array(), '3.2' );
    wp_enqueue_style( 'happyship-theme', get_template_directory_uri() . '/css/theme.css', array(), '3.2' );
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'custom', HAPPYSHIP_LINK . '/js/custom.js', array(), '1.0.0', true );
    wp_enqueue_script( 'jquery.validate', HAPPYSHIP_LINK . '/js/jquery.validate.js', array(), '1.0.0', true );
    wp_enqueue_script( 'jquery.happyship', HAPPYSHIP_LINK . '/js/happyship.js', array(), '1.0.0', true );
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

// function revcon_change_post_label() {
//     global $menu;
//     global $submenu;
//     $menu[5][0] = 'Vận đơn';
//     $submenu['edit.php'][5][0] = 'Vận đơn';
//     $submenu['edit.php'][10][0] = 'Tạo vận đơn';
//     $submenu['edit.php'][16][0] = 'News Tags';
// }
// function revcon_change_post_object() {
//     global $wp_post_types;
//     $labels = &$wp_post_types['post']->labels;
//     $labels->name = 'Vận đơn';
//     $labels->singular_name = 'Vận đơn';
//     $labels->add_new = 'Tạo vận đơn';
//     $labels->add_new_item = 'Tên hàng hóa'; 
//     $labels->edit_item = 'Edit News';
//     $labels->new_item = 'Vận đơn';
//     $labels->view_item = 'View News';
//     $labels->search_items = 'Search News';
//     $labels->not_found = 'No News found';
//     $labels->not_found_in_trash = 'No News found in Trash';
//     $labels->all_items = 'All News';
//     $labels->menu_name = 'Vận đơn';
//     $labels->name_admin_bar = 'Vận đơn';
// }
 
// add_action( 'admin_menu', 'revcon_change_post_label' );
// add_action( 'init', 'revcon_change_post_object' );

add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}


add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() { 
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}

add_action( 'init', 'blockusers_init' );

function blockusers_init() {
    if ( is_admin() && ! current_user_can( 'administrator' ) &&
    ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
    wp_redirect( home_url() );
    exit;
    }
}

function happy_get_meta($meta_name){
    if ( is_user_logged_in() ) {

        return get_user_meta(get_current_user_id(),$meta_name,true );

    }
}
function starter_scripts() {
    wp_enqueue_style( 'jquery_popup_style', get_template_directory_uri() .'/css/jquery-confirm.min.css' );
     wp_enqueue_script( 'jquery_popup_master', get_template_directory_uri() . '/js/jquery-confirm.min.js', array('jquery'), '3.0.0', true );
    }
add_action('wp_enqueue_scripts', 'starter_scripts');

function pagination_bar( $custom_query ) {

    $total_pages = $custom_query->max_num_pages;
    $big = 999999999; // need an unlikely integer
    var_dump(get_query_var('paged'));
    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));

        echo paginate_links(array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'prev_text'          => __('«'),
            'next_text'          => __('»'),
            'current' => $current_page,
            'total' => $total_pages,
        ));
    }
}
function pagination_admin_bar( $custom_query ) {

    $total_pages = $custom_query->max_num_pages;
    $big = 999999999; // need an unlikely integer
    if ($total_pages > 1){
        $current_page = max(1, $_GET['paged']);
        echo paginate_links(array(
            'base' =>  @add_query_arg('paged','%#%'),
            'format' => '?paged=%#%',
            'prev_text'          => __('«'),
            'next_text'          => __('»'),
            'current' => $current_page,
            'total' => $total_pages,
            //'add_args'=> $arr_params
        ));
    }
}
add_action( 'widgets_init', 'theme_slug_widgets_init' );
function theme_slug_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Order Sidebar', 'theme-happyship' ),
        'id' => 'sidebar-order-page',
        'description' => __( 'Widgets in this area will be shown on all posts order.', 'theme-happyship' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
}

// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
 
// Creating the widget 
class wpb_widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(
         
        // Base ID of your widget
        'wpb_widget', 
         
        // Widget name will appear in UI
        __('WPBeginner Widget', 'wpb_widget_domain'), 
         
        // Widget description
        array( 'description' => __( 'Hiển thị thông tin khách hàng', 'wpb_widget_domain' ), ) 
        );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
     
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
    $current_user = wp_get_current_user();$id = $current_user->ID;
    $ten = $current_user->user_nicename;
    $email = $current_user->user_email;
    $mobile = get_user_meta($id,user_phone,true);
    $shop_name = $current_user->display_name;
    $shop_address = get_user_meta($id,shop_address,true);
    echo "<p><strong>Họ tên:</strong><span> ".$ten." </span></p>";
    echo "<p><strong>Email:</strong><span> ".$email." </span></p>";
    echo "<p><strong>Phone:</strong><span> ".$mobile." </span></p>";
    echo "<p><strong>Tên Shop:</strong><span> ".$shop_name." </span></p>";
    echo "<p><strong>Địa chỉ:</strong><span> ".$shop_address." </span></p>";
    echo '<a href="" class="link_change_info"> Đổi Thông tin</a>';
    echo $args['after_widget'];
    }
             
    // Widget Backend 
    public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    }
    else {
    $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
    }
         
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
    }
} // Class wpb_widget ends here