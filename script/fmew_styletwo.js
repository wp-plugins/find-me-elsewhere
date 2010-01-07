jQuery(document).ready(function(){
	jQuery("#fmew").hover(function(){
		jQuery("#fmew").find("ul").slideDown("slow");
	},
	function(){
		jQuery("#fmew").find("ul").slideUp("slow");
	});
})