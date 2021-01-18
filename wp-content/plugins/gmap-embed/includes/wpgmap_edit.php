<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$gmap_data     = $this->get_wpgmapembed_data( intval( $_GET['id'] ) );
$wpgmap_single = json_decode( $gmap_data );
list( $wpgmap_lat, $wpgmap_lng ) = explode( ',', esc_html( $wpgmap_single->wpgmap_latlng ) );
?>
<div data-columns="8">
    <!--    getting hidden id-->
    <input id="wpgmap_map_id" name="wpgmap_map_id" value="<?php echo intval( $_GET['id'] ); ?>" type="hidden"/>

    <span class="wpgmap_msg_error" style="width:80%;">
<!--        error will goes here-->
    </span>
    <div class="wp-gmap-properties-outer">
        <div class="wpgmap_tab_menu">
            <ul class="wpgmap_tab">
                <li class="active" id="wp-gmap-properties">General</li>
                <li id="wp-gmap-other-properties">Other Settings</li>
            </ul>
        </div>
        <div class="wp-gmap-tab-contents wp-gmap-properties">
            <table style="width: 100% !important;" class="gmap_properties">
                <tr>
                    <td>
                        <label for="wpgmap_title"><b><?php _e( 'Map Title', 'gmap-embed' ); ?></b></label><br/>
                        <input id="wpgmap_title" name="wpgmap_title"
                               value="<?php echo esc_attr( $wpgmap_single->wpgmap_title ); ?>"
                               type="text"
                               class="regular-text">
                        <br/>

                        <input type="checkbox" value="1" name="wpgmap_show_heading"
                               id="wpgmap_show_heading" <?php echo ( $wpgmap_single->wpgmap_show_heading == 1 ) ? 'checked' : ''; ?>>
                        <label for="wpgmap_show_heading"><?php _e( 'Show as map title', 'gmap-embed' ); ?></label>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="wpgmap_latlng"><b><?php _e( 'Latitude, Longitude', 'gmap-embed' ); ?></b></label><br/>
                        <input id="wpgmap_latlng" name="wpgmap_latlng"
                               value="<?php echo esc_attr( $wpgmap_single->wpgmap_latlng ); ?>"
                               type="text"
                               class="regular-text">
                    </td>
                </tr>

                <tr>
                    <td>
                        <input id="wpgmap_upload_hidden" type="hidden" size="36" name="upload_image"
                               value="<?php echo $wpgmap_single->wpgmap_marker_icon; ?>"/>
                        <img src="<?php echo $wpgmap_single->wpgmap_marker_icon; ?>"
                             id="wpgmap_icon_img" width="32" style="float: left;">
                        <input id="upload_image_button" type="button" value="Change Marker Icon"
                               style="float: left;margin-left: 14px;margin-top: 12px;"/>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="wpgmap_map_zoom"><b><?php _e( 'Zoom', 'gmap-embed' ); ?></b></label><br/>
                        <input id="wpgmap_map_zoom" name="wpgmap_map_zoom"
                               value="<?php echo esc_attr( $wpgmap_single->wpgmap_map_zoom ); ?>" type="text"
                               class="regular-text">


                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="wpgmap_map_width"><b><?php _e( 'Width (%)', 'gmap-embed' ); ?></b></label><br/>
                        <input id="wpgmap_map_width" name="wpgmap_map_width"
                               value="<?php echo esc_attr( $wpgmap_single->wpgmap_map_width ); ?>"
                               type="text" class="regular-text">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="wpgmap_map_height"><b><?php _e( 'Height (px)', 'gmap-embed' ); ?></b></label><br/>
                        <input id="wpgmap_map_height" name="wpgmap_map_height"
                               value="<?php echo esc_attr( $wpgmap_single->wpgmap_map_height ); ?>"
                               type="text" class="regular-text">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label><b><?php _e( 'Map Type', 'gmap-embed' ); ?></b></label><br/>
                        <select id="wpgmap_map_type" class="regular-text" style="width:25em;">
                            <option <?php echo $wpgmap_single->wpgmap_map_type == 'ROADMAP' ? 'selected' : ''; ?>>
                                ROADMAP
                            </option>
                            <option <?php echo $wpgmap_single->wpgmap_map_type == 'SATELLITE' ? 'selected' : ''; ?>>
                                SATELLITE
                            </option>
                            <option <?php echo $wpgmap_single->wpgmap_map_type == 'HYBRID' ? 'selected' : ''; ?>>HYBRID
                            </option>
                            <option <?php echo $wpgmap_single->wpgmap_map_type == 'TERRAIN' ? 'selected' : ''; ?>>
                                TERRAIN
                            </option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="wpgmap_map_address"><b><?php _e( 'Location Address', 'gmap-embed' ); ?></b></label><br/>
                        <textarea id="wpgmap_map_address" style="width:25em;" name="wpgmap_map_address"
                                  class="regular-text"
                                  rows="3"><?php echo esc_attr( trim( $wpgmap_single->wpgmap_map_address ) ); ?></textarea>

                        <br/>

                        <label for="wpgmap_show_infowindow"><input type="checkbox" value="1"
                                                                   name="wpgmap_show_infowindow"
                                                                   id="wpgmap_show_infowindow" <?php echo ( $wpgmap_single->wpgmap_show_infowindow == 1 ) ? 'checked' : ''; ?>>
							<?php _e( 'Show in marker infowindow', 'gmap-embed' ); ?>
                        </label>

                        <br/>


                    </td>
                </tr>

            </table>
        </div>
        <div class="wp-gmap-tab-contents wp-gmap-other-properties hidden">
            <table class="gmap_properties">
                <tr>
                    <td>
                        <label for="wpgmap_heading_class"><b><?php _e( 'Heading Custom Class', 'gmap-embed' ); ?></b></label><br/>
                        <input id="wpgmap_heading_class" name="wpgmap_heading_class"
                               value="<?php echo $wpgmap_single->wpgmap_heading_class; ?>" type="text"
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="wpgmap_enable_direction"><input type="checkbox" value="1"
                                                                    name="wpgmap_enable_direction"
                                                                    id="wpgmap_enable_direction" <?php echo ( $wpgmap_single->wpgmap_enable_direction == 1 ) ? 'checked' : ''; ?>>
							<?php _e( 'Enable Direction in Map', 'gmap-embed' ); ?>
                        </label>


                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="wpgmap_disable_zoom_scroll"><input type="checkbox" value="1"
                                                                       name="wpgmap_disable_zoom_scroll"
                                                                       id="wpgmap_disable_zoom_scroll" <?php echo ( $wpgmap_single->wpgmap_disable_zoom_scroll == 1 ) ? 'checked' : ''; ?>>
							<?php _e( 'Disable zoom on mouse scroll', 'gmap-embed' ); ?>
                        </label>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="wp-gmap-preview">
        <h1 id="wpgmap_heading_preview"
            style="padding: 0px;margin: 0px;"><?php echo $wpgmap_single->wpgmap_title; ?></h1>
        <input id="pac-input" class="controls" type="text"
               placeholder="<?php _e( 'Search by Address, Zip Code', 'gmap-embed' ); ?>"/>
        <div id="map" style="height: 415px;"></div>
    </div>
    <script type="text/javascript"
            src="<?php echo esc_url( plugins_url( "../assets/js/geo_based_map_edit.js?v=".filemtime(__DIR__.'/../assets/js/geo_based_map_edit.js'), __FILE__ ) ); ?>"></script>
    <script>
        (function ($) {
            $(function () {
                icon = '<?php echo $wpgmap_single->wpgmap_marker_icon;?>';
                google.maps.event.addDomListener(window, 'load',
                    initAutocomplete('map', 'pac-input',<?php echo $wpgmap_lat;?>,<?php echo $wpgmap_lng;?>, '<?php echo $wpgmap_single->wpgmap_map_type; ?>',<?php echo $wpgmap_single->wpgmap_map_zoom;?>, 'edit')
                );
                if (jQuery('#wpgmap_show_infowindow').is(':checked') === true) {
                    openInfoWindow();
                }
            });
        })(jQuery);
    </script>
</div>

<div class="media-frame-toolbar">
    <div class="media-toolbar">
        <div class="media-toolbar-secondary"
             style="text-align: right;float: right;margin-top:10px;">
            <span class="spinner" style="margin: 0px !important;float:left;"></span>
            <button class="button button-primary" style="margin-right:10px;"
                    id="wp-gmap-embed-update"><?php _e( 'Update', 'gmap-embed' ); ?></button>
        </div>
    </div>
</div>