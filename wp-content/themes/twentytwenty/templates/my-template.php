<?php
/**
 * Template Name: my-template
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
if(is_front_page()):
    get_header("my-template");
endif;
?>
<main id="site-content" role="main">
    
    <?php
    while ( have_posts() ) : the_post();  
        the_content();
    endwhile;
	get_template_part('template-parts/fixed-background-menu');
	get_template_part('template-parts/fixed-bottom-menu');
    ?>
</main><!-- #site-content -->
