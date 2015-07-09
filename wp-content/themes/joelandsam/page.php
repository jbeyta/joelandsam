<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div class="main row" role="main">
		<div class="small-12 medium-8 medium-offset-2 large-8 large-offset-2 columns">
			<?php
				if(have_posts()) {
					while(have_posts()) {
						the_post();
						echo '<h2 class="page-title">'.get_the_title().'</h2>';
						the_content();
						// comments_template( '', true );
					}
				}
			?>
		</div>
	</div>

<?php get_footer(); ?>