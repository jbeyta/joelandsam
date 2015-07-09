<?php
/**
 * CW  functions
 *
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */

// for debugging
function echo_pre($input) {
	echo '<pre><span class="close-pre"></span><span class="content">';
	print_r($input);
	echo '</span></pre>';
}

// // // // // // // // // //// // // // //// // // // //
//
// Uncomment below in the case the CMB2 plugin doesn't work
// Will need to download an update from here: https://github.com/WebDevStudios/CMB2
//
// if ( file_exists(__DIR__.'/lib/php/cmb2/init.php')) {
// 	require_once __DIR__.'/lib/php/cmb2/init.php';
// }
//
// // // // //// // // // //// // // // //// // // // //

/* Include walker for wp_nav_menu */
get_template_part('lib/php/foundation_walker');

// Used for cropping images on the fly.
// Read docs here => https://github.com/syamilmj/Aqua-Resizer/
require_once( 'lib/php/aq_resizer.php' );

/**
 * Sets up theme defaults
 *
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since CW 1.0
 */
function cw_setup() {
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css' ) );

	/*
	 * Adds RSS feed links to <head> for posts and comments.
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switches default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	/*
	 * Create the main menu location.
	 */
	register_nav_menu( 'primary', __( 'Main Menu', 'cw' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on "standard" posts.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'cw_setup' );

/**
 * Import Custom Post Types, etc.
 *
 *
 * @since CW 1.0
 */
get_template_part('lib/php/cw-options-page');
get_template_part('lib/php/cw-cpt-page');
get_template_part('lib/php/cw-make-post-types');
get_template_part('lib/php/content', 'states');
get_template_part('metaboxes');
get_template_part('custom-columns');
get_template_part('lib/php/cw-widgets');

/**
 * Enqueue front end scripts for CW theme.
 */
add_action("wp_enqueue_scripts", "cw_enqueue_frontend", 11);
function cw_enqueue_frontend() {
	// Places modernizr in head of site
	wp_enqueue_script('modernizr', get_template_directory_uri() .'/js/modernizr.js');

	wp_deregister_script('jquery');
	wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", null, '1.10.2', false);

	// Enqueue dist.js with jquery and foudnation as a dependency.
	wp_enqueue_script('cw_js', get_template_directory_uri().'/js/dist.min.js', array('jquery'), '1', true);
	wp_enqueue_script('cw-slides', get_template_directory_uri().'/js/cw-slides.js', array('cw_js'), '1', true);

	// Enqueue the threaded comments reply scipt when necessary.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/* 
	*  Auto-version CSS & JS files, allowing for cache busting when these files are changed.
	*  Avoids using query strings which prevent proxy caching
	*  Adjust paths based on your theme setup. These paths work with Bones theme
	*/
 
	$mtime = filemtime(dirname(__FILE__) . '/css/style.css');
	wp_register_style( 'cw-stylesheet', get_bloginfo('template_url') . '/css/style.css', array(), $mtime, 'all');

	// called in header.php
	// wp_register_style( 'cw-fa', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '1', 'all');
	 
	// enqueue the stylesheet
	wp_enqueue_style( 'cw-stylesheet' );
}

function cw_enqueue_admin() {
	wp_register_style( 'cw_admin_css', get_template_directory_uri() . '/css/admin/admin-style.css', false, '1.0.0' );
	wp_enqueue_style( 'cw_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'cw_enqueue_admin' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since CW 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function cw_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'cw_wp_title', 10, 2 );

/**
 * Extends the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since CW 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function cw_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'cw_body_class' );

/**
 * Register Widget Areas
 *
 * Uncomment and edit to create widget areas where needed.
 * These are default examples so make changes before production.
 *
 * @since CW 1
 *
 */
function cw_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the sidebar section of the site.' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// register_sidebar( array(
	// 	'name'          => __( 'Secondary Widget Area' ),
	// 	'id'            => 'sidebar-2',
	// 	'description'   => __( 'Appears on posts and pages in the sidebar.' ),
	// 	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	// 	'after_widget'  => '</div>',
	// 	'before_title'  => '<h3 class="widget-title">',
	// 	'after_title'   => '</h3>',
	// ) );
}
add_action( 'widgets_init', 'cw_widgets_init' );

/**
 * Remove Admin Menu Items
 * http://codex.wordpress.org/Function_Reference/remove_menu_page
 * @since CW 1.0
 */
function cw_remove_admin_menu_items() {
	// remove_menu_page( 'index.php' );                  //Dashboard
	// remove_menu_page( 'edit.php' );                   //Posts
	// remove_menu_page( 'upload.php' );                 //Media
	// remove_menu_page( 'edit.php?post_type=page' );    //Pages
	// remove_menu_page( 'edit-comments.php' );          //Comments
	// remove_menu_page( 'themes.php' );                 //Appearance
	// remove_menu_page( 'plugins.php' );                //Plugins
	// remove_menu_page( 'users.php' );                  //Users
	// remove_menu_page( 'tools.php' );                  //Tools
	// remove_menu_page( 'options-general.php' );        //Settings
	
	$hide_posts = cw_pt_get_option( '_cwpt_hide_posts' );
	if(!empty($hide_posts) && $hide_posts == 'on') {
		remove_menu_page( 'edit.php' );  
	}
}
add_action('admin_menu', 'cw_remove_admin_menu_items');

function foundation_pagination() {
	global $wp_query;
	$big = 999999999;

	$links = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'prev_next' => true,
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'type' => 'list'
	)
	);

	$pagination = str_replace('page-numbers','pagination',$links);

	echo $pagination;
}

/**
 * Custom Excerpt Function
 *
 * @link http://www.wpexplorer.com/custom-excerpt-lengths-wordpress/
 * 
 * useage: echo excerpt(25);
 */
function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	} 
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

