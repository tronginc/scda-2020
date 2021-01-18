<?php
/**
* Plugin Name: TDA Common Plugin (Do not delete this plugin)
* Plugin URI: https://trongnc.com/
* Description: This is the common plugin created by trongnc.
* Version: 1.0.0
* Author: Nguyen Cong Trong
* Author URI: https://trongnc.com/
**/
// include('wp_dropdown_posts.php');

function get_post_primary_category($post_id, $term='category', $return_all_categories=false){
    $return = array();

    if (class_exists('WPSEO_Primary_Term')){
        // Show Primary category by Yoast if it is enabled & set
        $wpseo_primary_term = new WPSEO_Primary_Term( $term, $post_id );
        $primary_term = get_term($wpseo_primary_term->get_primary_term());

        if (!is_wp_error($primary_term)){
            $return['primary_category'] = $primary_term;
        }
       }

    if (empty($return['primary_category']) || $return_all_categories){
        $categories_list = get_the_terms($post_id, $term);

        if (empty($return['primary_category']) && !empty($categories_list)){
            $return['primary_category'] = $categories_list[0];  //get the first category
        }
        if ($return_all_categories){
            $return['all_categories'] = array();

            if (!empty($categories_list)){
                foreach($categories_list as &$category){
                    $return['all_categories'][] = $category->term_id;
                }
            }
        }
    }

    return $return;
}

add_action('admin_menu', 'create_option_menu');

function create_option_menu() {

	//create new top-level menu
	add_menu_page('TDA Settings', 'TDA Settings', 'administrator', __FILE__, 't5l_plugin_settings_page' , plugins_url('/images/page.png', __FILE__), 10);

	//call register settings function
	add_action( 'admin_init', 'register_plugin_settings' );
}


function register_plugin_settings() {
    //register our settings
    register_setting( 't5l-plugin-settings-group', 't5l_collapsible_menu_title' );
    register_setting( 't5l-plugin-settings-group', 't5l_primary_about_post_id' );
    register_setting( 't5l-plugin-settings-group', 't5l_primary_contact_post_id' );
    register_setting( 't5l-plugin-settings-group', 't5l_primary_press_post_id' );
    // category settings
    register_setting( 't5l-plugin-settings-group', 't5l_architecture_category_id' );
    register_setting( 't5l-plugin-settings-group', 't5l_interiors_category_id' );
    register_setting( 't5l-plugin-settings-group', 't5l_landscape_category_id' );
    register_setting( 't5l-plugin-settings-group', 't5l_about_category_id' );    
    register_setting( 't5l-plugin-settings-group', 't5l_news_category_id' );
    register_setting( 't5l-plugin-settings-group', 't5l_news_current_category_id' );
    register_setting( 't5l-plugin-settings-group', 't5l_press_category_id' );
    register_setting( 't5l-plugin-settings-group', 't5l_contact_category_id' );    
}

function t5l_plugin_settings_page() {
?>
<div class="wrap">
<h1>TDA Page, Post, Category Settings</h1>
<br />
<form method="post" action="options.php">
    <?php settings_fields( 't5l-plugin-settings-group' ); ?>
    <?php do_settings_sections( 't5l-plugin-settings-group' ); ?>    
    <table class="form-table">       
        <tr valign="top">
            <th scope="row">Architecture category:</th>
             <td><?php wp_dropdown_categories(array(
                'show_option_none' => 'Please choose',
                'name' => 't5l_architecture_category_id',
                'hide_empty' => 0,
                "selected" => get_option('t5l_architecture_category_id'),
                'hierarchical' => 1,
                'depth' => 1 
            )) ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">Interiors category:</th>
            <td><?php wp_dropdown_categories(array(
                'show_option_none' => 'Please choose',
                'name' => 't5l_interiors_category_id',
                'hide_empty' => 0,
                "selected" => get_option('t5l_interiors_category_id'),
                'hierarchical' => 1,
                'depth' => 1 
            )) ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">Landscape category:</th>
            <td><?php wp_dropdown_categories(array(
                'show_option_none' => 'Please choose',
                'name' => 't5l_landscape_category_id',
                'hide_empty' => 0,
                "selected" => get_option('t5l_landscape_category_id'),
                'hierarchical' => 1,
                'depth' => 1 
            )) ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">About category:</th>
            <td><?php wp_dropdown_categories(array(
                'show_option_none' => 'Please choose',
                'name' => 't5l_about_category_id',
                'hide_empty' => 0,
                "selected" => get_option('t5l_about_category_id'),
                'hierarchical' => 1,
                'depth' => 1 
            )) ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">News category:</th>
            <td><?php wp_dropdown_categories(array(
                'show_option_none' => 'Please choose',
                'name' => 't5l_news_category_id',
                'hide_empty' => 0,
                "selected" => get_option('t5l_news_category_id'),
                'hierarchical' => 1,
                'depth' => 1 
            )) ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">News-Current category:</th>
            <td><?php wp_dropdown_categories(array(
                'show_option_none' => 'Please choose',
                'name' => 't5l_news_current_category_id',
                'hide_empty' => 0,
                "selected" => get_option('t5l_news_current_category_id'),
                'hierarchical' => 0,
                'depth' => 0
            )) ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">Press category:</th>
            <td><?php wp_dropdown_categories(array(
                'show_option_none' => 'Please choose',
                'name' => 't5l_press_category_id',
                'hide_empty' => 0,
                "selected" => get_option('t5l_press_category_id'),
                'hierarchical' => 1,
                'depth' => 1 
            )) ?></td>
        </tr>
        <tr valign="top">
            <th scope="row">Contact category:</th>
            <td><?php wp_dropdown_categories(array(
                'show_option_none' => 'Please choose',
                'name' => 't5l_contact_category_id',
                'hide_empty' => 0,
                "selected" => get_option('t5l_contact_category_id'),
                'hierarchical' => 1,
                'depth' => 1 
            )) ?></td>
        </tr>
    </table>
    <br />
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Collapsible Menu Title:</th>
            <td><input type="text" name="t5l_collapsible_menu_title" value="<?php echo esc_attr( get_option('t5l_collapsible_menu_title') ); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Default About Post ID:</th>
            <td><input type="text" name="t5l_primary_about_post_id" value="<?php echo esc_attr( get_option('t5l_primary_about_post_id') ); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Default Contact Post ID:</th>
            <td><input type="text" name="t5l_primary_contact_post_id" value="<?php echo esc_attr( get_option('t5l_primary_contact_post_id') ); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Default Press Post ID:</th>
            <td><input type="text" name="t5l_primary_press_post_id" value="<?php echo esc_attr( get_option('t5l_primary_press_post_id') ); ?>" /></td>
        </tr>
    </table>    
    
    <?php submit_button(); ?>

</form>
</div>
<?php }
