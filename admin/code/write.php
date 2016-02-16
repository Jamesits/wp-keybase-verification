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

/**
 * Filter a sanitized multi line text field string without removing linebreaks and tabs.
 *
 * @since 1.4.3
 *
 * @param string $filtered The sanitized string.
 * @param string $str      The string prior to being sanitized.
 */
function sanitize_multiline_text_field($str)
{
    $filtered = wp_check_invalid_utf8($str);

    if (strpos($filtered, '<') !== false) {
        $filtered = wp_pre_kses_less_than($filtered);
        // This will strip extra whitespace for us.
        $filtered = wp_strip_all_tags($filtered, true);
    }

    $found = false;
    while (preg_match('/%[a-f0-9]{2}/i', $filtered, $match)) {
        $filtered = str_replace($match[0], '', $filtered);
        $found = true;
    }

    if ($found) {
        // Strip out the whitespace that may now exist after removing the octets.
        $filtered = trim(preg_replace('/ +/', ' ', $filtered));
    }

    return $filtered;
}

// Settings
$enable_form = true;

// Capture a submitted form.
if (isset($_POST['keybaseverif_text'])) {
    // Save the content.
    update_option('keybaseverif_text', sanitize_multiline_text_field($_POST['keybaseverif_text']));

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
