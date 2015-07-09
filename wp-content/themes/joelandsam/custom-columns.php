<?php
// add custom columns in admin

function add_slides_columns($columns) {
    return array_merge($columns, 
		array(
			'thumbnail' => 'Thumbnail',
			'page' => 'Page'
		)
	);
}
add_filter('manage_slides_posts_columns' , 'add_slides_columns');

function custom_slides_column( $column, $post_id ) {
	global $post;
	$post_id = $post->ID;
	$image = get_post_meta( $post_id , '_cwmb_slide_image' , true );
	$thumbnail = aq_resize($image, 300, 300, false);

	$title = '<b style="text-transform: uppercase; color: #d10000;">Warning: Slide not shown anywhere on site!</b><br>Click edit and select a page in the right-hand column.';
	$page = get_post_meta( $post_id , '_cwmb_slide_page' , true );
	if(!empty($page)) {
		$title = get_the_title($page);
	}
	
	switch ( $column ) {
		case 'thumbnail':
		echo '<img style="width: 100%;" src="'.$thumbnail.'" alt="" />';
		break;

		case 'page':
		echo $title;
		break;	
	}
}
add_action( 'manage_slides_posts_custom_column' , 'custom_slides_column', 10, 2  );

////////////////////////////////////////////////// staff categories /////////////////////////////////////////////////////////////

function add_staff_columns($columns) {
    return array_merge($columns, 
		array(
			'category' => 'Category',
		)
	);
}
add_filter('manage_staff_posts_columns' , 'add_staff_columns');

function custom_staff_column( $column, $post_id ) {
	global $post;
	$terms = wp_get_post_terms($post->ID, 'staff_categories');
	$terms = array_values($terms);

	$output = '';
	if(!empty($terms)) {
		foreach($terms as $key => $term) {
			if($key == 0) {
				$output .= $term->name;
			} else {
				$output .= ', '.$term->name;
			}
		}
	}
	
	switch ( $column ) {
		case 'category':
		echo $output;
		break;
	}
}
add_action( 'manage_staff_posts_custom_column' , 'custom_staff_column', 10, 2  );