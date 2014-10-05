<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Vintage Camera
 * @since Vintage Camera 1.0
 */

if ( ! function_exists( 'vintage_camera_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 */
function vintage_camera_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<div class="ribbon-left"></div>
	<div class="blackbar">
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'vintage-camera' ); ?></h1>

		<?php if ( is_single() ) : // navigation links for single posts ?>

			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&laquo;', 'Previous post link', 'vintage-camera' ) . '</span> %title' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&raquo;', 'Next post link', 'vintage-camera' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Previous', 'vintage-camera' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Next <span class="meta-nav">&raquo;</span>', 'vintage-camera' ) ); ?></div>
				<?php endif; ?>

		<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	</div><!-- .blackbar -->
	<div class="ribbon-right"></div>
	<?php
}
endif; // vintage_camera_content_nav


if ( ! function_exists( 'vintage_camera_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function vintage_camera_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'vintage-camera' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'vintage-camera' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'vintage-camera' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'vintage-camera' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'vintage-camera' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( 'Edit', 'vintage-camera' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for vintage_camera_comment()


if ( ! function_exists( 'vintage_camera_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function vintage_camera_posted_on() {
	echo '<div class="post-date">';
	echo '<a href="' . get_permalink() . '" rel="bookmark" title="' . __( 'Permanent Link to' , 'vintage-camera' ) . get_the_title() . '">';

	if( get_post_type() !== 'page' ) {
		echo '<span class="post-month">' . get_the_time('M') . '</span> ';
		echo '<span class="post-day">' . get_the_time('j') . '</span> ';
	} else {
		echo '<span class="page-post-month">Page</span>';
	}
	echo '</a>';
	echo '</div>';
}
endif;


/**
 * Returns true if a blog has more than 1 category
 *
 * @since Vintage Camera 1.0
 */
function vintage_camera_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so vintage_camera_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so vintage_camera_categorized_blog should return false
		return false;
	}
}


/**
 * Flush out the transients used in vintage_camera_categorized_blog
 *
 * @since Vintage Camera 1.0
 */
function vintage_camera_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'vintage_camera_category_transient_flusher' );
add_action( 'save_post', 'vintage_camera_category_transient_flusher' );