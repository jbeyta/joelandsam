<?php
/**
 * Template Name: Testimonials Template
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>
	<div class="testimonialsrow" role="main">
		<div class="small-12 medium-8 large-8 columns">
			<?php if (have_posts()) : while (have_posts()) : the_post();
				echo '<h2 class="page-title">'.get_the_title().'</h2>';
				the_content();
			endwhile; endif; ?>
			<hr>		
			<?php 
				$post_type = 'testimonials';
				$post_args = array(
					'post_type' => $post_type,
					'posts_per_page' => -1,
					'orderby' => 'date',
					'order' => 'DESC'
				);

				$posts = new WP_Query($post_args);
				if($posts->have_posts()){
					while($posts->have_posts()){
						$posts->the_post();

						the_title();
						the_post_thumbnail();
						the_content();

						echo '<pre>';
						print_r(get_post_meta($post->ID));
						echo '</pre>';

					}
				} else {
					echo '<p>No '.$post_type.' yet. Check back soon</p>';
				}

				wp_reset_query();
			?>
		</div>

		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>