<?php 
/**
* Plugin Name: CW Options Page
* Plugin URI: http://crane-west.com
* Description: Custom contact info page
* Version: 1.2
* Author: Joel Abeyta, Crane | West
* Author URI: http://crane-west.com
* License: GPLv2 or later
 */

// add customizable admin page
/**
 * CMB Theme Options
 * @version 0.1.0
 */
class cw_quicklinks_Admin {

/**
 * Option key, and option page slug
 * @var string
 */
private $key = 'cw_options_quicklinks';

/**
 * Array of metaboxes/fields
 * @var array
 */
protected $option_metabox = array();

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
	$this->title = __( 'Quick Links', 'cw_options' );
}

/**
 * Initiate our hooks
 * @since 0.1.0
 */
public function hooks() {
	add_action( 'admin_init', array( $this, 'init' ) );
	add_action( 'admin_menu', array( $this, 'add_options_page' ) );
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
	$this->options_page = add_menu_page( $this->title, $this->title, 'read', $this->key, array( $this, 'admin_page_display' ) );
}

/**
 * Admin page markup. Mostly handled by CMB
 * @since  0.1.0
 */
public function admin_page_display() {
	?>
	<div class="wrap cmb_options_page <?php echo $this->key; ?>">
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		<?php cmb2_metabox_form( self::option_fields(), $this->key ); ?>
	</div>
	<?php
}

/**
 * Defines the theme option metabox and field configuration
 * @since  0.1.0
 * @return array
 */
public function option_fields() {

// Only need to initiate the array once per page-load
	if ( ! empty( $this->option_metabox ) ) {
		return $this->option_metabox;
	}

	global $cw_page_list;
	global $cw_media_list;

	$prefix = 'cwo_';
	$this->fields = array(
		array(
			'id'          => $prefix . 'quicklinks',
			'type'        => 'group',
			'description' => '',
			'options'     => array(
			    'group_title'   => 'Quick Link {#}', // since version 1.1.4, {#} gets replaced by row number
			    'add_button'    => 'Add another link',
			    'remove_button' => 'Remove link',
			    'sortable'      => true, // beta
			),
			// Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
			'fields'      => array(
				array(
					'name' => 'Link Title',
					'desc' => 'NOTE: Page title, file name, or URL will be used if Link Title is empty. If Page URL, Page, and File are all empty, this Quick Link will not be shown',
					'id' => 'ql_title',
					'type' => 'text',
				),
				array(
					'name' => 'Page URL',
					'id' => 'ql_url',
					'type' => 'text_url',
				),
				array(
					'name' => 'Page',
					'id' => 'ql_page',
					'type' => 'select',
					'options' => $cw_page_list,
					'default' => ''
				),
				array(
					'name' => 'File',
					'id' => 'ql_file',
					'type' => 'select',
					'options' => $cw_media_list,
					'default' => ''
				)
			)
		)
	);

	$this->option_metabox = array(
		'id' => 'option_metabox',
		'show_on'=> array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
		'show_names' => true,
		'fields' => $this->fields,
		);

	return $this->option_metabox;
}

/**
 * Public getter method for retrieving protected/private variables
 * @since  0.1.0
 * @param  string  $field Field to retrieve
 * @return mixed  Field value or exception is thrown
 */
public function __get( $field ) {

// Allowed fields to retrieve
	if ( in_array( $field, array( 'key', 'fields', 'title', 'options_page' ), true ) ) {
		return $this->{$field};
	}
	if ( 'option_metabox' === $field ) {
		return $this->option_fields();
	}

	throw new Exception( 'Invalid property: ' . $field );
}

}

// Get it started
$cw_quicklinks_Admin = new cw_quicklinks_Admin();
$cw_quicklinks_Admin->hooks();

/**
 * Wrapper function around cmb_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixedOption value
 */
function cw_options_get_quicklinks( $key = '' ) {
	global $cw_quicklinks_Admin;
	// return cmb_get_option( $cw_quicklinks_Admin->key, $key );
	$cw_options = get_option('cw_options_quicklinks');
	return $cw_options[$key];
}