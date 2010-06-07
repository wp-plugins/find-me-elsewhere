<?php
/*
Plugin Name:Find Me Elsewhere
Plugin URI:http://wpease.com/find-me-else-where
Description:
version:1.2
Author:Wpease Team.
*/
if(!class_exists('FindMeElseWhere')){
	class FindMeElseWhere {
		/**
		 * Do action
		 */
		function fmew_action(){
			$default_icons = FindMeElseWhere::defaultOptions();
			if(!get_option('default_icons_options')){
				add_option('default_icons_options', $default_icons);
			}
			if(!get_option('display_options')){
				add_option('display_options', array('follow' => 0,'target' => 0, 'show' => 0));
			}
			if(isset($_POST['iconSubmit'])){
				$icon_name = strtolower(str_replace(' ','',$_POST['icon-name']));
				$bicon_url = $_POST['bicon-url'];
				$sicon_url = $_POST['sicon-url'];
				$default_icons = get_option('default_icons_options');
				if(!array_key_exists($icon_name, $default_icons)){
					$default_icons[$icon_name] = array(
													'name'       => $_POST['icon-name'],
													'icon'       => $bicon_url,
													'small-icon' => $sicon_url,
													'custom'     => true
												);
					update_option('default_icons_options', $default_icons);
				}
			}
			if(isset($_POST['icon-settings'])){
				$icon_follow = $_POST['icon-follow'];
				$icon_target = $_POST['icon-target'];
				$icon_show = $_POST['icon-show'];
				update_option('display_options', array('follow' => $icon_follow,'target' => $icon_target, 'show' => $icon_show));
			}
			add_menu_page('Find Me Elsewhere', 'Find me elsewhere', 8, basename(__FILE__), array('FindMeElseWhere','displayOptions'));
			add_action('admin_print_styles',array('FindMeElseWhere', 'fmew_add_style'));
			add_action('admin_print_scripts', array('FindMeElseWhere', 'fmew_add_script'));
		}
		
		/**
		 * Define default icons
		 */
		function defaultOptions(){
			$default_icons = array(
				'bebo' => array(
						'name'       => 'Bebo',
						'icon'       => 'bebo.png',
						'small-icon' => 'bebo-small.png'
				),
				'buzz' => array(
						'name'       => 'Buzz',		
						'icon'       => 'buzz.png',
						'small-icon' => 'buzz-small.png'
				),
				'delicious' => array(
						'name'       => 'Delicious',
						'icon'       => 'delicious.png',
						'small-icon' => 'delicious-small.png'
				),
				'digg' => array(
						'name'       => 'Digg',
						'icon'       => 'digg.png',
						'small-icon' => 'digg-small.png'
				),
				'facebook' => array(
					 	'name'       => 'FaceBook',
					 	'icon'       => 'facebook.png',
					 	'small-icon' => 'facebook-small.png'
				),
				'flickr' => array(
						'name'       => 'Flickr',
						'icon'       => 'flickr.png',
						'small-icon' => 'flickr-small.png'
				),
				'friendfeed' => array(
						'name'       => 'FriendFeed',
						'icon'       => 'friendfeed.png',
						'small-icon' => 'friendfeed-small.png'
				),
				'friendster' => array(
						'name'       => 'Friendster',
						'icon'       => 'friendster.png',
						'small-icon' => 'friendster-small.png'
				),
				'hi5' => array(
						'name'       => 'Hi5',
						'icon'       => 'hi5.png',
						'small-icon' => 'hi5-small.png'
				),
				'linkedin' => array(
						'name'       => 'LinkedIn',
						'icon'       => 'linkedin.png',
						'small-icon' => 'linkedin-small.png'
				),
				'myspace' => array(
						'name'       => 'MySpace',
						'icon'       => 'myspace.png',
						'small-icon' => 'myspace-small.png'
				),
				'orkut' => array(
						'name'       => 'Orkut',
						'icon'       => 'orkut.png',
						'small-icon' => 'orkut-small.png'
				),
				'twitter' => array(
						'name'       => 'Twitter',
						'icon'       => 'twitter.png',
						'small-icon' => 'twitter-small.png'
				),
				'vimeo' => array(
						'name'       => 'Vimeo',
						'icon'       => 'vimeo.png',
						'small-icon' => 'vimeo-small.png'
				),
				'wave' => array(
						'name'       => 'Wave', 
						'icon'       => 'wave.png',
						'small-icon' => 'wave-small.png'
				),
				'youtube' => array(
						'name'       => 'Youtube',
						'icon'       => 'youtube.png',
						'small-icon' => 'youtube-small.png'
				)
			);
			return $default_icons;
		}
		
		/**
		 * Display the control panel
		 */
		function displayOptions(){
			if(get_option('default_icons_options') !== false){
				$default_icons = get_option('default_icons_options');
			}
			if(get_option('actived_icons_options') !== false){
				$actived_icons = get_option('actived_icons_options');
			}
			if(get_option('display_options') !== false){
				$display_options = get_option('display_options');
			}
?>
<div class="updated fade">
	<p>
	Notice:If you have any problem on using the plugin,please ask for help on our <a href="http://www.wpease.com/support/viewforum.php?f=2" target="_blank">Support forum</a>.
	</p>
	<p>
	If you like this plugin and want it to be better, Please share your mind with us on how to improve it .<a href="http://www.wpease.com/support/viewforum.php?f=2" target="_blank">Support forum</a>
	</p>
</div>
		<div class="wrap">
			<div id="fmew-options">	
				<div class="icon32" id="icon-themes"><br></div>
				<h2>Find Me Elsewhere Options</h2>
				<div class="fmew-icons-container">
					<div class="fmew-wrap">
						<div class="fmew-default-icons">
							<div class="default-icons-name">
								<h3>Available Icons</h3>
							</div>
							<div class="default-icons-holder">
								<p class="description">Drag icons from here to a icon list on the right to activate them. Drag icons back here to deactivate them and delete their settings.</p>
								<ul id="draggable">
								<?php if(isset($default_icons) && $default_icons != ''): ?>
								<?php foreach($default_icons as $key => $icon): ?>
								<?php $url = (preg_match('/^http/',$icon['small-icon']))? $icon['small-icon']: WP_PLUGIN_URL.'/find-me-elsewhere/images/'.$icon['small-icon']; ?>
									<li class="icon <?php echo (isset($icon['custom']) && $icon['custom'] == true)? 'custom':''; ?>">
										<h2>
											<img src="<?php echo $url; ?>" />
											<span><?php echo $icon['name']; ?></span>
											<a href="javascript:;" class="control"></a>
											<?php if(isset($icon['custom']) && $icon['custom'] == true): ?>
											<a href="javascript:;" class="custom-control"></a>
											<?php endif; ?>
										</h2>
										<?php if(isset($icon['custom']) && $icon['custom'] == true): ?>
										<div class="custom-inside">
											<input type="hidden" name="custom-icon-type" class="custom-icon-type" value="<?php echo $key; ?>" />
											<p><label>Icon name:</label><br /><input type="text" name="custom-icon-name" class="custom-icon-name" value="<?php echo $icon['name']; ?>"/></p>
											<p><label>Icon big image url:</label><br /><input type="text" name="custom-bicon-url" class="custom-bicon-url" value="<?php echo $icon['icon']; ?>" /></p>
											<p><label>Icon small image url:</label><br /><input type="text" name="custom-sicon-url" class="custom-sicon-url" value="<?php echo $icon['small-icon']; ?>" /></p>
											<p>
												<input type="submit" value="Save" class="button-primary alignright custom-icon-save" name="custom-icon-save" />
												<img src="<?php echo WP_PLUGIN_URL; ?>/find-me-elsewhere/images/wpspin_light.gif" class="alignright ajax" />
												<a class="custom-icon-remove" href="javascript:;">Delete</a> | <a class="custom-icon-close" href="javascript:;">Close</a>
											</p>
										</div>
										<?php endif; ?>
										<div class="icon-inside">
											<input type="hidden" name="icon-type" class="icon-type" value="<?php echo $key; ?>" />
											<input type="hidden" name="icon-id" class="icon-id" value="" />
											<input type="hidden" name="add_new" class="add_new" value="add" />
											<p><label>Title: </label><input type="text" name="title" value="" class="icon-title"/></p>
											<p><label>URL: </label><input type="text" name="url" class="icon-url" /></p>
											<p>
												<input type="submit" value="Save" class="button-primary alignright icon-save" name="icon-save" />
												<img src="<?php echo WP_PLUGIN_URL; ?>/find-me-elsewhere/images/wpspin_light.gif" class="alignright ajax" />
												<a class="icon-remove" href="javascript:;">Delete</a> | <a class="icon-close" href="javascript:;">Close</a>
											</p>
										</div>
									</li>
								<?php endforeach; ?>
								<?php endif; ?>
								</ul>
							</div>					
						</div>
					</div>
					<div class="fmew-wrap">
						<div class="fmew-default-icons custom-icon">
							<div class="default-icons-name">
								<h3>Custom Icons</h3>
							</div>
							<div class="default-icons-holder">
								<p class="description">Add your favorite icons, they will display in the "Available Icons"</p>
								<form action="#" name="custom-icons" class="custom-icons" method="POST">
									<fieldset>
										<p><label for="icon-name">Icon name:</label><input type="text" name="icon-name" id="icon-name" value=""/></p>
										<p><label for="bicon-url">Icon big image url:</label><input type="text" name="bicon-url" id="bicon-url" value="" /></p>
										<p><label for="sicon-url">Icon small image url:</label><input type="text" name="sicon-url" id="sicon-url" value="" /></p>
										<p><input type="submit" value="Add Icon" class="button-primary" name="iconSubmit" style="width:auto;"></p>
									</fieldset>
								</form>
							</div>					
						</div>
					</div>
					<div class="fmew-wrap">
						<div class="fmew-default-icons icon-settings">
							<div class="default-icons-name">
								<h3>Icons display settings</h3>
							</div>
							<div class="default-icons-holder">
								<p class="description"></p>
								<form action="#" name="icon-settings" method="POST">
									<fieldset>
										<p>
											<input type="checkbox" name="icon-follow" value="1" <?php echo (isset($display_options) && ($display_options['follow'] == 1))? 'checked': '';?> /><label>&nbsp;&nbsp; Don't add "nofollow"</label>
										</p>
										</p>
										<p>
											<input type="checkbox"" name="icon-show" value="1" <?php echo (isset($display_options) && ($display_options['show'] == 1))? 'checked': '';?> ><label>&nbsp;&nbsp; Show small icons in front page</label>
										</p>
										<p>
											<input type="checkbox" name="icon-target" value="1" <?php echo (isset($display_options) && ($display_options['target'] == 1))? 'checked': '';?> ><label>&nbsp;&nbsp; Open the socialnet in a new window</label>
										</p>
										
										</p>
										<p><input type="submit" value="Save Changes" class="button-primary" name="icon-settings" style="width:auto;"></p>
									</fieldset>
								</form>
							</div>					
						</div>
					</div>
				</div>
				<div class="fmew-active-icons">
					<div class="active-icons-name">
						<h3>Actived Icons<span><img src="<?php echo WP_PLUGIN_URL; ?>/find-me-elsewhere/images/wpspin_dark.gif" class="header-ajax"/></span></h3>
					</div>
					<div class="active-icons-holder">
						<ul id="sortable">
						<?php if(isset($actived_icons) && count($actived_icons) > 0):?>
						<?php foreach($actived_icons as $key => $icon): ?>
						<?php $url = (preg_match('/^http/',$default_icons[$icon['icon-type']]['small-icon']))? $default_icons[$icon['icon-type']]['small-icon']: WP_PLUGIN_URL.'/find-me-elsewhere/images/'.$default_icons[$icon['icon-type']]['small-icon']; ?>
							<li class="icon">
								<h2>
									<img src="<?php echo $url; ?>" />
									<span><?php echo $default_icons[$icon['icon-type']]['name']; ?></span>
									<a href="javascript:;" class="control"></a>
								</h2>
								<div class="icon-inside" style="display:none;">
									<input type="hidden" name="icon-type" class="icon-type" value="<?php echo $icon['icon-type']; ?>" />
									<input type="hidden" name="icon-id" class="icon-id" value="<?php echo $key; ?>"/>
									<input type="hidden" name="add_new" class="add_new" value="" />
									<p><label>Title: </label><input type="text" name="title" value="<?php echo $icon['title']; ?>" class="icon-title"/></p>
									<p><label>URL: </label><input type="text" name="url" class="icon-url" value="<?php echo $icon['url']; ?>" /></p>
									<p>
										<input type="submit" value="Save" class="button-primary alignright icon-save" name="icon-save"  />
										<img src="<?php echo WP_PLUGIN_URL; ?>/find-me-elsewhere/images/wpspin_light.gif" class="alignright ajax" />
										<a class="icon-remove" href="javascript:;">Delete</a> | <a class="icon-close" href="javascript:;">Close</a>
									</p>
								</div>
							</li>
						<?php endforeach; ?>
						<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
	<h3>Help us by Donate</h3>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="10519234">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

<?php 
		}
		
		/**
		 * Add admin style
		 */
		function fmew_add_style(){
			if(is_admin()){
				wp_register_style('fmew-style', WP_PLUGIN_URL.'/find-me-elsewhere/css/fmew.css');
				wp_enqueue_style('fmew-style');
			}
		}
		
		/**
		 * Add admin script
		 */
		function fmew_add_script(){
			if(is_admin()){
				wp_register_script('fmew-script', WP_PLUGIN_URL.'/find-me-elsewhere/script/fmew.js');
				wp_enqueue_script('fmew-script');
				wp_register_script('jq', get_bloginfo('siteurl').'/wp-includes/js/jquery/jquery.js');
				wp_enqueue_script('jq');
				wp_register_script('ui-core', get_bloginfo('siteurl').'/wp-includes/js/jquery/ui.core.js');
				wp_enqueue_script('ui-core');
				wp_register_script('ui-widget', get_bloginfo('siteurl').'/wp-includes/js/jquery/ui.widget.js');
				wp_enqueue_script('ui-widget');
				wp_register_script('ui-mouse', get_bloginfo('siteurl').'/wp-includes/js/jquery/ui.mouse.js');
				wp_enqueue_script('ui-mouse');
				wp_register_script('ui-draggable', get_bloginfo('siteurl').'/wp-includes/js/jquery/ui.draggable.js');
				wp_enqueue_script('ui-draggable');
				wp_register_script('ui-droppable', get_bloginfo('siteurl').'/wp-includes/js/jquery/ui.droppable.js');
				wp_enqueue_script('ui-droppable');
				wp_register_script('ui-sortable', get_bloginfo('siteurl').'/wp-includes/js/jquery/ui.sortable.js');
				wp_enqueue_script('ui-sortable');
			}
		}
		
		/**
		 * Add front css
		 */
		function fmew_front_css(){
			wp_register_style('fmew-front', WP_PLUGIN_URL.'/find-me-elsewhere/css/front.css');
			wp_enqueue_style('fmew-front');
		}
	}
	add_action('admin_menu', array('FindMeElseWhere', 'fmew_action'));
	add_action("wp_print_styles",array('FindMeElseWhere', 'fmew_front_css'));
}
if(!class_exists("FmewWidget")){
	class FmewWidget extends WP_Widget {
		function FmewWidget() {
	        parent::WP_Widget(false, $name = 'Find Me Elsewhere');	
	    }
	    function widget($args, $instance) {	
	        extract( $args );
	        $actived_icons = get_option("actived_icons_options");
	        $default_icons = get_option('default_icons_options');
	        $display_options = get_option('display_options');
	        $icon_follow = (isset($display_options['follow']) && ($display_options['target'] == 1))? '': 'rel="nofollow"';
	        $icon_target = (isset($display_options['target']) && ($display_options['target'] == 1))? '_blank': '_self';
	        $icon_show = (isset($display_options['show']) && ($display_options['show'] == 1))? 'small-icon': 'icon';
	    	echo $before_widget;
	    	if($instance['title'] != ''){
				echo $before_title .$instance['title']. $after_title;
	    	}
	    	if(is_array($actived_icons) && (count($actived_icons) > 0)){
				echo '<ul id="fmew-icons-widget">';
				foreach($actived_icons as $key => $icon){
					$url = (preg_match('/^http/',$default_icons[$icon['icon-type']][$icon_display_type]))? $default_icons[$icon['icon-type']][$icon_show]: WP_PLUGIN_URL.'/find-me-elsewhere/images/'.$default_icons[$icon['icon-type']][$icon_show];
					echo '<li><a href="'.$icon['url'].'" title="'.$icon['title'].'" target="'.$icon_target.'" '.$icon_follow.'><img src="'.$url.'" /></a></li>';
				}
				echo '</ul>';
	    	}
			echo $after_widget;        
	    }
	    function update($new_instance, $old_instance) {				
	        return $new_instance;
	    }
	    function form($instance) {				
	        $title = esc_attr($instance['title']);
	        ?>
	        <p>
		        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
		        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		        </label>
	        </p>
	        <?php 
	    }
	}
	add_action('widgets_init', create_function('', 'return register_widget("FmewWidget");'));
}
?>