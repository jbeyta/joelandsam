<?php
// ------------------------------------
//
// Custom Meta Boxes
//
// ------------------------------------
// custom meta boxes
function cw_list_galleries() {
	$sargs = array(
		'post_type' => 'galleries',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);

	global $galleries_list;
	// global $gallery_ids;
	$galleries_list = array('' => 'Select a Gallery');
	// $gallery_ids = array();

	$servs = new WP_Query($sargs);
	if($servs->have_posts()) {
		while($servs->have_posts()) {
			$servs->the_post();
			global $post;
			$galleries_list[$post->ID] = get_the_title();
			// array_push($gallery_ids, $post->ID);
		}
	}
}
cw_list_galleries();

function list_pages() {
	$pages_args = array(
		'sort_order' => 'ASC',
		'sort_column' => 'post_title'
		);

	$pages = get_pages($pages_args);

	global $cw_page_list;
	$cw_page_list = array('' => 'Select a page');
	foreach($pages as $page) {
		$page_name = $page->post_title;
		$page_id = $page->ID;
		if($page_name != "Blog") {
			$cw_page_list[$page_id] = $page_name;
		}
	}
}
list_pages();

// function cw_list_media() {
// 	$margs = array(
// 		'post_type' => 'attachment',
// 		'post_mime_type' =>'application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
// 		'post_status' => 'inherit',
// 		'posts_per_page' => -1
// 	);

// 	$media = new WP_Query( $margs );

// 	global $cw_media_list;
// 	$cw_media_list = array('' => 'Select a file');
// 	foreach($media->posts as $file) {
// 		$cw_media_list[$file->ID] = $file->post_title;
// 	}
// }
// cw_list_media();

