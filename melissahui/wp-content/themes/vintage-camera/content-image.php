<?php
/**
 * The template used for displaying image content
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
		<?php
			if ( '' != get_the_post_thumbnail() ) { ?>
				<div class="wp-caption">
					<?php the_post_thumbnail(); ?>
					<div class="wp-caption-text"><?php the_title(); ?></div>
				</div>
			<?php
			}
			else {
				the_content();
			} ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->