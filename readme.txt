=== Keybase.io verification ===
Contributors: jamesits, hansvedo
Tags: keybase, keybase.io, verification
Requires at least: 4.0.0
Tested up to: 4.4.2
Stable tag: 1.4.3
License: GPLv3 or later

A plugin to create a keybase.txt (Keybase.io Verification) file, which would verify your possession of this website on Keybase.io.

== Description ==

This plugin enables you to verify your site through <a href="https://keybase.io">keybase.io</a>. Notice: Only works while WordPress is installed to root directory, otherwise you need to set up your server to let WordPress handle `your.domain/keybase.txt`.

 * Download from WordPress Plugin Directory: <a href="https://wordpress.org/plugins/wp-keybase-verification/">https://wordpress.org/plugins/wp-keybase-verification/</a>
 * WordPress Plugin Directory SVN repository: <a href="https://plugins.svn.wordpress.org/wp-keybase-verification/">https://plugins.svn.wordpress.org/wp-keybase-verification/</a><b>
 * Github repository: <a href="https://github.com/Jamesits/wp-keybase-verification">https://github.com/Jamesits/wp-keybase-verification</a>

Disclaimer: This plugin and it's developer has no affect with Keybase.io itself.

= Features =
* Add your keybase.txt file without needing FTP/SSH to upload and download files.

== Screenshots ==
1. The keybase.txt text editor

== Installation ==

= Download and Upload: =
1. Download the plugin files.
2. Upload the plugin's folder to the "/wp-content/plugins/" directory
3. Activate the plugin through the "Plugins" menu in WordPress
4. Select "Settings"

== Frequently Asked Questions ==

= Will this work if my WordPress installation in not at website root? =

Keybase.io requires a `your.domain/keybase.txt` or `your.domain/.well-known/keybase.txt` to be present, so no. Of course you can set up the server to redirect that URI, but it's another story and I'm not providing support for it.

== Changelog ==

= 1.4 =
* Removed unused code.
* Changes to meet WordPress plugin submission requirements.

= 1.3 =
* Published

== Upgrade Notice ==

= 1.4.2 =
Initial release on WordPress Plugin Directory.
