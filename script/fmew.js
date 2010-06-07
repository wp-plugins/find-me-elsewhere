jQuery(document).ready(function(){
	jQuery(".default-icons-name").toggle(function(){
		jQuery(this).css("background","url(../wp-content/plugins/find-me-elsewhere/images/lefttitle.png) 700px 0");
		jQuery(this).siblings(".default-icons-holder").toggle(); 
	},function(){
		jQuery(this).css("background","url(../wp-content/plugins/find-me-elsewhere/images/lefttitle.png) 0 0");
		jQuery(this).siblings(".default-icons-holder").toggle(); 
	});
	jQuery(".active-icons-name").toggle(function(){
		jQuery(this).css("background","url(../wp-content/plugins/find-me-elsewhere/images/righttitle.png) 285px 0");
		jQuery(this).siblings(".active-icons-holder").toggle();
	},function(){
		jQuery(this).css("background","url(../wp-content/plugins/find-me-elsewhere/images/righttitle.png) 0 0");
		jQuery(this).siblings(".active-icons-holder").toggle();
	});
	jQuery("#sortable li").find(".control").click(function(){
		jQuery(this).parent("h2").siblings(".icon-inside").toggle();
	});
	jQuery("#draggable li").find(".custom-control").click(function(){
		jQuery(this).parent("h2").siblings(".custom-inside").toggle();
	});
	jQuery("#draggable li").find(".custom-icon-remove").click(function(){
		jQuery(this).parents("li").remove();
		var icon_key = jQuery(this).parents("li").find('.custom-icon-type').val();
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
			data: "action=custom-delete&icon-key="+icon_key,
			success: function(msg){
				var icons = jQuery("#sortable").find('.icon');
				var num = icons.length;
				for(i = 0; i < num; i++){
					if(icon_key == icons.eq(i).find('.icon-type').val()){
						icons.eq(i).remove();
					}
				}
			}
		}); 
	});
	jQuery("#draggable li").find(".custom-icon-save").click(function(){
		var current_li = jQuery(this).parents("li");
		var icon_key = current_li.find('.custom-icon-type').val();
		var custom_icon_name = current_li.find('.custom-icon-name').val();
		var custom_bicon_url = current_li.find('.custom-bicon-url').val();
		var custom_sicon_url = current_li.find('.custom-sicon-url').val();
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
			data: "action=custom-save&icon-key="+icon_key+"&icon-name="+custom_icon_name+"&bicon-url="+encodeURIComponent(custom_bicon_url)+"&sicon-url="+encodeURIComponent(custom_sicon_url),
			beforeSend: function(){
				current_li.find('.ajax').show();
			},
			success: function(msg){
				current_li.find('.ajax').hide();
				current_li.find('h2').children("img").attr('src',custom_sicon_url);
				current_li.find('h2').children("span").text(custom_icon_name);
			}
		});
	});
	jQuery("#draggable li").find(".custom-icon-close").click(function(){
		jQuery(this).parents(".custom-inside").hide();
	});
	jQuery("#sortable li").find(".icon-remove").click(function(){
		jQuery(this).parents("li").remove();
		var icon_id = jQuery(this).parents("li").find('.icon-id').val();
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
			data: "action=delete&icon-id="+icon_id,
			beforeSend: function(){
				jQuery(".header-ajax").show();
			},
			success: function(msg){
				jQuery(".header-ajax").hide();
			}
		}); 
	});
	jQuery("#sortable li").find(".icon-save").click(function(){
		var icon_id = jQuery(this).parents("li").find('.icon-id').val();
		var icon_title = jQuery(this).parents("li").find('.icon-title').val();
		var icon_url = jQuery(this).parents("li").find('.icon-url').val();
		var icon_ajax = jQuery(this).parents("li").find('.ajax');
		jQuery.ajax({
			type: "POST",
			url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
			data: "action=save&icon-id="+icon_id+"&icon-title="+icon_title+"&icon-url="+encodeURIComponent(icon_url),
			beforeSend: function(){
				icon_ajax.show();
			},
			success: function(msg){
				icon_ajax.hide();
			}
		});
	}); 
	jQuery("#sortable li").find(".icon-close").click(function(){
		jQuery(this).parents(".icon-inside").hide();
	});
	jQuery("#sortable").sortable({
		revert: true,
		items: "> .icon",
		handle: "> h2",
		cursor: "move",
		stop: function(ev, ui){
			var item = ui.item;
			var add = item.find("input.add_new").val();
			if(add == "add"){
				var icon_type = item.find("input.icon-type").val();
				jQuery.ajax({
					type: "POST",
					url:  "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
					data: "action=add&icon-type="+icon_type,
					beforeSend: function(){
						item.find(".ajax").show();
					},
					success: function(key){
						item.find("input.add_new").val("");
						item.find("input.icon-id").val(key);
						item.find(".ajax").hide();
						var keys = jQuery("#sortable").find(".icon-id");
						var len = keys.length;
						var keys_str = '';
						for (i = 0; i < len; i++){
							if(i == 0){
								keys_str = keys_str + keys.eq(i).val();
							}else{
								keys_str = keys_str + ',' + keys.eq(i).val();
							}
						}
						jQuery.ajax({
							type: "POST",
							url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
							data: "action=sort&keys="+keys_str,
							beforeSend: function(){
								jQuery(".header-ajax").show();
							},
							success: function(){
								jQuery(".header-ajax").hide();
							}
						});
					}
				});
				item.find(".control").click(function(){
					jQuery(this).parent("h2").siblings(".icon-inside").toggle();
				});
				item.find(".icon-remove").click(function(){
					jQuery(this).parents("li").remove();
					var icon_id = jQuery(this).parents("li").find('.icon-id').val();
					jQuery.ajax({
						type: "POST",
						url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
						data: "action=delete&icon-id="+icon_id,
						beforeSend: function(){
							jQuery(".header-ajax").show();
						},
						success: function(msg){
							jQuery(".header-ajax").hide();
						}
					}); 
				});
				item.find(".icon-save").click(function(){
					var icon_id = jQuery(this).parents("li").find(".icon-id").val();
					var icon_title = jQuery(this).parents("li").find(".icon-title").val();
					var icon_url = jQuery(this).parents("li").find(".icon-url").val();
					var icon_ajax = jQuery(this).parents("li").find(".ajax");
					jQuery.ajax({
						type: "POST",
						url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
						data: "action=save&icon-id="+icon_id+"&icon-title="+icon_title+"&icon-url="+encodeURIComponent(icon_url),
						beforeSend: function(){
							icon_ajax.show();
						},
						success: function(msg){
							icon_ajax.hide();
						}
					});
				}); 
				item.find(".icon-close").click(function(){
					jQuery(this).parents(".icon-inside").hide();
				});
			}else{
				var keys = jQuery("#sortable").find(".icon-id");
				var len = keys.length;
				var keys_str = '';
				for (i = 0; i < len; i++){
					if(i == 0){
						keys_str = keys_str + keys.eq(i).val();
					}else{
						keys_str = keys_str + ',' + keys.eq(i).val();
					}
				}
				jQuery.ajax({
					type: "POST",
					url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
					data: "action=sort&keys="+keys_str,
					beforeSend: function(){
						jQuery(".header-ajax").show();
					},
					success: function(){
						jQuery(".header-ajax").hide();
					}
				});
			}
		}
	});
	jQuery("#draggable > li").draggable({
		connectToSortable: '#sortable',
		helper: 'clone',
		revert: 'invalid',
		start:function(ev, ui){
			jQuery(this).find(".custom-inside").hide();
		}
	});
	jQuery("#draggable").droppable({
		accept: '#sortable li',
		activeClass:'droppable-active',
		hoverClass:'droppable-hover',
		drop: function(ev, ui) {
			var icon_id = ui.draggable.find('.icon-id').val();
			var len = jQuery("#sortable").find(".icon-id").length;
			for(i = 0; i < len; i++){
				if(jQuery("#sortable").find(".icon-id").eq(i).val() == icon_id){
					jQuery("#sortable").find(".icon-id").eq(i).parents("li").hide();
					jQuery("#sortable").find(".icon-id").eq(i).parents("li").empty();
				}
			}
			jQuery.ajax({
				type: "POST",
				url: "../wp-content/plugins/find-me-elsewhere/find-me-else-where-action.php",
				data: "action=delete&icon-id="+icon_id,
				beforeSend: function(){
					jQuery(".header-ajax").show();
				},
				success: function(msg){
					jQuery(".header-ajax").hide();
				}
			}); 
		}
	});
	jQuery('.custom-icons').submit(function(){
		if(jQuery("#icon-name").val() == ''){
			alert("Icon name is empty");
			jQuery("#icon-name").focus();
			return false;
		}
		if(jQuery("#bicon-url").val() == ''){
			alert("Icon big image url is empty");
			jQuery("#bicon-url").focus();
			return false;
		}
		if(jQuery("#sicon-url").val() == ''){
			alert("Icon small image url is empty");
			jQuery("#sicon-url").focus();
			return false;
		}
		return true;
	});
});