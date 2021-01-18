<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div data-columns="8">
    <div class="wpgmapembed_get_api_key" style="padding: 17px;background-color: #f1f1f1;margin: 17px;width: 50%;">
        <span style="font-size: 23px;font-weight: 400;margin: 0;padding: 9px 0 4px 0;line-height: 1.3;">API Key and License Information</span>
        <hr/>
        <table class="form-table" role="presentation">

            <tbody>
            <form method="post" action="<?php echo admin_url(); ?>admin.php?page=wpgmapembed&message=3">
                <tr>
                    <th scope="row">
                        <label for="blogname">
							<?php _e( 'Enter API Key: ', 'gmap-embed' ); ?>
                        </label>
                    </th>
                    <td scope="row">
                        <input type="text" name="wpgmapembed_key"
                               value="<?php echo esc_html( get_option( 'wpgmap_api_key' ) ); ?>"
                               size="45" class="regular-text"/>
                        <p class="description" id="tagline-description">
							<?php _e( 'The API key may take up to 5 minutes to take effect', 'gmap-embed' ); ?>
                        </p>
                    </td>
                    <td width="30%" style="vertical-align: top;">
                        <button class="wd-btn wd-btn-primary button media-button button-primary"><?php _e( 'Save', 'gmap-embed' ); ?></button>
                        <a target="_blank" style="margin-left: 5px;" href="
					<?php echo esc_url( 'https://console.developers.google.com/flows/enableapi?apiid=maps_backend,places_backend,geolocation,geocoding_backend,directions_backend&amp;keyType=CLIENT_SIDE&amp;reusekey=true' ); ?>"
                           class="button media-button button-default button-large">
							<?php _e( 'GET FREE API KEY', 'gmap-embed' ); ?>
                        </a>
                    </td>
                </tr>
            </form>

            <form method="post" action="<?php echo admin_url(); ?>admin.php?page=wpgmapembed&message=4">
                <tr>
                    <th scope="row">
                        <label for="blogname">
							<?php _e( 'License Key: ', 'gmap-embed' ); ?>
                        </label>
                    </th>
                    <td scope="row">
                        <input type="text" name="wpgmapembed_license"
                               value="<?php echo esc_html( get_option( 'wpgmapembed_license' ) ); ?>"
                               size="45" class="regular-text"/>
                        <p class="description" id="tagline-description">
							<?php _e( 'After payment you will get an email with license key', 'gmap-embed' ); ?>
                        </p>
                    </td>
                    <td width="30%" style="vertical-align: top;">
                        <button class="wd-btn wd-btn-primary button media-button button-primary"><?php _e( 'Save', 'gmap-embed' ); ?></button>

						<?php
						if ( strlen( trim( get_option( 'wpgmapembed_license' ) ) ) !== 32 ) { ?>
                            <a target="_blank"
                               href="<?php echo esc_url( 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZBERRKARGNEYA' ); ?>"
                               class="button media-button button-default button-large"><?php _e( 'GET LICENSE KEY', 'gmap-embed' ); ?></a>
							<?php
						}
						?>
                    </td>
                </tr>
            </form>
            </tbody>
        </table>
    </div>
</div>

<div data-columns="8">
    <div class="wpgmapembed_get_api_key" style="padding: 17px;background-color: #f1f1f1;margin: 17px;width: 50%;">
        <span style="font-size: 23px;font-weight: 400;margin: 0;padding: 9px 0 4px 0;line-height: 1.3;">Map Language and Regional Settings</span>>
        <hr/>
        <table class="form-table" role="presentation">

            <tbody>
            <form method="post" action="<?php echo admin_url(); ?>admin.php?page=wpgmapembed&message=4">
                <tr>
                    <th scope="row">
                        <label for="blogname">
							<?php _e( 'Map Language: ', 'gmap-embed' ); ?>
                        </label>
                    </th>
                    <td scope="row">
                        <select id="language" name="srm_gmap_lng" class="regular-text" style="width: 25em">
							<?php
							$wpgmap_languages = gmap_embed_get_languages();
							if ( count( $wpgmap_languages ) > 0 ) {
								foreach ( $wpgmap_languages as $lng_key => $language ) {
									$selected = '';
									if ( get_option( 'srm_gmap_lng', 'en' ) == $lng_key ) {
										$selected = 'selected';
									}
									echo "<option value='$lng_key' $selected>$language</option>";
								}
							}
							?>
                        </select>
                        <p class="description" id="tagline-description">
							<?php _e( 'Chose your desired map language', 'gmap-embed' ); ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="blogname">
							<?php _e( 'Map Region: ', 'gmap-embed' ); ?>
                        </label>
                    </th>
                    <td scope="row">
                        <select id="region" name="srm_gmap_region" class="regular-text" style="width: 25em">
							<?php
							$wpgmap_regions = gmap_embed_get_regions();
							if ( count( $wpgmap_regions ) > 0 ) {
								foreach ( $wpgmap_regions as $region_key => $region ) {
									$selected = '';
									if ( get_option( 'srm_gmap_region', 'US' ) == $region_key ) {
										$selected = 'selected';
									}
									echo "<option value='$region_key' $selected>$region</option>";
								}
							}
							?>

                        </select>
                        <p class="description" id="tagline-description">
							<?php _e( 'Chose your regional area', 'gmap-embed' ); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button name="srm_gmap_map_language_settings"
                                class="wd-btn wd-btn-primary button media-button button-primary"><?php _e( 'Update', 'gmap-embed' ); ?></button>
                    </td>
                </tr>
            </form>
            </tbody>
        </table>
    </div>
</div>