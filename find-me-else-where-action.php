<?php 
@require('../../../wp-config.php');
if(isset($_POST['action']) && ($_POST['action'] == "add")){
	$icon_type = $_POST['icon-type'];
	if(($actived_icons = get_option('actived_icons_options')) !== false){
		$actived_icons[] = array('title' => '', 'url' => '', 'icon-type' => $icon_type);
		update_option('actived_icons_options', $actived_icons);
		end($actived_icons);
		echo key($actived_icons);
	}else{
		$actived_icons[] = array('title' => '', 'url' => '', 'icon-type' => $icon_type);
		add_option('actived_icons_options', $actived_icons);
		end($actived_icons);
		echo key($actived_icons);
	}
}
if(isset($_POST['action']) && ($_POST['action'] == "delete")){
	$icon_id = $_POST['icon-id'];
	$actived_icons = get_option('actived_icons_options');
	unset($actived_icons[$icon_id]);
	update_option('actived_icons_options', $actived_icons);
}
if(isset($_POST['action']) && ($_POST['action'] == "save")){
	$icon_id = $_POST['icon-id'];
	$icon_title = $_POST['icon-title'];
	$icon_url = $_POST['icon-url'];
	$actived_icons = get_option('actived_icons_options');
	$actived_icons[$icon_id]['title'] = $icon_title;
	$actived_icons[$icon_id]['url'] = $icon_url;
	update_option('actived_icons_options', $actived_icons);
}
if(isset($_POST['action']) && ($_POST['action'] == 'sort')){
	$keys = $_POST['keys'];
	if($keys != ''){
		$actived_icons = get_option('actived_icons_options');
		$keys = explode(',', $keys);
		$sort_actived_icons = array();
		foreach($keys as $key){
			$sort_actived_icons[$key] = $actived_icons[$key];
		}
		update_option('actived_icons_options', $sort_actived_icons);
	}
}
if(isset($_POST['action']) && ($_POST['action'] == 'custom-delete')){
	$key = $_POST['icon-key'];
	$default_icons = get_option('default_icons_options');
	unset($default_icons[$key]);
	update_option('default_icons_options', $default_icons);
	$actived_icons = get_option('actived_icons_options');
	if(is_array($actived_icons) && (count($actived_icons) > 0)){
		foreach($actived_icons as $actived_key => $actived_icon){
			if(in_array($key, $actived_icon)){
				
				unset($actived_icons[$actived_key]);
			}
		}
	}
	update_option('actived_icons_options', $actived_icons);
}
if(isset($_POST['action']) && ($_POST['action'] == 'custom-save')){
	$key = $_POST['icon-key'];
	$icon_name = $_POST['icon-name'];
	$bicon_url = $_POST['bicon-url'];
	$sicon_url = $_POST['sicon-url'];
	$default_icons = get_option('default_icons_options');
	$default_icons[$key] = array(
								'name'       => $icon_name,
								'icon'       => $bicon_url,
								'small-icon' => $sicon_url,
								'custom'     => true
							);
	update_option('default_icons_options', $default_icons);
}
?>