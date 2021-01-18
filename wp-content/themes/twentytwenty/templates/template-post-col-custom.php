<?php
/**
 * Template Name: Template Post Col Custom
 * Template Post Type: post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header("custom-page");


function build_title(){	
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
}
?>

<div class="custom-container">
	<div class="custom-page-body">
		<div class="custom-nav">
			<?php get_template_part('template-parts/collapsible-list-menu'); ?>
			<div class="side-bar">
				<?php get_template_part('template-parts/side-bar-menu'); ?>

			</div>
		</div>
		<div class="custom-content">
			<div>
				<h1><?php build_title() ?></h1>
			</div>	
			<div class="post">
				<?php
					the_content();
				?>								
			</div>
		</div>
	</div>
</div>

<?php 
get_template_part('template-parts/fixed-bottom-menu');
get_footer("custom"); ?>

