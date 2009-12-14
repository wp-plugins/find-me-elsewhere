<?php
/*
Plugin Name:Find Me Else Where
Plugin URI:http://wpease.com/find-me-else-where
Description:
version:1.0 beta
Author:Wpease Team.
*/
require(ABSPATH.'wp-config.php');
class FindMeElseWhere{
	public function __construct(){
		global $table_prefix;
		$mysqli = @new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if(@$mysqli->errno !== 0){
			exit('can not connect mysql');
		}
		$query = 'SELECT * FROM '.$table_prefix.'find_me_else_where';
		$result = $mysqli->query($query);
		if(!$result){
			$table_create = "CREATE TABLE ".$table_prefix."find_me_else_where( 
							id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
							show_order INT NOT NULL,
							title VARCHAR(50) NOT NULL,
							category VARCHAR(50) NOT NULL,
							url VARCHAR(100) NOT NULL);";
			$result_table = @$mysqli->query($table_create);
			if(!$result_table){
				exit('create table failure');
			}
		}
		$mysqli->close();
	}
	public function add_jquery(){
?>
		<script type="text/javascript">
			if(typeof(jQuery) == 'undefined'){
				var jquery_script = document.createElement("script");
			    jquery_script .type = "text/javascript";
			    jquery_script .src = "<?php echo WP_PLUGIN_URL;?>/find-me-else-where/script/jquery-1.3.2.min.js";
		   	    document.getElementsByTagName("head")[0].appendChild(jquery_script);
			}
		</script>
<?php }
	public function add_cssfile(){
		wp_register_style('admincss', WP_PLUGIN_URL.'/find-me-else-where/css/fmew.css');
		wp_enqueue_style('admincss');
	}
	public function add_style_cssfile(){
		$currentstyle = get_option('fmew_current_style');
		$css_file = $currentstyle.'.css';
		wp_register_style('fmew_sytle_css', WP_PLUGIN_URL.'/find-me-else-where/css/'.$css_file);
		wp_enqueue_style('fmew_sytle_css');
	}

	public function add_admin_jsfile(){
		wp_register_script('fmewscript',WP_PLUGIN_URL.'/find-me-else-where/script/fmew.js',array('jquery'));
		wp_enqueue_script('fmewscript');
	}
	public function add_style_jsfile(){
		$currentstyle = get_option('fmew_current_style');
		$js_file = $currentstyle.'.js';
		wp_register_script('fmew_sytle_js',WP_PLUGIN_URL.'/find-me-else-where/script/'.$js_file);
		wp_enqueue_script('fmew_sytle_js');
	}
	public function mt_add_pages(){
	    add_menu_page('Find Me Else Where', 'Find Me Else Where', 8, __FILE__, array(&$this,'manage_main_page'));  
	}
	
	function manage_main_page(){
	 	include_once('find_me_else_where_main.php');
	}
}
$fmew = new FindMeElseWhere();
add_action('wp_head', array(&$fmew, 'add_jquery'), 5);
add_action('admin_print_scripts',array(&$fmew,'add_admin_jsfile'), 6);
add_action('wp_print_scripts',array(&$fmew,'add_style_jsfile'), 7);
add_action('admin_print_styles', array(&$fmew,'add_cssfile'));
add_action('wp_print_styles', array(&$fmew,'add_style_cssfile'));
add_action('admin_menu', array(&$fmew,'mt_add_pages'));

class FindMeElseWhereWidget extends WP_Widget {
    function FindMeElseWhereWidget() {
        parent::WP_Widget(false, $name = 'Find Me Else Where');	
    }

