<?php
	/**
	 * Fixed menu for every page
	 *
	 * @package WordPress
	 * @subpackage Twenty_Twenty
	 * @since Twenty Twenty 1.0
	 */	
	echo '<div class="nav-container">';
	echo '<div>';
	echo '<ul class="navbar-nav">';
	if ( has_nav_menu('fixed-bottom-menu') ) {
		wp_nav_menu(
			array(
				'menu' => 'fixed-bottom-menu',
				'container' => 'ul',
				'items_wrap' => '%3$s',
				'theme_location' => 'fixed-bottom-menu',
			)			
		);
	}	
	echo '</div>';
	echo '</ul>';
	echo '</div>';
?>