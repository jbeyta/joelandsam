<?php
// phone number short code
function cw_phone_umber( $atts, $content = null ) {
	global $post;

	ob_start();

		echo cw_options_get_option('cwo_phone');

	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'phone_number', 'cw_phone_umber' );

function cw_get_promo( $atts, $content = null ) {
	global $post;

	ob_start();

		$promo_args = array(
			'post_type' => 'promos',
			'posts_per_page' => 1,
			'orderby'=> 'menu_order',
			'order' => 'ASC',
			'tax_query' => array(
				'taxonomy' => 'promos_locations',
				'field' => 'slug',
				'terms' => 'content'
			)
		);

		$promos = new WP_Query($promo_args);
		if($promos->have_posts()){
			while($promos->have_posts()) {
				$promos->the_post();

				$image = get_post_meta($post->ID, '_cwmb_promo_image', true);
				$link = get_post_meta($post->ID, '_cwmb_promo_link', true);

				if(!empty($image)) {
					echo '<figure style="margin-bottom: 30px;">';
						if(!empty($link)) { echo '<a href="'.$link.'">'; };
							echo '<img src="'.$image.'" alt="" />';
						if(!empty($link)) { echo '</a>'; };
					echo '</figure>';
				}
			}
		}	

	wp_reset_query();
	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'get_content_promo', 'cw_get_promo' );

function cw_posts_list( $atts, $content = null ) {
	global $post;

	ob_start();

		echo '<div class="article-list">';
			$posts = get_posts();

			foreach($posts as $post) {
				echo '<article class="news-article">';
					echo '<span class="close">X</span>';
					
					echo '<h4 class="article-title">';
						echo get_the_title($post->ID);
					echo '</h4>';

					$date = get_the_date('F j, Y');

					echo '<p class="article-date"><b>Posted '.$date.'</b></p>';

					$post_content = $post->post_content;
					$post_excerpt = strip_tags(substr($post_content, 0, 100));

					echo '<p class="article-excerpt">';
						echo $post_excerpt.'...<br><span class="readmore">Read More</span>';
					echo '</p>';

					echo '<div class="article-content">';
						echo get_the_post_thumbnail($post->ID);
						echo '<p>'.$post_content.'</p>';
					echo '</div>';

				echo '</article>';
			}

		echo '</div>';

	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'get_posts', 'cw_posts_list' );

function cw_get_promos( $atts, $content = null ) {
	global $post;

	extract(shortcode_atts(array(
		'position' => '',
	), $atts));

	ob_start();

		$pargs = array(
			'post_type' => 'promos',
			'posts_per_page' => 1,
			'orderby' => 'rand',
			'tax_query' => array(
				array (
					'taxonomy' => 'promos_categories',
					'field' => 'slug',
					'terms' => $position
				)
			)
		);

		$promos = new WP_Query($pargs);
		if($promos->have_posts()){
			while($promos->have_posts()) {
				$promos->the_post();

				$image = get_post_meta($post->ID, '_cwmb_promo_image', true);
				$url = get_post_meta($post->ID, '_cwmb_promo_link', true);

				if(!empty($image))	{
					$cropped = aq_resize( $image, 480, 120, true, true, true );
					if(!empty($url)) { echo '<a href="'.$url.'">'; }
						echo '<img src="'.$cropped.'" alt="" />';
					if(!empty($url)) { echo '</a>'; }
				}
			}
		}

	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'get_promo', 'cw_get_promos' );
