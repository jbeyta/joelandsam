<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
if ( post_password_required() )
	return;
?>

	<div class="row">
		<div class="large-12 columns comments">
			<?php comment_form(); ?>
		
			<?php if ( have_comments() ) : ?>
				<h4 class="comments-title">
					<?php
						printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title' ),
							number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
					?>
				</h4>

				<ol class="comment-list">
					<?php
						wp_list_comments( array(
							'style'       => 'ol',
							'short_ping'  => true,
							'avatar_size' => 74,
						) );
					?>
				</ol><!-- .comment-list -->

				<?php
					// Are there comments to navigate through?
					if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				?>
				<nav class="comment-navigation">
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;' ) ); ?></div>
				</nav><!-- .comment-navigation -->
				<?php endif; // Check for comment navigation ?>

				<?php if ( ! comments_open() && get_comments_number() ) : ?>
					<p class="no-comments"><?php _e( 'Comments are closed.' ); ?></p>
				<?php endif; ?>
			<?php endif; // have_comments() ?>
		</div>
	</div>