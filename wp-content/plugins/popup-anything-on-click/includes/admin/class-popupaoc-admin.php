<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Popup Anything
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Popupaoc_Admin {

	function __construct() {
		
		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'popupaoc_post_sett_metabox') );

		// Action to save metabox
		add_action( 'save_post', array($this, 'popupaoc_save_metabox_value') );

		// Action to add custom column to Slider listing
		add_filter( 'manage_'.POPUPAOC_POST_TYPE.'_posts_columns', array($this, 'popupaoc_manage_posts_columns') );

		// Action to add custom column data to Slider listing
		add_action('manage_'.POPUPAOC_POST_TYPE.'_posts_custom_column', array($this, 'popupaoc_post_columns_data'), 10, 2);

		// Filter to add row data
		add_filter( 'post_row_actions', array($this, 'popupaoc_add_post_row_action'), 10, 2 );
		
		// Action to add admin menu
		add_action( 'admin_menu', array($this, 'popupaoc_register_menu'), 12 );

		// Admin prior process
		add_action( 'admin_init', array($this, 'popupaoc_admin_init_process') );
	}

	/**
	 * Post Settings Metabox
	 * 
	 * @package Popup Anything
	 * @since 1.0.0
	 */
	function popupaoc_post_sett_metabox() {
		add_meta_box( 'popupaoc-post-sett', __( 'Popup Anything - Settings', 'popup-anything-on-click' ), array($this, 'popupaoc_post_sett_mb_content'), POPUPAOC_POST_TYPE, 'normal', 'high' );
		add_meta_box( 'popupaoc-meta-box-gevent', __( 'Google Analytic Event Setting', 'popup-anything-on-click' ), array($this, 'popupaoc_gevent_callback'), POPUPAOC_POST_TYPE, 'side');	
		add_meta_box( 'popupaoc-meta-box-popupimg', __( 'Popup Background Image', 'popup-anything-on-click' ), array($this, 'popupaoc_bgimg_callback'), POPUPAOC_POST_TYPE, 'side');	
		add_meta_box( 'popupaoc-meta-box-shortcode', __( 'Shortcode', 'popup-anything-on-click' ), array($this, 'popupaoc_shortcode_display_callback'), POPUPAOC_POST_TYPE, 'side');
		
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @package Popup Anything
	 * @since 1.0.0
	 */
	function popupaoc_post_sett_mb_content() {
		include_once( POPUPAOC_DIR .'/includes/admin/metabox/popupaoc-post-sett-metabox.php');
	}
	
	/**
	* Meta box to display shortcode
	*
	* @package Popup Anything
	*/
	function popupaoc_shortcode_display_callback( $post) {
		echo "<h3>" .__( 'Shortcode', 'popup-anything-on-click'). "</h3>";
		echo "<p>" .__( 'To display popup button or link, add the following shortcode to your page or post.', 'popup-anything-on-click' ). "</p>";
		echo '<div class="popupaoc-shortcode-preview">[popup_anything id="'.$post->ID.'"]</div>';	
		echo "<h3>" .__( 'Template Code', 'popup-anything-on-click'). "</h3>";
		echo "<p>" .__( 'If adding the button or link to your theme files, add the following template code.', 'popup-anything-on-click' ). "</p>";
		echo '<div class="popupaoc-shortcode-preview">&lt;?php echo do_shortcode(\'[popup_anything id="'.$post->ID.'"]\'); ?&gt;</div>';		
	}
	
	/**
	* Meta box to display popup bg image
	*
	* @package Popup Anything
	*/
	function popupaoc_bgimg_callback( $post) {
		echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get this option.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK);			
	}
	
	/**
	* Meta box to display event tracking
	*
	* @package Popup Anything
	*/
	function popupaoc_gevent_callback( $post) {
		?>
		<table class="paoc-pro-ggl-anlyc-tbl form-table popupaoc-pro-feature">
		<tbody>
		<tr>
			<th scope="row"><label for="paoc-pro-analytic-action"><?php esc_html_e('Event Action', 'popup-anything-on-click'); ?></label></th>
			<td>
				<input type="text" class="custom-small-text" name="" value="Popup-Click" disabled /><br/>
				<span class="description"><?php esc_html_e('Enter event action. eg : Popup-Click', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="paoc-pro-analytic-event"><?php esc_html_e('Event Category', 'popup-anything-on-click'); ?></label></th>
			<td>
				<input type="text" class="custom-small-text" name="" value="Popup-Open" disabled  /><br/>
				<span class="description"><?php esc_html_e('Enter event category. Eg: Popup-Open', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="paoc-pro-analytic-label"><?php esc_html_e('Event Label', 'popup-anything-on-click'); ?></label></th>
			<td>
				<input type="text" class="custom-small-text" name="" value="Popup" disabled /><br/>
				<span class="description"><?php esc_html_e('Enter event label. eg: Popup', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>		
	</tbody>
	</table>
	
		<?php 
		echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get this option.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK);			
	}

	/**
	 * Function to save metabox values
	 * 
	 * @package Popup Anything
	 * @since 1.0.0
	 */
	function popupaoc_save_metabox_value( $post_id ) {

		global $post_type;
		
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  POPUPAOC_POST_TYPE ) )              				// Check if current post type is supported.
		{
		  return $post_id;
		}

		$prefix = POPUPAOC_META_PREFIX; // Taking metabox prefix

		// Taking variables
		$popup_type 		= isset($_POST[$prefix.'popup_type']) 			? popupaoc_clean( $_POST[$prefix.'popup_type'] ) 			: '';
		$popup_image_url 	= isset($_POST[$prefix.'popup_image_url']) 		? popupaoc_clean_url( $_POST[$prefix.'popup_image_url'] ) 	: '';
		$popup_image_id 	= isset($_POST[$prefix.'popup_image_id']) 		? popupaoc_clean_numeric( $_POST[$prefix.'popup_image_id'] ) 	: '';
		$image_title 		= isset($_POST[$prefix.'image_title']) 			? popupaoc_clean($_POST[$prefix.'image_title']) 			: 'false';
		$image_caption 	 	= isset($_POST[$prefix.'image_caption']) 		? popupaoc_clean( $_POST[$prefix.'image_caption'] )			: 'false';
		$popup_button_txt 	= isset($_POST[$prefix.'popup_button_txt']) 	? popupaoc_clean( $_POST[$prefix.'popup_button_txt'] ) 	 	: '';
		$popup_link_txt 	= isset($_POST[$prefix.'popup_link_txt']) 		? popupaoc_clean( $_POST[$prefix.'popup_link_txt'] ) 		: '';
		$full_screen 		= isset($_POST[$prefix.'full_screen']) 			? popupaoc_clean( $_POST[$prefix.'full_screen'])	 		: '';
		$enable_loader 		= isset($_POST[$prefix.'enable_loader']) 		? popupaoc_clean( $_POST[$prefix.'enable_loader'] )			: '';
		$enable_ovelay 		= isset($_POST[$prefix.'enable_ovelay']) 		? popupaoc_clean( $_POST[$prefix.'enable_ovelay'] )			: '';
		$popup_effect 		= isset($_POST[$prefix.'popup_effect']) 		? popupaoc_clean( $_POST[$prefix.'popup_effect'] )			: '';
		$popup_positionx 	= isset($_POST[$prefix.'popup_positionx']) 		? popupaoc_clean( $_POST[$prefix.'popup_positionx'] )		: '';
		$popup_positiony 	= isset($_POST[$prefix.'popup_positiony']) 		? popupaoc_clean( $_POST[$prefix.'popup_positiony'] )		: '';
		$popupwidth 		= isset($_POST[$prefix.'popupwidth']) 			? popupaoc_clean ( $_POST[$prefix.'popupwidth'] ) 			: '';
		$speedin 			= isset($_POST[$prefix.'speedin']) 				? popupaoc_clean_numeric ( $_POST[$prefix.'speedin'], 300 ) : 300;
		$speedout 			= isset($_POST[$prefix.'speedout']) 			? popupaoc_clean_numeric ( $_POST[$prefix.'speedout'], 300 ): 300;
		$delay 				= isset($_POST[$prefix.'delay']) 				? popupaoc_clean_numeric ( $_POST[$prefix.'delay'], 150 ) 	: 150;
		
		update_post_meta($post_id, $prefix.'popup_type', $popup_type);
		update_post_meta($post_id, $prefix.'popup_button_txt', $popup_button_txt);
		update_post_meta($post_id, $prefix.'popup_link_txt', $popup_link_txt);
		update_post_meta($post_id, $prefix.'popup_image_url', $popup_image_url);
		update_post_meta($post_id, $prefix.'popup_image_id', $popup_image_id);
		update_post_meta($post_id, $prefix.'image_title', $image_title);
		update_post_meta($post_id, $prefix.'image_caption', $image_caption);
		update_post_meta($post_id, $prefix.'full_screen', $full_screen);
		update_post_meta($post_id, $prefix.'enable_loader', $enable_loader);
		update_post_meta($post_id, $prefix.'enable_ovelay', $enable_ovelay);
		update_post_meta($post_id, $prefix.'popup_effect', $popup_effect);
		update_post_meta($post_id, $prefix.'popup_positionx', $popup_positionx);
		update_post_meta($post_id, $prefix.'popup_positiony', $popup_positiony);
		update_post_meta($post_id, $prefix.'popupwidth', $popupwidth);
		update_post_meta($post_id, $prefix.'speedin', $speedin);
		update_post_meta($post_id, $prefix.'speedout', $speedout);
		update_post_meta($post_id, $prefix.'delay', $delay);
	}

	/**
	 * Add custom column to Post listing page
	 * 
	 * @package Popup Anything
	 * @since 1.0.0
	 */
	function popupaoc_manage_posts_columns( $columns ) {
		
		$new_columns['popupaoc_shortcode'] 	= __( 'Shortcode', 'popup-anything-on-click' );	   

	    $columns = popupaoc_add_array( $columns, $new_columns, 1, true );

	    return $columns;
	}

	/**
	 * Add custom column data to Post listing page
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_post_columns_data( $column, $post_id ) {

		$prefix = POPUPAOC_META_PREFIX; // Taking metabox prefix

	    switch ($column) {
			case 'popupaoc_shortcode':			
				$shortcode_string = '';
				$shortcode_string .= '[popup_anything id="'.$post_id.'"] ';				
				echo $shortcode_string;
				break;
		}
	}

	/**
	 * Function to add custom quick links at post listing page
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_add_post_row_action($actions, $post ) {
		if( $post->post_type == POPUPAOC_POST_TYPE ) {
			return array_merge( array( 'popupaoc_id' => 'ID: ' . $post->ID ), $actions );
		}
		return $actions;
	}
	
	/**
	 * Function to add menu
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_register_menu() {

		// Setting page
		add_submenu_page( 'edit.php?post_type='.POPUPAOC_POST_TYPE, __('Settings - Popup Anything on Click', 'popup-anything-on-click'), __('Settings', 'popup-anything-on-click'), 'manage_options', 'popupaoc-settings', array($this, 'popupaoc_settings_page') );

		// Register plugin premium page
		add_submenu_page( 'edit.php?post_type='.POPUPAOC_POST_TYPE, __('Upgrade to PRO - Popup Anything', 'popup-anything-on-click'), '<span style="color:#2ECC71">'.__('Upgrade to PRO', 'popup-anything-on-click').'</span>', 'manage_options', 'popupaoc-premium', array($this, 'popupaoc_premium_page') );

		// Hire Us Menu
		add_submenu_page( 'edit.php?post_type='.POPUPAOC_POST_TYPE, __('Hire Us', 'popup-anything-on-click'), '<span style="color:#2ECC71">'.__('Hire Us', 'popup-anything-on-click').'</span>', 'manage_options', 'popupaoc-hireus', array($this, 'popupaoc_hireus_page') );		
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_settings_page() {
		include_once( POPUPAOC_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Popup Anything on Click
	 * @since 1.0.0
	 */
	function popupaoc_premium_page() {
		include_once( POPUPAOC_DIR . '/includes/admin/settings/premium.php' );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Popup Anything on Click
	 * @since 1.2.2
	 */
	function popupaoc_hireus_page() {
		include_once( POPUPAOC_DIR . '/includes/admin/settings/hire-us.php' );
	}

	/**
	 * Admin Prior Process
	 * 
	 * @package Popup Anything on Click
	 * @since 1.2.2
	 */
	function popupaoc_admin_init_process() {
		// If plugin notice is dismissed
	    if( isset($_GET['message']) && $_GET['message'] == 'popupaoc-plugin-notice' ) {
	    	set_transient( 'popupaoc_install_notice', true, 604800 );
	    }

	    // Register Plugin Settings
		register_setting( 'popupaoc_plugin_options', 'popupaoc_options', array($this, 'popupaoc_validate_options') );
	}

	/**
	 * Validate Settings Options
	 * 
	 * @package Popup Anything on Click
	 * @since 1.6.1
	 */
	function popupaoc_validate_options( $input ) {

		$input['add_js'] = isset($input['add_js']) ? $input['add_js'] : '';
		
		return $input;
	}
}

$popupaoc_admin = new Popupaoc_Admin();