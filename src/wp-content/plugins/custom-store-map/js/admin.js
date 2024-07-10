jQuery(document).ready(function($) {
    var defaultIcon = customStoreMapAdmin.defaultIcon; // Default icon URL

    // Log default icon URL to ensure it's correct
    console.log('Default Icon URL:', defaultIcon);

    $('#add-location').click(function() {
        var index = $('#custom-store-map-locations .custom-store-map-location').length;

        // Log current index to ensure it's being calculated correctly
        console.log('Current index:', index);

        var newLocation = `
            <tr class="custom-store-map-location">
                <td>
                    <input type="hidden" name="custom_store_map_data[${index}][icon]" class="custom-store-map-icon-url" />
                    <img src="${defaultIcon}" class="custom-store-map-icon-preview" style="max-width: 100px; max-height: 100px;" />
                    <button type="button" class="upload-icon-button button">Upload Icon</button>
                </td>
                <td><input type="text" name="custom_store_map_data[${index}][name]" placeholder="Store Name" required /></td>
                <td><input type="text" name="custom_store_map_data[${index}][address]" placeholder="Store Address" required /></td>
                <td><input type="text" name="custom_store_map_data[${index}][location]" placeholder="Store Location (lat,lng)" required /></td>
                <td><input type="text" name="custom_store_map_data[${index}][map_link]" placeholder="Map Link" required /></td>
                <td><input type="text" name="custom_store_map_data[${index}][page_link]" placeholder="Page Link" required /></td>
                <td><button type="button" class="remove-location">Remove</button></td>
            </tr>
        `;

        // Log the new location HTML to ensure it's being generated correctly
        console.log('New Location HTML:', newLocation);

        $('.custom-store-map-table tbody').append(newLocation);

        // Log a message after appending the new location to ensure it's added to the DOM
        console.log('New location added to the DOM');
    });

    $(document).on('click', '.remove-location', function() {
        $(this).closest('.custom-store-map-location').remove();
        // Log a message after removing a location to ensure it's removed from the DOM
        console.log('Location removed from the DOM');
    });

    $(document).on('click', '.upload-icon-button', function(e) {
        e.preventDefault();
        var button = $(this);
        var customUploader = wp.media({
            title: 'Select Store Icon',
            button: {
                text: 'Use this icon'
            },
            multiple: false
        }).on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();
            button.siblings('.custom-store-map-icon-url').val(attachment.url);
            button.siblings('.custom-store-map-icon-preview').attr('src', attachment.url);

            // Log the attachment URL to ensure it's being set correctly
            console.log('Selected attachment URL:', attachment.url);
        }).open();
    });
});
