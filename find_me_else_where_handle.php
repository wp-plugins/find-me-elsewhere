<?php
require('../../../wp-config.php');
if(isset($_POST['action'])){
	$action = $_POST['action'];
	if($action == 'add'){
		$order = $_POST['order'];
		$title = $_POST['title'];
		$url = urlencode($_POST['url']);
		$category = $_POST['category'];
		$networklink =array('order' => $order, 'title' =>$title, 'url' =>$url, 'category' => $category);
		if( $networklinks = get_option('fmew_networklinks_option')){
			array_push($networklinks, $networklink);
			update_option('fmew_networklinks_option', $networklinks);
			echo 1;
		}else{
			$networklinks[] = $networklink;
			update_option('fmew_networklinks_option', $networklinks);
			echo 1;
		}
	}else if($action == 'del'){
		$key = $_POST['key'];
		if( $networklinks = get_option('fmew_networklinks_option')){
			unset($networklinks[$key]);
			update_option('fmew_networklinks_option', $networklinks);
			echo 1;
		}else{
			echo 'Delete failed';
		}
	}else if($action == 'edit'){
		$order = $_POST['order'];
		$title = $_POST['title'];
		$url = urlencode($_POST['url']);
		$key = $_POST['key'];
		if( $networklinks = get_option('fmew_networklinks_option')){
			$networklinks[$key]['order'] = $order;
			$networklinks[$key]['title'] = $title;
			$networklinks[$key]['url'] = $url;
			update_option('fmew_networklinks_option', $networklinks);
			echo 1;
		}else{
			echo 'Edit Failed';
		}
	}else if($action == 'save_style'){
		$style = $_POST['style'];
		if(get_option('fmew_current_style')){
			update_option('fmew_current_style', $style);
			echo 1;
		}else{
			add_option('fmew_current_style', $style);
			echo 1;
		}
	}else if($action == "save_display"){
		$display = $_POST['display'];
		if(get_option('fmew_message_option')){
			update_option('fmew_message_option', $display);
			echo 1;
		}else{
			add_option('fmew_message_option', $display);
			echo 1;
		}
	}
}
?>