<?php
	if(is_404() || is_search() || is_home())
		return;

	global $post;
	$page_id = $post->ID;
	
	$slides_args = array(
		'post_type' => 'slides',
		'posts_per_page' => -1,
		'meta_key' => '_cwmb_slide_page',
		'meta_value' => $page_id,
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);

	$the_slides = new WP_Query($slides_args);

	// echo_pre($page_id);

	if($the_slides->have_posts()){
		echo '<div class="cw-slideshow">';
			echo '<ul class="styleless cw-slider">';
			while($the_slides->have_posts()) {
				$the_slides->the_post();

				$slide_image = get_post_meta($post->ID, '_cwmb_slide_image', true);

				$class = 'slide';

				$cropped = aq_resize( $slide_image, 1200, NULL, true, true, true );

				if(empty($slide_color)) {
					$slide_color = '#0075bf';
				}
				if(!empty($slide_image)) { 
					if(is_front_page()) {
						echo '<li class="'.$class.'" style="background-image: url('.$slide_image.');">';
						echo '</li>';
					} else {
						echo '<li class="'.$class.'">';
							echo '<img src="'.$cropped.'" alt="" />';
						echo '</li>';
					}
				}
			}
		echo '</ul>';
	echo '</div>'; // cw-slideshow
	}
wp_reset_query(); ?>