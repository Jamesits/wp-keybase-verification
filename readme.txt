=== Keybase.io Verification ===
Contributors: jamesits
Tags: keybase, keybase.io, verification
Requires at least: 4.0.0
Tested up to: 5.3.0
Stable tag: 1.4.5
License: GPLv3 or later

A plugin to create a `keybase.txt` (Keybase.io Verification) file, which would verify your possession of this website on Keybase.io.

== Description ==

This plugin enables you to verify your site through <a href="https://keybase.io">keybase.io</a>. 

 * Download from WordPress Plugin Directory: <a href="https://wordpress.org/plugins/wp-keybase-verification/">https://wordpress.org/plugins/wp-keybase-verification/</a>
 * WordPress Plugin Directory SVN repository: <a href="https://plugins.svn.wordpress.org/wp-keybase-verification/">https://plugins.svn.wordpress.org/wp-keybase-verification/</a><b>
 * Github repository: <a href="https://github.com/Jamesits/wp-keybase-verification">https://github.com/Jamesits/wp-keybase-verification</a>
 
Don't worry if the WordPress plugin page tells you "This plugin hasn't been tested with the latest 3 major releases of WordPress". This plugin does not need frequent upgrade. If it does not work for you, <a href="https://github.com/Jamesits/wp-keybase-verification/issues">create an issue at GitHub</a> or use the support forum for WordPress plugins.

Disclaimer: This plugin and it's developer is not affiliated with Keybase.io in any way.

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

Keybase.io requires a `your.domain/keybase.txt` or `your.domain/.well-known/keybase.txt` to be present, so if your WordPress installation is under some directory, e.g., `example.com/blog/`, then this plugin will not work for you. Of course you can set up the server to redirect that URI, but it's another story and I'm not providing support for it.

== Changelog ==

= 1.4.5 =
* Fix bug: you don't have permission to view this page.

= 1.4.4 =
* Modify documentation

= 1.4 =
* Removed unused code.
* Changes to meet WordPress plugin submission requirements.

= 1.3 =
* Published

== Upgrade Notice ==

= 1.4.4 =
Serious usability bug fix.
