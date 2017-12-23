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
                    	<?php if ( is_active_sidebar( 'sidebar-order-page' )) : ?>
                        <div class="widget-area <?php echo $sidebarClass; ?>">
                            <?php dynamic_sidebar('sidebar-order-page'); ?>
                        </div>  
                        <?php endif; ?>
                    	<div class="content-area <?php echo $mainClass; ?>">
							<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
							<?php the_content(); ?>
							<div class="entry-links"><?php wp_link_pages(); ?></div>
						</div>
						<?php if ( is_active_sidebar( 'primary-widget-area' ) || is_active_sidebar( 'slider-widget' ) ) : ?>
						<div class="widget-area <?php echo $sidebarClass; ?>">
							<?php get_sidebar(); ?>
						</div>	
						<?php endif;?>
					</div>
				</div>
			</section>
		</article>
	</div>
	<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
	<?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>