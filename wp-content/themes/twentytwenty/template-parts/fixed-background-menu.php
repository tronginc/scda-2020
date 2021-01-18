<?php
	/**
	 * Fixed menu for every page
	 *
	 * @package WordPress
	 * @subpackage Twenty_Twenty
	 * @since Twenty Twenty 1.0
	 */
	echo '<div class="nav-container nav-absolute">';
	echo '<div>';
	echo '<ul class="navbar-nav-absolute">';
	if ( has_nav_menu('home-absolute-menu') ) {
		wp_nav_menu(
			array(
				'menu' => 'home-absolute-menu',
				'container' => 'ul',
				'items_wrap' => '%3$s',
				'theme_location' => 'home-absolute-menu',
			)			
		);
	}
	echo '</div>';
	echo '</ul>';
	echo '</div>';
?>