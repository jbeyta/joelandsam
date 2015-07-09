<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<div role="main">
	<div class="search main-content row">
		<div class="small-12 medium-9 medium-push-3 large-9 large-push-3 columns">
			<?php

				if ( have_posts() && strlen( trim(get_search_query()) ) != 0) {
					echo '<h2 class="page-title">Results for: &ldquo;'.get_search_query().'&rdquo;</h2>';

					while ( have_posts() ) {
						the_post();
						get_template_part( 'content', 'search' );
					}
				} elseif(have_posts() && strlen( trim(get_search_query()) ) == 0) {
					echo '<h2 class="page-title">Oops! Nothing was put into the search field.</h2>';
				} else {
					echo '<h2 class="page-title">Nothing found for: &ldquo;'.get_search_query().'&rdquo;</h2>';
				}		
			?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer();