jQuery(document).ready(function($) {
    // Upload image button
    $('.upload-image-button').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var custom_uploader = wp.media({
            title: 'Upload Image',
            button: {
                text: 'Use Image'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            button.siblings('.store-icon').val(attachment.url);
            button.siblings('.image-preview').html('<img src="' + attachment.url + '" style="max-width: 100px; max-height: 100px;" />');
        });
        custom_uploader.open();
    });

    // Display default image if no image selected
    $('.image-preview').each(function() {
        var $this = $(this);
        if ($this.children('img').length === 0) {
            var defaultImage = '/wp-content/plugins/custom-store-map/images/default.jpg'; // Replace with your default image path
            $this.html('<img src="' + defaultImage + '" style="max-width: 100px; max-height: 100px;" />');
        }
    });
});
