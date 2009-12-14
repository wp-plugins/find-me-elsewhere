<?php
require('../../../wp-config.php');
$mysqli = @new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if(@$mysqli->errno !== 0){
	exit('can not connect mysql');
}
if(isset($_POST['action'])){
	$action = $_POST['action'];
	if($action == 'add'){
		$order = $_POST['order'];
		$title = $_POST['title'];
		$url = urlencode($_POST['url']);
		$category = $_POST['category'];
		$insert = "INSERT INTO {$table_prefix}find_me_else_where (show_order, title, category, url) VALUES($order, '$title', '$category', '$url')";
		$result = $mysqli->query($insert);
		if($result){
			echo 1;
		}else{
			echo 'unable to insert into the database';
		}
	}else if($action == 'del'){
		$id = $_POST['id'];
		$del = "DELETE FROM {$table_prefix}find_me_else_where WHERE id=$id";
		$del_result = $mysqli->query($del);
		if($del_result){
			echo 1;
		}else{
			echo 'Unable to delete';
		}
	}else if($action == 'edit'){
		$order = $_POST['order'];
		$title = $_POST['title'];
		$url = urlencode($_POST['url']);
		$id = $_POST['id'];
		$update = "UPDATE {$table_prefix}find_me_else_where SET show_order=$order, title='$title', url='$url' WHERE id=$id";
		$result = $mysqli->query($update);
		if($result){
			echo 1;
		}else{
			echo 'Unable to edit';
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