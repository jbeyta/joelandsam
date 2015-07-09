<?php
/**
 * Template Name: Staff w/ categories Page Template
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>
	<div role="main" class="staff-cats row">
		<h2 class="page-header"><?php the_title(); ?></h2>
		<div class="small-12 medium-8 large-8 columns">
			<!-- get categories -->
			<?php
				$post_type = 'staff';
				$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type) );
				foreach( $taxonomies as $taxonomy ) {

				// get category terms
				$terms = get_terms( $taxonomy );
				foreach( $terms as $term ) { ?>
					<!-- display the terms -->
					<h2 class="section-header"><?php echo $term->name ?></h2>
					<div>
					<!-- get the posts -->
					<?php
						$args = array(
							'post_type' => $post_type,
							'posts_per_page' => -1,
							'orderby' => 'title',
							'order' => 'ASC',
							'tax_query' => array(
								array(
									'taxonomy' => $taxonomy,
									'field' => 'slug',
									'terms' => $term
								)
							)
						);
						$posts = new WP_Query( $args );
						if( $posts->have_posts() ) {
							while( $posts->have_posts() ) {
								$posts->the_post(); ?>
								<div class="listing large-6 columns">
									<div class="inner">

										<!-- check for image -->
										<?php if( has_post_thumbnail() ) { ?><figure class="listing-image"><?php the_post_thumbnail() ?></figure><?php }?>
										<div class="listing-info<?php if( has_post_thumbnail() ) { ?> has-image<?php }?>">
											<!-- all of the info, if it exists -->
											<a href="<?php the_permalink()?>"><h3><?php the_title() ?></h3></a>
											<p><?php $phone = get_post_meta($post->ID, "_phone", true); if ( !empty( $phone ) ) { ?><?php echo $phone ?><?php } ?></p>
											<?php $email = get_post_meta($post->ID, "_email", true); if ( !empty( $email ) ) { ?><a href="mailto:<?php echo $email ?>">Email</a><?php } ?>
											<?php $link = get_post_meta($post->ID, "_link", true); if ( !empty( $link ) ) { ?><a href="mailto:<?php echo $link ?>"><?php echo $link ?></a><?php } ?>

										</div>
									</div>
								</div>
							<?php } // end while have_posts
						} // end if have_posts ?>
					</div>
				<?php } // end foreach $terms
			} // end foreach $taxonomies
			wp_reset_query(); ?>
		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>