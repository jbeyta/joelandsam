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
				while (have_posts()){
					the_post();
					echo '<h2>'.get_the_title().'</h2>';
					echo '<p class="date">'.get_the_date('M j, Y').'</p>';
					the_content();

					$gallery_id = get_post_meta($post->ID, '_cwmb_gallery_id', true);

					if(!empty($gallery_id)) {
						$images = get_post_meta($gallery_id, '_cwmb_galler_imgs', true);

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
			?>
		</div>
	</div>

<?php get_footer(); ?>