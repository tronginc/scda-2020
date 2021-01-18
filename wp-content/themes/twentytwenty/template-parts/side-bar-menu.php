<?php
	/**
	 * Sidebar menu for post
	 **/	

	// get_search_form();

	$cat_name = '';

	if (is_category()){
		$child = get_category($cat);
		$parent = $child->parent;

		$cat_name = $child->slug;

		if ($parent){
			$parent = get_category($parent);
			$cat_name = $parent->slug;
		}

	}

	else if (function_exists("get_post_primary_category")) {
		$categories = get_post_primary_category(get_the_ID());
		if (isset($categories['primary_category'])){
			$primary = $categories['primary_category'];
			$cat_name = $primary->slug;	
		}	
	}


	$cat_menu = strtolower(htmlspecialchars($cat_name)).'-menu';
	
	if ($cat_menu !== '' && has_nav_menu($cat_menu)){		
		return wp_nav_menu(
			array(
				'theme_location' => $cat_menu,
				'menu_id' => 'side-bar-menu'
			)		
		);
	}
	if (has_nav_menu("collapsible-menu")){		
		return wp_nav_menu(
			array(
				'theme_location' => 'collapsible-menu',
				'menu_id' => 'side-bar-menu'
			)		
		);
	}
?>