<?php
/*
Plugin Name:Find Me Else Where
Plugin URI:http://wpease.com/find-me-else-where
Description:
version:1.1.0
Author:Wpease Team.
*/
require(ABSPATH.'wp-config.php');
class FindMeElseWhere{
	public function add_jquery(){
?>
		<script type="text/javascript">
			if(typeof(jQuery) == 'undefined'){
				var jquery_script = document.createElement("script");
			    jquery_script .type = "text/javascript";
			    jquery_script .src = "<?php echo WP_PLUGIN_URL;?>/find-me-elsewhere/script/jquery-1.3.2.min.js";
		   	    document.getElementsByTagName("head")[0].appendChild(jquery_script);
			}
		</script>
<?php }
	public function add_cssfile(){
		wp_register_style('admincss', WP_PLUGIN_URL.'/find-me-elsewhere/css/fmew.css');
		wp_enqueue_style('admincss');
	}
	public function add_style_cssfile(){
		if($currentstyle = get_option('fmew_current_style')){
			$css_file = $currentstyle.'.css';
		}else{
			$css_file = 'fmew_default.css';
		}
		wp_register_style('fmew_sytle_css', WP_PLUGIN_URL.'/find-me-elsewhere/css/'.$css_file);
		wp_enqueue_style('fmew_sytle_css');
	}

	public function add_admin_jsfile(){
		wp_register_script('fmewscript',WP_PLUGIN_URL.'/find-me-elsewhere/script/fmew.js',array('jquery'));
		wp_enqueue_script('fmewscript');
	}
	public function add_style_jsfile(){
		if($currentjs = get_option('fmew_current_style')){
			$js_file = $currentjs.'.js';
		}else{
			$js_file = 'fmew_default.js';
		}
		wp_register_script('fmew_sytle_js',WP_PLUGIN_URL.'/find-me-elsewhere/script/'.$js_file);
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
        extract( $args );
        $currentstyle = get_option('fmew_current_style');
        $display = get_option('fmew_message_option');
        $networklinks = get_option('fmew_networklinks_option');
	    if(count($networklinks) > 0){
	    	$arr = array();
	    	foreach($networklinks as $key => $value){
	    		$arr[$value['order'].$key] = $key;
	    	}
	    	ksort($arr);
	    	echo $before_widget;
    		echo '<div id="fmew">';
    		echo $before_title;
    		if($instance['title'] != ''){
    			echo $instance['title'];
    		}else{
    			echo 'Find me else where';
    		}
    		echo $after_title;
			echo '<ul class="network">';
			$i = 0;
        	foreach ($arr as $key){
        		if(isset($instance['number']) && $instance['number'] != ''){
        			$number = $instance['number'];
        		}else{
        			$number = 5;
        		}
        		if(($i % $number) == 0){
	        		echo '<li class="first"><a href="'.urldecode($networklinks[$key]['url']).'" title="'.$networklinks[$key]['title'].'" class="'.$networklinks[$key]['category'].'">'.$networklinks[$key]['title'].'</a></li>';
        		}else{
        			echo '<li><a href="'.urldecode($networklinks[$key]['url']).'" title="'.$networklinks[$key]['title'].'" class="'.$networklinks[$key]['category'].'">'.$networklinks[$key]['title'].'</a></li>';
        		}
        		$i++;
        	}
        	echo '</ul>';
        	if($display == 'yes'){
        		echo '<a class="getfmew" href="http://wpease.com/find-me-else-where" title="">Get this plugin for my blog</a>';
        	}
    		echo '</div>';
    		echo $after_widget;
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
        	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Icons per lines:'); ?> 
	        <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
	        </label>
        </p>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("FindMeElseWhereWidget");'));

class FmewOptions{
	function saveoption(){
		$arr_sites = array();
		$arr_sites[0] = array('network' => 'FaceBook');
		$arr_sites[1] = array('network' => 'FriendFeed');
		$arr_sites[2] = array('network' => 'MySpace');
		$arr_sites[3] = array('network' => 'Friendster');
		$arr_sites[4] = array('network' => 'LinkedIn');
		$arr_sites[5] = array('network' => 'Orkut');
		$arr_sites[6] = array('network' => 'Bebo');
		$arr_sites[7] = array('network' => 'Hi5');
		$arr_sites[8] = array('network' => 'Twitter');
		$arr_sites[9] = array('network' => 'Flickr');
		$arr_sites[10] = array('network' => 'Digg');
		$arr_sites[11] = array('network' => 'Delicious');
		if(!get_option('fmew_network_option')){
			add_option('fmew_network_option', $arr_sites);
		}else{
			update_option('fmew_network_option', $arr_sites);
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
function get_networks(){
    $currentstyle = get_option('fmew_current_style');
    $display = get_option('fmew_message_option');
    $networklinks = get_option('fmew_networklinks_option');
    if(count($networklinks) > 0){
    	$arr = array();
    	foreach($networklinks as $key => $value){
    		$arr[$value['order'].$key] = $key;
    	}
    	ksort($arr);
		echo '<div id="fmew">';
		echo '<h3>Find me else where</h3>';
		echo '<ul class="network">';
    	foreach ($arr as $key){
    		$i = 0;
    		echo '<li><a href="'.urldecode($networklinks[$key]['url']).'" title="'.$networklinks[$key]['title'].'" class="'.$networklinks[$key]['category'].'">'.$networklinks[$key]['title'].'</a></li>';
    		$i++;
    	}
    	echo '</ul>';
    	if($display == 'yes'){
    		echo '<a class="getfmew" href="http://wpease.com/find-me-else-where" title="">Get this plugin for my blog</a>';
    	}
		echo '</div>';
    }           
}           
?>