<?php
/*
  Plugin Name: Google Map Embed
  Plugin URI: https://www.srmilon.info
  Description: The plugin will help to embed Google Map in post and pages also in sidebar as widget.
  Author: srmilon.info
  Text Domain: gmap-embed
  Domain Path: /languages
  Author URI: https://www.srmilon.info
  Version: 1.6.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once plugin_dir_path( __FILE__ ) . '/includes/helper.php';
load_plugin_textdomain( 'gmap-embed', false, dirname( plugin_basename( __FILE__, '/languages/' ) ) );
if ( ! class_exists( 'srm_gmap_embed_main' ) ) {

	class srm_gmap_embed_main {

		private $plugin_name = 'Google Map SRM';
		public $wpgmap_api_key = 'AIzaSyD79uz_fsapIldhWBl0NqYHHGBWkxlabro';


		/**
		 * constructor function
		 */
		function __construct() {
			$this->wpgmap_api_key = get_option( 'wpgmap_api_key' );
			add_action( 'plugins_loaded', array( $this, 'wpgmap_do_after_plugins_loaded' ) );
			add_action( 'activated_plugin', array( $this, 'wpgmap_do_after_activation' ), 10, 2 );
			add_action( 'wp_enqueue_scripts', array( $this, 'gmap_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_gmap_scripts' ) );
			add_action( 'admin_menu', array( $this, 'gmap_create_menu' ) );
			add_action( 'init', array( $this, 'gmap_embed_register_post_type' ) );
			add_action( 'admin_init', array( $this, 'gmap_register_fields' ) );
			add_action( 'wp_ajax_wpgmapembed_save_map_data', array( $this, 'save_wpgmapembed_data' ) );
			add_action( 'wp_ajax_wpgmapembed_load_map_data', array( $this, 'load_wpgmapembed_list' ) );
			add_action( 'wp_ajax_wpgmapembed_popup_load_map_data', array( $this, 'load_popup_wpgmapembed_list' ) );
			add_action( 'wp_ajax_wpgmapembed_get_wpgmap_data', array( $this, 'get_wpgmapembed_data' ) );
			add_action( 'wp_ajax_wpgmapembed_remove_wpgmap', array( $this, 'remove_wpgmapembed_data' ) );
			add_action( 'admin_notices', array( $this, 'gmap_embed_notice_generate' ) );

		}

		/**
		 * To set options values
		 */


		/**
		 * To enqueue scripts for front-end
		 */
		public function gmap_enqueue_scripts() {
			//including map library
			$srm_gmap_lng    = get_option( 'srm_gmap_lng', 'en' );
			$srm_gmap_region = get_option( 'srm_gmap_region', 'US' );
			wp_enqueue_script( 'srm_gmap_api', 'https://maps.googleapis.com/maps/api/js?key=' . $this->wpgmap_api_key . '&libraries=places&language=' . $srm_gmap_lng . '&region=' . $srm_gmap_region, array( 'jquery' ) );
		}

		function enqueue_admin_gmap_scripts() {
			global $pagenow;
			if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' || ( isset( $_GET['page'] ) and $_GET['page'] == 'wpgmapembed' ) ) {
				$srm_gmap_lng    = get_option( 'srm_gmap_lng', 'en' );
				$srm_gmap_region = get_option( 'srm_gmap_region', 'US' );
				wp_enqueue_script( 'wp-gmap-api', 'https://maps.google.com/maps/api/js?key=' . $this->wpgmap_api_key . '&libraries=places&language=' . $srm_gmap_lng . '&region=' . $srm_gmap_region, array( 'jquery' ), '20200506', true );
				wp_enqueue_script( 'wp-gmap-custom-js', plugins_url( 'assets/js/custom.js', __FILE__ ), array( 'wp-gmap-api' ), '20161019', false );
				wp_enqueue_style( 'wp-gmap-embed-css', plugins_url( 'assets/css/wp-gmap-style.css', __FILE__ ), rand( 999, 9999 ) );

				// For media upload
				wp_enqueue_script( 'media-upload' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_script( 'wpgmap-media-upload' );
				wp_enqueue_style( 'thickbox' );
			}
		}


		/**
		 * To create menu in admin panel
		 */
		public function gmap_create_menu() {

			//create new top-level menu
			add_menu_page( $this->plugin_name, $this->plugin_name, 'administrator', 'wpgmapembed', array(
				$this,
				'srm_gmap_main'
			), 'dashicons-location', 11 );

			$no_of_map_created = gmap_embed_no_of_post();
			//to create sub menu
			if ( gmap_embed_is_using_premium_version() ) {
				add_submenu_page( 'wpgmapembed', __( "Add new Map", "gmap-embed" ), __( "Add New", "gmap-embed" ), 'administrator', 'wpgmapembed&tag=new', array(
					$this,
					'srm_gmap_new'
				), 11 );
			}
		}

		public function gmap_register_fields() {
			//register fields
			register_setting( 'gmap_settings_group', 'gmap_title' );
			register_setting( 'gmap_settings_group', 'wpgmap_heading_class' );
			register_setting( 'gmap_settings_group', 'gmap_lat' );
			register_setting( 'gmap_settings_group', 'gmap_long' );
			register_setting( 'gmap_settings_group', 'gmap_width' );
			register_setting( 'gmap_settings_group', 'gmap_height' );
			register_setting( 'gmap_settings_group', 'gmap_zoom' );
			register_setting( 'gmap_settings_group', 'gmap_disable_zoom_scroll' );
			register_setting( 'gmap_settings_group', 'gmap_type' );
		}

		/**
		 * Google Map Embed Mail Page
		 */
		public function srm_gmap_main() {
			require plugin_dir_path( __FILE__ ) . '/includes/gmap.php';
		}

		/*
		 * To update post meta data
		 */

		public function __update_post_meta( $post_id, $field_name, $value = '' ) {
			if ( ! get_post_meta( $post_id, $field_name ) ) {
				add_post_meta( $post_id, $field_name, $value );
			} else {
				update_post_meta( $post_id, $field_name, $value );
			}
		}

		/**
		 * To save New Map Data
		 */

		public function save_wpgmapembed_data() {
			$error = '';
			// Getting ajax fileds value
			$meta_data   = array(
				'wpgmap_title'               => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_title'] ) ),
				'wpgmap_heading_class'       => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_heading_class'] ) ),
				'wpgmap_show_heading'        => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_show_heading'] ) ),
				'wpgmap_latlng'              => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_latlng'] ) ),
				'wpgmap_map_zoom'            => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_map_zoom'] ) ),
				'wpgmap_disable_zoom_scroll' => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_disable_zoom_scroll'] ) ),
				'wpgmap_map_width'           => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_map_width'] ) ),
				'wpgmap_map_height'          => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_map_height'] ) ),
				'wpgmap_map_type'            => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_map_type'] ) ),
				'wpgmap_map_address'         => sanitize_text_field( esc_html( $_POST['map_data']['wpgmap_map_address'] ) ),
				'wpgmap_show_infowindow'     => sanitize_text_field( $_POST['map_data']['wpgmap_show_infowindow'] ),
				'wpgmap_enable_direction'    => sanitize_text_field( $_POST['map_data']['wpgmap_enable_direction'] ),
				'wpgmap_marker_icon'         => sanitize_text_field( $_POST['map_data']['wpgmap_marker_icon'] )
			);
			$action_type = sanitize_text_field( esc_html( $_POST['map_data']['action_type'] ) );
			if ( $meta_data['wpgmap_latlng'] == '' ) {
				$error = "Please input Latitude and Longitude";
			}
			if ( strlen( $error ) > 0 ) {
				echo json_encode( array(
					'responseCode' => 0,
					'message'      => $error
				) );
				exit;
			} else {

				if ( $action_type == 'save' ) {
					// saving post array
					$post_array = array(
						'post_type' => 'wpgmapembed'
					);
					$post_id    = wp_insert_post( $post_array );

				} elseif ( $action_type == 'update' ) {
					$post_id = intval( $_POST['map_data']['post_id'] );
				}

				// Updating post meta
				foreach ( $meta_data as $key => $value ) {
					$this->__update_post_meta( $post_id, $key, $value );
				}
				$returnArray = array(
					'responseCode' => 1,
					'post_id'      => $post_id
				);
				if ( $action_type == 'save' ) {
					$returnArray['message'] = 'Created Successfully.';
				} elseif ( $action_type == 'update' ) {
					$returnArray['message'] = 'Updated Successfully.';
				}
				echo json_encode( $returnArray );
				exit;
			}
		}

		public function load_wpgmapembed_list() {
			$content  = '';
			$args     = array(
				'post_type'      => 'wpgmapembed',
				'posts_per_page' => - 1
			);
			$mapsList = new WP_Query( $args );

			if ( $mapsList->have_posts() ) {
				while ( $mapsList->have_posts() ) {
					$mapsList->the_post();
					$title   = get_post_meta( get_the_ID(), 'wpgmap_title', true );
					$content .= '<div class="wp-gmap-single">
                                        <div class="wp-gmap-single-left">
                                            <div class="wp-gmap-single-title">
                                                ' . $title . '
                                            </div>
                                            <div class="wp-gmap-single-shortcode">
                                                <input class="wpgmap-shortcode regular-text" type="text" value="' . esc_attr( '[gmap-embed id=&quot;' . get_the_ID() . '&quot;]' ) . '"
                                                       onclick="this.select()"/>
                                            </div>
                                        </div>
                                        <div class="wp-gmap-single-action">
                                            <a href="?page=wpgmapembed&tag=edit&id=' . get_the_ID() . '" class="button media-button button-primary button-large wpgmap-edit" data-id="' . get_the_ID() . '">
                                                ' . __( 'Change', 'gmap-embed' ) . '
                                            </a>
                                            <button type="button"
                                                    class="button media-button button-danger button-large wpgmap-insert-delete" data-id="' . get_the_ID() . '" style="background-color: red;color: white;opacity:0.7;">
                                                X
                                            </button>
                                        </div>
                                    </div>';
				}
			} else {
				ob_start();
			    ?>
				<a style="padding: 9px;margin-left:100px;border-radius: 5px;background-color: #0073aa;color: white;text-decoration: none;font-weight: bold;font-size: 11px;" href="<?php echo esc_url( admin_url() ) . 'admin.php?page=wpgmapembed&amp;tag=new'; ?>"
                                           data-id="wp-gmap-new" class="media-menu-item">
                                           <i class="dashicons dashicons-plus"                 ></i>
                                           <?php echo __( "Create Your First Map", "gmap-embed" ); ?>
                                           </a>
				<br/><br/><div class="srm_gmap_instructions">
                <h3>Frequently asked questions</h3>
                    <?php
				require_once( plugin_dir_path( __FILE__ ) . 'includes/wpgmap_faqs.php' );
				echo '</div>';
                $content .= ob_get_clean();
			}

			echo $content;


		}

		public function load_popup_wpgmapembed_list() {
			$content  = '';
			$args     = array(
				'post_type' => 'wpgmapembed'
			);
			$mapsList = new WP_Query( $args );

			while ( $mapsList->have_posts() ) {
				$mapsList->the_post();
				$title   = get_post_meta( get_the_ID(), 'wpgmap_title', true );
				$content .= '<div class="wp-gmap-single">
                                        <div class="wp-gmap-single-left">
                                            <div class="wp-gmap-single-title">
                                                ' . $title . '
                                            </div>
                                            <div class="wp-gmap-single-shortcode">
                                                <input class="wpgmap-shortcode regular-text" type="text" value="[gmap-embed id=&quot;' . get_the_ID() . '&quot;]"
                                                       onclick="this.select()"/>
                                            </div>
                                        </div>
                                        <div class="wp-gmap-single-action">
                                            <button type="button"
                                                    class="button media-button button-primary button-large wpgmap-insert-shortcode">
                                                Insert
                                            </button>                                            
                                        </div>
                                    </div>';
			}
			echo $content;
			exit;


		}

		public function get_wpgmapembed_data( $gmap_id = '' ) {
			if ( $gmap_id == '' ) {
				$gmap_id = intval( $_POST['wpgmap_id'] );
			}

			$gmap_data = array(
				'wpgmap_title'               => get_post_meta( $gmap_id, 'wpgmap_title', true ),
				'wpgmap_heading_class'       => get_post_meta( $gmap_id, 'wpgmap_heading_class', true ),
				'wpgmap_show_heading'        => get_post_meta( $gmap_id, 'wpgmap_show_heading', true ),
				'wpgmap_latlng'              => get_post_meta( $gmap_id, 'wpgmap_latlng', true ),
				'wpgmap_map_zoom'            => get_post_meta( $gmap_id, 'wpgmap_map_zoom', true ),
				'wpgmap_disable_zoom_scroll' => get_post_meta( $gmap_id, 'wpgmap_disable_zoom_scroll', true ),
				'wpgmap_map_width'           => get_post_meta( $gmap_id, 'wpgmap_map_width', true ),
				'wpgmap_map_height'          => get_post_meta( $gmap_id, 'wpgmap_map_height', true ),
				'wpgmap_map_type'            => get_post_meta( $gmap_id, 'wpgmap_map_type', true ),
				'wpgmap_map_address'         => get_post_meta( $gmap_id, 'wpgmap_map_address', true ),
				'wpgmap_show_infowindow'     => get_post_meta( $gmap_id, 'wpgmap_show_infowindow', true ),
				'wpgmap_enable_direction'    => get_post_meta( $gmap_id, 'wpgmap_enable_direction', true ),
				'wpgmap_marker_icon'         => get_post_meta( $gmap_id, 'wpgmap_marker_icon', true )
			);

			return json_encode( $gmap_data );
		}

		public function remove_wpgmapembed_data() {

			$meta_data = array(
				'wpgmap_title',
				'wpgmap_heading_class',
				'wpgmap_show_heading',
				'wpgmap_latlng',
				'wpgmap_map_zoom',
				'wpgmap_disable_zoom_scroll',
				'wpgmap_map_width',
				'wpgmap_map_height',
				'wpgmap_map_type',
				'wpgmap_map_address',
				'wpgmap_show_infowindow',
				'wpgmap_enable_direction'
			);

			$post_id = intval( $_POST['post_id'] );
			wp_delete_post( $post_id );
			foreach ( $meta_data as $field_name => $value ) {
				delete_post_meta( $post_id, $field_name, $value );
			}
			$returnArray = array(
				'responseCode' => 1,
				'message'      => "Deleted Successfully."
			);
			echo json_encode( $returnArray );
			exit;
		}

		/**
		 * Fires after plugins loaded
		 */
		function wpgmap_do_after_plugins_loaded() {
			// In case of existing installation
			if ( get_option( 'gmap_embed_activation_time', false ) == false ) {
				update_option( 'gmap_embed_activation_time', time() );
			}
		}

		/**
		 * Works on when plugin is activated successfully
		 */

		function wpgmap_do_after_activation( $plugin, $network_activation ) {
			// In case of existing installation
			if ( get_option( 'gmap_embed_activation_time', false ) == false ) {
				update_option( 'gmap_embed_activation_time', time() );
			}

			if ( $plugin == 'gmap-embed/srm_gmap_embed.php' ) {
				wp_redirect( admin_url( 'admin.php?page=wpgmapembed' ) );
				exit;
			}
		}

		public function gmap_embed_register_post_type() {
			register_post_type( 'wpgmapembed',
				array(
					'labels'      => array(
						'name'          => __( 'Google Maps' ),
						'singular_name' => __( 'Map' ),
					),
					'public'      => false,
					'has_archive' => false,
				)
			);
		}

		private function gmap_embed_get_full_uri() {
			$link = "http";
			if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ) {
				$link = "https";
			}

			return $link . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}

		function gmap_embed_notice_generate() {

			// Generating admin notice for review after one month
			$this->gmap_embed_generate_admin_review_notice();

			// Generate new feature admin notice
			$this->gmap_embed_new_feature_admin_notice();
		}

		private function gmap_embed_generate_admin_review_notice(){
			$gmap_embed_activation_time   = get_option( 'gmap_embed_activation_time', false );
			$seconds_diff                 = time() - $gmap_embed_activation_time;
			$passed_days                  = ( $seconds_diff / 3600 ) / 24;
			$gmap_embed_is_review_snoozed = get_option( 'gmap_embed_is_review_snoozed' );
			$gmap_embed_activation_time   = get_option( 'gmap_embed_review_snoozed_at' );
			$seconds_diff                 = time() - $gmap_embed_activation_time;
			$snoozed_before               = ( $seconds_diff / 3600 ) / 24;
			$gmap_embed_is_review_done    = get_option( 'gmap_embed_is_review_done' );

			if ( $gmap_embed_is_review_done == false and ( ( $passed_days >= 30 and $gmap_embed_is_review_snoozed == false ) or ( $gmap_embed_is_review_snoozed == true and $snoozed_before >= 7 ) ) ) {
				$redirect_url = esc_url( $this->gmap_embed_get_full_uri() );
				?>
                <div class="notice notice-success is-dismissible">
                    <p><?php _e( '<b style="color:green;">Hey, We noticed that you have successfully crossed <b>30+ day\'s</b> of using <a target="_blank" href="' . esc_url( 'https://wordpress.org/plugins/gmap-embed' ) . '"> <b style="color:#007cba">Google Map SRM plugin</b></a>.
Could you please give us a BIG favour and give it a 5-star rating on Wordpress?<br/> 
Just to help us spread the word and boost our motivation.!<br/>- <i>SRMILON</i></b>
<ul style="list-style: circle;padding-left: 25px;">
<li><a target="_blank" href="' . esc_url( 'https://wordpress.org/support/plugin/gmap-embed/reviews/#new-topic-0' ) . '"><b>Ok, You deserve it</b></a></li>
<li><a href="' . esc_url( admin_url() . 'admin.php?page=wpgmapembed&tag=review-maybe-latter' ) . '&redirect_to=' . esc_url( $redirect_url ) . '"><b>Nope, maybe later</b></a></li>
<li><a href="' . esc_url( admin_url() . 'admin.php?page=wpgmapembed&tag=review-done' ) . '&redirect_to=' . esc_url( $redirect_url ) . '"><b>I already did</b></a></a></li>
</ul>
', 'gmap-embed' ); ?></p>
                </div>
				<?php
			}
		}

		private function gmap_embed_new_feature_admin_notice(){
			if ( get_option( 'srm_gmap_lng' ) == false and isset( $_GET['page'] ) and $_GET['page'] == 'wpgmapembed') {

			?>
			<div class="notice notice-success is-dismissible">
                    <p style="font-weight: bold;color: green;">We are happy to announce that, Now you can customize your Map Language and Map Regional settings. Go to <a href="<?php  echo esc_url( admin_url() . 'admin.php?page=wpgmapembed&tag=settings' ); ?>">Settings</a> tab to change your map settings.</p>
                    </div>
			<?php
	}
			}

	}


}
new srm_gmap_embed_main();


