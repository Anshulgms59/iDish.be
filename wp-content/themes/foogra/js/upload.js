jQuery(document).ready(function($){
	"use strict";
	var foogra_upload;
	var foogra_selector;

	function foogra_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		foogra_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( foogra_upload ) {
			foogra_upload.open();
			return;
		} else {
			// Create the media frame.
			foogra_upload = wp.media.frames.foogra_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			foogra_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = foogra_upload.state().get('selection').first();

				foogra_upload.close();
				foogra_selector.find('.upload_image').val(attachment.attributes.url).change();
				if ( attachment.attributes.type == 'image' ) {
					foogra_selector.find('.foogra_screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		foogra_upload.open();
	}

	function foogra_remove_file(selector) {
		selector.find('.foogra_screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').on('click', '.foogra_upload_image_action .remove-image', function(event) {
		foogra_remove_file( $(this).parent().parent() );
	});

	$('body').on('click', '.foogra_upload_image_action .add-image', function(event) {
		foogra_add_file(event, $(this).parent().parent());
	});

});