    function widget($args, $instance) {	
    	global $table_prefix;
    	$mysqli = @new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if(@$mysqli->errno !== 0){
			exit('can not connect mysql');
		}
    	$query = "SELECT * FROM {$table_prefix}find_me_else_where ORDER BY show_order";
		$result = $mysqli->query($query);
		$num = $result->num_rows;
		if($num > 0){
			$i = 0;
			while($row = $result->fetch_assoc()){
				foreach($row as $key => $value){
					$links[$i][$key] = $value;
				}
				$i++;
			}
		}	
		$mysqli->close();
        extract( $args );
        $currentstyle = get_option('fmew_current_style');
        $display = get_option('fmew_message_option');
        if(isset($links)){
        	echo '<div id="fmew">';
				echo '<h3>Find me else where</h3>';
				echo '<ul>';
	        	for($i = 0; $i < count($links); $i++){
	        		if(isset($instance['number']) && $instance['number'] != ''){
	        			$number = $instance['number'];
	        		}else{
	        			$number = 5;
	        		}
	        		if(($i % $number) == 0){
		        		echo '<li class="first"><a href="'.urldecode($links[$i]['url']).'" title="'.$links[$i]['title'].'" class="'.$links[$i]['category'].'">'.$links[$i]['title'].'</a></li>';
	        		}else{
	        			echo '<li><a href="'.urldecode($links[$i]['url']).'" title="'.$links[$i]['title'].'" class="'.$links[$i]['category'].'">'.$links[$i]['title'].'</a></li>';
	        		}
	        	}
	        	echo '</ul>';
	        	if($display == 'yes'){
	        		echo '<a href="#" title="">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</a>';
	        	}
        	echo '</div>';
        }           
    }
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }
    function form($instance) {				
        $title = esc_attr($instance['title']);
        $number = esc_attr($instance['number']);
        ?>
        <p>
	        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
	        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	        </label>
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('The number of lines:'); ?> 
	        <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
	        </label>
        </p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("FindMeElseWhereWidget");'));

class FmewOptions{
	function saveoption(){
		if(!get_option('fmew_network_option')){
			$arr_sites = array();
			$arr_sites[0] = array('network' => 'FaceBook', 'img' => 'facebook.gif');
			$arr_sites[1] = array('network' => 'FriendFeed', 'img' => 'ff.png');
			$arr_sites[2] = array('network' => 'MySpace', 'img' => 'myspace.png');
			$arr_sites[3] = array('network' => 'Friendster', 'img' => 'friendster.png');
			$arr_sites[4] = array('network' => 'LinkedIn', 'img' => 'linkedin.png');
			$arr_sites[5] = array('network' => 'Orkut', 'img' => 'Orkut.png');
			$arr_sites[6] = array('network' => 'Zorpia', 'img' => 'zorpia.png');
			$arr_sites[7] = array('network' => 'Netlog', 'img' => 'netlog.png');
			$arr_sites[8] = array('network' => 'Bebo', 'img' => 'bebo.png');
			$arr_sites[9] = array('network' => 'Hi5', 'img' => 'hi5.png');
			$arr_sites[10] = array('network' => 'PerfSpot', 'img' => 'perfspot.png');
			$arr_sites[11] = array('network' => 'Twitter', 'img' => 'twitter.png');
			add_option('fmew_network_option', $arr_sites);
		}
		if(!get_option('fmew_message_option')){
			add_option('fmew_message_option','yes');
		}
		if(!get_option('fmew_styles_option')){
			$styles = array();
			$styles[0] = array('title' => 'fmew_default', 'description' => 'List the icons only');
			$styles[1] = array('title' => 'fmew_styleone', 'description' => 'List the text title only');
			$styles[2] = array('title' => 'fmew_styletwo', 'description' => 'Icon appear when  mouse on the title');
			$styles[3] = array('title' => 'fmew_stylethree', 'description' => 'Icons appears/disappear when click the title ');
			add_option('fmew_styles_option', $styles);
		}
		if(!get_option('fmew_current_style')){
			add_option('fmew_current_style', 'fmew_default');
		}
	}
}
add_action('admin_menu', array('FmewOptions', 'saveoption'));
function wpease_get_network(){
	global $table_prefix;
	$mysqli = @new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if(@$mysqli->errno !== 0){
		exit('can not connect mysql');
	}
	$query = "SELECT * FROM {$table_prefix}find_me_else_where ORDER BY show_order";
	$result = $mysqli->query($query);
	$num = $result->num_rows;
	if($num > 0){
		$i = 0;
		while($row = $result->fetch_assoc()){
			foreach($row as $key => $value){
				$links[$i][$key] = $value;
			}
			$i++;
		}
	}	
	$mysqli->close();
    $currentstyle = get_option('fmew_current_style');
    $display = get_option('fmew_message_option');
    if(isset($links)){
    	echo '<div id="fmew">';
			echo '<h3>Find me else where</h3>';
			echo '<ul>';
        	for($i = 0; $i < count($links); $i++){
        		$number = 5;
        		if(($i % $number) == 0){
	        		echo '<li class="first"><a href="'.urldecode($links[$i]['url']).'" title="'.$links[$i]['title'].'" class="'.$links[$i]['category'].'">'.$links[$i]['title'].'</a></li>';
        		}else{
        			echo '<li><a href="'.urldecode($links[$i]['url']).'" title="'.$links[$i]['title'].'" class="'.$links[$i]['category'].'">'.$links[$i]['title'].'</a></li>';
        		}
        	}
        	echo '</ul>';
        	if($display == 'yes'){
        		echo '<a class="getfmew" href="http://wpease.com/find-me-else-where" title="">Get this plugin for my blog</a>';
        	}
    	echo '</div>';
    }           
}
?>