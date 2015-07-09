<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class cw_pt_Admin {
	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'cw_pt_options';
	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'cw_pt_option_metabox';
	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';
	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';
	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Post Types', 'cw_pt' );
	}
	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}
	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}
	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'update_core', $this->key, array( $this, 'admin_page_display' ), 'dashicons-index-card' );
		// add_action( "admin_head-{$this->options_page}", array( $this, 'enqueue_js' ) );
	}
	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}
	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {
		$icons_list = array(
			'' => 'Select an Icon',
			'menu' => 'Menu',
			'admin-site' => 'Admin Site',
			'dashboard' => 'Dashboard',
			'admin-post' => 'Admin Post',
			'admin-media' => 'Admin Media',
			'admin-links' => 'Admin Links',
			'admin-page' => 'Admin Page',
			'admin-comments' => 'Admin Comments',
			'admin-appearance' => 'Admin Appearance',
			'admin-plugins' => 'Admin Plugins',
			'admin-users' => 'Admin Users',
			'admin-tools' => 'Admin Tools',
			'admin-settings' => 'Admin Settings',
			'admin-network' => 'Admin Network',
			'admin-home' => 'Admin Home',
			'admin-generic' => 'Admin Generic',
			'admin-collapse' => 'Admin Collapse',
			'welcome-write-blog' => 'Welcome Write Blog',
			'welcome-add-page' => 'Welcome Add Page',
			'welcome-view-site' => 'Welcome View Site',
			'welcome-widgets-menus' => 'Welcome Widgets Menus',
			'welcome-comments' => 'Welcome Comments',
			'welcome-learn-more' => 'Welcome Learn More',
			'format-aside' => 'Format Aside',
			'format-image' => 'Format Image',
			'format-gallery' => 'Format Gallery',
			'format-video' => 'Format Video',
			'format-status' => 'Format Status',
			'format-quote' => 'Format Quote',
			'format-chat' => 'Format Chat',
			'format-audio' => 'Format Audio',
			'camera' => 'Camera',
			'images-alt' => 'Images Alt',
			'images-alt2' => 'Images Alt2',
			'video-alt' => 'Video Alt',
			'video-alt2' => 'Video Alt2',
			'video-alt3' => 'Video Alt3',
			'image-crop' => 'Image Crop',
			'image-rotate-left' => 'Image Rotate Left',
			'image-rotate-right' => 'Image Rotate Right',
			'image-flip-vertical' => 'Image Flip Vertical',
			'image-flip-horizontal' => 'Image Flip Horizontal',
			'undo' => 'Undo',
			'redo' => 'Redo',
			'editor-bold' => 'Editor Bold',
			'editor-italic' => 'Editor Italic',
			'editor-ul' => 'Editor Ul',
			'editor-ol' => 'Editor Ol',
			'editor-quote' => 'Editor Quote',
			'editor-alignleft' => 'Editor Alignleft',
			'editor-aligncenter' => 'Editor Aligncenter',
			'editor-alignright' => 'Editor Alignright',
			'editor-insertmore' => 'Editor Insertmore',
			'editor-spellcheck' => 'Editor Spellcheck',
			'editor-distractionfree' => 'Editor Distractionfree',
			'editor-kitchensink' => 'Editor Kitchensink',
			'editor-underline' => 'Editor Underline',
			'editor-justify' => 'Editor Justify',
			'editor-textcolor' => 'Editor Textcolor',
			'editor-paste-word' => 'Editor Paste Word',
			'editor-paste-text' => 'Editor Paste Text',
			'editor-removeformatting' => 'Editor Removeformatting',
			'editor-video' => 'Editor Video',
			'editor-customchar' => 'Editor Customchar',
			'editor-outdent' => 'Editor Outdent',
			'editor-indent' => 'Editor Indent',
			'editor-help' => 'Editor Help',
			'editor-strikethrough' => 'Editor Strikethrough',
			'editor-unlink' => 'Editor Unlink',
			'editor-rtl' => 'Editor Rtl',
			'align-left' => 'Align Left',
			'align-right' => 'Align Right',
			'align-center' => 'Align Center',
			'align-none' => 'Align None',
			'lock' => 'Lock',
			'calendar' => 'Calendar',
			'visibility' => 'Visibility',
			'post-status' => 'Post Status',
			'edit' => 'Edit',
			'trash' => 'Trash',
			'arrow-up' => 'Arrow Up',
			'arrow-down' => 'Arrow Down',
			'arrow-right' => 'Arrow Right',
			'arrow-left' => 'Arrow Left',
			'arrow-up-alt' => 'Arrow Up Alt',
			'arrow-down-alt' => 'Arrow Down Alt',
			'arrow-right-alt' => 'Arrow Right Alt',
			'arrow-left-alt' => 'Arrow Left Alt',
			'arrow-up-alt2' => 'Arrow Up Alt2',
			'arrow-down-alt2' => 'Arrow Down Alt2',
			'arrow-right-alt2' => 'Arrow Right Alt2',
			'arrow-left-alt2' => 'Arrow Left Alt2',
			'sort' => 'Sort',
			'leftright' => 'Leftright',
			'list-view' => 'List View',
			'exerpt-view' => 'Exerpt View',
			'share' => 'Share',
			'share-alt' => 'Share Alt',
			'share-alt2' => 'Share Alt2',
			'twitter' => 'Twitter',
			'rss' => 'Rss',
			'facebook' => 'Facebook',
			'facebook-alt' => 'Facebook Alt',
			'googleplus' => 'Googleplus',
			'networking' => 'Networking',
			'hammer' => 'Hammer',
			'art' => 'Art',
			'migrate' => 'Migrate',
			'performance' => 'Performance',
			'wordpress' => 'Wordpress',
			'wordpress-alt' => 'Wordpress Alt',
			'pressthis' => 'Pressthis',
			'update' => 'Update',
			'screenoptions' => 'Screenoptions',
			'info' => 'Info',
			'cart' => 'Cart',
			'feedback' => 'Feedback',
			'cloud' => 'Cloud',
			'translation' => 'Translation',
			'tag' => 'Tag',
			'category' => 'Category',
			'yes' => 'Yes',
			'no' => 'No',
			'no-alt' => 'No Alt',
			'plus' => 'Plus',
			'minus' => 'Minus',
			'dismiss' => 'Dismiss',
			'marker' => 'Marker',
			'star-filled' => 'Star Filled',
			'star-half' => 'Star Half',
			'star-empty' => 'Star Empty',
			'flag' => 'Flag',
			'location' => 'Location',
			'location-alt' => 'Location Alt',
			'vault' => 'Vault',
			'shield' => 'Shield',
			'shield-alt' => 'Shield Alt',
			'search' => 'Search',
			'slides' => 'Slides',
			'analytics' => 'Analytics',
			'chart-pie' => 'Chart Pie',
			'chart-bar' => 'Chart Bar',
			'chart-line' => 'Chart Line',
			'chart-area' => 'Chart Area',
			'groups' => 'Groups',
			'businessman' => 'Businessman',
			'id' => 'Id',
			'id-alt' => 'Id Alt',
			'products' => 'Products',
			'awards' => 'Awards',
			'forms' => 'Forms',
			'portfolio' => 'Portfolio',
			'book' => 'Book',
			'book-alt' => 'Book Alt',
			'download' => 'Download',
			'upload' => 'Upload',
			'backup' => 'Backup',
			'lightbulb' => 'Lightbulb',
			'smiley' => 'Smiley'
		);

		$prefix = '_cwpt_';
		
		$cmb = new_cmb2_box( array(
			'id'	  => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// echo_pre($this->metabox_id);

		// Set our CMB2 fields
		$cmb->add_field( array(
			'id' => $prefix.'default_post_types',
			'name' => 'Select default post types here. Define custom post types below.',
			'desc' => 'Edit default post type options in <b>cw-make-post-types.php</b>',
			'type' => 'multicheck',
			'options' => array(
				'slides' => 'Slides',
				'faqs' => 'FAQs',
				'testimonials' => 'Testimonials',
				'staff' => 'Staff',
				'services' => 'Services',
				'locations' => 'Locations',
				'promos' => 'Promos'
			)
		) );


		$cmb->add_field( array(
			'name' => 'Hide Posts',
			'desc' => 'Don\'t need a blog? Hide the posts to clean up the admin.',
			'id' => $prefix.'hide_posts',
			'type' => 'checkbox'
		) );

		$group_field_id = $cmb->add_field( array(
			'id'		  => $prefix.'options',
			'type'		=> 'group',
			'options'	 => array(
				'group_title'   => __( 'Post Type {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'	=> __( 'Add Another Post Type', 'cmb' ),
				'remove_button' => __( 'Remove Post Type', 'cmb' ),
				'sortable'	  => false, // beta
			),
		) );

		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Post Type Name',
			'desc' => '<b>NOTE:</b> Make sure this is correct. Changing this name will create a new post type and any saved posts will be inaccessible',
			'id' => 'pt_name',
			'type' => 'text'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Singular Name',
			'id' => 'singular',
			'type' => 'text'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Plural Name',
			'desc' => '<b>NOTE:</b> This will be used if Post Type Name above is empty. i.e.: "Fences" here will create a post type named "fences". If this is changed and there is no Post Type Name, it will create a new post type and any saved posts will be inaccessible.',
			'id' => 'plural',
			'type' => 'text'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Menu Position',
			'desc' => 'The position in the menu order the post type should appear. show_in_menu must be true.',
			'id' => 'menu_position',
			'type' => 'select',
			'options' => array(
				'5' => 'below Posts',
				'10' => 'below Media',
				'15' => 'below Links',
				'20' => 'below Pages',
				'25' => 'below comments',
				'60' => 'below first separator',
				'65' => 'below Plugins',
				'70' => 'below Users',
				'75' => 'below Tools',
				'80' => 'below Settings',
				'100' => 'below second separator'
			),
			'default' => '5'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Hierarchical',
			'desc' => 'Whether the post type is hierarchical (e.g. page). Allows Parent to be specified. The supports parameter should contain page-attributes to show the parent select box on the editor page. <b>NOTE:</b> This must be True to use Simple Page ordering',
			'id' => 'hierarchical',
			'type' => 'radio_inline',
			'options' => array(
				true => 'True',
				false => 'False'
			),
			'default' => true
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Has Archive',
			'desc' => 'Enables post type archives. Will use $post_type as archive slug by default.',
			'id' => 'has_archive',
			'type' => 'radio_inline',
			'options' => array(
				true => 'True',
				false => 'False'
			),
			'default' => false
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Supports',
			'id' => 'supports',
			'type' => 'multicheck',
			'options' => array(
				'title' => 'Title',
				'editor' => 'Editor',
				'author' => 'Author',
				'thumbnail' => 'Thumbnail',
				'excerpt' => 'Excerpt',
				'trackbacks' => 'Trackbacks',
				'custom-fields' => 'Custom Fields',
				'comments' => 'Comments',
				'revisions' => 'Revisions',
				'page-attributes' => 'Page Attributes',
				'post-formats' => 'Post Formats'
			),
			'default' => array(
				'title',
				'editor',
				'author',
				'excerpt',
				'revisions'
			)
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Categories',
			'desc' => '',
			'id' => 'categories',
			'type' => 'radio_inline',
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No'
			),
			'default' => 'no'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Icon',
			'desc' => '<a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">Previews can be seen here.</a>',
			'id' => 'icon',
			'type' => 'select',
			'options' => $icons_list,
			'default' => ''
		) );
	}
	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		throw new Exception( 'Invalid property: ' . $field );
	}
}

/**
 * Helper function to get/return the cw_pt_Admin object
 * @since  0.1.0
 * @return cw_pt_Admin object
 */
function cw_pt_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new cw_pt_Admin();
		$object->hooks();
	}
	return $object;
}
/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed		Option value
 */
function cw_pt_get_option( $key = '' ) {
	// global $cw_cpt_Admin;
	// return cmb2_get_option( myprefix_admin()->key, $key );
	$cw_cpt = get_option(cw_pt_admin()->key);
	return $cw_cpt[$key];

}
// Get it started
cw_pt_admin();