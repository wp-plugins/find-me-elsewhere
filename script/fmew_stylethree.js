jQuery(document).ready(function(){
	jQuery("#fmew").toggle(function(){
		jQuery("#fmew").find("ul").slideDown("slow");
	},
	function(){
		jQuery("#fmew").find("ul").slideUp("slow");
	});
})