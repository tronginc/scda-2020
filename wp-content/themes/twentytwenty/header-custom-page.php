<?php
/**
 * Header file for page template
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		
		<link rel="profile" href="https://gmpg.org/xfn/11">
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/custom-style.css?v=<?php echo microtime(true) ?>" type="text/css" media="screen" />	   
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/home.css?v=<?php echo microtime(true) ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/bottom-fixed-menu.css?v=<?php echo microtime(true) ?>" type="text/css" media="screen" />
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
		<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
			
		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		
		wp_body_open();		
		?>

		<?php
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );