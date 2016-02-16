// jQuery
jQuery(document).ready(function() {
  // Enable the tab key.
  jQuery('#keybaseverif_text_field').tabby();

  // Make the textarea elastic.
  jQuery('#keybaseverif_text_field').elastic();

  // Hide any messages after a couple seconds.
  jQuery('#keybaseverif_message').delay(10000).fadeOut();
})
