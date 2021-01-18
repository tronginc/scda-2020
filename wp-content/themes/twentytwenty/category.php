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
	echo '<h2>Không có bài viết nào.</h2>';
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
			echo '<div id="fancybox-image">';
			the_content();				
			echo '</div>';
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
	
	// THE CONTENT POST OF ABOUT
	if (in_category(get_option('t5l_about_category_id')) && !$category->category_parent > 0){
		echo '<div class="contents" id="fancybox-image">';
		$post_content = get_post(get_option('t5l_primary_about_post_id'));
		$content = $post_content->post_content;
		echo apply_filters('the_content',$content);
		echo '</div>';
		return;
	}	
	// THE CONTENT POST OF CONTACT
	if (in_category(get_option('t5l_contact_category_id')) && !$category->category_parent > 0){		
		$post_content = get_post(get_option('t5l_primary_contact_post_id'));
		$content = $post_content->post_content;
		echo apply_filters('the_content',$content);
		return;
	}	
	// LIST POST OF CATEGORY PRESS 	
	if (in_category(get_option('t5l_press_category_id')) ){			
		if (is_category(get_option('t5l_press_category_id'))){
			$post_content = get_post(get_option('t5l_primary_press_post_id'));
			$content = $post_content->post_content;
			echo apply_filters('the_content',$content);
			return;
		}
		$args = array(
			'post_type' => 'post' ,
			'orderby' => 'date' ,
			'order' => 'ASC' ,
			'posts_per_page' => get_option('posts_per_page'),
			'cat' => $cat,
			'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1
		); 

		$q = new WP_Query($args);
		build_content($args,"posts-press", false);
		return;
		
	}
	
	// LIST POST OF CATEGORY NEWS 	
	if (in_category(get_option('t5l_news_category_id')) ){		
		if (is_category(get_option('t5l_news_category_id')) || is_category(get_option('t5l_news_current_category_id'))){
			$args = array(
			'post_type' => 'post' ,
			'orderby' => 'date' ,
			'order' => 'ASC' ,
			'posts_per_page' => get_option('posts_per_page'),
			'cat' => get_option('t5l_news_current_category_id'),
			'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1
		); 

			$q = new WP_Query($args);
			build_content($args,"col", false);
			return;
		}
		$args = array(
			'post_type' => 'post' ,
			'orderby' => 'date' ,
			'order' => 'ASC' ,
			'posts_per_page' => get_option('posts_per_page'),
			'cat' => $cat,
			'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1
		); 

		$q = new WP_Query($args);
		build_content($args,"row", false);
		return;
	}
	
	
	if (in_category(get_option('t5l_contact_category_id'))){	
		$args = array(
			'post_type' => 'post' ,
			'orderby' => 'date' ,
			'order' => 'ASC' ,
			'posts_per_page' => get_option('posts_per_page'),
			'cat' => $cat,
			'paged' => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1
		); 

		$q = new WP_Query($args);
		build_content($args,"posts-contact", false);
		return;
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
	build_content($args,"posts", true);
}
?>

<div class="custom-container">
	<div class="custom-page-body">
		<div class="custom-nav">
			<?php get_template_part('template-parts/collapsible-list-menu'); ?>
			<h1 id="breadcrumb_mobile"><?php show_breadcrumb("term-name","taxonomy"); ?> </h1>
			<div class="side-bar">
				<?php get_template_part('template-parts/side-bar-menu'); ?>
			</div>
		</div>
		<div class="custom-content">
			<div>
				<h1 id="breadcrumb_desktop"><?php show_breadcrumb("term-name","taxonomy"); ?> </h1>
			</div>
			<?php build_category_content() ?>
		</div>
	</div>
</div>

<?php 
	get_template_part('template-parts/fixed-bottom-menu');
	get_footer("custom");
?>