function content($limit) {
	$content = explode(' ', get_the_content(), $limit);
	if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).'...';
	} else {
		$content = implode(" ",$content);
	} 
	$content = preg_replace('/\[.+\]/','', $content);
	$content = apply_filters('the_content', $content); 
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}

/**
 * Rename "Posts" to "News"
 *
 * @link http://new2wp.com/snippet/change-wordpress-posts-post-type-news/
 */
// add_action( 'admin_menu', 'pilau_change_post_menu_label' );
// add_action( 'init', 'pilau_change_post_object_label' );
// function pilau_change_post_menu_label() {
// 	global $menu;
// 	global $submenu;
// 	$menu[5][0] = 'News';
// 	$submenu['edit.php'][5][0] = 'News';
// 	$submenu['edit.php'][10][0] = 'Add News';
// 	$submenu['edit.php'][16][0] = 'News Tags';
// 	echo '';
// }
// function pilau_change_post_object_label() {
// 	global $wp_post_types;
// 	$labels = &$wp_post_types['post']->labels;
// 	$labels->name = 'News';
// 	$labels->singular_name = 'News';
// 	$labels->add_new = 'Add News';
// 	$labels->add_new_item = 'Add News';
// 	$labels->edit_item = 'Edit News';
// 	$labels->new_item = 'News';
// 	$labels->view_item = 'View News';
// 	$labels->search_items = 'Search News';
// 	$labels->not_found = 'No News found';
// 	$labels->not_found_in_trash = 'No News found in Trash';
// }


/**
 * Remove "Personal Options" from user profile
 *
 * @link http://wpsnipp.com/index.php/functions-php/remove-personal-options-from-user-profiles/
 */
function hide_personal_options(){
echo "\n" . '<script type="text/javascript">jQuery(document).ready(function($) { $(\'form#your-profile > h3:first\').hide(); $(\'form#your-profile > table:first\').hide(); $(\'form#your-profile\').show(); });</script>' . "\n";
}
// add_action('admin_head','hide_personal_options');

