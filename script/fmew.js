jQuery(document).ready(function(){
	jQuery(".select").toggle(function(){
		jQuery(".add").find("ul").show();
		jQuery(".select").css('background','#FFFFFF url(../wp-content/plugins/find-me-else-where/images/select_click.png) no-repeat');
	},
	function(){
		jQuery(".add").find("ul").hide();
		jQuery(".select").css('background','#FFFFFF url(../wp-content/plugins/find-me-else-where/images/select.png) no-repeat');
	});
	jQuery("div.add > ul").find("li").click(function(){
		var cla = jQuery(this).attr("class");
		var text = jQuery(this).text();
		jQuery(".select").html('<span class="'+cla+'">'+text+'</span>');
		jQuery("#category").val(text);
		jQuery(".select").css('background','#FFFFFF url(../wp-content/plugins/find-me-else-where/images/select.png) no-repeat');
		jQuery(".add").find("ul").hide();
	});
	jQuery("#save_liststyle").click(function(){
		var radio = jQuery(".list_style").find("input:radio");
		for(i = 0; i < radio.length; i++){
			if(radio.eq(i).attr('checked') == true){
				var j = i
			}
		}
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-else-where/find_me_else_where_handle.php",
			data: "action=save_style&style="+radio.eq(j).val(),
			beforeSend: function(){
				jQuery("#stylemsg").show();
				jQuery("#stylemsg").html("<img src='../wp-content/plugins/find-me-else-where/images/ajaxloading.gif'/>waiting......");
			},
			success: function(msg){
				if(msg == 1){
					jQuery("#stylemsg").show();
					jQuery("#stylemsg").html("<img src='../wp-content/plugins/find-me-else-where/images/ok.gif'/>ok");
					setTimeout("re()",500);
				}else{alert(msg);
					jQuery("#stylemsg").show();
					jQuery("#stylemsg").html("<img src='../wp-content/plugins/find-me-else-where/images/use.gif'/>"+msg);
				}
			}
		}); 
	});
	jQuery("#save_display_msg").click(function(){
		var radio = jQuery(".msg_manage").find("input:radio");
		for(i = 0; i < radio.length; i++){
			if(radio.eq(i).attr('checked') == true){
				var j = i;
			}
		}
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-else-where/find_me_else_where_handle.php",
			data: "action=save_display&display="+radio.eq(j).val(),
			beforeSend: function(){
				jQuery("#displaymsg").show();
				jQuery("#displaymsg").html("<img src='../wp-content/plugins/find-me-else-where/images/ajaxloading.gif'/>waiting......");
			},
			success: function(msg){
				if(msg == 1){
					jQuery("#displaymsg").show();
					jQuery("#displaymsg").html("<img src='../wp-content/plugins/find-me-else-where/images/ok.gif'/>ok");
					setTimeout("re()",500);
				}else{
					jQuery("#displaymsg").show();
					jQuery("#displaymsg").html("<img src='../wp-content/plugins/find-me-else-where/images/use.gif'/>"+msg);
				}
			}
		}); 
	});
})
function addnetwork(){
	var category = jQuery("#category").val();
	var order = jQuery("#order").val();
	var title = jQuery("#title").val();
	var url = jQuery("#url").val();
	if(category == ""){
		alert("category is empty");
		return;
	}
	if(order == ""){
		alert("order is empty");
		return;
	}
	if(title == ""){
		alert("title is empty");
		return;
	}
	if(url == ""){
		alert("url is empty");
		return;
	}else{
		url = encodeURIComponent(url);
	}
	jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-else-where/find_me_else_where_handle.php",
			data: "action=add&order="+order+"&title="+title+"&url="+url+"&category="+category,
			beforeSend: function(){
				jQuery("#msg").show();
				jQuery("#msg").html("<img src='../wp-content/plugins/find-me-else-where/images/ajaxloading.gif'/>waiting......");
			},
			success: function(msg){
				if(msg == 1){
					jQuery("#msg").show();
					jQuery("#msg").html("<img src='../wp-content/plugins/find-me-else-where/images/ok.gif'/>ok");
					jQuery("#category").val('');
					jQuery("#order").val('');
					jQuery("#title").val('');
					jQuery("#url").val('');
					setTimeout("re()",500);
				}else{
					jQuery("#msg").show();
					jQuery("#msg").html("<img src='../wp-content/plugins/find-me-else-where/images/use.gif'/>"+msg);
				}
			}
	}); 
}
function re(){
	window.location.reload();
}
function del(id){
	if(confirm("You are about to delete it 'Cancel' to stop, 'OK' to delete.")){
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-else-where/find_me_else_where_handle.php",
			data: "action=del&id="+id,
			beforeSend: function(){
				jQuery("#listmsg").show();
				jQuery("#listmsg").html("<img src='../wp-content/plugins/find-me-else-where/images/ajaxloading.gif'/>waiting......");
			},
			success: function(msg){
				if(msg == 1){
					jQuery("#listmsg").show();
					jQuery("#listmsg").html("<img src='../wp-content/plugins/find-me-else-where/images/ok.gif'/>ok");
					setTimeout("re()",500);
				}else{
					jQuery("#listmsg").show();
					jQuery("#listmsg").html("<img src='../wp-content/plugins/find-me-else-where/images/use.gif'/>"+msg);
				}
			}
		}); 
	}
}

function edit(id){
	var order = jQuery("#mod_order").val();
	var title = jQuery("#mod_title").val();
	var url = jQuery("#mod_url").val();
	if(order == ""){
		alert("order is empty");
		return;
	}
	if(title == ""){
		alert("title is empty");
		return;
	}
	if(url == ""){
		alert("url is empty");
		return;
	}else{
		url = encodeURIComponent(url);
	}
	jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-else-where/find_me_else_where_handle.php",
			data: "action=edit&order="+order+"&title="+title+"&url="+url+"&id="+id,
			beforeSend: function(){
				jQuery("#listmsg").show();
				jQuery("#listmsg").html("<img src='../wp-content/plugins/find-me-else-where/images/ajaxloading.gif'/>waiting......");
			},
			success: function(msg){
				if(msg == 1){
					jQuery("#listmsg").show();
					jQuery("#listmsg").html("<img src='../wp-content/plugins/find-me-else-where/images/ok.gif'/>ok");
					setTimeout("re()",500);
				}else{
					jQuery("#listmsg").show();
					jQuery("#listmsg").html("<img src='../wp-content/plugins/find-me-else-where/images/use.gif'/>"+msg);
				}
			}
	}); 
}