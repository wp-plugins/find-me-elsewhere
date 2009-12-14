jQuery(document).ready(function(){
	jQuery("#fmew").find("h3").toggle(function(){
		jQuery("#fmew").find("ul").slideDown("slow");
	},
	function(){
		jQuery("#fmew").find("ul").slideUp("slow");
	});
})