// get rid of [...]
function new_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter('excerpt_more', 'new_excerpt_more');

// change "enter title here"
// add_filter('gettext','custom_enter_title');
// function custom_enter_title( $input ) {

//     global $post_type;

//     if( is_admin() && 'Enter title here' == $input )
//     	if('testimonials' == $post_type )
//         	return 'Enter Name Here';
//         elseif('staff' == $post_type )
//         	return 'Enter Name Here';

//     return $input;
// }

// block site admin users from creating administrator users
// take from here http://wordpress.stackexchange.com/questions/4479/editor-can-create-any-new-user-except-administrator
class JPB_User_Caps {

	// Add our filters
	function JPB_User_Caps(){
		add_filter( 'editable_roles', array(&$this, 'editable_roles'));
		add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
	}

	// Remove 'Administrator' from the list of roles if the current user is not an admin
	function editable_roles( $roles ){
		if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
			unset( $roles['administrator']);
		}
		return $roles;
	}

	// If someone is trying to edit or delete and admin and that user isn't an admin, don't allow it
	function map_meta_cap( $caps, $cap, $user_id, $args ){
		switch( $cap ){
			case 'edit_user':
			case 'remove_user':
			case 'promote_user':
				if( isset($args[0]) && $args[0] == $user_id )
					break;
				elseif( !isset($args[0]) )
					$caps[] = 'do_not_allow';
				$other = new WP_User( absint($args[0]) );
				if( $other->has_cap( 'administrator' ) ){
					if(!current_user_can('administrator')){
						$caps[] = 'do_not_allow';
					}
				}
				break;
			case 'delete_user':
			case 'delete_users':
			    if( !isset($args[0]) )
			        break;
				$other = new WP_User( absint($args[0]) );
			    if( $other->has_cap( 'administrator' ) ){
					if(!current_user_can('administrator')){
						$caps[] = 'do_not_allow';
					}
				}
				break;
			default:
				break;
		}
		return $caps;
	}

}

$jpb_user_caps = new JPB_User_Caps();

// fancy costumizable pagination
// from http://sgwordpress.com/teaches/how-to-add-wordpress-pagination-without-a-plugin/
//
// usage
//
// if (function_exists('pagination')) {
// 	pagination($posts->max_num_pages);
// }

function pagination($pages = '', $range = 4) {  
	$showitems = ($range * 2)+1;  
	
	global $paged;
	if(empty($paged)) $paged = 1;
	
	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages) {
			$pages = 1;
		}
	}   
	
	if(1 != $pages) {
		echo "<div class=\"pagination\">";
		// echo "<span>Page ".$paged." of ".$pages."</span>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
		if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
		
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
			}
		}
		
		if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
		echo "</div>\n";
	}
}

