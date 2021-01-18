<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once( plugin_dir_path( __FILE__ ) . '/helper.php' );
$no_of_map_created = gmap_embed_no_of_post();
if ( isset( $_GET['page'] ) ) {

	// Form actions like Settings, Contact
	require_once( plugin_dir_path( __FILE__ ) . '/form_actions.php' );

	$wpgmap_page = esc_html( $_GET['page'] );
	$wpgmap_tag  = '';
	if ( isset( $_GET['tag'] ) ) {
		$wpgmap_tag = esc_html( $_GET['tag'] );
	}

	// In case of review snoozed
	if ( $wpgmap_tag == 'review-maybe-latter' ) {
		update_option( 'gmap_embed_is_review_snoozed', true );
		update_option( 'gmap_embed_review_snoozed_at', time() );
		$wpgmap_redirect_to = isset( $_GET['redirect_to'] ) ? $_GET['redirect_to'] : admin_url();
		echo "<script type='text/javascript'>window.location.href='$wpgmap_redirect_to'</script>";
	}

	// In case of review already done
	if ( $wpgmap_tag == 'review-done' ) {
		update_option( 'gmap_embed_is_review_done', true );
		$wpgmap_redirect_to = isset( $_GET['redirect_to'] ) ? $_GET['redirect_to'] : admin_url();
		echo "<script type='text/javascript'>window.location.href='$wpgmap_redirect_to'</script>";
	}
	?>
    <script type="text/javascript">
        var wp_gmap_api_key = '<?php echo esc_html( get_option( 'wpgmap_api_key' ) );?>';
    </script>
    <div class="wrap">
        <div id="gmap_container_inner">
            <!--contents-->

            <!--            Menu area-->
            <div class="gmap_header_section">

                <!--                Left area-->
                <div class="gmap_header_section_left">
                    <ul id="wp-gmap-nav">
                        <li class="<?php echo ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == '' ) ? 'active' : ''; ?>">
                            <a href="<?php echo admin_url(); ?>admin.php?page=wpgmapembed" data-id="wp-gmap-all"
                               class="media-menu-item"><?php _e( 'All Maps', 'gmap-embed' ); ?></a>
                        </li>
                        <li class="<?php echo $wpgmap_tag == 'new' ? 'active' : ''; ?>">
							<?php
							if ( gmap_embed_is_using_premium_version() ) { ?>
                                <a href="<?php echo esc_url( admin_url() . 'admin.php?page=wpgmapembed&tag=new' ); ?>"
                                   data-id="wp-gmap-new"
                                   class="media-menu-item"><?php _e( 'Create New Map', 'gmap-embed' ); ?></a>
							<?php } else {
								require_once( plugin_dir_path( __FILE__ ) . '/premium-version-notice.php' );
							}
							?>
                        </li>

                        <li class="<?php echo $wpgmap_tag == 'settings' ? 'active' : ''; ?>">
                            <a href="<?php echo esc_url( admin_url() . 'admin.php?page=wpgmapembed&tag=settings' ); ?>"
                               data-id="wp-gmap-settings"
                               class="media-menu-item"><?php _e( 'Settings', 'gmap-embed' ); ?></a>
                        </li>
                        <li class="<?php echo $wpgmap_tag == 'contact' ? 'active' : ''; ?>">
                            <a href="<?php echo esc_url( admin_url() . 'admin.php?page=wpgmapembed&tag=contact' ); ?>"
                               data-id="wp-gmap-settings"
                               class="media-menu-item"><?php _e( 'Having Problem?', 'gmap-embed' ); ?></a>
                        </li>
                        <li>
                            <a target="_blank"
                               href="<?php echo esc_url( 'https://www.youtube.com/watch?v=h8fLhYZb5_4' ); ?>"
                               class="media-menu-item">
								<?php _e( 'See Video', 'gmap-embed' ); ?></a>
                        </li>
                    </ul>
                </div>

                <!--    Right Area-->
                <div class="gmap_header_section_right">
                    <a class="gmap_donate_button"
                       href="<?php echo esc_url( 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZBERRKARGNEYA' ); ?>">
                        <img alt="Donate"
                             src="<?php echo esc_url( plugins_url( "../assets/images/paypal.png", __FILE__ ) ); ?>"
                             width="150"/>
                    </a>

					<?php
					if ( strlen( trim( get_option( 'wpgmapembed_license' ) ) ) !== 32 ) { ?>
                        <a target="_blank"
                           href="<?php echo esc_url( 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZBERRKARGNEYA' ); ?>"
                           class="button media-button button-default button-large gmap_get_pro_version">
                            GET PRO VERSION
                        </a>
						<?php
					} else {
						?>
                        <img style="margin-left: 10px;"
                             src="<?php echo esc_url( plugins_url( "../assets/images/pro_version.png", __FILE__ ) ); ?>"
                             width="80"/>
						<?php
					}
					?>
                    <a onclick="window.open('<?php echo esc_url( 'https://tawk.to/chat/5ca5dea51de11b6e3b06dc41/default' ); ?>', 'LIVE CHAT', 'width=500,height=300')"
                       style="float: right;cursor: pointer;">
                        <img src="<?php echo esc_url( plugins_url( "../assets/images/live_chat.png", __FILE__ ) ); ?>"
                             width="110"/>
                    </a>
                </div>
            </div>

            <div id="wp-gmap-tabs" style="float: left;width: 100%;">
				<?php
				if ( isset( $_GET['message'] ) ) {
					?>
                    <div class="message">
                        <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
                            <p>
                                <strong>
									<?php
									$message_status = $_GET['message'];
									switch ( $message_status ) {
										case 1:
											echo __( 'Map has been created Successfully. <a href="' . esc_url( 'https://youtu.be/Nh2z_oRK-RM?t=181' ) . '" target="_blank"> See How to use >></a>', 'gmap-embed' );
											break;
										case 2:
											echo __( 'Map Updated Successfully. <a href="' . esc_url( 'https://youtu.be/Nh2z_oRK-RM?t=181' ) . '" target="_blank"> See How to use >></a>', 'gmap-embed' );
											break;
										case 3:
											echo __( 'Settings updated Successfully.', 'gmap-embed' );
											break;
										case 4:
											echo __( $message, 'gmap-embed' );
											break;
										case - 1:
											echo __( 'Map Deleted Successfully.', 'gmap-embed' );
											break;
									}
									?>
                                </strong>
                            </p>
                            <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span>
                            </button>
                        </div>
                    </div>
					<?php
				}
				?>
				<?php
				if ( get_option( 'wpgmap_api_key' ) == false ) {
					require_once( plugin_dir_path( __FILE__ ) . '/wpgmap_settings.php' );
				}
				?>
                <!---------------------------Maps List-------------->
				<?php
				if ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == '' ) {
					?>
                    <div class="wp-gmap-tab-content active" id="wp-gmap-all">
						<?php
						require_once( plugin_dir_path( __FILE__ ) . '/wpgmap_list.php' );
						?>
                    </div>
					<?php
				}
				?>
                <!---------------------------Create New Map-------------->

                <div
                        class="wp-gmap-tab-content <?php echo ( $_GET['page'] == 'wpgmapembed' && $wpgmap_tag == 'new' ) ? 'active' : ''; ?>"
                        id="wp-gmap-new">
					<?php
					if ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == 'new' ) {
						require_once( plugin_dir_path( __FILE__ ) . '/wpgmap_create.php' );
					}
					?>
                </div>

                <!---------------------------Existing map update-------------->

                <div
                        class="wp-gmap-tab-content <?php echo ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == 'edit' ) ? 'active' : ''; ?>"
                        id="wp-gmap-edit">
					<?php
					if ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == 'edit' ) {
						require_once( plugin_dir_path( __FILE__ ) . '/wpgmap_edit.php' );
					}
					?>
                </div>

                <!---------------------------Plugin Settings-------------->

                <div
                        class="wp-gmap-tab-content <?php echo ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == 'contact' ) ? 'active' : ''; ?>"
                        id="wp-gmap-contact">
					<?php
					if ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == 'contact' ) {
						require_once( plugin_dir_path( __FILE__ ) . '/wpgmap_contact.php' );
					}
					?>
                </div>

                <!---------------------------Plugin Settings-------------->

                <div
                        class="wp-gmap-tab-content <?php echo ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == 'settings' ) ? 'active' : ''; ?>"
                        id="wp-gmap-settings">
					<?php
					if ( $wpgmap_page == 'wpgmapembed' && $wpgmap_tag == 'settings' ) {
						require_once( plugin_dir_path( __FILE__ ) . '/wpgmap_settings.php' );
					}
					?>
                </div>


            </div>
        </div>
    </div>
	<?php
}
?>