// including requird files
require_once plugin_dir_path( __FILE__ ) . '/includes/widget.php';
require_once plugin_dir_path( __FILE__ ) . '/includes/shortcodes.php';

if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
	require_once plugin_dir_path( __FILE__ ) . '/includes/wpgmap_popup_content.php';
}

load_plugin_textdomain( 'gmap-embed', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

//updated at 07.04.2019 14:20:00

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'gmap_srm_settings_link' );
function gmap_srm_settings_link( $links ) {
	$links[] = '<a href="' .
	           admin_url( 'admin.php?page=wpgmapembed' ) .
	           '">' . __( 'Settings' ) . '</a>';

	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'gmap_srm_settings_linka' );
function gmap_srm_settings_linka( $links ) {
	if ( ! gmap_embed_is_using_premium_version() ) {
		$links[] = '<a target="_blank" style="color: #11967A;font-weight:bold;" href="' . esc_url( 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZBERRKARGNEYA' ) . '">' . __( 'Upgrade To Premium' ) . '</a>';
	}
	$links[] = '<a target="_blank" href="' . esc_url( 'https://wordpress.org/support/plugin/gmap-embed/reviews/#new-post' ) . '">' . __( 'Rate Us' ) . '</a>';
	$links[] = '<a target="_blank" href="' . esc_url( 'https://wordpress.org/support/plugin/gmap-embed/#new-topic-0' ) . '">' . __( 'Support' ) . '</a>';

	return $links;
}
