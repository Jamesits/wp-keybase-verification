<?php
/*
Plugin Name: Keybase.io Verification
Version: 1.3
Plugin URI: https://github.com/Jamesits/wp-keybase-verification
Description: Keybase.io site verification helper.
Author: James Swineson
Author URI: https://swineson.me/
Text Domain: keybaseverif
Domain Path: /lang
*/

/*
Copyright 2016  James Swineson (@jamesits) <jamesswineson@gmail.com>
Copyright 2011  Hans Vedo  (email : hans@cultivate.it)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Settings
define('keybaseverif_version','1.3');

// Install the plugin
register_activation_hook(__FILE__,'keybaseverif_install');
function keybaseverif_install(){
	// 1st: Look for the file itself.
	if(file_exists(ABSPATH.'keybase.txt')){
		$keybaseverif_text = file_get_contents(ABSPATH.'keybase.txt');
	}else if(get_option('keybaseverif_text') != ''){
		// 2nd: Check if settings have already been saved.
		$keybaseverif_text = stripslashes(get_option('keybaseverif_text'));
	}else{
		// 3rd: Lastly just load the template contents.
		$keybaseverif_text = file_get_contents(ABSPATH.'wp-content/plugins/wp-keybase-verification/template.txt');
	}

	// Save the default keybase.txt
	update_option('keybaseverif_text',$keybaseverif_text);

	// Auto detect the language.
	update_option('keybaseverif_lang','auto');
}

// Hook into Wordpress
add_action('admin_menu','keybaseverif_settings');
function keybaseverif_settings(){
	add_options_page('Keybase.txt','Keybase.txt', 'manage_options','wp-keybase-verification', 'keybaseverif_settings_page');
}

// Create the page.
function keybaseverif_settings_page(){
	global $wpdb;

	// Include the selected code/html pages.
	if(isset($_GET['request'])){
		$page_request = $_GET['request'];
	}else{
		$page_request = 'write';
	}

	// Include the code and layout files.
	ob_start();
		switch($page_request){
			case 'write':
				include(dirname(__FILE__).'/admin/code/write.php');
				include(dirname(__FILE__).'/admin/html/write.php');
			break;
			case 'resources':
				include(dirname(__FILE__).'/admin/code/resources.php');
				include(dirname(__FILE__).'/admin/html/resources.php');
			break;
			case 'settings':
				include(dirname(__FILE__).'/admin/code/settings.php');
				include(dirname(__FILE__).'/admin/html/settings.php');
			break;
		}

		$plugin_output = ob_get_contents();
	ob_end_clean();

	// Liquid Templating
	$plugin_output = str_replace('{keybaseverif.text}',$keybaseverif_text,$plugin_output);
	$plugin_output = str_replace('{page}',$_GET['page'],$plugin_output);
	echo($plugin_output);
}

// Language
add_action('init','load_keybaseverif_language');
function load_keybaseverif_language(){
	// Save the language settings.
	if(isset($_POST['keybaseverif_lang'])){
		// Save the content.
		update_option('keybaseverif_lang',$_POST['keybaseverif_lang']);
	}

	// Check if a language file exists for Wordpress' regional settings.
	if(get_option('keybaseverif_lang') == 'auto'){
		$locale = get_locale();

		if(file_exists(dirname(__FILE__).'/lang/'.$locale.'.mo')){
			load_textdomain('keybaseverif',dirname(__FILE__).'/lang/'.$locale.'.mo');
		}
	}else{
		// Look for a language file in the plugin directory.
		if(file_exists(dirname(__FILE__).'/lang/'.get_option('keybaseverif_lang').'.mo')){
			load_textdomain('keybaseverif',dirname(__FILE__).'/lang/'.get_option('keybaseverif_lang').'.mo');
		}else if(file_exists(WP_CONTENT_DIR.'/keybaseverif/lang/'.get_option('keybaseverif_lang').'.mo')){
			// Look for a language file in the content directory.
			load_textdomain('keybaseverif',WP_CONTENT_DIR.'/keybaseverif/lang/'.get_option('keybaseverif_lang').'.mo');
		}
	}
}

// Add the settings link on the plugin page
$plugin = plugin_basename(__FILE__);
add_filter('plugin_action_links_'.$plugin,'keybaseverif_settings_link');
function keybaseverif_settings_link($links) {
	$settings_link = '<a href="options-general.php?page=wp-keybase-verification">Settings</a>';
	array_unshift($links,$settings_link);
	return($links);
}

// Admin HEAD
add_action('admin_head','keybaseverif_admin_head');
function keybaseverif_admin_head(){
	echo('<link href="'.get_bloginfo('url').'/wp-content/plugins/wp-keybase-verification/admin/style.css?'.keybaseverif_version.'" rel="stylesheet" type="text/css" />');
	echo('<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/wp-keybase-verification/thirdparty/jquery.elastic.js?'.keybaseverif_version.'"></script>');
	echo('<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/wp-keybase-verification/thirdparty/jquery.textarea.js?'.keybaseverif_version.'"></script>');
	echo('<script type="text/javascript" src="'.get_bloginfo('url').'/wp-content/plugins/wp-keybase-verification/admin/functions.js?'.keybaseverif_version.'"></script>');
}

// This allows keybase.txt content to be served even if the file doesn't exist.
add_action('init','serve_keybaseverif');
function serve_keybaseverif(){
	// Stop the function if the client isn't looking for keybase.txt
	if(
		((get_bloginfo('url').'/keybase.txt' != 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) or (get_bloginfo('url').'/.well-known/keybase.txt' != 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']))
		and ('/keybase.txt' != $_SERVER['REQUEST_URI'])
		and ('keybase.txt' != $_SERVER['REQUEST_URI'])
		and ('/.well-known/keybase.txt' != $_SERVER['REQUEST_URI'])
		and ('.well-known/keybase.txt' != $_SERVER['REQUEST_URI'])
	){
		return;
	}

	// Get the text content.
	$keybaseverif_text = stripslashes(get_option('keybaseverif_text'));

	// Stop if it doesn't exist.
	if(!$keybaseverif_text or $keybaseverif_text == ''){
		return;
	}

	// Output the keybase.txt content.
	header('Content-type: text/plain');
	echo($keybaseverif_text);
	die;
}

?>
