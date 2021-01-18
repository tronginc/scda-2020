<?php
/**
 * Category template
 * Template Post Type: category, post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header("custom-page");

function build_post(){
	echo '<div class="post">';
	echo '<a href="'.get_permalink().'">';
	the_post_thumbnail();
	the_title('<h2>','</h2>');
	echo '<div class="category black-hover">';
	foreach((get_the_category()) as $category) { 
		echo $category->cat_name . ' '; 
	}
	echo '</div>';
	echo '</a>';
	echo '</div>';
}
?>
<body>
	<div class="custom-container">
		<div class="custom-page-body">
			<div class="custom-nav">
				<?php get_template_part('template-parts/collapsible-list-menu'); ?>
				<div class="side-bar">
					<?php 
						if (in_category('About')):
							wp_nav_menu(
								array(
									'menu' => 'About',
									'menu_id' => 'side-bar-menu'
								)		
							);
						endif;
					?>
				</div>
			</div>
			<div class="custom-content">
				<div>
					<h1><?php echo '<div class="category black-hover">'.single_cat_title().'</div>'; ?></h1>
				</div>
				<div class="contents">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>

<?php 
	get_template_part('template-parts/fixed-bottom-menu'); 
	get_footer("custom");
?>