function cw_mime_type_format($cw_file_type) {
	$cw_allowed_types = array(
		// Image formats
		'jpg|jpeg|jpe'                 => 'image/jpeg',
		'gif'                          => 'image/gif',
		'png'                          => 'image/png',
		'bmp'                          => 'image/bmp',
		'tif|tiff'                     => 'image/tiff',
		'ico'                          => 'image/x-icon',

		// Video formats
		'asf|asx'                      => 'video/x-ms-asf',
		'wmv'                          => 'video/x-ms-wmv',
		'wmx'                          => 'video/x-ms-wmx',
		'wm'                           => 'video/x-ms-wm',
		'avi'                          => 'video/avi',
		'divx'                         => 'video/divx',
		'flv'                          => 'video/x-flv',
		'mov|qt'                       => 'video/quicktime',
		'mpeg|mpg|mpe'                 => 'video/mpeg',
		'mp4|m4v'                      => 'video/mp4',
		'ogv'                          => 'video/ogg',
		'webm'                         => 'video/webm',
		'mkv'                          => 'video/x-matroska',
		
		// Text formats
		'txt|asc|c|cc|h'               => 'text/plain',
		'csv'                          => 'text/csv',
		'tsv'                          => 'text/tab-separated-values',
		'ics'                          => 'text/calendar',
		'rtx'                          => 'text/richtext',
		'css'                          => 'text/css',
		'htm|html'                     => 'text/html',
		
		// Audio formats
		'mp3|m4a|m4b'                  => 'audio/mpeg',
		'ra|ram'                       => 'audio/x-realaudio',
		'wav'                          => 'audio/wav',
		'ogg|oga'                      => 'audio/ogg',
		'mid|midi'                     => 'audio/midi',
		'wma'                          => 'audio/x-ms-wma',
		'wax'                          => 'audio/x-ms-wax',
		'mka'                          => 'audio/x-matroska',
		
		// Misc application formats
		'rtf'                          => 'application/rtf',
		'js'                           => 'application/javascript',
		'pdf'                          => 'application/pdf',
		'swf'                          => 'application/x-shockwave-flash',
		'class'                        => 'application/java',
		'tar'                          => 'application/x-tar',
		'zip'                          => 'application/zip',
		'gz|gzip'                      => 'application/x-gzip',
		'rar'                          => 'application/rar',
		'7z'                           => 'application/x-7z-compressed',
		'exe'                          => 'application/x-msdownload',
		
		// MS Office formats
		'doc'                          => 'application/msword',
		'pot|pps|ppt'                  => 'application/vnd.ms-powerpoint',
		'wri'                          => 'application/vnd.ms-write',
		'xla|xls|xlt|xlw'              => 'application/vnd.ms-excel',
		'mdb'                          => 'application/vnd.ms-access',
		'mpp'                          => 'application/vnd.ms-project',
		'docx'                         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'docm'                         => 'application/vnd.ms-word.document.macroEnabled.12',
		'dotx'                         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
		'dotm'                         => 'application/vnd.ms-word.template.macroEnabled.12',
		'xlsx'                         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'xlsm'                         => 'application/vnd.ms-excel.sheet.macroEnabled.12',
		'xlsb'                         => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
		'xltx'                         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
		'xltm'                         => 'application/vnd.ms-excel.template.macroEnabled.12',
		'xlam'                         => 'application/vnd.ms-excel.addin.macroEnabled.12',
		'pptx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
		'pptm'                         => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
		'ppsx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
		'ppsm'                         => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
		'potx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.template',
		'potm'                         => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
		'ppam'                         => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
		'sldx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
		'sldm'                         => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
		'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',
		
		// OpenOffice formats
		'odt'                          => 'application/vnd.oasis.opendocument.text',
		'odp'                          => 'application/vnd.oasis.opendocument.presentation',
		'ods'                          => 'application/vnd.oasis.opendocument.spreadsheet',
		'o dg'                         => 'application/vnd.oasis.opendocument.graphics',
		'odc'                          => 'application/vnd.oasis.opendocument.chart',
		'odb'                          => 'application/vnd.oasis.opendocument.database',
		'odf'                          => 'application/vnd.oasis.opendocument.formula',
		
		// WordPerfect formats
		'wp|wpd'                       => 'application/wordperfect',
		
		// iWork formats
		'key'                          => 'application/vnd.apple.keynote',
		'numbers'                      => 'application/vnd.apple.numbers',
		'pages'                        => 'application/vnd.apple.pages',
	);

	$cw_formatted_type = array_search($cw_file_type, $cw_allowed_types);
	return $cw_formatted_type;
}

// uncomment to allow search enging visibility to be turned off
function cw_default_search_engine_visiblity() {
	update_option('blog_public', 1);
}
add_action('init', 'cw_default_search_engine_visiblity');

/* Flush rewrite rules for custom post types. */
// flush_rewrite_rules(true);
// global $wp_rewrite; $wp_rewrite->flush_rules();