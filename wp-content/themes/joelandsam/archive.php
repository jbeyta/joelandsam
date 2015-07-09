<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div class="main row" role="main">
		<div class="small-12 medium-8 large-8 columns">
			<?php if ( have_posts() ) : ?>
				<header class="archive-header">
					<h2 class="archive-title"><?php
						if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'cw' ), '<span>' . get_the_date() . '</span>' );
						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'cw' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'cw' ) ) . '</span>' );
						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'cw' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'cw' ) ) . '</span>' );
						else :
							_e( 'Archives', 'cw' );
						endif;
					?></h2>
				</header><!-- .archive-header -->

				<?php /* Start the Loop */
				// use line below to change sort order
				// $posts = query_posts($query_string .'&orderby=title&order=asc&posts_per_page=-1'); 
				while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_format() );
				endwhile;
				?>
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>
		</div>

		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>