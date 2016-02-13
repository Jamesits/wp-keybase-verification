<?php
// Security: Ensure the file is accessed by Wordpress.
if(!defined('ABSPATH')){
	return;
}
?>

<div class="wrap" id="keybaseverif_admin">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>keybase.txt</h2>
	<?php include(dirname(__FILE__).'/submenu.php'); ?>

	<div class="setting-description">
		<h3><?php echo(__('More Information','keybaseverif')); ?></h3>
		<?php echo(__('More Information','keybaseverif')); ?>: <a href="https://keybase.io">keybase.io</a>
		<br /><?php echo(__('Sample File','keybaseverif')); ?>: <a href="https://blog.swineson.me/keybase.txt">blog.swineson.me/keybase.txt</a>
	</div>
</div>
