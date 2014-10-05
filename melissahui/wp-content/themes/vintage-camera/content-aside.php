<?php
/**
 * The template used for displaying aside content
 *
 * @package Vintage Camera
 * @since Vintage Camera 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php edit_post_link( __( 'Edit', 'vintage-camera' ) , '', ''); ?>
		<div class="entry-meta">
			<?php vintage_camera_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="divider"></div>
		<?php the_content(); ?>
		<div class="divider"></div>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->