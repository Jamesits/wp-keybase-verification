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

	<?php if(isset($keybaseverif_message) and $keybaseverif_message != ''){ ?>
		<div id="keybaseverif_message"><?php echo($keybaseverif_message); ?></div>
	<?php } ?>

	<form action="options-general.php?page=wp-keybase-verification&request=settings" method="post">
		<strong><label for="lang_field"><?php echo(__('keybase.txt Language','keybaseverif')); ?></label></strong>

		<div>
			<select id="lang_field" name="keybaseverif_lang">
				<option value="auto"<?php echo($selected_language == 'auto' ? ' selected' : ''); ?>><?php echo(__('Automatically Detected','keybaseverif')); ?></option>
				<option value="en_US"<?php echo($selected_language == 'en_US' ? ' selected' : ''); ?>>English</option>
			</select>
		</div>

		<p class="submit">
			<input type="submit" name="submit" class="button-primary" value="<?php echo(__('Save Language','keybaseverif')); ?>" />
		</p>
	</form>
</div>
