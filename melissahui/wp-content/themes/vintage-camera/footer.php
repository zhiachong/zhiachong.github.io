<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Vintage Camera
 * @since Vintage Camera 1.0
 */

 global $vintage_camera_footerimgext;
?>
		<?php vintage_camera_content_nav( 'nav-below' ); ?>
	</div><!-- #main -->

	<div class="sidebars">
		<?php get_sidebar(); ?>
		<?php get_sidebar( '2' ); ?>
		<?php get_sidebar( '3' ); ?>
	</div>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'vintage_camera_credits' ); ?>
			<a href="<?php echo esc_url( 'http://www.carolinemoore.net' ); ?>" target="_blank" title="<?php _e( 'Vintage Camera Theme by Caroline Moore' , 'vintage-camera' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/img/cameraicon<?php echo $vintage_camera_footerimgext ?>.png" alt="<?php _e( 'Vintage Camera Theme by Caroline Moore' , 'vintage-camera' ); ?>" /></a>
		<img src="<?php echo get_template_directory_uri() ?>/img/copyright<?php echo $vintage_camera_footerimgext ?>.png" alt="<?php _e( 'Copyright' , 'vintage-camera' ); ?> <?php echo date('Y'); ?> <?php bloginfo('name'); ?>" title="<?php _e( 'Copyright' , 'vintage-camera' ); ?> <?php echo date('Y'); ?> <?php bloginfo('name'); ?>" />
		<a href="http://www.wordpress.org" target="_blank" title="<?php _e( 'Powered by WordPress' , 'vintage-camera' ); ?>"><img src="<?php echo get_template_directory_uri() ?>/img/wordpresslogo<?php echo $vintage_camera_footerimgext ?>.png" alt="<?php _e( 'Powered by WordPress' , 'vintage-camera' ); ?>" /></a>
		</div><!-- .site-info -->
	</footer><!-- .site-footer .site-footer -->
</div><!-- #page .hfeed .site -->

<?php
$menu = has_nav_menu('headermenu');
if ( isset( $menu ) && $menu ) { ?>
	<div class="navbar">
		<nav role="navigation" class="site-navigation main-navigation">
			<h1 class="assistive-text"><?php _e( 'Menu', 'vintage-camera' ); ?></h1>
			<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'vintage-camera' ); ?>"><?php _e( 'Skip to content', 'vintage-camera' ); ?></a></div>
			<?php wp_nav_menu( array( 'container_id' => 'header-menu', 'theme_location' => 'headermenu' ) ); ?>
			<div class="searchbar">
				<?php get_search_form(); ?>
			</div>
		</nav>
	</div>
<?php } ?>

<?php wp_footer(); ?>
</body>
</html>