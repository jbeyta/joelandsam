<?php
/**
Plugin Name: CW Search Posts
Plugin URI: http://crane-west.com
Description: Search Blog Posts by single term
Version: 1.0
Author: Joel Abeyta, Crane | West
Author URI: http://crane-west.com
License: GPLv2 or later
 */

// search blog posts widget
class cw_blog_search_widget extends WP_Widget {

function __construct() {
	parent::__construct(
		// Base ID of your widget
		'cw_blog_search_widget', 

		// Widget name will appear in UI
		__('Blog Search', 'cw_blog_search_domain'),

		// Widget description
		array( 'description' => __( 'List blog posts by single search term.', 'cw_blog_search_domain' ), ) 
	);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$search_term = $instance['search_term'];
	$search_count = $instance['search_count'];

	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];

	// This is where you run the code and display the output
	$search = '';
	if(!empty($search_term)) {
		$search = $search_term;
	} else {
		$search = '';
	}

	$number_of_posts = -1;
	if(!empty($search_count)) {
		$number_of_posts = $search_count;
	} else {
		$number_of_posts = -1;
	}


	$search_args = array(
		's' => $search,
		'posts_per_page' => $number_of_posts,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$the_query = new WP_Query( $search_args );

	// The Loop
	if ( $the_query->have_posts() ) {
		echo '<ul>';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			echo '<li><a href="'.get_the_permalink().'">' . get_the_title() . '</a></li>';
		}
		echo '</ul>';
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();


	echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	} else {
		$title = __( '', 'cw_blog_search_domain' );
	}

	if ( isset( $instance[ 'search_term' ] ) ) {
		$search_term = $instance[ 'search_term' ];
	} else {
		$search_term = '';
	}

	if ( isset( $instance[ 'search_count' ] ) ) {
		$search_count = $instance[ 'search_count' ];
	} else {
		$search_count = '';
	}
// Widget admin form
?>

<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
<br>
<br>
<label for="<?php echo $this->get_field_id( 'search_term' ); ?>">Search Term:<br><small>NOTE: Leave this field empty will load all posts.</small></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'search_term' ); ?>" name="<?php echo $this->get_field_name( 'search_term' ); ?>" type="text" value="<?php echo esc_attr( $search_term ); ?>" />
<br>
<br>
<label for="<?php echo $this->get_field_id( 'search_count' ); ?>">Number of Posts:<br><small>NOTE: Leave this field empty will load all posts.</small></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'search_count' ); ?>" name="<?php echo $this->get_field_name( 'search_count' ); ?>" type="text" value="<?php echo esc_attr( $search_count ); ?>" />
</p>

<?php }

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['search_term'] = ( ! empty( $new_instance['search_term'] ) ) ? strip_tags( $new_instance['search_term'] ) : '';
			$instance['search_count'] = ( ! empty( $new_instance['search_count'] ) ) ? strip_tags( $new_instance['search_count'] ) : '';			
			return $instance;
		}
	} // Class cw_blog_search_widget ends here

// Register and load the widget
function cw_blog_search_load_widget() {
	register_widget( 'cw_blog_search_widget' );
}
add_action( 'widgets_init', 'cw_blog_search_load_widget' );
?>