function cw_metaboxes( array $meta_boxes ) {
	global $cw_page_list;
	global $galleries_list;
	// use for select, checkbox, radio of list of states
	global $cw_states;

	$prefix = '_cwmb_'; // Prefix for all fields

	// $meta_boxes['slide_video'] = array(
	// 	'id' => 'slide_video',
	// 	'title' => 'Slide Video Files',
	// 	'object_types' => array( 'slides' ), // Post type
	// 	'context' => 'normal',
	// 	'priority' => 'high',
	// 	'show_names' => true, // Show field names on the left
	// 	'fields' => array(
	// 		array(
	// 			'name' => 'Video mp4',
	// 			'desc' => 'NOTE: Uploading video will override any other content. Both video codec must be uploaded for video to play.',
	// 			'id' => $prefix.'slide_mp4',
	// 			'type' => 'file',
	// 		),
	// 		array(
	// 			'name' => 'Video webm',
	// 			'desc' => 'NOTE: Uploading video will override any other content. Both video codec must be uploaded for video to play.',
	// 			'id' => $prefix.'slide_webm',
	// 			'type' => 'file',
	// 		)
	// 	)
	// );

	$slides = new_cmb2_box( array(
		'id'            => $prefix.'slides',
		'title'         => 'Slide Info',
		'object_types'  => array( 'slides', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	// $slides->add_field( array(
	// 	'name' => 'Title',
	// 	'id' => $prefix.'slide_title',
	// 	'type' => 'text',
	// ) );

	// $slides->add_field( array(
	// 	'name' => 'Subtitle',
	// 	'id' => $prefix.'slide_subtitle',
	// 	'type' => 'text',
	// ) );

	// $slides->add_field( array(
	// 	'name' => 'Title Position',
	// 	'id' => $prefix.'slide_title_pos',
	// 	'type' => 'radio',
	// 	'options' => array(
	// 		'left' => 'Left',
	// 		'center' => 'Center',
	// 		'right' => 'Right'
	// 	),
	// 	'default' => 'left'
	// ) );

	$slides->add_field( array(
		'name' => 'Image',
		'id' => $prefix.'slide_image',
		'type' => 'file'
	) );

	// $slides->add_field( array(
	// 	'name' => 'Image Position',
	// 	'id' => $prefix.'slide_image_pos',
	// 	'type' => 'radio',
	// 	'options' => array(
	// 		'left' => 'Left',
	// 		'center' => 'Center',
	// 		'right' => 'Right'
	// 	),
	// 	'default' => 'center'
	// ) );

	// $slides->add_field( array(
	// 	'name' => 'Caption',
	// 	'id' => $prefix.'slide_caption',
	// 	'type' => 'textarea'
	// ) );

	// $slides->add_field( array(
	// 	'name' => 'Caption Position',
	// 	'id' => $prefix.'slide_caption_pos',
	// 	'type' => 'radio',
	// 	'options' => array(
	// 		'left' => 'Left',
	// 		'center' => 'Center',
	// 		'right' => 'Right'
	// 	),
	// 	'default' => 'left'
	// ) );

	// $slides->add_field( array(
	// 	'name' => 'Link',
	// 	'id' => $prefix.'slide_link',
	// 	'type' => 'text_url'
	// ) );

	// $slides->add_field( array(
	// 	'name' => 'Background Color',
	// 	'id' => $prefix.'slide_color',
	// 	'type' => 'radio',
	// 	'options' => array (
	// 		'#ffffff' => 'None',
	// 		'#0075bf' => 'Blue',
	// 		'#ff685a' => 'Salmon',
	// 		'#5b5b5b' => 'Grey',
	// 		'#4a9231' => 'Green'
	// 	),
	// 	'default' => '#0075bf'
	// ) );

	$slide_page = new_cmb2_box( array(
		'id'            => $prefix.'slide_page',
		'title'         => 'Slide Page',
		'object_types'  => array( 'slides', ), // Post type
		'context' => 'side',
		'priority' => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	$slide_page->add_field( array(
		'name' => '',
		'desc' => 'Choose page(s) to show this slide on. NOTE: If no page is selected, this slide will note be shown anywhere on the site.',
		'id' => $prefix.'slide_page',
		'type' => 'select',
		'options' => $cw_page_list
	) );

	//galleries
	$gallery = new_cmb2_box( array(
		'id'            => $prefix.'gallery',
		'title' => 'Location Info',
		'object_types'  => array( 'galleries', ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	$gallery->add_field( array(
		'name' => 'Images',
		'id' => $prefix.'galler_imgs',
		'type' => 'file_list'
	) );

	//posts
	$post_gallery = new_cmb2_box( array(
		'id'            => $prefix.'post_gallery',
		'title' => 'Location Info',
		'object_types'  => array( 'post', ), // Post type
		'context' => 'side',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	$post_gallery->add_field( array(
		'name' => 'Link to Gallery',
		'id' => $prefix.'gallery_id',
		'type' => 'select',
		'options' => $galleries_list
	) );

	// locations
	// $location = new_cmb2_box( array(
	// 	'id'            => $prefix.'locations',
	// 	'title' => 'Location Info',
	// 	'object_types'  => array( 'locations', ), // Post type
	// 	'context' => 'normal',
	// 	'priority' => 'default',
	// 	'show_names'    => true, // Show field names on the left
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Address 1',
	// 	'id' => $prefix.'loc_address1',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Address 2',
	// 	'id' => $prefix.'loc_address2',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'City',
	// 	'id' => $prefix.'loc_city',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'State',
	// 	'id' => $prefix.'loc_state',
	// 	'type' => 'select',
	// 	'options' => $cw_states
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Zip',
	// 	'id' => $prefix.'loc_zip',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Phone',
	// 	'id' => $prefix.'loc_phone',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Phone 2',
	// 	'id' => $prefix.'loc_phone2',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Fax',
	// 	'id' => $prefix.'loc_fax',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Email',
	// 	'id' => $prefix.'loc_email',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Photo',
	// 	'id' => $prefix.'loc_photo',
	// 	'type' => 'file'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Hours',
	// 	'id' => $prefix.'loc_hours',
	// 	'type' => 'textarea'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Lat',
	// 	'desc' => 'In the case that Google maps show the inccorrect location, use lat & lon',
	// 	'id' => $prefix.'loc_lat',
	// 	'type' => 'text'
	// ) );

	// $location->add_field( array(
	// 	'name' => 'Lon',
	// 	'desc' => 'In the case that Google maps show the inccorrect location, use lat & lon',
	// 	'id' => $prefix.'loc_lon',
	// 	'type' => 'text'
	// ) );

	// promos
	// $promos = new_cmb2_box( array(
	// 	'id'            => $prefix.'promo',
	// 	'title'         => 'Promo Info',
	// 	'object_types'  => array( 'promos', ), // Post type
	// 	'context' => 'normal',
	// 	'priority' => 'default',
	// 	'show_names'    => true, // Show field names on the left
	// ) );

	// $promos->add_field( array(
	// 	'name' => 'Promo Image',
	// 	'id' => $prefix.'promo_image',
	// 	'type' => 'file'
	// ) );

	// $promos->add_field( array(
	// 	'name' => 'Link',
	// 	'id' => $prefix.'promo_link',
	// 	'type' => 'text_url'
	// ) );

	// // zips
	// $zips = new_cmb2_box( array(
	// 	'id'            => $prefix.'zips',
	// 	'title' => 'Available Services in this Zip Code',
	// 	'object_types'  => array( 'zips', ), // Post type
	// 	'context' => 'normal',
	// 	'priority' => 'default',
	// 	'show_names'    => true, // Show field names on the left
	// ) );

	// $zips->add_field( array(
	// 	'name' => 'Services',
	// 	'id' => $prefix.'zip_services',
	// 	'type' => 'multicheck',
	// 	'options' => $cw_services_list,
	// 	'default' => $cw_services_ids
	// ) );


	// services
	// $services = new_cmb2_box( array(
	// 	'id'            => $prefix.'services',
	// 	'title' => 'Options',
	// 	'object_types'  => array( 'services', ), // Post type
	// 	'context' => 'side',
	// 	'priority' => 'default',
	// 	'show_names'    => true, // Show field names on the left
	// ) );

	// $services->add_field( array(
	// 	'name' => 'Service Image',
	// 	'id' => $prefix.'service_image',
	// 	'type' => 'file'
	// ) );

	// $services->add_field( array(
	// 	'name' => 'SVG Code',
	// 	'desc' => 'advanced users only',
	// 	'id' => $prefix.'svg_code',
	// 	'type' => 'textarea_code'
	// ) );

	// $service_excerpt = new_cmb2_box( array(
	// 	'id'            => $prefix.'service_excerpt',
	// 	'title' => 'Options',
	// 	'object_types'  => array( 'services', ), // Post type
	// 	'context' => 'normal',
	// 	'priority' => 'default',
	// 	'show_names'    => true, // Show field names on the left
	// ) );

	// $service_excerpt->add_field( array(
	// 	'name' => 'Service Excerpt',
	// 	'desc' => 'Optional excerpt. If left empty, an excerpt will be generated from the content.',
	// 	'id' => $prefix.'service_excerpt',
	// 	'type' => 'textarea'
	// ) );

	// $service_excerpt->add_field( array(
	// 	'name' => 'Service Subtitle',
	// 	'id' => $prefix.'service_subtitle',
	// 	'type' => 'text'
	// ) );


	// $testimonials = new_cmb2_box( array(
	// 	'id'            => $prefix.'testimonials',
	// 	'title' => 'Testimonial',
	// 	'object_types'  => array( 'testimonials', ), // Post type
	// 	'context' => 'normal',
	// 	'priority' => 'default',
	// 	'show_names'    => true, // Show field names on the left
	// ) );

	// $testimonials->add_field( array(
	// 	'id' => $prefix.'testimonial',
	// 	'type' => 'textarea'
	// ) );
	// $testimonials->add_field( array(
	// 	'name' => 'Vocation',
	// 	'id' => $prefix.'vocation',
	// 	'type' => 'text'
	// ) );
	// $testimonials->add_field( array(
	// 	'name' => 'Location',
	// 	'id' => $prefix.'location',
	// 	'type' => 'text'
	// ) );


	// $staff = new_cmb2_box( array(
	// 	'id'            => $prefix.'staff',
	// 	'title' => 'Testimonial',
	// 	'object_types'  => array( 'staff', ), // Post type
	// 	'context' => 'normal',
	// 	'priority' => 'default',
	// 	'show_names'    => true, // Show field names on the left
	// ) );

	// $staff->add_field( array(
	// 	'name' => 'Title',
	// 	'id' => $prefix.'staff_title',
	// 	'type' => 'text'
	// ) );
	// $staff->add_field( array(
	// 	'name' => 'Image',
	// 	'id' => $prefix.'staff_image',
	// 	'type' => 'file'
	// ) );
	// $staff->add_field( array(
	// 	'name' => 'Bio',
	// 	'id' => $prefix.'staff_bio',
	// 	'type' => 'textarea'
	// ) );

	return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'cw_metaboxes' );

// end custom meta boxes