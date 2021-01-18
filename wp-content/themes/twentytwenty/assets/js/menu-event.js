window.addEventListener('DOMContentLoaded', function(){
	const checkbox = document.getElementById("collapsible-menu");
	const menu = document.getElementById("side-bar-menu");
	if (!menu || !checkbox){
		return;
	}
    checkbox.addEventListener( 'change', function() {
		if(this.checked) {
			menu.style.visibility = "hidden";
		} else {
			menu.style.visibility = "visible";
		}
	});
	
	if (window.location.pathname == "/about" || window.location.pathname == "/news" || window.location.pathname == "/press" || window.location.pathname == "/contact"){
		const menu = document.getElementById("side-bar-menu");
		menu.getElementsByTagName('li')[0].classList.add('current-menu-item');
	}
	
	
	/* Apply fancybox to multiple items */
	if(window.location.pathname.includes("landscape") || window.location.pathname.includes("architecture") || window.location.pathname.includes("interiors") || window.location.pathname == "/about" || window.location.pathname == "/about/scda-architects.html" ) {
		$("#fancybox-image img").each(function(){ //search all images inside
		if ($(this).attr("fancybox") == "false" || $(this).attr("class") == "popupaoc-img"){
			return;
		}
	  	//get the imgs url
	 	const imgSrc = $(this).attr("src"); 
		

	  	//put the image inside a div
	  	$(this).wrap('<a data-fancybox="gallery" data-width="2048" data-height="1365" href="'+imgSrc+'"></a>'); 	  
	});
	}
	else{
		return
	}
	
});
