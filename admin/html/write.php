<?php
// Security: Ensure the file is accessed by Wordpress.
if (!defined('ABSPATH')) {
    return;
}
?>

<div class="wrap" id="keybaseverif_admin">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>keybase.txt</h2>

	<div class="clear setting-description">
		<p><?php echo __('Paste your keybase.txt content here. For more information please refer to <a href="https://keybase.io">Keybase.io</a>.', 'keybaseverif'); ?></p>
	</div>

	<?php if (isset($keybaseverif_message) and $keybaseverif_message != '') {
    ?>
		<div id="keybaseverif_message"><?php echo $keybaseverif_message;
    ?></div>
	<?php
} ?>

	<?php if ($enable_form == true) {
    ?>
		<div id="keybaseverif_form">
			<form name="keybaseverif-form" action="options-general.php?page={page}" method="post">

				<div id="poststuff">
					<textarea id="keybaseverif_text_field" name="keybaseverif_text" wrap="off">{keybaseverif.text}</textarea>
				</div>

				<p class="submit">
					<input type="submit" name="submit" class="button-primary" value="<?php echo __('Save Changes', 'keybaseverif');
    ?>" /> or view your <a href="<?php get_bloginfo('url');
    ?>/keybase.txt" target="_blank">keybase.txt</a>
				</p>
			</form>
		</div>
	<?php
} ?>
</div>
