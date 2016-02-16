<?php
/*
Title: Write
Description: The code for the write page.
Author: Hans Vedo, hans@cultivate.it
Author: James Swineson, jamesswineson@gmail.com
2011-01-23: Created
*/

// Security: Ensure the file is accessed by Wordpress.
if (!defined('ABSPATH')) {
    return;
}

// Settings
$enable_form = true;

// Capture a submitted form.
if (isset($_POST['keybaseverif_text'])) {
    // Save the content.
    update_option('keybaseverif_text', sanitize_text_field($_POST['keybaseverif_text']));

    // Return a message
    $keybaseverif_message = __('Your keybase.txt file has been updated!', 'keybaseverif').' <a href="'.get_bloginfo('url').'/keybase.txt">keybase.txt</a>';
}

// 1st: Look for the file itself.
if (file_exists(ABSPATH.'keybase.txt')) {
    $keybaseverif_text = file_get_contents(ABSPATH.'keybase.txt');
} elseif (get_option('keybaseverif_text') != '') {
    // 2nd: Check if settings have already been saved.
    $keybaseverif_text = stripslashes(get_option('keybaseverif_text'));
} else {
    // 3rd: Lastly just load the template contents.
    $keybaseverif_text = "// paste your keybase.txt content here\n";
}

// Warnings
if (file_exists(ABSPATH.'keybase.txt')) {
    $keybaseverif_message = __('A keybase.txt file already exists. Please remove and then use this plugin normally.', 'keybaseverif');
    $enable_form = false;
}
