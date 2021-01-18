<?php
	/**
	 * Collapsible menu for every page
	 */
	echo '<div class="collapsible-menu">';
	echo '<input style="display:none" type="checkbox" id="collapsible-menu">';
	echo '<label class="custom-label" for="collapsible-menu">';
	echo '<img src="/wp-content/themes/twentytwenty/assets/images/menu.png" />';
	echo '<a href="/">'.get_option('t5l_collapsible_menu_title').'</a>';
	echo '</label>';
	if (has_nav_menu("collapsible-menu")){
		wp_nav_menu(
			array(
				'container'=> false,
				'theme_location' => "collapsible-menu",
			)			
		);
	}
	
	echo '</div>';
?>