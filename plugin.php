<?php
/*
Plugin Name: Keybase.io Verification
Version: 1.4.5
Plugin URI: https://github.com/Jamesits/wp-keybase-verification
Description: Keybase.io site verification helper.
Author: James Swineson
Author URI: https://swineson.me/
Text Domain: keybaseverif
Domain Path: /lang
*/

/*
Copyright 2016  James Swineson (@jamesits) <jamesswineson@gmail.com>
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// Settings
define('keybaseverif_version', '1.4.5');

// Install the plugin
register_activation_hook(__FILE__, 'keybaseverif_install');
function keybaseverif_install()
{
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

    // Save the default keybase.txt
    update_option('keybaseverif_text', $keybaseverif_text);
}

// Hook into Wordpress
add_action('admin_menu', 'keybaseverif_settings');
function keybaseverif_settings()
{
    add_options_page('Keybase.txt', 'Keybase.txt', 'manage_options', 'wp-keybase-verification', 'keybaseverif_settings_page');
}

// Create the page.
function keybaseverif_settings_page()
{
    global $wpdb;

    // Include the selected code/html pages.
    if (isset($_GET['request'])) {
        $page_request = $_GET['request'];
    } else {
        $page_request = 'write';
    }

    // Include the code and layout files.
    ob_start();
    switch ($page_request) {
            case 'write':
                include dirname(__FILE__).'/admin/code/write.php';
                include dirname(__FILE__).'/admin/html/write.php';
            break;
        }

    $plugin_output = ob_get_contents();
    ob_end_clean();

    // Liquid Templating
    $plugin_output = str_replace('{keybaseverif.text}', $keybaseverif_text, $plugin_output);
    $plugin_output = str_replace('{page}', $_GET['page'], $plugin_output);
    echo $plugin_output;
}

// Add the settings link on the plugin page
$plugin = plugin_basename(__FILE__);
add_filter('plugin_action_links_'.$plugin, 'keybaseverif_settings_link');
function keybaseverif_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=wp-keybase-verification">keybase.txt</a>';
    array_unshift($links, $settings_link);

    return $links;
}

// Admin HEAD
add_action('admin_enqueue_scripts', 'keybaseverif_admin_head');
function keybaseverif_admin_head($hook)
{
    if ('settings_page_wp-keybase-verification' != $hook) {
        return;
    }
    wp_enqueue_style('keybaseverif-style', plugin_dir_url(__FILE__).'admin/style.css', array(), keybaseverif_version);
    wp_enqueue_script('keybaseverif-jquery-elastic', plugin_dir_url(__FILE__).'thirdparty/jquery.elastic.js', array('jquery'), keybaseverif_version);
    wp_enqueue_script('keybaseverif-jquery-textarea', plugin_dir_url(__FILE__).'thirdparty/jquery.textarea.js', array('jquery'), keybaseverif_version);
    wp_enqueue_script('keybaseverif-functions', plugin_dir_url(__FILE__).'admin/functions.js', array('keybaseverif-jquery-elastic', 'keybaseverif-jquery-textarea'), keybaseverif_version);
}

// This allows keybase.txt content to be served even if the file doesn't exist.
add_action('init', 'serve_keybaseverif');
function serve_keybaseverif()
{
    // Stop the function if the client isn't looking for keybase.txt
    if (
        ((get_bloginfo('url').'/keybase.txt' != 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) or (get_bloginfo('url').'/.well-known/keybase.txt' != 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']))
        and ('/keybase.txt' != $_SERVER['REQUEST_URI'])
        and ('keybase.txt' != $_SERVER['REQUEST_URI'])
        and ('/.well-known/keybase.txt' != $_SERVER['REQUEST_URI'])
        and ('.well-known/keybase.txt' != $_SERVER['REQUEST_URI'])
    ) {
        return;
    }

    // Get the text content.
    $keybaseverif_text = stripslashes(get_option('keybaseverif_text'));

    // Stop if it doesn't exist.
    if (!$keybaseverif_text or $keybaseverif_text == '') {
        return;
    }

    // Output the keybase.txt content.
    header('Content-type: text/plain');
    echo $keybaseverif_text;
    die;
}
