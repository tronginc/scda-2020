<?php
/**
 * Template Name: Template Post Custom
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

function build_no_post_content(){
	echo '<div class="no-post">';
	echo '<h2>Không tìm thấy bài viết nào phù hợp.</h2>';
	echo '</div>';
}

function build_content(){
	if (!is_search()){
		echo '<div>';
		the_content();
		echo '</div>';
		the_tags('<div class="custom-tags">',  ", ", "</div>");
		return;
	}
	global $wp_query;
	if (!$wp_query->have_posts()) {
		return build_no_post_content();
	}
	
	// The search result
	echo '<div class="search-results">';	
	while ( $wp_query->have_posts() ) {
		$wp_query->the_post();
		echo '<div>';
		
		echo '<a href="'.get_permalink().'">';
		the_title('<h2>','</h2>');
		echo '</a>';
		the_post_thumbnail();
		$content = apply_filters('the_content', wp_trim_words(get_the_content(), 100, '...'));
		echo $content;
		echo '<a class="view-more" href="'.get_permalink().'">Xem thêm... </a>';
		echo '</div>';
	}
	echo '</div>';
	
	// Pagination
	
	echo '<div class="posts-pagination">';
	$big = 999999999; // need an unlikely integer
	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	) );		
	echo '</div>';		
}
?>



<div class="custom-container">
	<div class="custom-page-body">
		<div class="custom-nav">
			<?php get_template_part('template-parts/collapsible-list-menu'); ?>
			<h1 id="breadcrumb_mobile"><?php build_title() ?></h1>
			<div class="side-bar">
				<?php get_template_part('template-parts/side-bar-menu'); ?>				
			</div>
		</div>
		<div class="custom-content" id="fancybox-image">			
			<div>
				<h1 id="breadcrumb_desktop"><?php build_title() ?></h1>
			</div>	
			<?php get_template_part('template-parts/social-sharing'); ?>
			<?php build_content();?>
		</div>
	</div>
</div>

<?php 
get_template_part('template-parts/fixed-bottom-menu');
get_footer("custom"); ?>

