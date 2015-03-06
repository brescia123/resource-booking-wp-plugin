(function($) {
    'use strict';

    // Document ready
    $(function() {
        var calendar = $('#calendar');
        var post_id = $('#post_ID').val();
        var time_interval = '00:' + $('#time-interval').find('option:selected').val() + ':00';

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
                editable: true,
                slotDuration: time_interval,
                events: function(start, end, timezone, callback) {
                    var data = {
                        'action': 'res_reservations_callback',
                        'res_id': post_id,
                        'start_date': start.format(),
                        'end_date': end.format(),
                    };
                    jQuery.post(ajax_object.ajax_url, data, function(response) {
                        var reservations = JSON.parse(response);
                        var events = resToEventsArray(reservations)
                        console.log(events);
                        callback(events);
                    });
                }
            });

        var resToEventsArray = function(reservations) {
            var events = [];

            for (var i = 0; i < reservations.length; i++) {
                var res = reservations[i];
                events.push({
                    'id': res.id,
                    'title': res.title,
                    'allDay': false,
                    'start': res.start,
                    'end': res.end,
                });
            }
            return events;
        }
    });

})(jQuery);
