<?php
function cw_cpt_init() {
	flush_rewrite_rules();

	$cw_defaults = cw_pt_get_option('_cwpt_default_post_types');
	$cw_post_types = cw_pt_get_option('_cwpt_options');

	// echo_pre(get_option('cw_pt_options'));

	if(!empty($cw_defaults)) {
		$i=count($cw_post_types);
		foreach($cw_defaults as $cwd) {
			$plural = '';
			$singular = '';
			$supports = array();
			$icon = '';
			$archive = false;
			$hierarchical = true;
			$categories = 'no';

			if($cwd == 'slides') {
				$plural = 'Slides';
				$singular = 'Slide';
				$icon = 'slides';
				$supports = array(
					'0' => 'title',
					'1' => 'revisions'
				);
				$hierarchical = false;
			}

			if($cwd == 'faqs') {
				$plural = 'FAQs';
				$singular = 'FAQ';
				$icon = 'editor-help';
				$supports = array(
					'0' => 'title',
					'1' => 'editor',
					'2' => 'author',
					'3' => 'excerpt',
					'4' => 'revisions'
				);
				$archive = true;
				$categories = 'yes';
			}

			if($cwd == 'testimonials') {
				$plural = 'Testimonials';
				$singular = 'Testimonial';
				$icon = 'admin-comments';
				$supports = array(
					'0' => 'title',
					'1' => 'editor',
					'2' => 'author',
					'3' => 'excerpt',
					'4' => 'revisions'
				);
				$archive = true;
			}

			if($cwd == 'staff') {
				$plural = 'Staff';
				$singular = 'Listing';
				$icon = 'groups';
				$supports = array(
					'0' => 'title',
					'1' => 'editor',
					'2' => 'author',
					'3' => 'excerpt',
					'4' => 'revisions'
				);
				$archive = true;
				$categories = 'yes';

			}

			if($cwd == 'services') {
				$plural = 'Services';
				$singular = 'Service';
				$icon = 'hammer';
				$supports = array(
					'0' => 'title',
					'1' => 'editor',
					'2' => 'author',
					'3' => 'excerpt',
					'4' => 'revisions'
				);
				$archive = true;
				$categories = 'yes';
			}

			if($cwd == 'locations') {
				$plural = 'Locations';
				$singular = 'Location';
				$icon = 'location-alt';
				$supports = array(
					'0' => 'title',
					'1' => 'revisions'
				);
				$archive = true;
			}

			if($cwd == 'promos') {
				$plural = 'Promos';
				$singular = 'Promo';
				$icon = 'format-image';
				$supports = array(
					'0' => 'title',
					'1' => 'revisions'
				);
				$hierarchical = false;
				$categories = 'yes';
			}

			$cw_post_types[$i] = array(
				'singular' => $singular,
				'plural' => $plural,
				'menu_position' => '5',
				'hierarchical' => $hierarchical,
				'has_archive' => $archive,
				'supports' => $supports,
				'categories' => $categories,
				'icon' => $icon
			);
			$i++;
		}
	}
	
	if(!empty($cw_post_types)) {
		$cw_post_types = array_values($cw_post_types);

		foreach($cw_post_types as $cw_post_type) {
			$s_name = $cw_post_type['singular'];
			$lower_s_name =  str_replace(' ', '-', strtolower($cw_post_type['singular']));

			$pl_name = $cw_post_type['plural'];
			$lower_pl_name = str_replace(' ', '-', strtolower($cw_post_type['plural']));

			$post_type_name = $cw_post_type['pt_name'];
			if(empty($cw_post_type['pt_name'])) {
				$post_type_name = $lower_pl_name;
			}

			$supports = $cw_post_type['supports'];
			$menu_pos = $cw_post_type['menu_position'];
			$hierarchical = $cw_post_type['hierarchical'];
			$has_archive = $cw_post_type['has_archive'];
			$icon = $cw_post_type['icon'];

			$uc_pl_name = ucfirst($pl_name);
			if($pl_name == 'listings') {
				$uc_pl_name = 'Directory';
			}

			if(!empty($cw_post_type['singular']) && !empty($cw_post_type['plural'])) {
				$field_args = array(
					'labels' => array(
						'name' => $pl_name,
						'singular_name' => $pl_name,
						'add_new' => 'Add New '.$s_name,
						'add_new_item' => 'Add New '.$s_name,
						'edit_item' => 'Edit '.$s_name,
						'new_item' => 'Add New '.$s_name,
						'view_item' => 'View '.$s_name,
						'search_items' => 'Search '.$pl_name,
						'not_found' => 'No '.$lower_pl_name.' found',
						'not_found_in_trash' => 'No '.$lower_pl_name.' found in trash'
					),
					'public' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					'capability_type' => 'post',
					'has_archive' => $has_archive,
					'hierarchical' => $hierarchical,
					'rewrite' => true,
					'menu_position' => null,
					'supports' => $supports,
					'menu_icon' => 'dashicons-'.$icon
				);
				register_post_type($post_type_name, $field_args);

				if($cw_post_type['categories'] == 'yes') {
					$cat_s = 'Category';
					$cat_pl = 'Categories';

					if($s_name == 'Promo') {
						$cat_s = 'Position';
						$cat_pl = 'Positions';
					}

					$field_args = array(
						'labels' => array(
							'name'			  => _x( $cat_pl, 'taxonomy general name' ),
							'singular_name'	 => _x( $cat_s, 'taxonomy singular name' ),
							'search_items'	  => __( 'Search '.$cat_pl ),
							'all_items'		 => __( 'All '.$cat_pl ),
							'parent_item'	   => __( 'Parent '.$cat_s ),
							'parent_item_colon' => __( 'Parent '.$cat_s.':' ),
							'edit_item'		 => __( 'Edit '.$cat_s ),
							'update_item'	   => __( 'Update '.$cat_s ),
							'add_new_item'	  => __( 'Add New '.$cat_s ),
							'new_item_name'	 => __( 'New '.$cat_s ),
							'menu_name'		 => __( $cat_pl )
						),
						'rewrite' => array(
							'slug' => $post_type_name.'/category'
						),
						'hierarchical' => true,
						'show_ui' => true,
						'show_admin_column' => true
					);
					register_taxonomy( $post_type_name.'_categories', $post_type_name, $field_args );
				} // end if categories
			} // end if names not empty
		} // end main foreach
	}
}
add_action( 'init', 'cw_cpt_init' );