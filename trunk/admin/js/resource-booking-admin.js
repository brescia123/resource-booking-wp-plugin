(function($) {
    'use strict';

    // Document ready
    $(function() {
        var calendar = $('#calendar');

        // Calendar configuration
        calendar
            .fullCalendar({
                header: {
                    left: 'title',
                    center: 'agendaDay,agendaWeek,month',
                    right: 'today prev,next'
                },
                weekends: false,
                defaultView: 'agendaWeek',
                allDaySlot: false,
            });

        var data = {
            'action': 'res_reservations_callback',
            'whatever': ajax_object.we_value // We pass php values differently!
        };
        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
        jQuery.post(ajax_object.ajax_url, data, function(response) {
            alert('Got this from the server: ' + response);
        });
    });

})(jQuery);
