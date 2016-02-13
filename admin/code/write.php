<?php
/*
Title: Write
Description: The code for the write page.
Author: Hans Vedo, hans@cultivate.it
Author: James Swineson, jamesswineson@gmail.com
2011-01-23: Created
*/

// Security: Ensure the file is accessed by Wordpress.
if(!defined('ABSPATH')){
	return;
}

// Settings
$enable_form = true;

// Capture a submitted form.
if(isset($_POST['keybaseverif_text'])){
	// Save the content.
	update_option('keybaseverif_text',$_POST['keybaseverif_text']);

	// Return a message
	$keybaseverif_message = __('Your keybase.txt file has been updated!','keybaseverif').' <a href="'.get_bloginfo('url').'/keybase.txt">keybase.txt</a>';
}

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

// Warnings
if(file_exists(ABSPATH.'keybase.txt')){
	$keybaseverif_message = __('A keybase.txt file already exists. Please rename it to humans-backup.txt and then use this plugin normally.','keybaseverif');
	$enable_form = false;
}

// Get the current theme developer.
$current_theme = get_current_theme();
$all_themes = get_themes();
foreach($all_themes as $theme){
	if($theme['Name'] == $current_theme){
		$theme_details = $theme;
		break;
	}
}

// Select the users.
$all_users = $wpdb->get_results("
	SELECT *
	FROM ".$wpdb->prefix."users
	ORDER BY display_name ASC
");
//var_dump($all_users);

// Get the timezone city.
$timezone_string = get_option('timezone_string');
$timezone_string_parts = explode('/',$timezone_string);
if(count($timezone_string_parts) >= 2){
	$sites_timezone = $timezone_string_parts[(count($timezone_string_parts)-1)];

	// Underscores added to the DB.
	$sites_timezone = str_replace('_',' ',$sites_timezone);
}else{
	$sites_timezone = '';
}

// Get the selected language.
if(get_option('keybaseverif_lang') != ''){
	$selected_language = get_option('keybaseverif_lang');

	switch($selected_language){
		case 'de_DE':
			$selected_language = 'Deutsch';
		break;
		case 'auto':
		case 'en_US':
			$selected_language = 'English';
		break;
		case 'es_ES':
			$selected_language = 'Espanol';
		break;
		case 'nb_NO':
			$selected_language = 'Norsk';
		break;
	}
}else{
	$selected_language = 'English';
}
?>
