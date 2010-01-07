<div class="updated fade">
	<p>
	Notice:If you have any problem on using the plugin,please ask for help on our <a href="http://www.wpease.com/support/viewforum.php?f=2" target="_blank">Support forum</a>.
	</p>
	<p>
	If you like this plugin and want it to be better, Please share your mind with us on how to improve it .<a href="http://www.wpease.com/support/viewforum.php?f=2" target="_blank">Support forum</a>
	</p>
</div>
<?php
require('../wp-config.php');
?>
<div id="fmew_admin">

	<div class ="wrap">
	

		<div id="icon-edit" class="icon32"></div>
		<h2>Add social network</h2>
	</div>
	<div id="msg"></div>
	<div class="add">
		<div class="select"><span>Social Networks</span></div>
		<ul>
			<?php
				$arr_sites = get_option('fmew_network_option');
				for($i = 0; $i < count($arr_sites); $i++){
					echo '<li class="'.$arr_sites[$i]['network'].'">';
					echo $arr_sites[$i]['network'];
					echo '</li>';
				};
			?>
		</ul>
		<div class="select_footer"></div>
	</div>
		<fieldset>
			<table>
				<tr><td><label>Order</label></td><td><input type="text" id="order" class="text"/></td><td>*The order of the icons display in widget. Would be a number, for example "1" will appears before "2"</td></tr>
				<tr><td><label>Title</label></td><td><input type="text" id="title" class="text"/></td><td>*The title of the Socical networks, for example "Facebook".</td></tr>
				<tr><td><label>Url</label></td><td><input type="text" id="url"/></td><td>*The url of your social network page, for example "http://www.twitter.com/yourname"</td></tr>
				<input type="hidden" id="category"/>
				<tr><td colspan="2"><br/><input type="button" value="Add to my social network list" onclick="addnetwork()" /></td>
			</table>
		</fieldset>
		<hr/>
	<div class ="wrap">
		<div id="icon-link-manager" class="icon32"></div>
		<h2>Edit social network list</h2>
	</div>
	<div id="listmsg"></div>
	<table class="list">
		<tr>
			<td>Order</td><td>Title</td><td>Url</td><td>edit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;delete</td>
		</tr>
		<?php
			$networklinks = (get_option('fmew_networklinks_option'))?get_option('fmew_networklinks_option'): array() ;
			if(count($networklinks) > 0){$arr = array();
		    	foreach($networklinks as $key => $value){
		    		$arr[$value['order'].$key] = $key;
		    	}
		    	ksort($arr);
				foreach($arr as $key){
					if(isset($_GET['key']) && $_GET['key'] == $key){
						echo '<tr>';
						echo '<td><span class="'.$networklinks[$key]['category'].'"></span><input type="text" id="mod_order" value="'.$networklinks[$key]['order'].'" class="text"/></td>';
						echo '<td><input type="text" id="mod_title" value="'.$networklinks[$key]['title'].'" class="text"/></td>';
						echo '<td><input type="text" id="mod_url" value="'.urldecode($networklinks[$key]['url']).'" /></td>';
						echo '<td><input type="button" id="edit" value="edit" onclick="edit('.$key.')"/><a href="javascript:del('.$key.')" title="delete" class="del">delete</a></td>';
						echo '</tr>';
					}else{
						echo '<tr>';
						echo '<td><span class="'.$networklinks[$key]['category'].'"></span>'.$networklinks[$key]['order'].'</td>';
						echo '<td>'.$networklinks[$key]['title'].'</td>';
						echo '<td>'.urldecode($networklinks[$key]['url']).'</td>';
						echo '<td><a href="admin.php?page=find-me-elsewhere/find_me_else_where.php&action=edit&key='.$key.'" title="edit" class="edit">edit</a><a href="javascript:del('.$key.')" title="delete" class="del">delete</a></td>';
						echo '</tr>';
					}
				}
			}else{
				echo '<tr>';
				echo '<td>Please add a item first !</td>';
				echo '</tr>';
			}
		?>
	</table>
	<hr/>
	
	<div class ="wrap">
		<div id="icon-edit" class="icon32"></div>
		<h2>List style</h2>
	</div>
	<div id="stylemsg"></div>
	<?php $currentstyle = get_option('fmew_current_style'); ?>
	<?php $styles = get_option('fmew_styles_option'); ?>
	<div class="list_style">
		<fieldset>
			<table>
				<?php 
					for($i = 0; $i < count($styles); $i++){
						echo '<tr>';
						if($currentstyle == $styles[$i]['title']){
							echo '<td><input type="radio" name="femw_style" value="'.$styles[$i]['title'].'" checked/></td>';
						}else{
							echo '<td><input type="radio" name="femw_style" value="'.$styles[$i]['title'].'" /></td>';
						}
						echo '<td>'.$styles[$i]['description'].'</td>';
						echo '</tr>';
					}
				?>
				<tr><td colspan="2"><input type="button" id="save_liststyle" value="Save" /></td></tr>
			</table>
		</fieldset>
	</div>
	<hr/>
	<div class ="wrap">
		<div id="icon-link-manager" class="icon32"></div>
		<h2>Help us</h2>
	</div>
	<div id="displaymsg"></div>
	<?php $display_msg = get_option('fmew_message_option'); ?>
	<div class="msg_manage">
		<fieldset>
			<h3>Display the copyright</h3>
			
			<input type="radio" name="fmew_msg" value="yes" <?php echo ($display_msg == 'yes')? 'checked': ''; ?>/><label> display </label>
			<input type="radio" name="fmew_msg" value="no" <?php echo ($display_msg == 'no')? 'checked': ''; ?>/><label> no display</label> &nbsp;&nbsp;&nbsp;&nbsp;(If display is choosen, a piece of text "Get this plugin for my blog" will appear under the social networks list.)
			<p><br/><input type="button" id="save_display_msg" value="Save"></p>
			<p></p>
		</fieldset>
		
	</div>
	<br/><br/><br/>
	<h3>Help us by Donate</h3>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="10519234">
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

		
</div>