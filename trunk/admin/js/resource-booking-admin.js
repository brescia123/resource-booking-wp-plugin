(function($) {
    'use strict';

    // Document ready
    $(function() {
        var calendar = $('#calendar');
        var post_id = $('#post_ID').val();
        var time_interval_select = $('#time-interval');
        var time_interval = '00:' + time_interval_select.find('option:selected').val() + ':00';

        // Calendar configuration
        var calendarOpts = {
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
                }
                jQuery.post(ajax_object.ajax_url, data, function(response) {
                    var reservations = JSON.parse(response);
                    var events = resToEventsArray(reservations)
                    console.log(events);
                    callback(events);
                });
            }
        };
        calendar.fullCalendar(calendarOpts);

        time_interval_select.change(function () {
            var minutesTot = $(this).val();
            var hours = parseInt(minutesTot / 60);
            var minutesRel = minutesTot % 60;
            calendarOpts.slotDuration = '00:' + minutesTot + ':00';
            calendar.fullCalendar('destroy');
            calendar.fullCalendar(calendarOpts);
        })

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
