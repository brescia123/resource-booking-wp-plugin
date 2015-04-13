(function($) {
    'use strict';

    tinymce.create('tinymce.plugins.res_booking_button', {

        init: function(ed, url) {
            ed.addButton('res_booking_button', {
                title: 'Insert resource booking calendar',
                image: url + '/add_booking.png',
                onclick: function() {
                    ed.selection.setContent('[resource_booking]');
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
    