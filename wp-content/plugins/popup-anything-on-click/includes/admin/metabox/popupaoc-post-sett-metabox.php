<?php
/**
 * Handles Post Setting metabox HTML
 *
 * @package Buttons With Style Pro
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $post;

// Taking some variables
$prefix 				= POPUPAOC_META_PREFIX; // Metabox prefix
$popup_type_list 		= popupaoc_popup_type();
$popup_effect_list 		= popupaoc_effect();
$popup_positionx_list	= popupaoc_positionx();
$popup_positiony_list 	= popupaoc_positiony();

$popup_fullscreen_list 	= popupaoc_popupfullscreen();
$popup_overlay_list     = popupaoc_popupoverlay();
$popup_lodaer_list 	    = popupaoc_lodaer();

// Getting saved values
$popup_type 			= get_post_meta( $post->ID, $prefix.'popup_type', true );
$popup_link_txt 		= get_post_meta( $post->ID, $prefix.'popup_link_txt', true );
$popup_button_txt 		= get_post_meta( $post->ID, $prefix.'popup_button_txt', true );
$popup_image_url 		= get_post_meta( $post->ID, $prefix.'popup_image_url', true );
$popup_image_id 		= get_post_meta( $post->ID, $prefix.'popup_image_id', true );
$image_title 			= get_post_meta( $post->ID, $prefix.'image_title', true );
$image_caption 			= get_post_meta( $post->ID, $prefix.'image_caption', true );
$full_screen 			= get_post_meta( $post->ID, $prefix.'full_screen', true );
$enable_loader 			= get_post_meta( $post->ID, $prefix.'enable_loader', true );
$enable_ovelay 			= get_post_meta( $post->ID, $prefix.'enable_ovelay', true );
$popup_effect 			= get_post_meta( $post->ID, $prefix.'popup_effect', true );
$popup_positionx 		= get_post_meta( $post->ID, $prefix.'popup_positionx', true );
$popup_positiony 		= get_post_meta( $post->ID, $prefix.'popup_positiony', true );
$popupwidth 			= get_post_meta( $post->ID, $prefix.'popupwidth', true );
$speedin 				= get_post_meta( $post->ID, $prefix.'speedin', true );
$speedout 				= get_post_meta( $post->ID, $prefix.'speedout', true );
$delay 					= get_post_meta( $post->ID, $prefix.'delay', true );

if($popup_type == 'simple_link' || $popup_type == '') {
	$popup_simple_style = 'style = "display:table"';
	$popup_img_style = 'style = "display:none"';
	$popup_img_btn = 'style = "display:none"';
} elseif($popup_type == 'image') {
	$popup_img_style = 'style = "display:table"';
	$popup_simple_style = 'style = "display:none"';
	$popup_img_btn = 'style = "display:none"';
}
else{
	$popup_img_btn = 'style = "display:table"';
	$popup_simple_style = 'style = "display:none"';
	$popup_img_style = 'style = "display:none"';
}
?>

<table class="form-table popupaoc-post-sett-tbl">
	<tbody>
		<!-- popup button text -->
		<tr valign="top">
			<th scope="row">
				<label for="popup-btn-type"><?php _e('Link type', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<select name="<?php echo $prefix;?>popup_type" class="popupaoc-select-box popup-btn-type" id="popup-btn-type">
					<?php
					if( !empty($popup_type_list) ) {
						foreach ($popup_type_list as $key => $value) {
							echo '<option value="'.$key.'" '.selected($popup_type,$key).'>'.$value.'</option>';
						}
					}
					?>
				</select>
				<br/>
				<span class="description"><?php _e('Select on click type ie where user going to click.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>
		<!-- Simple button settings -->
		<tr valign="top">
			<td colspan="2" class="popupaoc-no-padding">
				<table class="form-table popupaoc-simple-link" <?php echo $popup_simple_style;?>>
					<tr>
						<th><label for="popupaoc-simple-btn-name"><?php echo __('Link Text','popup-anything-on-click');?></label></th>
						<td class="row-meta">
							<input type="text" name="<?php echo $prefix;?>popup_link_txt" value="<?php echo $popup_link_txt; ?>" class="large-text" placeholder="<?php _e('Link Text', 'popup-anything-on-click'); ?>" /><br/>
							<span class="description"><?php _e('Enter text.', 'popup-anything-on-click'); ?></span>
						</td>
					</tr>

				</table>
				<table class="form-table popupaoc-simple-button" <?php echo $popup_img_btn;?>>

					<tr>
						<th>
							<?php _e('Button Text','popup-anything-on-click');?>
						</th>
						<td class="row-meta">
							<input type="text" name="<?php echo $prefix;?>popup_button_txt" value="<?php echo $popup_button_txt; ?>" class="large-text" placeholder="<?php _e('Button Text', 'popup-anything-on-click'); ?>" /><br/>
							<span class="description"><?php _e('Enter Popup button text.', 'popup-anything-on-click'); ?></span>
						</td>
					</tr>

					<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Button Custom Class','popup-anything-on-click');?> <span class="popupaoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span>
						</th>
						<td class="row-meta">
							<input type="text" name="" value="" class="regular-text"  disabled /><br/>
							<span class="description"><?php _e('Enter Popup button custom class if you want to apply your own custom styling.', 'popup-anything-on-click'); ?></span>
						   <?php echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get this option.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK); ?>
						</td>
					</tr>
					
				</table><!-- end .popupaoc-group-button-sett -->
				<table class="form-table popupaoc-simple-image" <?php echo $popup_img_style;?>>

					<tr>
						<th>
							<?php _e('Popup Image','popup-anything-on-click');?>
						</th>
						<td>
							<input type="text" name="<?php echo $prefix.'popup_image_url';?>" value="<?php echo $popup_image_url;?>" id="popup-anything-default-img" class="regular-text popup-antything-default-img popup-antything-img-upload-input" />
							<input type="button" name="popup_default_img" class="button-secondary popup-anything-img-uploader" value="<?php _e( 'Upload Image', 'popup-anything-on-click'); ?>" />
							<input type="button" name="popu_default_img_clear" id="popup-anything-default-img-clear" class="button button-secondary popup-anything-image-clear" value="<?php _e( 'Clear', 'popup-anything-on-click'); ?>" /> <br />
							<span class="description"><?php _e( 'Upload popup button image.','popup-anything-on-click' ); ?></span>
							<?php
								$default_img = '';
								if( !empty($popup_image_url)) { 
									$default_img = '<img src="'.esc_url($popup_image_url).'" alt="" />';
								}
							?>
							<div class="popup-anything-imgs-preview"><?php echo $default_img; ?></div>
							<input type="hidden" name="<?php echo $prefix.'popup_image_id';?>" value="<?php echo $popup_image_id; ?>" class="popup-image-id" />
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="paoc-image-title"><?php esc_html_e('Image Title', 'popup-anything-on-click'); ?></label></th>
						<td>
							<select name="<?php echo $prefix;?>image_title" class="popupaoc-select-box paoc-image-title" id="paoc-image-title">
								<option value="false" <?php selected( $image_title, 'false' ); ?>><?php esc_html_e('False', 'popup-anything-on-click'); ?></option>
								<option value="true" <?php selected( $image_title, 'true' ); ?>><?php esc_html_e('True', 'popup-anything-on-click'); ?></option>
							</select><br/>
							<span class="description"><?php esc_html_e('Enable Image Title.', 'popup-anything-on-click'); ?></span>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="paoc-image-caption"><?php esc_html_e('Image Caption', 'popup-anything-on-click'); ?></label></th>
						<td>
							<select name="<?php echo $prefix;?>image_caption" class="popupaoc-select-box paoc-image-caption" id="paoc-image-caption">
								<option value="false" <?php selected( $image_caption, 'false' ); ?>><?php esc_html_e('False', 'popup-anything-on-click'); ?></option>
								<option value="true" <?php selected( $image_caption, 'true' ); ?>><?php esc_html_e('True', 'popup-anything-on-click'); ?></option>
							</select><br/>
							<span class="description"><?php esc_html_e('Enable Image Caption.', 'popup-anything-on-click'); ?></span>
						</td>
					</tr>

				</table><!-- end .popupaoc-group-button-sett -->
			</td>
		</tr>
		<tr>
			<th scope="row" colspan="2"><div class="popupaoc-sub-sett-title"> <?php _e('Popup Screen and Effects', 'popup-anything-on-click'); ?></div></th>
		</tr>
		<!-- popup screen -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-style-type"><?php _e('Full Screen', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<select name="<?php echo $prefix;?>full_screen" class="popupaoc-select-box popupaoc-btn-clr-class" id="popupaoc-btn-clr-class">
					<?php
					if( !empty($popup_fullscreen_list) ) {
						foreach ($popup_fullscreen_list as $key => $value) {
							echo '<option value="'.$key.'" '.selected($full_screen,$key).'>'.$value.'</option>';
						}
					}
					?>
				</select><br/>
				<span class="description"><?php _e('Enable popup full screen. NOTE: If you are using Full Screen: True then Popup Width value added by you will not work.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>
		<!-- popup width -->
		
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-clr-class"><?php _e('Popup Width', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<input type="text" name="<?php echo $prefix;?>popupwidth" value="<?php echo $popupwidth; ?>" class="regular-text" placeholder="<?php _e('300px', 'popup-anything-on-click'); ?>" /><br/>
				<span class="description"><?php _e('Set popup width. e.g 80% OR 800px. Leave empty for default width.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>

		<!-- popup effect -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-clr-class"><?php _e('Effect', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<select name="<?php echo $prefix;?>popup_effect" class="popupaoc-select-box popupaoc-btn-clr-class" id="popupaoc-btn-clr-class">
					<?php
					if( !empty($popup_effect_list) ) {
						foreach ($popup_effect_list as $key => $value) {
							echo '<option value="'.$key.'" '.selected($popup_effect,$key).'>'.$value.'</option>';
						}
					}
					?>
				</select><br/>
				<span class="description"><?php _e('Select effect.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>
		<!-- popup speedin -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-clr-class"><?php _e('SpeedIn', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<input type="number" name="<?php echo $prefix;?>speedin" value="<?php echo $speedin; ?>" class="small-text" placeholder="<?php _e('300', 'popup-anything-on-click'); ?>" /><br/>
				<span class="description"><?php _e('Enter the speed start of the animation in milliseconds.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>
		<!-- popup speedout -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-clr-class"><?php _e('SpeedOut', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<input type="number" name="<?php echo $prefix;?>speedout" value="<?php echo $speedout; ?>" class="small-text" placeholder="<?php _e('300', 'popup-anything-on-click'); ?>" /><br/>
				<span class="description"><?php _e('Enter the speed end of the animation in milliseconds.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>
		<!-- popup delay -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-clr-class"><?php _e('Delay', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<input type="number" name="<?php echo $prefix;?>delay" value="<?php echo $delay; ?>" class="small-text" placeholder="<?php _e('150', 'popup-anything-on-click'); ?>" /><br/>
				<span class="description"><?php _e('Enter the wait before the transition effect start.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>

		<tr>
			<th scope="row" colspan="2"><div class="popupaoc-sub-sett-title"> <?php _e('Popup Position', 'popup-anything-on-click'); ?></div></th>
		</tr>

		<!-- popup positionx -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-clr-class"><?php _e('PositionX', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<select name="<?php echo $prefix;?>popup_positionx" class="popupaoc-select-box popupaoc-btn-clr-class" id="popupaoc-btn-clr-class">
					<?php
					if( !empty($popup_positionx_list) ) {
						foreach ($popup_positionx_list as $key => $value) {
							echo '<option value="'.$key.'" '.selected($popup_positionx,$key).'>'.$value.'</option>';
						}
					}
					?>
				</select><br/>
				<span class="description"><?php _e('Select positionx.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>
		<!-- popup positiony -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-clr-class"><?php _e('PositionY', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<select name="<?php echo $prefix;?>popup_positiony" class="popupaoc-select-box popupaoc-btn-clr-class" id="popupaoc-btn-clr-class">
					<?php
					if( !empty($popup_positiony_list) ) {
						foreach ($popup_positiony_list as $key => $value) {
							echo '<option value="'.$key.'" '.selected($popup_positiony,$key).'>'.$value.'</option>';
						}
					}
					?>
				</select><br/>
				<span class="description"><?php _e('Select positiony.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>

		<tr>
			<th scope="row" colspan="2"><div class="popupaoc-sub-sett-title"> <?php _e('Popup Overlay Setting', 'popup-anything-on-click'); ?></div></th>
		</tr>

		<!-- popup overlay -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-style-type"><?php _e('Enable Overlay', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<select name="<?php echo $prefix;?>enable_ovelay" class="popupaoc-select-box popupaoc-btn-clr-class" id="popupaoc-btn-clr-class">
					<?php
					if( !empty($popup_overlay_list) ) {
						foreach ($popup_overlay_list as $key => $value) {
							echo '<option value="'.$key.'" '.selected($enable_ovelay,$key).'>'.$value.'</option>';
						}
					}
					?>
				</select><br/>
				<span class="description"><?php _e('Enable Overlay', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>

		<!-- popup Overlay Color -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Popup Overlay Color','popup-anything-on-click');?> <span class="popupaoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span>
						</th>
						<td class="row-meta">
							<input type="text" name="" value="" class="regular-text"  disabled /><br/>
							<span class="description"><?php _e('Select popup overlay background color.', 'popup-anything-on-click'); ?></span>
						   <?php echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get this option.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK); ?>	 
						</td>
					</tr>

		<!-- popup Popup Overlay Opacity -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Popup Overlay Opacity','popup-anything-on-click');?> <span class="popupaoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span>
						</th>
						<td class="row-meta">
							<input type="number" name="" value="" class="small-text"  disabled /><br/>
							<span class="description"><?php _e('Set the popup overlay opacity. Value must be from 0 to 1.', 'popup-anything-on-click'); ?></span>
						   <?php echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get this option.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK); ?>	 
						</td>
					</tr>

		<!-- Close Popup On Overlay -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Close Popup On Overlay','popup-anything-on-click');?> <span class="popupaoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span>
						</th>
						<td class="row-meta">
							<input type="text" name="" value="" class="regular-text"  disabled /><br/>
							<span class="description"><?php _e('Allow users to close the popup by clicking the overlay or outside the popup.', 'popup-anything-on-click'); ?></span>
						   <?php echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get this option.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK); ?>	 
						</td>
					</tr>

		<tr>
			<th scope="row" colspan="2"><div class="popupaoc-sub-sett-title"> <?php _e('Popup Loader Setting', 'popup-anything-on-click'); ?></div></th>
		</tr>
		<!-- popup loader -->
		<tr valign="top">
			<th scope="row">
				<label for="popupaoc-btn-style-type"><?php _e('Enable Loader', 'popup-anything-on-click'); ?></label>
			</th>
			<td class="row-meta">
				<select name="<?php echo $prefix;?>enable_loader" class="popupaoc-select-box popupaoc-btn-clr-class" id="popupaoc-btn-clr-class">
					<?php
					if( !empty($popup_lodaer_list) ) {
						foreach ($popup_lodaer_list as $key => $value) {
							echo '<option value="'.$key.'" '.selected($enable_loader,$key).'>'.$value.'</option>';
						}
					}
					?>
				</select><br/>
				<span class="description"><?php _e('Enable loader.', 'popup-anything-on-click'); ?></span>
			</td>
		</tr>

		<!-- popup Loader Color -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Popup Loader Color','popup-anything-on-click');?> <span class="popupaoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span> 
						</th>
						<td class="row-meta">
							<input type="text" name="" value="" class="regular-text"  disabled /><br/>
							<span class="description"><?php _e(' Select popup loader color.', 'popup-anything-on-click'); ?></span>
						   <?php echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get this option.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK); ?>	 
						</td>
					</tr>
		<!-- popup Loader Speed -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Loader Speed','popup-anything-on-click');?> <span class="popupaoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span> 
						</th>
						<td class="row-meta">
							<input type="number" name="" value="" class="small-text"  disabled /><br/>
							<span class="description"><?php _e(' Enter the popup loader speed. Leave empty for default. Value should be in milliseconds. e.g 300.', 'popup-anything-on-click'); ?></span>
						   <?php echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get this option.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK); ?>	 
						</td>
					</tr>

		<tr class="popupaoc-pro-feature">
			<th scope="row" colspan="2"><div class="popupaoc-sub-sett-title"> <?php _e('Popup Colors Setting', 'popup-anything-on-click'); ?> <span class="popupaoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span></div> </th>
		</tr>
		
		<!-- Popup Background Color -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Popup Background Color','popup-anything-on-click');?> 
						</th>
						<td class="row-meta">
							<input type="text" name="" value="" class="regular-text"  disabled /><br/>
							<span class="description"><?php _e('Select popup background color.', 'popup-anything-on-click'); ?></span>
						</td>
		</tr>
		<!-- Popup Background Color Opacity -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Popup Background Color Opacity','popup-anything-on-click');?> 
						</th>
						<td class="row-meta">
							<input type="number" name="" value="" class="small-text"  disabled /><br/>
							<span class="description"><?php _e('Set the popup background color opacity if background image also added. Value must be from 0 to 1.', 'popup-anything-on-click'); ?></span>
						</td>
		</tr>
		<!-- Popup Background Color Opacity -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Popup Fonts Color','popup-anything-on-click');?> 
						</th>
						<td class="row-meta">
							<input type="text" name="" value="" class="regular-text"  disabled /><br/>
							<span class="description"><?php _e('Select popup fonts color.', 'popup-anything-on-click'); ?></span>
						</td>
		</tr>
		<!-- Buylink -->
		<tr class="popupaoc-pro-feature">
						<th>
							
						</th>
						<td class="row-meta">
							 <?php echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get these options.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK); ?>
						</td>
		</tr>

		<tr class="popupaoc-pro-feature">
			<th scope="row" colspan="2"><div class="popupaoc-sub-sett-title"> <?php _e('Popup Background Image Setting. (Note: These settings only works with Popup background image)', 'popup-anything-on-click'); ?> <span class="popupaoc-pro-tag"><?php _e('PRO','popup-anything-on-click');?></span></div></th>
		</tr>

		<!-- Background Image Repeat -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Background Image Repeat','popup-anything-on-click');?> 
						</th>
						<td class="row-meta">
							<select name="" class="popupaoc-select-box popupaoc-btn-clr-class" disabled>
								<option><?php esc_html_e('No Repeat', 'popup-anything-on-click'); ?></option>
								<option><?php esc_html_e('Repeat', 'popup-anything-on-click'); ?></option>
							</select><br/>
							<span class="description"><?php _e('Select popup background image repeat.', 'popup-anything-on-click'); ?></span>
						</td>
		</tr>

		<!-- Background Position X -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Background Position X','popup-anything-on-click');?> 
						</th>
						<td class="row-meta">
							<select name="" class="popupaoc-select-box popupaoc-btn-clr-class" disabled>
								<option><?php esc_html_e('Center', 'popup-anything-on-click'); ?></option>
								<option><?php esc_html_e('Center', 'popup-anything-on-click'); ?></option>
							</select><br/>
							<span class="description"><?php _e('Select popup background position X (Horizontal)', 'popup-anything-on-click'); ?></span>
						</td>
		</tr>
		<!-- Background Position Y -->
		<tr class="popupaoc-pro-feature">
						<th>
							<?php _e('Background Position Y','popup-anything-on-click');?> 
						</th>
						<td class="row-meta">
							<select name="" class="popupaoc-select-box popupaoc-btn-clr-class" disabled>
								<option><?php esc_html_e('Center', 'popup-anything-on-click'); ?></option>
								<option><?php esc_html_e('Center', 'popup-anything-on-click'); ?></option>
							</select><br/>
							<span class="description"><?php _e('Select popup background position Y (Vertical)', 'popup-anything-on-click'); ?></span>
						</td>
		</tr>

		<!-- Buylink -->
		<tr class="popupaoc-pro-feature">
						<th>
						</th>
						<td class="row-meta">
							 <?php echo sprintf( __( 'Upgrade to <a href="%s" target="_blank">Premium Version</a> to get these options.', 'popup-anything-on-click'), POPUPAOC_PLUGIN_LINK); ?>
						</td>
		</tr>
	</tbody>
</table><!-- end .popupaoc-post-sett-tbl -->