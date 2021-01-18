<?php
/**
 * Settings Page
 *
 * @package Popup Anything on Click
 * @since 1.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $popupaoc_options;
$add_js = popupaoc_get_option('add_js');

?>

<div class="wrap popupaoc-settings">

	<h2><?php _e( 'Popup Anything on Click - Settings', 'popup-anything-on-click' ); ?></h2>

	<?php
	// Success message
	if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ) {
		echo '<div id="message" class="updated notice notice-success is-dismissible">
				<p><strong>'.__("Your changes saved successfully.", "popup-anything-on-click").'</strong></p>
			  </div>';
	}
	?>

	<form action="options.php" method="POST" id="popupaoc-settings-form" class="popupaoc-settings-form">

		<?php settings_fields( 'popupaoc_plugin_options' ); ?>

		<div class="metabox-holder">
			<div class="meta-box-sortables">

				<!-- General Settings Starts -->
				<div class="postbox">

					<button class="handlediv button-link" type="button"><span class="toggle-indicator"></span></button>

					<!-- Settings box title -->
					<h3 class="hndle">
						<span><?php _e( 'General Settings', 'popup-anything-on-click' ); ?></span>
					</h3>

					<div id="general" class="inside">
						<table class="form-table popupaoc-general-sett-tbl">
							<tbody>
								<tr>
									<th scope="row">
										<label for="popupaoc-add-js"><?php _e('Manage Polyfill JS', 'popup-anything-on-click'); ?></label>
									</th>
									<td>
										<select name="popupaoc_options[add_js]" class="popupaoc-add-js" id="popupaoc-add-js">
											<option value=""><?php _e('Select Option', 'popup-anything-on-click'); ?></option>
											<option value="1" <?php selected( $add_js, 1 ); ?>><?php _e('Disable polyfill js file to load from this plugin', 'popup-anything-on-click'); ?></option>
											<option value="2" <?php selected( $add_js, 2 ); ?>><?php _e('Include polyfill js file in header', 'popup-anything-on-click'); ?></option>
										</select><br>
										<span class="description"><?php esc_html_e( 'Note : If you are facing any error related Polyfill JS eg : Uncaught Error: only one instance of babel-polyfill is allowed, than select above option to hide plugin polyfill js or inluclude polyfill js in header so no conflict arise with default js of WordPress. You are getting this error because of there are two version of polyfill.js loading in your website.', 'popup-anything-on-click'); ?></span>
									</td>
								</tr>
								<tr>
									<td colspan="2" scope="row">
										<input type="submit" name="popupaoc_sett_submit" class="button button-primary right" value="<?php _e('Save Changes', 'popup-anything-on-click'); ?>" />
									</td>
								</tr>
							</tbody>
						</table>
					</div><!-- .inside -->
				</div><!-- .postbox -->
				<!-- General Settings Ends -->

			</div><!-- .meta-box-sortables -->
		</div><!-- .metabox-holder -->

	</form><!-- end .popupaoc-settings-form -->
</div><!-- end .popupaoc-settings -->