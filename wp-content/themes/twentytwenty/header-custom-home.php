<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slider-pro/1.5.0/css/slider-pro.min.css" integrity="sha512-v/XxHuJ2Q7eQ0Ot06LW84M154Vx/54VZY2MygLMdg7EPVZ/9TXQhkYA1VmaEfXVlT7sMhrXsk2Q/r+Q97kjx7Q==" crossorigin="anonymous" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/slider-pro/1.5.0/js/jquery.sliderPro.min.js" integrity="sha512-kE/Z39UCtQFV6heGkVHzcQuswQW8t4Hn96hv8p/dO00rsbtBDrK8kaiePj72kZEYdWoczavC7Ib2u14SzW6Wzg==" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

		<link rel="profile" href="https://gmpg.org/xfn/11">
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/css/bottom-fixed-menu.css?v=<?php echo microtime(true) ?>" type="text/css" media="screen" />	 
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/home.css?v=<?php echo microtime(true) ?>" type="text/css" media="screen" />	 
		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php		
		wp_body_open();		
		?>

		<?php
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );