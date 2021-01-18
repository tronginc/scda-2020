<?php
/**
 * 404 template
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header("custom-page");

function build_not_found_content(){
	echo '<div class="no-post">';
	echo '<h2>Không tìm thấy trang mà bạn yêu cầu.</h2>';
	echo '</div>';
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
					<h1></h1>
				</div>
				<?php build_not_found_content() ?>
			</div>
		</div>
	</div>

<?php 
	get_template_part('template-parts/fixed-bottom-menu');
	get_footer("custom");
?>