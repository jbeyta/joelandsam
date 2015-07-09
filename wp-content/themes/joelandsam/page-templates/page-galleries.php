<?php
/**
 * Template Name: Galleries Template
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>
	<div class="links row" role="main">
		<div class="small-12 medium-8 medium-offset-2 large-8 large-offset-2 columns">
			<?php if (have_posts()) : while (have_posts()) : the_post();
				echo '<h2 class="page-title">'.get_the_title().'</h2>';
				the_content();
			endwhile; endif; ?>
			<hr>		
			<?php 
				$taxonomy = 'galleries_categories';
				$terms = get_terms($taxonomy);

				if(!empty($terms)) {
					foreach ($terms as $term) {
						$slug = $term->slug;

						echo '<h4>'.$term->name.'</h4>';

						$gargs = array(
							'post_type' => 'galleries',
							'posts_per_page' => -1,
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'tax_query' => array(
								array(
									'taxonomy' => $taxonomy,
									'field' => 'slug',
									'terms' => $slug
								)
							)
						);

						$galleries = new WP_Query($gargs);
						if($galleries->have_posts()) {
							while($galleries->have_posts()) {
								$galleries->the_post();
								$images = get_post_meta($post->ID, '_cwmb_galler_imgs', true);

								echo '<h5>'.get_the_title().'</h5>';

								if(!empty($images)) {
									echo '<ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-4">';
									foreach ($images as $image) {
										$cropped = aq_resize( $image, 200, 200, true, true, true );
										echo '<li><a href="'.$image.'" data-lightbox="gal-'.$slug.'"><img src="'.$cropped.'" alt="" /></a></li>';
									}
									echo '</ul>';
								}
							}
						}
						echo '<hr>';
					}
				}

				wp_reset_query();
			?>
		</div>
	</div>

<?php get_footer(); ?>