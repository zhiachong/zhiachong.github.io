<?php
/**
 * The template used for displaying gallery content
 *
 * @package Vintage Camera
 * @since Vintage Camera 1.0
 */

global $post;

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

		$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
		if ( $images ) { ?>
			<div class="wp-caption">
			<?php

			$total_images = count( $images );
			$count = 1;
			foreach( $images as $image ) {
				if( $count <=3 ) {
				?>
					<a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title(); ?>"><?php echo wp_get_attachment_image( $image->ID, 'thumbnail' ); ?></a>
				<?php
					$count++;
				}
			}

			?>
			<p class="wp-caption-text"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title(); ?>"><?php the_title(); ?> - <?php printf( _n( '%1$s photo &#187;', '%1$s photos &#187;', $total_images, "vintage-camera" ), number_format_i18n( $total_images ) ); ?></a></p></div>
		<?php
		}
		else {
			the_content();
		} ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->