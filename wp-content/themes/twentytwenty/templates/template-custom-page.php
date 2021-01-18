<?php
/**
 * Template Name: Custom
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header("custom-page");
if (has_nav_menu('primaryzzz') ) {
		wp_nav_menu(
			array(
				'menu' => 'second-menu',
				'container' => 'div',
				'container_id' => 'my-template-menu',
				'items_wrap' => '%3$s',
				'theme_location' => 'primary',
			)
		);
}
function build_post(){
	echo '<div class="post">';
	echo '<a href="'.get_permalink().'">';
	the_post_thumbnail();
	the_title('<h2>','</h2>');
	echo '</a>';
	echo '</div>';
}
?>
<body>
	<div class="custom-container">
		<div class="custom-page-body">
			<div class="custom-nav">
				<div class="side-bar">
					<?php 
						if (is_page('architecture')):
							wp_nav_menu(
								array(
									'menu' => 'Architecture'
								)		
							);
						endif;
					?>
				</div>
			</div>
			<div class="custom-content">
				<div class="posts">
					<?php 
						$args = array(
						  'post_type' => 'post' ,
						  'orderby' => 'date' ,
						  'order' => 'DESC' ,
						); 
						$q = new WP_Query($args);
						if ( $q->have_posts() ) { 
						  while ( $q->have_posts() ) {
							$q->the_post();
							build_post();
						  }
						}
					?>
				</div>			
			</div>
		</div>
	</div>
</body>