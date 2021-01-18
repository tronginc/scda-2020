<?php
/**
 * Category template
 * Template Post Type: category
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header("custom-page");

function show_breadcrumb($name,$type){
    if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
	}
}


function build_custom_post_content(){
	echo '<a href="'.get_permalink().'">';
	the_post_thumbnail();
	the_title('<h2>','</h2>');
	echo '<div class="category black-hover">';
	foreach((get_the_category()) as $category) { 
		echo $category->cat_name . ' '; 
	}
	echo '</div>';
	echo '</a>';
}

function build_no_post_content(){
	echo '<div class="no-post">';
	echo '<h2>No post found.</h2>';
	echo '</div>';
}

function build_content($args, $container_class, $custom_content = false){
	$q = new WP_Query($args);
	if (!$q->have_posts()) {
		return build_no_post_content();
	}
	echo '<div class="'.$container_class.'">';	
	while ( $q->have_posts() ) {
		$q->the_post();
		echo '<div>';
		if ($custom_content){
			build_custom_post_content();
		}
		else {	
			the_content();				
		}
		echo '<div class="custom-tags">';
		the_tags('', ", ", '');
		echo '</div>';
		echo '</div>';
	}
	echo '</div>';
	echo '<div class="posts-pagination">';
	$big = 999999999; // need an unlikely integer
	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $q->max_num_pages
	) );		
	echo '</div>';		
	echo '</div>';
}

function build_category_content(){
	global $cat;
	$category = get_category($cat);
	
	if (is_tag()){	
    	$tag = get_queried_object();
		$args = array(
			'orderby' => 'date' ,
			'order' => 'ASC' ,
			'posts_per_page' => get_option('posts_per_page'),
			'tag' => $tag->slug,
			'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1
		); 

		$q = new WP_Query($args);
		return build_content($args,"posts", true);
	}
	
	// THE CONTENT POST OF ABOUT
	if (in_category('About') && !$category->category_parent > 0){
		echo '<div class="contents">';
		$post_content = get_post(get_option('t5l_primary_about_post_id'));
		$content = $post_content->post_content;
		echo apply_filters('the_content',$content);
		echo '</div>';
		return;
	}	
	
	// LIST POST OF CATEGORY NEWS 	
	if (in_category('News') ){		
		$args = array(
			'post_type' => 'post' ,
			'orderby' => 'date' ,
			'order' => 'ASC' ,
			'posts_per_page' => get_option('posts_per_page'),
			'cat' => $cat,
			'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1
		); 

		$q = new WP_Query($args);
		return build_content($args,"posts-news", false);
	}
	
	// LIST POST OF CATEGORY PRESS 	
	if (in_category('Press') ){	
		$args = array(
			'post_type' => 'post' ,
			'orderby' => 'date' ,
			'order' => 'ASC' ,
			'posts_per_page' => get_option('posts_per_page'),
			'cat' => $cat,
			'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1
		); 

		$q = new WP_Query($args);
		return build_content($args,"posts-press", false);
	}
	
	// LIST POST OF ANOTHER CATEGORY
	$args = array(
			'post_type' => 'post' ,
			'orderby' => 'date' ,
			'order' => 'DESC' ,
			'posts_per_page' => get_option('posts_per_page'),
			'cat' => $cat,
			'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1
		); 
	return build_content($args,"posts", true);
}
?>

<body>
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
					<h1><?php show_breadcrumb("term-name","taxonomy"); ?> </h1>
				</div>
				<?php build_category_content() ?>
			</div>
		</div>
	</div>

<?php 
	get_template_part('template-parts/fixed-bottom-menu');
	get_footer("custom");
?>