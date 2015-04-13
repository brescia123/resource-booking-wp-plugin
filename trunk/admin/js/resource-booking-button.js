(function($) {
    'use strict';

    /*
    * POPUP
    */

    var options = '';
    var resources = $.parseJSON(res_booking.resources);
    for (var i = 0; i < resources.length; i++) {
        options += '<option value=' + resources[i].ID + '>' + resources[i].post_title + '</option>'; 
    };

    var popup = jQuery(
        '<div id="button-dialog" title="Resource Booking calendar">\
            <label for="resource-select">Resource</label>\
                <select name="size" id="resource-select">\ ' +
                    options
                + '</select>\
        </div>'
        );
    popup.appendTo('body').hide();
    popup.dialog({
            autoOpen: false,
            dialogClass: 'wp-dialog',
            resizable: false,
            closeOnEscape: true,
            modal: true,
            buttons: {
                'Cancel': function() {
                    $(this).dialog('close');
                },
                'Add': function() {
                    var resource_id = $('#resource-select').val();
                    var shortcode = '[resource_booking resource_id=' + resource_id + ']';
                    // Add the shortcode to the editor
                    tinymce.activeEditor.execCommand('mceInsertContent', 0, shortcode);
                    $(this).dialog('close');
                }
            }
        });

    /*
    * Editor BUTTON
    */

    tinymce.create('tinymce.plugins.res_booking_button', {

        init: function(ed, url) {
            ed.addButton('res_booking_button', {
                title: 'Insert resource booking calendar',
                image: res_booking.url + '/images/add_booking.png',
                onclick: function() {
                    popup.dialog('open');
                }
            });
        },

        createControl: function(n, cm) {
            return null;
        }
    });

    // Register plugin
    tinymce.PluginManager.add('res_tinymce_button_script', tinymce.plugins.res_booking_button);

})(jQuery);
    