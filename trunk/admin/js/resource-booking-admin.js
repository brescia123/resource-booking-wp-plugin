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
            selectable: true,
            selectOverlap: false,
            eventOverlap: false,
            editable: true,
            slotDuration: time_interval,
            eventSources: [{
                // Get events from the db
                events: function(start, end, timezone, callback) {
                    var data = {
                        'action': 'res_reservations_callback',
                        'res_id': post_id,
                        'start': start.format(),
                        'end': end.format(),
                    }
                    jQuery.post(ajax_object.ajax_url, data, function(response_json) {
                        var response = JSON.parse(response_json);
                        if (response.success) {
                            var events = $.map(response.reservations, resToEvent);
                            callback(events);
                        } else {
                            alert("Error: \n" + response_json);
                        }
                    });
                }
            }],
            select: function(start, end, jsEvent, view) {
                var title = prompt('Name:');
                if (title) {
                    var data = {
                            'action': 'res_save_reservation_callback',
                            'res_id': post_id,
                            'title': title,
                            'start': start.format(),
                            'end': end.format()
                        }
                    // Post the new event to the server
                    jQuery.post(ajax_object.ajax_url, data, function(response_json) {
                        var response = JSON.parse(response_json);

                        if (response.success) {
                            var event = resToEvent(response.reservation);
                            calendar.fullCalendar('renderEvent', event, true);
                        } else {
                            alert("Error: \n" + response_json);
                        }
                    });
                }
            }
        };
        calendar.fullCalendar(calendarOpts);

        // Reacts to new time interval selection
        time_interval_select.change(function() {
            var minutesTot = $(this).val();
            var hours = parseInt(minutesTot / 60);
            var minutesRel = minutesTot % 60;

            calendarOpts.slotDuration = '00:' + minutesTot + ':00';
            calendar.fullCalendar('destroy');
            calendar.fullCalendar(calendarOpts);
        });

        /* Helper Methods */

        // Converts a reservation object retrieved from the server in FullCalendar event
        var resToEvent = function(reservation) {
            return {
                'id': reservation.id,
                'title': reservation.title,
                'start': reservation.start,
                'end': reservation.end,
                'allDay': false
            }
        }

        // Converts an envent to a reservation object
        var eventToRes = function(event) {
            return {
                'id': post_id,
                'title': event.title,
                'start': event.start.toString(),
                'end': event.end.toString()
            }
        }
    });

})(jQuery);
