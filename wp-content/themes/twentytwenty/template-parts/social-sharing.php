<?php	
	echo '	
	<div class="social-sharing-container">
	
		<a target="_new" href="http://www.facebook.com/share.php?u=' . urlencode(get_the_permalink()) . '&title=' . urlencode(get_the_title()). '">
			<img fancybox="false" src="'.get_template_directory_uri()."/assets/images/facebook-share.png".'" />
		</a>
		
		<a target="_new" href="#">
			<img fancybox="false" src="'.get_template_directory_uri()."/assets/images/instagram-share.png".'" />
		</a>
		
		<a target="_new" href="https://pinterest.com/pin/create/button/?url=' . urlencode(get_the_permalink()) . '&media=' . urlencode(get_the_post_thumbnail_url()) . '&description=' . urlencode(get_the_title()). '">
			<img fancybox="false" src="'.get_template_directory_uri()."/assets/images/pinterest-share.png".'" />
		</a>
		
		
		<a target="_new" href="mailto:?subject=' . urlencode(get_the_permalink()) . '&body=Check out this article I came across '. get_the_permalink() .'">
			<img fancybox="false" src="'.get_template_directory_uri()."/assets/images/email-share.png".'" />
		</a>
	</div>
';
?>